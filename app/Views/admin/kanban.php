<style>
    .kanban-shell {
        --kb-green: #0f8f5f;
        --kb-soft: #eef8f3;
    }
    .board-card,
    .kanban-column,
    .task-card {
        border: 1px solid #e8eef3;
        border-radius: 10px;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05);
    }
    .board-card {
        background: #fff;
    }
    .kanban-column {
        min-height: 420px;
        background: #f8fafc;
        transition: background-color .18s ease, border-color .18s ease;
    }
    .kanban-column.drag-over {
        background: #eef8f3;
        border-color: rgba(15, 143, 95, .45);
    }
    .task-card {
        background: #fff;
        cursor: grab;
        transition: transform .16s ease, box-shadow .16s ease;
    }
    .task-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 22px rgba(15, 23, 42, 0.08);
    }
    .task-card[draggable="false"] {
        cursor: default;
    }
    .kanban-pill {
        background: var(--kb-soft);
        color: var(--kb-green);
        border-radius: 999px;
        padding: .25rem .65rem;
        font-size: .75rem;
        font-weight: 700;
    }
</style>

<?php
    $prefix = $prefix ?? (in_array(session()->get('role'), ['admin', 'superadmin'], true) ? 'admin' : 'member');
    $boards = $boards ?? [];
    $selectedBoard = $selectedBoard ?? null;
    $tasks = $tasks ?? [];
    $canEdit = (bool) ($canEdit ?? false);
    $canManageBoard = (bool) ($canManageBoard ?? false);
    $users = $users ?? [];
    $sharedUserIds = $sharedUserIds ?? [];
    $columns = [
        'todo' => ['label' => 'To Do', 'class' => 'warning', 'icon' => 'fa-list-check'],
        'inprogress' => ['label' => 'Sedang Dikerjakan', 'class' => 'primary', 'icon' => 'fa-spinner'],
        'done' => ['label' => 'Selesai', 'class' => 'success', 'icon' => 'fa-circle-check'],
    ];
?>

