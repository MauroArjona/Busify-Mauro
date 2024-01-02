const containerPaymentForm = $('#containerPaymentForm');
const btnPayment = $('#btnPayment');
const loadingAnimation = $('#loadingAnimation');
const inputName = $('#name');
const cardnumber = $('#cardnumber');
const expirationdate = $('#expirationdate');
const securitycode = $('#securitycode');
const errorInputs = $('#errorInputs');
const ulErrors = $('#ulErrors');
const btnFinishPayment = $('#btnFinishPayment');

function showContainerPaymentForm() {
    containerPaymentForm.removeAttr("hidden");
    btnPayment.hide();
}

function finishPayment(event, form) {
    event.preventDefault();
    containerPaymentForm.hide();
    loadingAnimation.show();
    setTimeout(function () {
        form.submit();
    }, 5000);
}

function validatePayment(event, form) {
    event.preventDefault();
    let errors = [];
    let error = false;
    if (inputName.val().length < 1) {
        errors.push("El nombre es obligatorio.");
        error = true;
    }
    if (cardnumber.val().length < 1) {
        errors.push("El numero de tarjeta es obligatorio.");
        error = true;
    }
    if (cardnumber.val().length < 16) {
        errors.push("El numero de tarjeta debe tener 16 digitos.");
        error = true;
    }

    if (expirationdate.val().length < 1) {
        errors.push("La fecha de expiración es obligatoria.");
        error = true;
    } else {
        const currentDate = new Date();
        const expirationValue = expirationdate.val();
        const [inputMonth, inputYear] = expirationValue.split('/').map(val => parseInt(val));
        const currentYear = currentDate.getFullYear() % 100; // Obtenemos los últimos dos dígitos del año actual
        const currentMonth = currentDate.getMonth() + 1;

        if ((inputYear === currentYear && inputMonth < currentMonth) || inputYear < currentYear) {
            errors.push("La fecha de expiración es inválida. La tarjeta está vencida.");
            error = true;
        }
    }
    
    
    if (securitycode.val().length < 1) {
        errors.push("El código de seguridad es obligatorio.");
        error = true;
    }
    if (error) {
        ulErrors.empty();
        errors.forEach(error => {
            ulErrors.append(`<li>${error}</li>`);
        });
        errorInputs.removeAttr("hidden");
    } else {
        errorInputs.attr("hidden", true);
        finishPayment(event, form);
    }
}

btnPayment.click(showContainerPaymentForm);
