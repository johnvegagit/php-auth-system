// Onclick show user password...
const showPwds = document.querySelectorAll('.show-pwd-btn');
showPwds.forEach(showPwd => {
    showPwd.addEventListener('click', ()=>{
        const input = showPwd.parentElement.querySelector('.auth-input-pwd');
        if (input.type === "password") {
            input.type = "text";
            input.nextElementSibling.innerHTML = '<i title="hide password" class="bi bi-eye-slash"></i>';
        } else {
            input.type = "password";
            input.nextElementSibling.innerHTML = '<i title="show password" class="bi bi-eye"></i>';
        }
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const steps = document.querySelectorAll('.form-step');
    const progressSteps = document.querySelectorAll('.progress-step');
    const nextButtons = document.querySelectorAll('.next-btn');
    const form = document.getElementById('registrationForm');
    let currentStep = 0;

    nextButtons.forEach((button, index) => {
        button.addEventListener('click', () => {
            updateStep(currentStep + 1);
            // if (validateStep(index)) {
            // }
        });
    });

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        if (validateStep(currentStep)) {
            alert('Cuenta creada exitosamente');
            form.reset();
            updateStep(0); // Reinicia el formulario
        }
    });

    function updateStep(newStep) {
        steps[currentStep].classList.remove('active');
        progressSteps[currentStep].classList.remove('active');

        currentStep = newStep;

        steps[currentStep].classList.add('active');
        progressSteps[currentStep].classList.add('active');
    }

    /*function validateStep(stepIndex) {
        const inputs = steps[stepIndex].querySelectorAll('input');
        for (let input of inputs) {
        if (!input.checkValidity()) {
            alert(`Por favor completa el campo: ${input.name}`);
            return false;
        }
        }
        return true;
    }*/
});  
  