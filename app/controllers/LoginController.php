<?php
declare(strict_types=1);
session_start();

use models\Signup as customer_login;

// Autoload configuration to automatically load classes.
// Converts the class name with namespaces into a compatible file path.
// For example: "models/Signup" becomes "models/Signup.php".
// dirname(__DIR__, 1) sets the base directory (the parent of the current directory).
spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class); // Replace '\' with '/' to match file paths on Unix/Windows.
    require dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . $class . '.php'; // Includes the corresponding class file.
});

// Autoload for Dotenv.
// It will get the: $_ENV['DATAMAIL'] and $_ENV['DATAPASS'] data from .env
$currentDirectory = __DIR__;
$newDirectory = dirname($currentDirectory, 2);
require "$newDirectory/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->safeLoad();

class LoginController
{
    public function loginCustomer(string $email, string $password)
    {
        function validate_empty($value)
        {
            return empty(trim($value));
        }

        function validate_email($email)
        {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        }

        function validate_email_char(string $email): bool
        {
            $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
            if (preg_match($pattern, $email)) {
                return true;
            }
            return false;
        }

        function is_email_registered(string $email)
        {
            $getBool = new customer_login;
            if ($getBool->is_email_registered($email)) {
                return true;
            }
            return false;
        }

        function is_user_email_wrong(string $email)
        {
            $getBool = new customer_login;
            if (!$getBool->is_email_registered($email)) {
                return true;
            }
            return false;
        }

        // Check if password are wrong, pwd and hashedPwd should be equal.
        function is_password_wrong(string $password, string $email)
        {
            $get_bol = new customer_login;
            $torf = $get_bol->get_hashedPwd($email);
            if (!password_verify($password, $torf->password)) {
                return true;
            }
            return false;
        }

        // Check if user are verify, check if code in db are empty.
        function is_user_verify(string $email)
        {
            $get_bol = new customer_login;
            $torf = $get_bol->user_verification_code_are_empty($email);
            if ($torf->auth_code) {
                return true;
            }
            return false;
        }

        // Check if user are verify, check if code in db are empty.
        function is_user_banned(string $email)
        {
            $get_bol = new customer_login;
            $torf = $get_bol->user_verification_account_are_banned($email);
            if ($torf->status === 'Blocked') {
                return true;
            }
            return false;
        }

        // Get user data.
        function get_user_data($email)
        {
            $user_data = new customer_login;
            $data = $user_data->get_user_data_from_db($email);
            return $data;
        }

        $errors = [];

        // Email Validation.
        if (validate_empty($email)) {
            $errors['email'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> The field is empty. Please enter your email address.</span>';
        } elseif (!validate_email($email)) {
            $errors['email'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> The email provided is not valid.</span>';
        } elseif (!validate_email_char($email)) {
            $errors['email'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> The email contains invalid characters.</span>';
        } elseif (is_user_email_wrong($email)) {
            $errors['email'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> The information entered is incorrect.</span>';
            $errors['pwd'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> The information entered is incorrect.</span>';
        } elseif (!is_user_email_wrong($email) && is_password_wrong($password, $email)) {
            $errors['email'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> The information entered is incorrect.</span>';
            $errors['pwd'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> The information entered is incorrect.</span>';
        } elseif (is_user_verify($email)) {

            $modalAlert = '
            <div id="HTMLModal-email-send">
                <div class="HTMLModal-icon" ><i class="bi bi-envelope-fill"></i></div>
                <h2>Verify Your Account!</h2>
                <p>Oops! It seems your account is not yet verified. Please check your email and click the verification link to activate your account.</p>
                <a class="HTMLModal-linkto" href="' . $_ENV['BASEURL'] . 'login">Log In</a>
                <p>If you don\'t see the email, remember to check your spam or junk folder.</p>
                <span>We hope to see you soon!</span>
            </div>';

        } elseif (is_user_banned($email)) {
            // Add your Support mobile number.
            $number = '00000000';

            // Your Support email.
            $Helpemail = 'help@my-company.com';

            $modalAlert = '
                <div id="HTMLModal-email-send">
                    <div class="HTMLModal-icon" ><i class="bi bi-exclamation-triangle-fill"></i></div>
                    <h2>Your Account Has Been Blocked!</h2>
                    <p>
                        We are sorry to inform you that we have detected activities in your account that violate our policies or appear suspicious. 
                        If you believe this is a mistake, please contact us through our support channels.
                    </p>

                    <a class="HTMLModal-linkto" href="mailto:' . $Helpemail . '">Contact Support via Email</a>

                    <a class="HTMLModal-linkto" href="https://wa.me/' . $number . '?text=Hello,%20I%20need%20help%20with%20my%20blocked%20account" target="_blank">
                        Contact Support via WhatsApp
                    </a>

                    <a class="HTMLModal-linkto" href="' . $_ENV['BASEURL'] . 'login">
                        Return to Login
                    </a>
                    <span>We hope to assist you soon!</span>
                </div> ';
        }

        // Check if is any errors.
        // Show error alert for email or password.
        if (!empty($errors)) {
            echo json_encode([
                'success' => false,
                'errors' => $errors,
            ]);
            die();
        }

        // Check if is any error.
        // show modal if account is banned or verify.
        if (!empty($modalAlert)) {
            echo json_encode([
                'success' => false,
                'modalAlert' => $modalAlert,
            ]);
            die();
        }

        if (empty($errors) && empty($modalAlert)) {

            // Get customer data and creat a session.
            $getData = get_user_data($email);

            $newSessionId = session_create_id();
            $sessionId = $newSessionId . "_" . $getData->id;
            session_id($sessionId);

            /** saved in session */
            $_SESSION["customerId"] = $getData->id;
            $_SESSION["customerToken"] = htmlspecialchars($getData->token);
            $_SESSION["customerRole"] = htmlspecialchars($getData->role);
            $_SESSION["customerName"] = htmlspecialchars($getData->name);
            $_SESSION["customerSurname"] = htmlspecialchars($getData->surname);
            $_SESSION["customerEmail"] = htmlspecialchars($getData->email);

            $_SESSION["last_regeneration"] = time();

            echo json_encode([
                'success' => true,
                'redirect' => $_ENV['BASEURL']
            ]);
            exit();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $pwd = isset($_POST['pwd']) ? trim($_POST['pwd']) : '';
    $action = isset($_POST['action']) ? trim($_POST['action']) : '';

    $valcustomer = new LoginController;

    switch ($action) {
        case 'loginData':
            $valcustomer->loginCustomer($email, $pwd);
            break;

        default:

            // This error will display if the case: in switch statement fails.
            echo json_encode(value: [
                'success' => false,
                'modal_msg' => '<div id="--modal-error-msg" class="--modal-error-msg">
                                    <span><i class="bi bi-exclamation-triangle-fill"></i> Error</span>
                                    <p>An internal error has occurred. Please try again later.</p>
                                    <button id="closeModalMsgBtn" class="--action-button" type="button" title="close modal">Close</button>
                                </div>',
            ]);
            break;
    }
}