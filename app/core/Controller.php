<?php
declare(strict_types=1);
defined('ROOTPATH') or exit('Access Denied!');

$DS = DIRECTORY_SEPARATOR;

$currentDirectory = __DIR__;
$newDirectory = dirname($currentDirectory, 2);
require $newDirectory . $DS . 'vendor' . $DS . 'autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->safeLoad();

trait Controller
{
    public function header($data = [])
    {
        $DS = DIRECTORY_SEPARATOR;
        $filename = $_ENV['BASEPTH'] . 'app' . $DS . 'views' . $DS . 'layout' . $DS . 'header.php';
        if (file_exists($filename)) {
            require $filename;
        } else {
            $filename = $_ENV['BASEPTH'] . 'app' . $DS . 'views' . $DS . '404.view.php';
            require $filename;
        }
    }

    public function footer()
    {
        $DS = DIRECTORY_SEPARATOR;
        $filename = $_ENV['BASEPTH'] . 'app' . $DS . 'views' . $DS . 'layout' . $DS . 'footer.php';
        if (file_exists($filename)) {
            require $filename;
        } else {
            $filename = $_ENV['BASEPTH'] . 'app' . $DS . 'views' . $DS . '404.view.php';
            require $filename;
        }
    }

    public function auth_header($data = [])
    {
        $DS = DIRECTORY_SEPARATOR;
        $filename = $_ENV['BASEPTH'] . 'app' . $DS . 'views' . $DS . 'layout' . $DS . 'auth' . $DS . 'header.php';
        if (file_exists($filename)) {
            require $filename;
        } else {
            $filename = $_ENV['BASEPTH'] . 'app' . $DS . 'views' . $DS . '404.view.php';
            require $filename;
        }
    }

    public function auth_footer($data = [])
    {
        $DS = DIRECTORY_SEPARATOR;
        $filename = $_ENV['BASEPTH'] . 'app' . $DS . 'views' . $DS . 'layout' . $DS . 'auth' . $DS . 'footer.php';
        if (file_exists($filename)) {
            require $filename;
        } else {
            $filename = $_ENV['BASEPTH'] . 'app' . $DS . 'views' . $DS . '404.view.php';
            require $filename;
        }
    }

    public function view($name, $data = [])
    {
        $DS = DIRECTORY_SEPARATOR;
        $filename = $_ENV['BASEPTH'] . 'app' . $DS . 'views' . $DS . $name . '.view.php';
        if (file_exists($filename)) {
            require $filename;
        } else {
            $filename = $_ENV['BASEPTH'] . 'app' . $DS . 'views' . $DS . '404.view.php';
            require $filename;
        }
    }
}