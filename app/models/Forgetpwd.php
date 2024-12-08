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

    public function update_customer_password_reset_code($email, $password_reset_code)
    {
        $pdo = $this->get_connection();
        $query = "UPDATE $this->table SET password_reset_code = :password_reset_code WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password_reset_code", $password_reset_code);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function clear_customer_password_reset_code($email)
    {
        $pdo = $this->get_connection();
        $query = "UPDATE $this->table SET password_reset_code = '' WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
    }

}