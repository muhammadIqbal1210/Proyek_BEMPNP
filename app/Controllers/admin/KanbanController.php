<?php

namespace App\Controllers\Admin; 
use App\Controllers\BaseController;

class KanbanController extends BaseController
{
    public function kanban()
    {
        $data = [
            'title' => 'Kanban Board',
            'page_title' => 'Kanban Board Interaktif',
            'current_menu' => 'kanban', // Untuk menandai menu aktif di Sidebar
            // Jika ada data lain dari database yang perlu dimuat, muat di sini.
        ];
        echo view('template/wrapper', $data); 
        
        echo view('admin/kanban', $data); 
    
    }
}