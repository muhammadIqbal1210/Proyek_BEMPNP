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

        // Struktur View harus memuat komponen template secara berurutan:
        // 1. Header (termasuk <head> dan tag <body> pembuka)
        echo view('template/wrapper', $data); 
        
        
        
        // 3. Konten Utama (Konten Kanban yang diinjeksikan)
        // Pastikan file ini ada di app/Views/admin/kanban_view.php
        echo view('admin/kanban', $data); 
    
    }
}