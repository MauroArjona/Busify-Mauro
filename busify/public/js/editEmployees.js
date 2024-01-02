
function editAssistant(event, form) {
    event.preventDefault();
    let inputs = form.querySelectorAll("input");
    let isError = false;
    const cuil = $('#cuil-id').val();

    inputs.forEach((input) => {
        if (input.value.trim() === "") {
            isError = true;
            input.classList.add("is-invalid");
        } else {
            input.classList.remove("is-invalid");
        }
    });

    if (isError) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Por favor, complete todos los campos.",
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

    Swal.fire({
        title: '¿Seguro desea realizar los cambios?',
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

function editSupervisor(event, form) {
    event.preventDefault();
    let inputs = form.querySelectorAll("input");
    let isEmpty = false;
    const cuil = $('#cuil-id').val();
    const dni = $('#dni-id').val();
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

    if (dni.length < 7 || dni.length > 8) {
        isError = true;
        $('#dni-id').addClass("is-invalid");
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "El DNI debe tener entre 7 y 8 digitos.",
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
        title: '¿Seguro desea realizar los cambios?',
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
