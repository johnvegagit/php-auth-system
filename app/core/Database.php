<?php
declare(strict_types=1);

namespace core;

/** Disactivate php display errors */
ini_set('display_errors', value: 0);
ini_set('display_startup_errors', 0);

use PDO;
use PDOException;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    defined('ROOTPATH') or exit('Access Denied!');
}

// This function is for loading the .env file.
// It is used to load database credentials (DBHOST, DBNAME, DBUSER, DBPASS).
// This function is necessary because it allows AJAX to work when performing database operations.
function loadEnv($path)
{
    if (!file_exists($path)) {
        throw new PDOException(".env file not found");
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {

        // Ignore lines that are comments.
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Split each line into key and value.
        list($key, $value) = explode('=', $line, 2);

        // Remove quotation marks from the value.
        $value = trim($value);
        $value = trim($value, '"');

        // Save in $_ENV
        $_ENV[trim($key)] = $value;
    }
}

trait Database
{
    private $dbhost;
    private $dbname;
    private $dbuser;
    private $dbpass;

    public function __construct()
    {
        $currentDirectory = __DIR__;
        $newDirectory = dirname($currentDirectory, 2);
        loadEnv("$newDirectory/.env");

        $this->dbhost = $_ENV['DBHOST'];
        $this->dbname = $_ENV['DBNAME'];
        $this->dbuser = $_ENV['DBUSER'];
        $this->dbpass = $_ENV['DBPASS'];
    }

    public function get_connection(): PDO
    {
        try {
            $pdo = new PDO("mysql:host=$this->dbhost;dbname=$this->dbname", $this->dbuser, $this->dbpass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

}