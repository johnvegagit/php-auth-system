<?php
declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use models\Forgetpwd as customer_forgetpwd;

// Autoload configuration to automatically load classes.
// Converts the class name with namespaces into a compatible file path.
// For example: "models/Signup" becomes "models/Signup.php".
// dirname(__DIR__, 1) sets the base directory (the parent of the current directory).
spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class); // Replace '\' with '/' to match file paths on Unix/Windows.
    require dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . $class . '.php'; // Includes the corresponding class file.
});

class ForgetPwdController
{
    public function forgetpwdCustomer($email)
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
            $getBool = new customer_forgetpwd;
            if ($getBool->is_email_registered($email)) {
                return true;
            }
            return false;
        }

        $errors = [];

        if (validate_empty($email)) {
            $errors['email'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Please enter your email address.</span>';
        } elseif (!validate_email($email)) {
            $errors['email'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> The entered email is not valid.</span>';
        } elseif (!validate_email_char($email)) {
            $errors['email'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> The email contains invalid characters.</span>';
        } elseif (!is_email_registered($email)) {
            $errors['email'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> The email address not found.</span>';
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

        // Generate new auth code.
        // Combine the user's email, current timestamp, and a random value to generate a unique string.
        $unique_string = $email . time() . bin2hex(random_bytes(8));
        // Hash the unique string using SHA-256 for added security.
        $password_reset_code = hash('sha256', $unique_string);

        try {
            // Autoload for Dotenv.
            // It will get the: $_ENV['DATAMAIL'] and $_ENV['DATAPASS'] data from .env
            $currentDirectory = __DIR__;
            $newDirectory = dirname($currentDirectory, 2);
            require "$newDirectory/vendor/autoload.php";

            $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
            $dotenv->safeLoad();

            $mail = new PHPMailer(true);

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
            $mail->setFrom($_ENV['DATAMAIL']);
            $mail->addAddress($email);

            // Content.
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'no reply';
            $mail->Body = 'Hello! To reset your password, please click the following link: <b><a href="' . $_ENV['BASEURL'] . 'resetpwd/?auth=' . $password_reset_code . '">Reset my password</a></b>. If you didn’t request this change, please ignore this message. Thank you for trusting us!';

            // Update customers aunt code.
            $customer = new customer_forgetpwd;
            $dataInsert = $customer->update_customer_password_reset_code($email, $password_reset_code);

            if ($dataInsert) {

                // Send a email with a link to customers.
                $mail->send();

                if ($mail) {
                    $HTMLModal = '<div id="HTMLModal-email-send">
                                        <div class="HTMLModal-icon" ><i class="bi bi-envelope-fill"></i></div>
                                        <h2>Check your email!</h2>
                                        <p>We’ve sent a link to reset your password to <strong>' . $email . '</strong>. <br>
                                            Just click the link to set a new password and get back to enjoying our services. 🚀
                                        </p>
                                        <p>If you don’t see the email in your inbox, please check your spam or junk folder.</p>
                                        <span>We can’t wait to have you back! If you have any questions, we’re here to help. 😊</span>
                                    </div>
                                    ';
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
                                    <button id="closeModalMsgBtn" class="--action-button" type="button" title="close modal">Close</button>
                                </div>'

            ]);
            die();
        } catch (Exception $e) {

            // If email not send clear customer auth code.
            $customer->clear_customer_password_reset_code($email);

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
    // Recopilar y sanitizar los datos.
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $action = isset($_POST['action']) ? trim($_POST['action']) : '';

    $valcustomer = new ForgetPwdController;

    switch ($action) {
        case 'forgetpwdData':
            $valcustomer->forgetpwdCustomer($email);
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