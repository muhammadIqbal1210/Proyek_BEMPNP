<?php namespace App\Filters;
use App\Models\UserModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface {
    public function before(RequestInterface $request, $arguments = null) {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId = $session->get('user_id');
        if ($userId) {
            $userModel = new UserModel();
            $user = $userModel->find($userId);
            if (!$user || (int) ($user['is_active'] ?? 0) !== 1) {
                $session->destroy();
                return redirect()->to('/login')->with('error', 'Akun Anda tidak aktif atau telah dinonaktifkan. Hubungi admin.');
            }
        }
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}