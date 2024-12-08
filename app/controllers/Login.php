<?php
declare(strict_types=1);
defined('ROOTPATH') or exit('Access Denied!');

use models\Login as customer_login;

class Login
{
    use Controller;

    public function index()
    {
        $data = [
            'title' => 'Login page',
        ];
        $this->auth_header($data);
        $this->view('layout/auth/login', $data);
        $this->auth_footer();
    }

    public function val_verification_code_func(string $customer_verification_code)
    {
        function validate_customer_verification_code($value)
        {
            return !empty($value) && preg_match("/^[a-zA-Z0-9]+$/", $value);
        }

        function customer_verification_code_exist(string $verification_code)
        {
            $query_verification_code = new customer_login;
            if ($query_verification_code->check_customer_verification_code_exist($verification_code)) {
                return true;
            }
            return false;
        }

        function delete_customer_verification_code(string $verification_code)
        {
            $query_verification_code = new customer_login;
            $query_verification_code->delete_customer_verification_code($verification_code);
        }

        // Check if customer auth code exists.
        if (!validate_customer_verification_code($customer_verification_code)) {
            echo '<h5 class="shared-header-login-msg shared-header-login-msg-err">The verification code you provided is invalid or no longer exists. Please check the email we sent you and use the link provided to verify your account.</h5>';
        } elseif (customer_verification_code_exist($customer_verification_code)) {
            echo '<h5 class="shared-header-login-msg">Congratulations! Your account is now active and ready to use.</h5>';
            delete_customer_verification_code($customer_verification_code);
        } else {
            echo '<h5 class="shared-header-login-msg">It seems your account has already been verified. Please log in to continue.</h5>';
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (isset($_GET['verification'])) {
        $get_customer_verification_code = trim(filter_var($_GET['verification'], FILTER_SANITIZE_STRING));
        $action = 'verification';
    }

    $verification_code = new Login;

    switch ($action) {
        case 'verification':
            $verification_code->val_verification_code_func($get_customer_verification_code);
            break;

        default:
            echo '';
            break;
    }
}