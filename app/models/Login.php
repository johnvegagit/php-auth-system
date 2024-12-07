<?php
declare(strict_types=1);

namespace models;

use core\Database;
use PDO;

class Login
{
    use Database;

    protected $table = 'customers';

    public function check_customer_auth_code_exist(string $auth_code)
    {
        $pdo = $this->get_connection();
        $query = "SELECT auth_code FROM $this->table WHERE auth_code = :auth_code";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':auth_code', $auth_code);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function delete_auth_customer_code($auth_code)
    {
        $pdo = $this->get_connection();
        $query = "UPDATE $this->table SET auth_code = '' WHERE auth_code = :auth_code";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':auth_code', $auth_code);
        $stmt->execute();
    }

}