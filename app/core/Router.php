<?php
declare(strict_types=1);
defined('ROOTPATH') or exit('Access Denied!');

$DS = DIRECTORY_SEPARATOR;

$currentDirectory = __DIR__;
$newDirectory = dirname($currentDirectory, 2);
require $newDirectory . $DS . 'vendor' . $DS . 'autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->safeLoad();

trait Router
{
    private $controller = 'user';
    private $method = 'index';

    private function splitURL()
    {
        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        return $URL;
    }

    public function loadController()
    {
        $URL = $this->splitURL();
        $filename = $_ENV['BASEPTH'] . 'app/controllers/' . ucfirst($URL[0]) . ".php";

        if (file_exists($filename)) {
            require $filename;
            $this->controller = ucfirst($URL[0]);
            unset($URL[0]);
        } else {
            $filename = $_ENV['BASEPTH'] . 'app/controllers/_404.php';
            require $filename;
            $this->controller = '_404';
        }

        $controller = new $this->controller;

        if (!empty($URL[1])) {
            if (method_exists($controller, $URL[1])) {
                $this->method = $URL[1];
                showPre($this->method);
                unset($URL[1]);
            }
        }
        call_user_func_array([$controller, $this->method], $URL);
    }
}