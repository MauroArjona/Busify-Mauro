$("#typeEmployee").change(function () {
    let selectedValue = $(this).val();
    if (selectedValue == 'assistant') {
        $(".assistant-hide").hide();
        $(".assistant-show").removeAttr("hidden");
        $(".employee-hide").hide();
    } else {
        $(".assistant-hide").show();
        $(".assistant-show").attr("hidden", "hidden");
        $(".employee-hide").show();
    }
}
);
function createEmployee(event, form) {
    event.preventDefault();
    let inputs = form.querySelectorAll("input");
    let isEmpty = false;
    const name = $('#name-id').val();
    const lastName = $('#lastName-id').val();
    const email = $('#email-id').val();
    const password = $('#password-id').val();
    const passwordConfirmation = $('#password_confirmation-id').val();
    const typeEmployee = $('#typeEmployee').val();
    const cuil = $('#cuil-id').val();
    const address = $('#address-id').val();
    const phoneNumber = $('#phoneNumber-id').val();
    const birthDate = $('#birthdate-id').val();


    if (typeEmployee != 'assistant') {
        if (email.trim() == '' || password.trim() == '' || passwordConfirmation.trim() == '' || address.trim() == '' || birthDate.trim() == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Debes completar todos los campos',
            });
            return;
        }

        if (password != passwordConfirmation) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Las contraseñas no coinciden',
            });
            return;
        }

        if (password.length < 8) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "La contraseña debe tener al menos 8 caracteres.",
            });
            return;
        }
    }
    if (phoneNumber < 0) {
        isError = true;
        $('#phoneNumber-id').addClass("is-invalid");
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'El número de teléfono no puede ser negativo',
        });
        return;
    }

    if (phoneNumber.length < 10 || phoneNumber.length > 15) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "El número de teléfono debe tener entre 10 y 15 caracteres.",
        });
        return;
    }

    if (typeEmployee == 'none') {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Debes seleccionar un tipo de empleado',
        });
        return;
    }

    if (name.trim() == '' || lastName.trim() == '' || cuil.trim() == '' || phoneNumber.trim() == '') {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Debes completar todos los campos',
        });
        return;
    }

    if (cuil < 0) {
        isError = true;
        $('#cuil-id').addClass("is-invalid");
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'El cuil no puede ser negativo',
        });
        return;
    }
    
    if (cuil.length < 10 || cuil.length > 11) {
        isError = true;
        $('#cuil-id').addClass("is-invalid");
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "El CUIL debe tener entre 10 y 11 digitos.",
        });
        return;
    }

    const today = new Date();
    const birthdateDate = new Date(birthDate);
    const age = today.getFullYear() - birthdateDate.getFullYear();
    const month = today.getMonth() - birthdateDate.getMonth();
    if (month < 0 || (month === 0 && today.getDate() < birthdateDate.getDate())) {
        age--;
    }

    if (birthdateDate > today) {
        isError = true;
        $('#birthdate-id').addClass("is-invalid");
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "La fecha de nacimiento no puede ser mayor a la actual.",
        });
        return;
    }
    if (age < 18) {
        $('#birthdate-id').addClass("is-invalid");
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "El empleado debe ser mayor de edad para registrarlo.",
        });
        return;
    }
    
    const minDate = new Date('1900-01-01'); // Establecer la fecha mínima como 1900-01-01

    if (birthdateDate < minDate) {
        $('#birthdate-id').addClass("is-invalid");
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "La fecha de nacimiento debe ser posterior a 1900-01-01.",
        });
        return;
    }


    Swal.fire({
        title: '¿Confirmar empleado?',
        text: "Podrás editarlo mas tarde.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            form.submit();
        }
    });
}

function createSupervisor(event, form) {
    event.preventDefault();
    let inputs = form.querySelectorAll("input");
    let isEmpty = false;
    const password = $('#password-id').val();
    const passwordConfirmation = $('#password_confirmation-id').val();
    const cuil = $('#cuil-id').val();
    const phoneNumber = $('#phoneNumber-id').val();
    const birthDate = $('#birthdate-id').val();
   
    inputs.forEach((input) => {
        if (input.value.trim() === "") {
            isEmpty = true;
            input.classList.add("is-invalid");
        } else {
            input.classList.remove("is-invalid");
        }
    });

    if (isEmpty) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Por favor, complete todos los campos.",
        });
        return;
    }

    if (password != passwordConfirmation) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Las contraseñas no coinciden',
        });
        return;
    }

    if (password.length < 8) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "La contraseña debe tener al menos 8 caracteres.",
        });
        return;
    }

    if (phoneNumber < 0) {
        $('#phoneNumber-id').addClass("is-invalid");
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'El numero de telefono no puede ser negativo',
        });
        return;
    }

    if (phoneNumber.length < 10 || phoneNumber.length > 15) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "El número debe tener entre 10 y 15 caracteres.",
        });
        return;
    }
    

    if (cuil < 0) {
        $('#cuil-id').addClass("is-invalid");
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'El cuil no puede ser negativo',
        });
        return;
    }

    if (cuil.length < 10 || cuil.length > 11) {
        isError = true;
        $('#cuil-id').addClass("is-invalid");
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "El CUIL debe tener entre 10 y 11 digitos.",
        });
        return;
    }


    const today = new Date();
    const birthdateDate = new Date(birthDate);
    const age = today.getFullYear() - birthdateDate.getFullYear();
    const month = today.getMonth() - birthdateDate.getMonth();
    if (month < 0 || (month === 0 && today.getDate() < birthdateDate.getDate())) {
        age--;
    }
    if (birthdateDate > today) {
        isError = true;
        $('#birthdate-id').addClass("is-invalid");
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "La fecha de nacimiento no puede ser mayor a la actual.",
        });
        return;
    }
    if (age < 18) {
        $('#birthdate-id').addClass("is-invalid");
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "El supervisor debe ser mayor de edad para registrarlo.",
        });
        return;
    }
    
    const minDate = new Date('1900-01-01'); // Establecer la fecha mínima como 1900-01-01

    if (birthdateDate < minDate) {
        $('#birthdate-id').addClass("is-invalid");
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "La fecha de nacimiento debe ser posterior a 1900-01-01.",
        });
        return;
    }

    Swal.fire({
        title: '¿Confirmar supervisor?',
        text: "Podrás editarlo mas tarde.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            form.submit();
        }
    });
}