<div class="container-fluid kanban-shell">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="row g-3 mb-3">
        <div class="col-lg-4">
            <div class="board-card p-3 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="mb-1">Board Saya</h5>
                        <div class="small text-muted">Pilih board untuk melihat progress.</div>
                    </div>
                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createBoardModal">
                        <i class="fas fa-plus me-1"></i> Board
                    </button>
                </div>

                <?php if (!empty($boards)): ?>
                    <div class="list-group">
                        <?php foreach ($boards as $board): ?>
                            <a href="<?= base_url($prefix . '/kanban?board=' . $board['id']) ?>"
                               class="list-group-item list-group-item-action <?= $selectedBoard && (int) $selectedBoard['id'] === (int) $board['id'] ? 'active' : '' ?>">
                                <div class="d-flex justify-content-between">
                                    <span class="fw-semibold text-truncate"><?= esc($board['title']) ?></span>
                                    <small><?= (int) $board['owner_id'] === (int) session()->get('user_id') ? 'Owner' : 'Shared' ?></small>
                                </div>
                                <div class="small <?= $selectedBoard && (int) $selectedBoard['id'] === (int) $board['id'] ? 'text-white-50' : 'text-muted' ?>">
                                    <?= $board['visibility'] === 'shared' ? 'Dibagikan' : 'Pribadi' ?>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-muted small border rounded p-3">Belum ada board. Buat board untuk mulai mengatur progress tim.</div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="board-card p-3 h-100">
                <?php if ($selectedBoard): ?>
                    <div class="d-flex flex-column flex-lg-row justify-content-between gap-3">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <h4 class="mb-0"><?= esc($selectedBoard['title']) ?></h4>
                                <span class="kanban-pill"><?= $selectedBoard['visibility'] === 'shared' ? 'Shared' : 'Private' ?></span>
                            </div>
                            <p class="text-muted mb-0"><?= esc($selectedBoard['description'] ?: 'Tidak ada deskripsi.') ?></p>
                        </div>
                        <?php if ($canEdit): ?>
                            <div class="d-flex gap-2">
                                <?php if ($canManageBoard): ?>
                                    <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#boardSettingModal">
                                        <i class="fas fa-share-nodes me-1"></i> Share
                                    </button>
                                <?php endif; ?>
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#taskModal">
                                    <i class="fas fa-plus me-1"></i> Tugas
                                </button>
                            </div>
                        <?php else: ?>
                            <span class="align-self-start badge bg-info-subtle text-info">Mode lihat progress</span>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <h4 class="mb-1">Belum ada board dipilih</h4>
                    <p class="text-muted mb-0">Buat board baru atau minta owner membagikan board ke akun Anda.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if ($selectedBoard): ?>
        <div class="row g-3">
            <?php foreach ($columns as $status => $column): ?>
                <div class="col-lg-4">
                    <div class="kanban-column p-3" data-status="<?= esc($status) ?>">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">
                                <i class="fas <?= esc($column['icon']) ?> text-<?= esc($column['class']) ?> me-2"></i>
                                <?= esc($column['label']) ?>
                            </h6>
                            <span class="badge bg-<?= esc($column['class']) ?>">
                                <?= count(array_filter($tasks, static fn ($task) => ($task['status'] ?? '') === $status)) ?>
                            </span>
                        </div>

                        <div class="d-flex flex-column gap-2">
                            <?php foreach ($tasks as $task): ?>
                                <?php if (($task['status'] ?? '') !== $status) continue; ?>
                                <div class="task-card p-3" draggable="<?= $canEdit ? 'true' : 'false' ?>" data-task-id="<?= (int) $task['id'] ?>">
                                    <div class="d-flex justify-content-between gap-2">
                                        <div class="fw-semibold"><?= esc($task['title']) ?></div>
                                        <?php if ($canEdit): ?>
                                            <form action="<?= base_url($prefix . '/kanban/task/delete/' . $task['id']) ?>" method="post" onsubmit="return confirm('Hapus tugas ini?')">
                                                <?= csrf_field() ?>
                                                <button class="btn btn-sm btn-link text-danger p-0" type="submit"><i class="fas fa-trash"></i></button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (!empty($task['description'])): ?>
                                        <div class="small text-muted mt-2"><?= esc($task['description']) ?></div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<div class="modal fade" id="createBoardModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" action="<?= base_url($prefix . '/kanban/board/store') ?>" method="post">
            <?= csrf_field() ?>
            <div class="modal-header">
                <h5 class="modal-title">Board Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama board</label>
                    <input type="text" name="title" class="form-control" placeholder="Contoh: Event Dies Natalis" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Akses</label>
                    <select name="visibility" class="form-select" data-share-toggle="create">
                        <option value="private">Pribadi</option>
                        <option value="shared">Bagikan ke user terpilih</option>
                    </select>
                </div>
                <div class="mb-0 d-none" data-share-box="create">
                    <label class="form-label">User yang bisa melihat</label>
                    <select name="shared_users[]" class="form-select" multiple size="6">
                        <?php foreach ($users as $user): ?>
                            <option value="<?= (int) $user['id'] ?>"><?= esc($user['username']) ?> - <?= esc($user['role']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="small text-muted mt-1">Tahan Ctrl untuk memilih lebih dari satu user.</div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-success" type="submit">Simpan Board</button>
            </div>
        </form>
    </div>
</div>

<?php if ($selectedBoard && $canManageBoard): ?>
<div class="modal fade" id="boardSettingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" action="<?= base_url($prefix . '/kanban/board/update/' . $selectedBoard['id']) ?>" method="post">
            <?= csrf_field() ?>
            <div class="modal-header">
                <h5 class="modal-title">Pengaturan Board</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama board</label>
                    <input type="text" name="title" class="form-control" value="<?= esc($selectedBoard['title']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3"><?= esc($selectedBoard['description'] ?? '') ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Akses</label>
                    <select name="visibility" class="form-select" data-share-toggle="edit">
                        <option value="private" <?= $selectedBoard['visibility'] === 'private' ? 'selected' : '' ?>>Pribadi</option>
                        <option value="shared" <?= $selectedBoard['visibility'] === 'shared' ? 'selected' : '' ?>>Bagikan ke user terpilih</option>
                    </select>
                </div>
                <div class="<?= $selectedBoard['visibility'] === 'shared' ? '' : 'd-none' ?>" data-share-box="edit">
                    <label class="form-label">User yang bisa melihat</label>
                    <select name="shared_users[]" class="form-select" multiple size="6">
                        <?php foreach ($users as $user): ?>
                            <option value="<?= (int) $user['id'] ?>" <?= in_array((int) $user['id'], $sharedUserIds, true) ? 'selected' : '' ?>>
                                <?= esc($user['username']) ?> - <?= esc($user['role']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="small text-muted mt-1">User terpilih hanya bisa melihat progress.</div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-success" type="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<?php if ($selectedBoard && $canEdit): ?>
<div class="modal fade" id="taskModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" action="<?= base_url($prefix . '/kanban/task/store') ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="board_id" value="<?= (int) $selectedBoard['id'] ?>">
            <input type="hidden" name="status" value="todo">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Tugas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Judul tugas</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="mb-0">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-success" type="submit">Tambah</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<script>
document.querySelectorAll('[data-share-toggle]').forEach((select) => {
    const target = document.querySelector(`[data-share-box="${select.dataset.shareToggle}"]`);
    const sync = () => target && target.classList.toggle('d-none', select.value !== 'shared');
    select.addEventListener('change', sync);
    sync();
});

<?php if ($selectedBoard && $canEdit): ?>
document.querySelectorAll('.task-card[draggable="true"]').forEach((card) => {
    card.addEventListener('dragstart', (event) => {
        event.dataTransfer.setData('task_id', card.dataset.taskId);
    });
});

document.querySelectorAll('.kanban-column').forEach((column) => {
    column.addEventListener('dragover', (event) => {
        event.preventDefault();
        column.classList.add('drag-over');
    });
    column.addEventListener('dragleave', () => column.classList.remove('drag-over'));
    column.addEventListener('drop', async (event) => {
        event.preventDefault();
        column.classList.remove('drag-over');
        const taskId = event.dataTransfer.getData('task_id');
        const formData = new FormData();
        formData.append('task_id', taskId);
        formData.append('status', column.dataset.status);

        const response = await fetch('<?= base_url($prefix . '/kanban/task/status') ?>', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });

        if (response.ok) {
            window.location.reload();
        }
    });
});
<?php endif; ?>
</script>
