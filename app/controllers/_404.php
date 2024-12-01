<?php
declare(strict_types=1);
defined('ROOTPATH') or exit('Access Denied!');

class _404
{
    use Controller;

    public function index()
    {
        $data = ['title' => 'Error 404'];
        $this->header($data);
        $this->view('404');
        $this->footer();
    }

}