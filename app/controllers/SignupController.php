<?php
declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use models\Signup as customer_signup;

// Autoload configuration to automatically load classes.
// Converts the class name with namespaces into a compatible file path.
// For example: "models/Signup" becomes "models/Signup.php".
// dirname(__DIR__, 1) sets the base directory (the parent of the current directory).
spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class); // Replace '\' with '/' to match file paths on Unix/Windows.
    require dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . $class . '.php'; // Includes the corresponding class file.
});

class SignupController
{
    public function signupDataCntr(string $name, string $surname, string $username, string $email, string $pwd, string $cnfrpwd)
    {
        function validate_empty($value)
        {
            return empty(trim($value));
        }

        function validate_name($value)
        {
            return preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s'-]+$/", $value);
        }

        function validate_username_char($value)
        {
            return preg_match("/^[0-9a-zA-ZáéíóúÁÉÍÓÚñÑ\s'-]+$/", $value);
        }

        function is_username_taken(string $username)
        {
            $getBool = new customer_signup;
            if ($getBool->is_username_registered($username)) {
                return true;
            }
            return false;
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
            $getBool = new customer_signup;
            if ($getBool->is_email_registered($email)) {
                return true;
            }
            return false;
        }

        function is_password_match(string $password, string $password_cnfr)
        {
            if ($password === $password_cnfr) {
                return true;
            }
            return false;
        }

        function are_password_have_minimun_characters($password)
        {
            if (strlen($password) < 8) {
                return false;
            }
            return true;
        }

        function are_password_secure($password)
        {
            if (
                !preg_match('/[a-z]/', $password) || !preg_match('/[A-Z]/', $password) ||
                !preg_match('/[0-9]/', $password) || !preg_match('/[^a-zA-Z0-9]/', $password)
            ) {
                return false;
            }
            return true;
        }

        $errors = [];

        // These are if else condition for errors validations.
        if (validate_empty($name)) {
            $errors['name'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Please enter your name.</span>';
        } elseif (!validate_name($name)) {
            $errors['name'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Invalid characters detected.</span>';
        }

        if (validate_empty($surname)) {
            $errors['surname'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Please enter your surname.</span>';
        } elseif (!validate_name($surname)) {
            $errors['surname'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Invalid characters detected.</span>';
        }

        if (validate_empty($username)) {
            $errors['username'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Please enter a username.</span>';
        } elseif (!validate_username_char($username)) {
            $errors['username'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Invalid characters detected.</span>';
        } elseif (is_username_taken($username)) {
            $errors['username'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Username already taken.</span>';
        }

        if (validate_empty($email)) {
            $errors['email'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Please enter your email address.</span>';
        } elseif (!validate_email($email)) {
            $errors['email'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> The entered email is not valid.</span>';
        } elseif (!validate_email_char($email)) {
            $errors['email'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> The email contains invalid characters.</span>';
        } elseif (is_email_registered($email)) {
            $errors['email'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> This email is already associated with another account. Please use a different email.</span>';
        }

        if (validate_empty($pwd)) {
            $errors['pwd'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Please enter your password.</span>';
        } elseif (!are_password_secure($pwd)) {
            $errors['pwd'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> The password is not secure. It must have at least 8 characters, uppercase, lowercase, special characters, and numbers.</span>';
        } elseif (!are_password_have_minimun_characters($pwd)) {
            $errors['pwd'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> The password is not secure. It must have at least 8 characters, uppercase, lowercase, special characters, and numbers.</span>';
        } elseif (!is_password_match($pwd, $cnfrpwd)) {
            $errors['pwd'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Passwords do not match.</span>';
        }

        if (validate_empty($cnfrpwd)) {
            $errors['cnfrpwd'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Please confirm your password.</span>';
        } elseif (!is_password_match($pwd, $cnfrpwd)) {
            $errors['cnfrpwd'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Passwords do not match.</span>';
        }

        // Check if is any errors.
        if (!empty($errors)) {
            echo json_encode([
                'success' => false,
                'errors' => $errors,
            ]);
            die();
        }

        $role = 'client';
        $token = bin2hex(random_bytes(32)) . time();
        // Generate new auth code.
        // Combine the user's email, current timestamp, and a random value to generate a unique string.
        $unique_string = $email . time() . bin2hex(random_bytes(8));
        // Hash the unique string using SHA-256 for added security.
        $verification_code = hash('sha256', $unique_string);

        $data = [
            'name' => $name,
            'surname' => $surname,
            'username' => $username,
            'email' => $email,
            'password' => $pwd,
            'role' => $role,
            'token' => $token,
            'verification_code' => $verification_code
        ];

        try {
            // Autoload for Dotenv.
            // It will get the: $_ENV['DATAMAIL'] and $_ENV['DATAPASS'] data from .env
            $currentDirectory = __DIR__;
            $newDirectory = dirname($currentDirectory, 2);
            require "$newDirectory/vendor/autoload.php";

            $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
            $dotenv->safeLoad();

            $mail = new PHPMailer(true);

            $mail->CharSet = 'UTF-8';
            // Server SMTP settings and email content.
            #$mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output.
            $mail->SMTPDebug = SMTP::DEBUG_OFF; // Disactivate verbose debug output.
            $mail->isSMTP(); // Send using SMTP.
            $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through.
            $mail->SMTPAuth = true; // Enable SMTP authentication.
            $mail->Username = $_ENV['DATAMAIL']; //SMTP username.
            $mail->Password = $_ENV['DATAPASS']; //SMTP password.
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption.
            $mail->Port = 465; // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`.

            // Recipients.
            $mail->setFrom($_ENV['DATAMAIL'], 'your-website.com');
            $mail->addAddress($email);

            // Content.
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'no reply - Activate your account';
            $mail->Body = 'Hello! To activate your account, simply verify it using this link: <b><a href="' . $_ENV['BASEURL'] . 'login/?verification=' . $verification_code . '">Verify my account</a></b>. We hope you enjoy your experience with us!';

            // Insert customers data in database.
            $user = new customer_signup();
            $dataInsert = $user->signupUser($data);

            if ($dataInsert) {

                // Send a email with a link to customers.
                $mail->send();

                if ($mail) {
                    $HTMLModal = '
                    <div id="HTMLModal-email-send">
                        <img src="' . $_ENV['BASEURL'] . 'public/assets/image/success.png" alt="success.png">
                        <h2>Hello, ' . $name . ' ' . $surname . '!</h2>
                        <p>We are so excited to have you with us! 🎉</p>
                        <p>To complete your registration, we have sent a verification link to 
                            <strong>' . $email . '</strong>. <br>
                            Just one more step: click on the link to validate your email and activate your account. 🚀
                        </p>
                        <p>If you cannot find the email, don’t forget to check your spam or junk mail folder.</p>
                        <span>We hope to see you soon enjoying our services!</span>
                    </div>';

                    echo json_encode([
                        'success' => true,
                        'HTMLModal' => $HTMLModal
                    ]);
                    exit();
                }
            }
        } catch (PDOException $e) {

            // This error message will be displayed when a data insertion fails,
            // such as due to an incorrect column name or a poorly written SQL statement.
            echo json_encode([
                'success' => false,
                'modal_msg' => '<div id="--modal-error-msg" class="--modal-error-msg">
                                    <span><i class="bi bi-exclamation-triangle-fill"></i> Error</span>
                                    <p>We are experiencing some technical issues. Please try again later.</p>
                                    ' . $e->getMessage() . '
                                    <button id="closeModalMsgBtn" class="--action-button" type="button" title="close modal">Close</button>
                                </div>'

            ]);
            die();
        } catch (Exception $e) {

            // If any errors happends. Delete the custumer data from database.
            $user->deleteUserById($dataInsert);

            // This error message will be displayed when the email sending process fails,
            // possibly due to incorrect SMTP settings, server issues, or network problems.
            echo json_encode([
                'success' => false,
                'modal_msg' => '<div id="--modal-error-msg" class="--modal-error-msg">
                                    <span><i class="bi bi-exclamation-triangle-fill"></i> Error</span>
                                    <p>An error occurred while verifying your information. Please try again later.</p>
                                    <button id="closeModalMsgBtn" class="--action-button" type="button" title="close modal">Close</button>
                                </div>'
            ]);
            die();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $surname = isset($_POST['surname']) ? trim($_POST['surname']) : '';
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $pwd = isset($_POST['pwd']) ? trim($_POST['pwd']) : '';
    $cnfrpwd = isset($_POST['cnfrpwd']) ? trim($_POST['cnfrpwd']) : '';
    $action = isset($_POST['action']) ? trim($_POST['action']) : '';

    $valemail = new SignupController;

    switch ($action) {
        case 'signupData':
            $valemail->signupDataCntr($name, $surname, $username, $email, $pwd, $cnfrpwd);
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