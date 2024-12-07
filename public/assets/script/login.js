const LOGINURLPATH = "http://localhost/public_html/php-auth-system/app/controllers/LoginController.php";
const loginbtn = document.getElementById('loginData');

const loginForm = document.getElementById('loginForm');
if (loginForm != null) {
    loginForm.addEventListener('click', (e)=> {
        if (e.target.id === 'loginData' && e.target.tagName === 'BUTTON') {
            e.preventDefault();

            // Add style effect to button.
            loginbtn.disabled = true;
            loginbtn.innerHTML = 'Loading... <i class="fa fa-circle-o-notch fa-spin"></i>';
            loginbtn.style.cursor = 'not-allowed';

            const formElement = e.target.closest('form');
            
            if (formElement) {
                sendLoginDataFunc(formElement);
            } else {

                // Reset button to default.
                loginbtn.disabled = false;
                loginbtn.innerHTML = 'Login';
                loginbtn.style.cursor = 'pointer';
            }
        }
    });
}

function sendLoginDataFunc(formElement) {
    const xhr = new XMLHttpRequest;
    const formData = new FormData;

    formData.append('email', formElement.querySelector('.FORM-INPUT-email').value);
    formData.append('pwd', formElement.querySelector('.FORM-INPUT-pwd').value);
    formData.append('action', 'loginData');

    xhr.open('POST', `${LOGINURLPATH}`, true);
    xhr.setRequestHeader("X-Requested-with", "XMLHttpRequest");
    
    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);

            const errFields = ['email','pwd'];
            errFields.forEach(field => {
                const errorMsgElement = document.getElementById(`inputMsg--${field}`);
                if (errorMsgElement) {
                    errorMsgElement.innerHTML = '';

                    // Reset inputs email and password style to default.
                    const inputErr = errorMsgElement.previousElementSibling;
                    inputErr.removeAttribute('style');
                }
            });

            if (!response.success) {
                
                // Reset button to default.
                loginbtn.disabled = false;
                loginbtn.innerHTML = 'Login';
                loginbtn.style.cursor = 'pointer';

                if (response.errors) {

                    // Go through the errors and place them in the corresponding elements.
                    for (const field in response.errors) {
                        const errorMsgElement = document.getElementById(`inputMsg--${field}`);
                        if (errorMsgElement) {
                            errorMsgElement.innerHTML = response.errors[field];
                            const inputErr = errorMsgElement.previousElementSibling;

                            // Add css style to inputs email and password.
                            inputErr.style.border = '2px solid #ff0000';
                            inputErr.style.outline = '3px solid #ff000015';
                            inputErr.style.borderRadius = '5px';
                        }
                    }
                }

                if (response.modalAlert) {
                    document.getElementById('authContainer').style.height = '100vh';
                    document.getElementById('authContainer').innerHTML = response.modalAlert; 
                }

                if (response.modal_msg) {
                    document.getElementById('modalMessageContainer').style.display = 'flex';
                    document.getElementById('modalMessageContainer').innerHTML = response.modal_msg;
                }
            } else {
                
                // Add style effect to button.
                loginbtn.disabled = false;
                loginbtn.innerHTML = 'Login';
                loginbtn.style.cursor = 'pointer';

                window.location.href = response.redirect;
            }
        } else {
            console.error('Error: '+this.status);

            // Reset button to default.
            loginbtn.disabled = false;
            loginbtn.innerHTML = 'Login';
            loginbtn.style.cursor = 'pointer';

        }
    }
    xhr.send(formData);
}