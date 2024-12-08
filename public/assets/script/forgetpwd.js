const FORGETPWDURLPATH = "http://localhost/public_html/php-auth-system/app/controllers/ForgetPwdController.php";
const forgetpwdbtn = document.getElementById('forgetpwdData');

const forgetpwdForm = document.getElementById('forgetpwdForm');
if (forgetpwdForm != null) {
    forgetpwdForm.addEventListener('click', (e)=>{

        if (e.target.id === 'forgetpwdData' && e.target.tagName === 'BUTTON') {
            e.preventDefault();

            // Add style effect to button.
            forgetpwdbtn.disabled = true;
            forgetpwdbtn.innerHTML = 'Loading... <i class="fa fa-circle-o-notch fa-spin"></i>';
            forgetpwdbtn.style.cursor = 'not-allowed';

            const formElement = e.target.closest('form');
            
            if (formElement) {
                sendForgetpwdDataFunc(formElement);
            } else {

                // Reset button to default.
                forgetpwdbtn.disabled = false;
                forgetpwdbtn.innerHTML = 'Send Link';
                forgetpwdbtn.style.cursor = 'pointer';
            }
        }
    });
}

function sendForgetpwdDataFunc(formElement) {
    const xhr = new XMLHttpRequest;
    const formData = new FormData;
    
    formData.append('email', formElement.querySelector('.FORM-INPUT-email').value);
    formData.append('action', 'forgetpwdData');

    xhr.open('POST', `${FORGETPWDURLPATH}`, true);
    xhr.setRequestHeader("X-Requested-with", "XMLHttpRequest");

    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);

            const errFields = ['email'];
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
                forgetpwdbtn.disabled = false;
                forgetpwdbtn.innerHTML = 'Send Link';
                forgetpwdbtn.style.cursor = 'pointer';

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
                
                if (response.HTMLModal) {
                    document.getElementById('authContainer').style.height = '100vh';
                    document.getElementById('forgetpwdForm').innerHTML = response.HTMLModal;
                }
            }
        }else{
            console.error('Error: '+this.status);

             // Reset button to default.
             forgetpwdbtn.disabled = false;
             forgetpwdbtn.innerHTML = 'Send Link';
             forgetpwdbtn.style.cursor = 'pointer';
        }
    }

    xhr.send(formData);
}
