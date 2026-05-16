<?php namespace App\Controllers\Member;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = [
            'title'   => 'Dashboard Member',
            'halaman' => 'Dashboard Member',
            'content' => 'member/dashboard',
        ];

        return view('template/wrapper', $data);
    }
}
