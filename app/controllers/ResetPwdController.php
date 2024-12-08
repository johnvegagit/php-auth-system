<?php
declare(strict_types=1);

use models\Resetpwd as customer_resetpwd;

// Autoload configuration to automatically load classes.
// Converts the class name with namespaces into a compatible file path.
// For example: "models/Signup" becomes "models/Signup.php".
// dirname(__DIR__, 1) sets the base directory (the parent of the current directory).
spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class); // Replace '\' with '/' to match file paths on Unix/Windows.
    require dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . $class . '.php'; // Includes the corresponding class file.
});
class ResetPwdController
{
    public function resetpwdCustomer(string $password, string $confr_password, string $password_reset_code)
    {

        function validate_empty($value)
        {
            return empty(trim($value));
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

        function customer_code_exist(string $password_reset_code)
        {
            $getBool = new customer_resetpwd;

            if (!$getBool->customers_password_reset_code_exist($password_reset_code)) {
                return true;
            }
            return false;
        }

        // Validación de la auth Code.
        if (validate_empty($password_reset_code)) {

            echo json_encode([
                'success' => false,
                'modal_msg' => '<div id="--modal-error-msg" class="--modal-error-msg">
                                    <span><i class="bi bi-exclamation-triangle-fill"></i> Error</span>
                                    <p>There was an issue with the authentication code. Please check the link in your email and try again.</p>
                                    <button id="closeModalMsgBtn" class="--action-button" type="button" title="Close modal">Close</button>
                                </div>'
            ]);
            die();
        } elseif (customer_code_exist($password_reset_code)) {

            echo json_encode([
                'success' => false,
                'modal_msg' => '<div id="--modal-error-msg" class="--modal-error-msg">
                                    <span><i class="bi bi-exclamation-triangle-fill"></i> Error</span>
                                    <p>There was an issue with the authentication code. Please check the link in your email and try again.</p>
                                    <button id="closeModalMsgBtn" class="--action-button" type="button" title="Close modal">Close</button>
                                </div>'

            ]);
            die();
        }

        // Password Validation.
        if (validate_empty($password)) {
            $errors['pwd'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> The field is empty. Please enter your password.</span>';
        } elseif (!are_password_secure($password)) {
            $errors['pwd'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> The password is not secure. It must have at least 8 characters, uppercase, lowercase, special characters, and numbers.</span>';
        } elseif (!are_password_have_minimun_characters($password)) {
            $errors['pwd'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> The password is not secure. It must have at least 8 characters, uppercase, lowercase, special characters, and numbers.</span>';
        } elseif (!is_password_match($password, $confr_password)) {
            $errors['pwd'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Passwords do not match.</span>';
        }

        // Confirm Password Validation.
        if (validate_empty($confr_password)) {
            $errors['cnfrpwd'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> The field is empty. Please confirm your password.</span>';
        } elseif (!is_password_match($password, $confr_password)) {
            $errors['cnfrpwd'] = '<span class="auth-input-msg-err"><i class="bi bi-exclamation-triangle-fill"></i> Passwords do not match.</span>';
        }


        // Verificar si hay errores.
        if (!empty($errors)) {
            echo json_encode([
                'success' => false,
                'errors' => $errors,
            ]);
            die();
        }

        try {
            if (empty($erros)) {
                $HTMLModal = '<div id="HTMLModal-email-send">
                                <div class="HTMLModal-icon" ><i class="bi bi-check-circle-fill"></i></div>
                                <h2>Your password has been successfully reset!</h2>
                                <p> You can now log in with your new password and continue enjoying our services.</p>
                                <a class="HTMLModal-linkto" href="' . $_ENV['BASEURL'] . 'login">Log In</a>
                                <p>If you encounter any issues or have any questions, don\'t hesitate to contact us. We\'re here to help! 😊</p>
                                <span>Thank you for trusting us!</span>
                            </div>';

                $customer = new customer_resetpwd;
                $customer->update_customer_reset($password, $password_reset_code);

                // Si todo está bien.
                echo json_encode([
                    'success' => true,
                    'HTMLModal' => $HTMLModal
                ]);
                exit();
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

    // Recopilar y sanitizar los datos
    $password_reset_code = isset($_POST['auth']) ? trim($_POST['auth']) : '';
    $password = isset($_POST['pwd']) ? trim($_POST['pwd']) : '';
    $confr_password = isset($_POST['cnfrpwd']) ? trim($_POST['cnfrpwd']) : '';
    $action = isset($_POST['action']) ? trim($_POST['action']) : '';

    $valcustomer = new ResetPwdController;

    switch ($action) {
        case 'resetpwdData':
            $valcustomer->resetpwdCustomer($password, $confr_password, $password_reset_code);
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