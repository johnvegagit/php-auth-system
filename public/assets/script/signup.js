const SINGUPURLPATH = "http://localhost/public_html/php-auth-system/app/controllers/SignupController.php";
const signupbtn = document.getElementById('singupData');

const signupForm = document.getElementById('signupForm');
if (signupForm != null) {
    signupForm.addEventListener('click', (e)=>{
        if (e.target.id === 'singupData' && e.target.tagName === 'BUTTON') {
            e.preventDefault();
            signupbtn.disabled = true;
            signupbtn.innerHTML = 'Loading... <i class="fa fa-circle-o-notch fa-spin"></i>';
            signupbtn.style.cursor = 'not-allowed';
            const formElement = e.target.closest('form');
            if (formElement) {
                sendSignupDataFunc(formElement);
            }else{
                signupbtn.disabled = false;
                signupbtn.innerHTML = 'Create Account err';
                signupbtn.style.cursor = 'pointer';
            }
        }
    });
}

function sendSignupDataFunc(formElement) {
    const xhr = new XMLHttpRequest;
    const formData = new FormData;

    formData.append('name', formElement.querySelector('.FORM-INPUT-name').value);
    formData.append('surname', formElement.querySelector('.FORM-INPUT-surname').value);
    formData.append('username', formElement.querySelector('.FORM-INPUT-username').value);
    formData.append('email', formElement.querySelector('.FORM-INPUT-email').value);
    formData.append('pwd', formElement.querySelector('.FORM-INPUT-pwd').value);
    formData.append('cnfrpwd', formElement.querySelector('.FORM-INPUT-confrpwd').value);
    formData.append('action', 'signupData');

    xhr.open('POST', `${SINGUPURLPATH}`, true);
    xhr.setRequestHeader("X-Requested-with", "XMLHttpRequest");

    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            
            const errFields = ['name','surname','username','email','pwd','cnfrpwd'];
            errFields.forEach(field => {
                const errorMsgElement = document.getElementById(`inputMsg--${field}`);
                if (errorMsgElement) {
                    errorMsgElement.innerHTML = '';
                    const inputErr = errorMsgElement.previousElementSibling;
                    inputErr.removeAttribute('style');
                }
            });

            if (!response.success) {
                
                // Reset button to default.
                signupbtn.disabled = false;
                signupbtn.innerHTML = 'Create Account false';
                signupbtn.style.cursor = 'pointer';

                if (response.errors) {
                    // Recorre los errores y colócalos en los elementos correspondientes
                    for (const field in response.errors) {
                        const errorMsgElement = document.getElementById(`inputMsg--${field}`);
                        if (errorMsgElement) {
                            errorMsgElement.innerHTML = response.errors[field];
                            const inputErr = errorMsgElement.previousElementSibling;
                            inputErr.style.border = '2px solid #ff0000';
                            inputErr.style.outline = '3px solid #ff000015';
                            inputErr.style.borderRadius = '5px';
                        }
                    }
                }

                if (response.modal_msg) {
                    document.getElementById('modalMessageContainer').style.display = 'flex';
                    document.getElementById('modalMessageContainer').innerHTML = response.modal_msg;
                }
            } else {

                signupbtn.disabled = false;
                signupbtn.innerHTML = 'Create Account true';
                signupbtn.style.cursor = 'pointer';

                if (response.HTMLModal) {
                    document.getElementById('authContainer').style.height = '100vh';
                    document.getElementById('signupForm').innerHTML = response.HTMLModal;
                }
            }

        }else{
            console.error('Error: '+this.status);
        }
    }
    xhr.send(formData);
}