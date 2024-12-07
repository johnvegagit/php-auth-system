<?php
declare(strict_types=1);
defined('ROOTPATH') or exit('Access Denied!');

$DS = DIRECTORY_SEPARATOR;

$currentDirectory = __DIR__;
$newDirectory = dirname($currentDirectory, 2);
require $newDirectory . $DS . 'vendor' . $DS . 'autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->safeLoad();

spl_autoload_register(function ($classname) {
    $classname = str_replace('\\', DIRECTORY_SEPARATOR, $classname);
    require $filename = $_ENV['BASEPTH'] . 'app/' . $classname . '.php';
});


require 'session.php';
require 'function.php';
require 'config.php';
require 'Database.php';
require 'Controller.php';
require 'Router.php';
require 'App.php';