// Onclick show user password...
const showPwds = document.querySelectorAll('.show-pwd-btn');
showPwds.forEach(showPwd => {
    showPwd.addEventListener('click', ()=>{
        const input = showPwd.parentElement.querySelector('.auth-input-pwd');
        if (input.type === "password") {
            input.type = "text";
            input.previousElementSibling.innerHTML = '<i title="hide password" class="bi bi-eye-slash"></i>';
        } else {
            input.type = "password";
            input.previousElementSibling.innerHTML = '<i title="show password" class="bi bi-eye"></i>';
        }
    });
});

// Remove modal msg.
const closeModalMsg = document.getElementById('modalMessageContainer');
if (closeModalMsg != null) {
    closeModalMsg.addEventListener('click', (e)=> {
        e.preventDefault();
        if (e.target.matches('#closeModalMsgBtn')) {
            document.getElementById('modalMessageContainer').style.display='none';
            const scsMsg = document.getElementById('--modal-scss-msg');
            if (scsMsg) {
                document.getElementById('--modal-scss-msg').remove();
            } else {
                document.getElementById('--modal-error-msg').remove();
            }
        }
    });
}