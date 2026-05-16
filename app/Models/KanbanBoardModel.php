<?php

namespace App\Models;

use CodeIgniter\Model;

class KanbanBoardModel extends Model
{
    protected $table = 'kanban_boards';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = ['title', 'description', 'owner_id', 'visibility'];
}
