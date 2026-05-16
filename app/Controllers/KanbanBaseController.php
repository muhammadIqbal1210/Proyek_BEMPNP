<?php

namespace App\Controllers;

use App\Models\KanbanBoardModel;
use App\Models\KanbanBoardShareModel;
use App\Models\KanbanTaskModel;
use App\Models\UserModel;

class KanbanBaseController extends BaseController
{
    protected KanbanBoardModel $boardModel;
    protected KanbanBoardShareModel $shareModel;
    protected KanbanTaskModel $taskModel;

    public function __construct()
    {
        $this->boardModel = new KanbanBoardModel();
        $this->shareModel = new KanbanBoardShareModel();
        $this->taskModel = new KanbanTaskModel();
        helper(['form', 'url']);
    }

    protected function panelPrefix(): string
    {
        return in_array(session()->get('role'), ['admin', 'superadmin'], true) ? 'admin' : 'member';
    }

    public function kanban()
    {
        $userId = (int) session()->get('user_id');
        $boards = $this->accessibleBoards($userId);
        $selectedId = (int) ($this->request->getGet('board') ?: ($boards[0]['id'] ?? 0));
        $selectedBoard = $selectedId ? $this->findAccessibleBoard($selectedId, $userId) : null;
        $canManageBoard = $selectedBoard && (int) $selectedBoard['owner_id'] === $userId;
        $canEdit = $selectedBoard && $this->canEditBoard($selectedBoard, $userId);

        $tasks = [];
        $sharedUserIds = [];
        if ($selectedBoard) {
            $tasks = $this->taskModel
                ->where('board_id', $selectedBoard['id'])
                ->orderBy('position', 'ASC')
                ->orderBy('created_at', 'ASC')
                ->findAll();
            $sharedUserIds = array_map('intval', array_column(
                $this->shareModel->where('board_id', $selectedBoard['id'])->findAll(),
                'user_id'
            ));
        }

        $data = [
            'title' => 'Kanban Board',
            'halaman' => 'Kanban Board',
            'content' => 'admin/kanban',
            'prefix' => $this->panelPrefix(),
            'boards' => $boards,
            'selectedBoard' => $selectedBoard,
            'tasks' => $tasks,
            'canEdit' => $canEdit,
            'canManageBoard' => $canManageBoard,
            'users' => (new UserModel())->where('id !=', $userId)->orderBy('username', 'ASC')->findAll(),
            'sharedUserIds' => $sharedUserIds,
        ];

        return view('template/wrapper', $data);
    }

    public function storeBoard()
    {
        $userId = (int) session()->get('user_id');
        $visibility = $this->request->getPost('visibility') === 'shared' ? 'shared' : 'private';

        $boardId = $this->boardModel->insert([
            'title' => $this->request->getPost('title') ?: 'Board Baru',
            'description' => $this->request->getPost('description'),
            'owner_id' => $userId,
            'visibility' => $visibility,
        ]);

        $this->syncShares((int) $boardId, $visibility, $this->request->getPost('shared_users') ?? []);

        return redirect()->to(base_url($this->panelPrefix() . '/kanban?board=' . $boardId))->with('success', 'Board berhasil dibuat.');
    }

    public function updateBoard($id)
    {
        $board = $this->boardModel->find($id);
        if (!$board || (int) $board['owner_id'] !== (int) session()->get('user_id')) {
            return redirect()->to(base_url($this->panelPrefix() . '/kanban'))->with('error', 'Board tidak dapat diubah.');
        }

        $visibility = $this->request->getPost('visibility') === 'shared' ? 'shared' : 'private';
        $this->boardModel->update($id, [
            'title' => $this->request->getPost('title') ?: $board['title'],
            'description' => $this->request->getPost('description'),
            'visibility' => $visibility,
        ]);
        $this->syncShares((int) $id, $visibility, $this->request->getPost('shared_users') ?? []);

        return redirect()->to(base_url($this->panelPrefix() . '/kanban?board=' . $id))->with('success', 'Pengaturan board disimpan.');
    }

