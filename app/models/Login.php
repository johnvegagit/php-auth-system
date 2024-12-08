<?php
declare(strict_types=1);

namespace models;

use core\Database;
use PDO;

class Login
{
    use Database;

    protected $table = 'customers';

    public function check_customer_verification_code_exist(string $verification_code)
    {
        $pdo = $this->get_connection();
        $query = "SELECT verification_code FROM $this->table WHERE verification_code = :verification_code";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':verification_code', $verification_code);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function delete_customer_verification_code($verification_code)
    {
        $pdo = $this->get_connection();
        $query = "UPDATE $this->table SET verification_code = '' WHERE verification_code = :verification_code";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':verification_code', $verification_code);
        $stmt->execute();
    }

}