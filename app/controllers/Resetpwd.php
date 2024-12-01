<?php
declare(strict_types=1);
defined('ROOTPATH') or exit('Access Denied!');

class Resetpwd
{
    use Controller;

    public function index()
    {
        $data = [
            'title' => 'Resetpwd page',
        ];
        $this->auth_header($data);
        $this->view('layout/auth/resetpwd', $data);
        $this->auth_footer();
    }
}