<?php
declare(strict_types=1);
defined('ROOTPATH') or exit('Access Denied!');

class App
{
    use Router;

    public function startApp()
    {
        $this->loadController();
    }

}