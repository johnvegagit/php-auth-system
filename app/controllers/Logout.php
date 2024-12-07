<?php
declare(strict_types=1);
defined('ROOTPATH') or exit('Access Denied!');

class Logout
{

    use Controller;

    public function index()
    {
        session_start();
        session_unset();
        session_destroy();

        header('Location: ' . $_ENV['BASEURL'] . '?logout=success');
        die();
    }
}