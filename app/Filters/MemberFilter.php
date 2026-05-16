<?php namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class MemberFilter implements FilterInterface {
    public function before(RequestInterface $request, $arguments = null) {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        if (in_array(session()->get('role'), ['admin', 'superadmin'], true)) {
            return redirect()->to('/admin/dashboard');
        }

        if (session()->get('role') !== 'member') {
            return redirect()->to('/login');
        }
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
