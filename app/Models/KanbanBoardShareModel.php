<?php

namespace App\Models;

use CodeIgniter\Model;

class KanbanBoardShareModel extends Model
{
    protected $table = 'kanban_board_shares';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = false;
    protected $createdField = 'created_at';
    protected $allowedFields = ['board_id', 'user_id', 'created_at'];
}