    public function storeTask()
    {
        $boardId = (int) $this->request->getPost('board_id');
        $board = $this->boardModel->find($boardId);
        if (!$board || !$this->canEditBoard($board, (int) session()->get('user_id'))) {
            return redirect()->to(base_url($this->panelPrefix() . '/kanban'))->with('error', 'Anda tidak memiliki akses menambah tugas di board ini.');
        }

        $this->taskModel->insert([
            'board_id' => $boardId,
            'title' => $this->request->getPost('title') ?: 'Tugas baru',
            'description' => $this->request->getPost('description'),
            'status' => $this->request->getPost('status') ?: 'todo',
            'position' => time(),
        ]);

        return redirect()->to(base_url($this->panelPrefix() . '/kanban?board=' . $boardId))->with('success', 'Tugas ditambahkan.');
    }

    public function updateTaskStatus()
    {
        $taskId = (int) $this->request->getPost('task_id');
        $status = $this->request->getPost('status');
        if (!in_array($status, ['todo', 'inprogress', 'done'], true)) {
            return $this->response->setStatusCode(422)->setJSON(['message' => 'Status tidak valid.']);
        }

        $task = $this->taskModel->find($taskId);
        $board = $task ? $this->boardModel->find($task['board_id']) : null;
        if (!$task || !$board || !$this->canEditBoard($board, (int) session()->get('user_id'))) {
            return $this->response->setStatusCode(403)->setJSON(['message' => 'Tidak memiliki akses edit.']);
        }

        $this->taskModel->update($taskId, ['status' => $status, 'position' => time()]);
        return $this->response->setJSON(['message' => 'Status diperbarui.']);
    }

    public function deleteTask($id)
    {
        $task = $this->taskModel->find($id);
        $board = $task ? $this->boardModel->find($task['board_id']) : null;
        if (!$task || !$board || !$this->canEditBoard($board, (int) session()->get('user_id'))) {
            return redirect()->to(base_url($this->panelPrefix() . '/kanban'))->with('error', 'Tugas tidak dapat dihapus.');
        }

        $boardId = (int) $task['board_id'];
        $this->taskModel->delete($id);
        return redirect()->to(base_url($this->panelPrefix() . '/kanban?board=' . $boardId))->with('success', 'Tugas dihapus.');
    }

    protected function accessibleBoards(int $userId): array
    {
        $sharedBoardIds = array_map('intval', array_column(
            $this->shareModel->where('user_id', $userId)->findAll(),
            'board_id'
        ));

        $builder = $this->boardModel
            ->select('kanban_boards.*')
            ->groupStart()
                ->where('kanban_boards.owner_id', $userId);

        if (!empty($sharedBoardIds)) {
            $builder->orWhereIn('kanban_boards.id', $sharedBoardIds);
        }

        return $builder->groupEnd()
            ->orderBy('updated_at', 'DESC')
            ->findAll();
    }

    protected function findAccessibleBoard(int $boardId, int $userId): ?array
    {
        $board = $this->boardModel->find($boardId);
        if (!$board) {
            return null;
        }

        if ((int) $board['owner_id'] === $userId) {
            return $board;
        }

        if ($board['visibility'] === 'shared') {
            $share = $this->shareModel->where('board_id', $boardId)->where('user_id', $userId)->first();
            return $share ? $board : null;
        }

        return null;
    }

    protected function syncShares(int $boardId, string $visibility, array $sharedUsers): void
    {
        $this->shareModel->where('board_id', $boardId)->delete();
        if ($visibility !== 'shared') {
            return;
        }

        $rows = [];
        foreach (array_unique(array_map('intval', $sharedUsers)) as $userId) {
            if ($userId > 0 && $userId !== (int) session()->get('user_id')) {
                $rows[] = ['board_id' => $boardId, 'user_id' => $userId, 'created_at' => date('Y-m-d H:i:s')];
            }
        }

        if ($rows) {
            $this->shareModel->insertBatch($rows);
        }
    }

    protected function canEditBoard(array $board, int $userId): bool
    {
        if ((int) $board['owner_id'] === $userId) {
            return true;
        }

        if (($board['visibility'] ?? 'private') !== 'shared') {
            return false;
        }

        return (bool) $this->shareModel
            ->where('board_id', $board['id'])
            ->where('user_id', $userId)
            ->first();
    }
}
