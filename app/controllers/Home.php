<?php
declare(strict_types=1);
defined('ROOTPATH') or exit('Access Denied!');

class Home
{
    use Controller;

    public function index()
    {
        $data = [
            'title' => 'Home page',
        ];

        $this->header($data);
        $this->view('home', $data);
        $this->footer();
    }
}