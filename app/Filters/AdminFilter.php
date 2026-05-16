<?php namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminFilter implements FilterInterface {
    public function before(RequestInterface $request, $arguments = null) {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        if (!in_array(session()->get('role'), ['admin', 'superadmin'], true)) {
            return redirect()->to('/member/dashboard')->with('error', 'Anda tidak memiliki akses ke panel admin.');
        }
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
