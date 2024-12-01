<?php
declare(strict_types=1);
defined('ROOTPATH') or exit('Access Denied!');

class Login
{
    use Controller;

    public function index()
    {
        $data = [
            'title' => 'Login page',
        ];
        $this->auth_header($data);
        $this->view('layout/auth/login', $data);
        $this->auth_footer();
    }

    public function auth()
    {
        echo 'auth page';
    }
}