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

    public function auth_val(string $authGet)
    {
        function validate_auth_code($value)
        {
            return !empty($value) && preg_match("/^[a-zA-Z0-9]+$/", $value);
        }

        function auth_customer_code_exist(string $auth_code)
        {
            $queryAuthCode = new customer_login;
            if ($queryAuthCode->check_customer_auth_code_exist($auth_code)) {
                return true;
            }
            return false;
        }

        function delete_auth_customer_code(string $auth_code)
        {
            $queryAuthCode = new customer_login;
            $queryAuthCode->delete_auth_customer_code($auth_code);
        }

        // Check if customer auth code exists.
        if (!validate_auth_code($authGet)) {
            echo '<h5 class="shared-header-login-msg">It seems your account has already been verified. Please log in to continue.</h5>';
        } elseif (auth_customer_code_exist($authGet)) {
            echo '<h5 class="shared-header-login-msg">Congratulations! Your account is now active and ready to use.</h5>';
            delete_auth_customer_code($authGet);
        } else {
            echo '<h5 class="shared-header-login-msg shared-header-login-msg-err">The verification code you provided is invalid or no longer exists. Please check the email we sent you and use the link provided to verify your account.</h5>';
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (isset($_GET['verification'])) {
        $authGet = trim(filter_var($_GET['verification'], FILTER_SANITIZE_STRING));
        $action = 'verification';
    }

    $auth = new Login;

    switch ($action) {
        case 'verification':
            $auth->auth_val($authGet);
            break;

        default:
            echo '';
            break;
    }
}