<?php
declare(strict_types=1);

namespace models;

use core\Database;
use PDO;

class Forgetpwd
{
    use Database;

    protected $table = 'customers';

    // Check if $email is registered.
    public function is_email_registered(string $email)
    {
        $pdo = $this->get_connection();
        $query = "SELECT email FROM $this->table WHERE email = :email";
        $stms = $pdo->prepare($query);
        $stms->bindParam(":email", $email);
        $stms->execute();
        $result = $stms->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function update_customer_auth_code($email, $auth_code)
    {
        $pdo = $this->get_connection();
        $query = "UPDATE $this->table SET auth_code = :auth_code WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":auth_code", $auth_code);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function clear_customer_auth_code($email)
    {
        $pdo = $this->get_connection();
        $query = "UPDATE $this->table SET auth_code = '' WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
    }

}