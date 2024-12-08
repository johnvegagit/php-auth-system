const RESETPWDURLPATH = "http://localhost/public_html/php-auth-system/app/controllers/ResetPwdController.php";
const resetpwdbtn = document.getElementById('resetpwdData');

const resetpwdForm = document.getElementById('resetpwdForm');
if (resetpwdForm != null) {
    resetpwdForm.addEventListener('click', (e)=>{

        if (e.target.id === 'resetpwdData' && e.target.tagName === 'BUTTON') {
            e.preventDefault();

            // Add style effect to button.
            resetpwdbtn.disabled = true;
            resetpwdbtn.innerHTML = 'Loading... <i class="fa fa-circle-o-notch fa-spin"></i>';
            resetpwdbtn.style.cursor = 'not-allowed';

            const formElement = e.target.closest('form');
            
            if (formElement) {
                sendResetpwdDataFunc(formElement);
            } else {

                // Reset button to default.
                resetpwdbtn.disabled = false;
                resetpwdbtn.innerHTML = 'Confirm Changes';
                resetpwdbtn.style.cursor = 'pointer';
            }
        }
    });
}

function sendResetpwdDataFunc(formElement) {
    const xhr = new XMLHttpRequest;
    const formData = new FormData;
    
    formData.append('auth', formElement.querySelector('.FORM-INPUT-auth').value);
    formData.append('pwd', formElement.querySelector('.FORM-INPUT-pwd').value);
    formData.append('cnfrpwd', formElement.querySelector('.FORM-INPUT-confrpwd').value);
    formData.append('action', 'resetpwdData');

    xhr.open('POST', `${RESETPWDURLPATH}`, true);
    xhr.setRequestHeader("X-Requested-with", "XMLHttpRequest");

    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);

            const errFields = ['pwd','cnfrpwd'];
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
                resetpwdbtn.disabled = false;
                resetpwdbtn.innerHTML = 'Confirm Changes';
                resetpwdbtn.style.cursor = 'pointer';

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
                    document.getElementById('resetpwdForm').innerHTML = response.HTMLModal;
                }
            }
        }else{
            console.error('Error: '+this.status);

             // Reset button to default.
             forgetpwdbtn.disabled = false;
             forgetpwdbtn.innerHTML = 'Confirm Changes';
             forgetpwdbtn.style.cursor = 'pointer';
        }
    }

    xhr.send(formData);
}