<?php

namespace App\Models;

use CodeIgniter\Model;

class KanbanTaskModel extends Model
{
    protected $table = 'kanban_tasks';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = ['board_id', 'title', 'description', 'status', 'position'];
}
