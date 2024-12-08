<?php
declare(strict_types=1);

namespace models;

use core\Database;
use PDO;

class Signup
{
    use Database;

    protected $table = 'customers';

    protected $useAllowedColumns = [
        "name",
        "surname",
        "username",
        "email",
        "password",
        "role",
        "token",
        "verification_code"
    ];

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

    // Check if $username is registered.
    public function is_username_registered(string $username)
    {
        $pdo = $this->get_connection();
        $query = "SELECT username FROM $this->table WHERE username = :username";
        $stms = $pdo->prepare($query);
        $stms->bindParam(":username", $username);
        $stms->execute();
        $result = $stms->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function get_hashedPwd($email)
    {
        $pdo = $this->get_connection();
        $query = "SELECT password FROM $this->table WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function are_customer_verification_code_empty($email)
    {
        $pdo = $this->get_connection();
        $query = "SELECT verification_code FROM $this->table WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function are_customer_account_banned($email)
    {
        $pdo = $this->get_connection();
        $query = "SELECT status FROM $this->table WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function get_customer_data_from_db($email)
    {
        $pdo = $this->get_connection();
        $query = "SELECT * FROM $this->table WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    // This is specific for when a customer creates an account.
    // If any error occurs, this will delete the customer account that was inserted.
    public function deleteUserById($id)
    {
        $pdo = $this->get_connection();
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', var: $id);
        $stmt->execute();
    }

    // Register customer.
    public function signupUser($data)
    {
        $pdo = $this->get_connection();
        /** remove unwanted data **/
        if (!empty($this->useAllowedColumns)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->useAllowedColumns)) {
                    unset($data[$key]);
                }
            }
        }

        $keys = array_keys($data);
        $query = "INSERT INTO $this->table (" . implode(",", $keys) . ") VALUES (:" . implode(",:", $keys) . ")";
        $stmt = $pdo->prepare($query);

        if (isset($data['password'])) {
            $option = [
                'cost' => 12
            ];
            $hashedPwd = password_hash($data['password'], PASSWORD_BCRYPT, $option);
            $data['password'] = $hashedPwd;
        }

        foreach ($keys as $key) {
            $paramName = ':' . $key;
            $stmt->bindParam($paramName, $data[$key]);
        }

        if ($stmt->execute()) {
            return $pdo->lastInsertId(); // Return the last inserted ID
        }

        return false;
    }
}