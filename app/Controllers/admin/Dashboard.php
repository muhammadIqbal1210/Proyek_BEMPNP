<?php namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Controllers\BaseController; 

class Dashboard extends Controller
{
    // Dashboard untuk Member (Akses: /dashboard) - Sekarang Akses Publik
    public function index()
    {
    $data['title'] = 'Dashboard Admin'; 
        
        // Gunakan helper 'view' atau fungsi view() bawaan CI4
        echo view('template/header', $data);
        echo view('template/footer', $data);
        
    //     // Pengecekan login telah dihapus.
    //     // Halaman ini sekarang dapat diakses oleh siapa saja (tamu dan member).
        
    //     // Data yang dikirim ke view bisa disesuaikan, misalnya status login
    //     $data = [
    //         'isLoggedIn' => session()->get('user_id') ? true : false,
    //         'username' => session()->get('username'),
    //         'role' => session()->get('role')
    //     ];

    //     // Tampilkan dashboard member
    //     return view('dashboard_member', $data);
    // }

    // // Dashboard untuk Admin (Akses: /admin/dashboard)
    // // Catatan: Akses admin tetap harus dilindungi oleh Filter di Routes atau Admin Controller.
    // public function adminDashboard()
    // {
    //     // Jika Anda menggunakan CodeIgniter Shield:
    //     // if (! service('auth')->check() || ! service('auth')->user()->inGroup('admin')) {
        
    //     // Menggunakan session default:
    //     if (!session()->get('user_id') || session()->get('role') !== 'admin') {
    //         // Arahkan ke dashboard member jika bukan admin, atau login jika belum masuk
    //         if (session()->get('user_id')) {
    //              return redirect()->to('/dashboard');
    //         }
    //         return redirect()->to('/login');
    //     }

        // Tampilkan dashboard admin
        return view('admin/dashboard');
    }
}