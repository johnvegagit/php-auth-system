<?php
declare(strict_types=1);
defined('ROOTPATH') or exit('Access Denied!');

class Signup
{
    use Controller;

    public function index()
    {
        $data = [
            'title' => 'Signup page',
        ];
        $this->auth_header($data);
        $this->view('layout/auth/signup', $data);
        $this->auth_footer();
    }
}