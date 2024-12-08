<?php
declare(strict_types=1);

namespace models;

use core\Database;
use PDO;

class Resetpwd
{
    use Database;

    protected $table = 'customers';

    public function customers_password_reset_code_exist($password_reset_code)
    {
        $pdo = $this->get_connection();
        $query = "SELECT password_reset_code FROM $this->table WHERE password_reset_code = :password_reset_code";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':password_reset_code', $password_reset_code);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function update_customer_reset($password, $password_reset_code)
    {
        $pdo = $this->get_connection();
        $query = "UPDATE $this->table SET password = :password, password_reset_code = '' WHERE password_reset_code = :password_reset_code";
        $stmt = $pdo->prepare($query);

        $option = [
            'cost' => 12
        ];
        $hashedpassword = password_hash($password, PASSWORD_BCRYPT, $option);

        $stmt->bindParam(":password", $hashedpassword);
        $stmt->bindParam(":password_reset_code", $password_reset_code);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

}