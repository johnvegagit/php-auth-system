<?php
declare(strict_types=1);
defined('ROOTPATH') or exit('Access Denied!');

class Forgetpwd
{
    use Controller;

    public function index()
    {
        $data = [
            'title' => 'Forgetpwd page',
        ];
        $this->auth_header($data);
        $this->view('layout/auth/forgetpwd', $data);
        $this->auth_footer();
    }
}