function removalAlert(event, form) {
    event.preventDefault();

    Swal.fire({
        title: "¿Estás seguro que deseas eliminar?",
        text: "No podrás revertir esto.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Eliminar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.value) {
            form.submit();
        }
    });
}




function saveAlert(event, form) {
    event.preventDefault();

    Swal.fire({
        title: "¿Confirmar cambios?",
        text: "Podrás editarlo mas tarde.",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#198754",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Guardar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.value) {
            form.submit();
        }
    });
}




function saveEvent(event, form) {
    event.preventDefault();


    Swal.fire({
        title: '¿Confirmar cambios?',
        text: "Podrás editarlo mas tarde si está permitido.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            form.submit();
        }
    });
};

function saveItinerary(event, form) {
    event.preventDefault();


    Swal.fire({
        title: '¿Confirmar cambios?',
        text: "Podrás editarlo mas tarde.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            form.submit();
        }
    });
};

function acceptContract(event, form) {
    event.preventDefault();

    Swal.fire({
        title: "¿Aprobar contrato?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#198754",
        cancelButtonColor: "##d33",
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.value) {
            form.submit();
        }
    });
}




function rejectContract(event, form) {
    event.preventDefault();

    Swal.fire({
        title: "¿Rechazar contrato?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.value) {
            form.submit();
        }
    });
}



function giveRest(event, form) {
    event.preventDefault();

    Swal.fire({
        title: "¿Dar franco al chofer?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#198754",
        cancelButtonColor: "#d33",
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.value) {
            form.submit();
        }
    });
}

function saveTravelReport(event, form) {
    event.preventDefault();

    const mileage_start = parseFloat($('#mileage_start').val());
    const mileage_end = parseFloat($('#mileage_end').val());
    const description = $('#description').val();

    if (isNaN(mileage_start) || isNaN(mileage_end) || description.trim() === '') {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Debes completar todos los campos',
        });
        return;
    }

    if (mileage_start >= mileage_end) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'El kilometraje inicial no puede ser mayor o igual al final',
        });
        return;
    }

    if (mileage_start < 0 || mileage_end < 0) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'El kilometraje no puede ser negativo',
        });
        return;
    }

    Swal.fire({
        title: '¿Confirmar cambios?',
        text: "Podrás editarlo mas tarde si está permitido.",
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

function saveUnit(event, form) {
    event.preventDefault();
    const patent = $('#patent').val();
    const brand = $('#brand').val();
    const model = $('#model').val();
    const total_capacity = $('#total_capacity').val();
    const mileage = $('#unit_mileage').val();
   

    if (patent.trim() == '' || brand.trim() == '' || model.trim() == '' || total_capacity.trim() == '' || mileage.trim() == '') {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Debes completar todos los campos',
        });
        return;
    }

    if (total_capacity < 0) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'La capacidad no puede ser negativa.',
        });
        return;
    }

    if (mileage < 0) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'El kilometraje no puede ser negativo.',
        });
        return;
    }

    if (!isNaN(brand)) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'La marca no puede contener solamente números.',
        });
        return;
    }


    Swal.fire({
        title: '¿Confirmar cambios?',
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

function updateUnit(event, form) {
    event.preventDefault();
    const patent = $('#unit_patent').val();
    const brand = $('#brand').val();
    const model = $('#model').val();
    const total_capacity = $('#total_capacity').val();
    const mileage = $('#unit_mileage').val();
    const detail = $('#unit_detail').val();

    if (patent.trim() == '' || brand.trim() == '' || model.trim() == '' || total_capacity.trim() == '' || mileage.trim() == '') {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Debes completar todos los campos',
        });
        return;
    }

    if (total_capacity < 0) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'La capacidad no puede ser negativa.',
        });
        return;
    }

    if (mileage < 0) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'El kilometraje no puede ser negativo.',
        });
        return;
    }

    if (!isNaN(brand)) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'La marca no puede contener solamente números.',
        });
        return;
    }

    //si el select state es 'Desafectada' mostrar el campo detalle
    if ($('#unit_state').val() == 'Desafectada') {
        if (detail.trim() == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Debes completar el campo detalle.',
            });
            return;
        }
    }

    Swal.fire({
        title: '¿Confirmar cambios?',
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

function validarFormulario(event, form) {
    event.preventDefault();
    let inputs = form.querySelectorAll("input");
    let isEmpty = false;

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

    form.submit();
}

function createEventAlert(event, form) {
    event.preventDefault();
    let inputs = form.querySelectorAll("input");
    const textarea = form.querySelector("textarea");
    let isEmpty = false;

    inputs.forEach((input) => {
        if (input.value.trim() === "") {
            isEmpty = true;
            input.classList.add("is-invalid");
        } else {
            input.classList.remove("is-invalid");
        }
    });

    if (textarea.value.trim() === "") {
        isEmpty = true;
        textarea.classList.add("is-invalid");
    } else {
        textarea.classList.remove("is-invalid");
    }

    if (isEmpty) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Por favor, complete todos los campos.",
        });
        return;
    }

    form.submit(); //funciona
}

function validateRegister(event, form) {
    event.preventDefault();
    let inputs = form.querySelectorAll("input");
    let isEmpty = false;
    const password = $('#password-id').val();
    const passwordConfirm = $('#password-confirmation-id').val();
    const cuil = $('#cuil-id').val();
    const birthdate = $('#birthdate-id').val();

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

    if (password != passwordConfirm) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Las contraseñas no coinciden.",
        });
        return;
    }


    if (cuil.length < 10 || cuil.length > 11) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "El CUIL debe tener entre 10 y 11 digitos.",
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

    const birthdateDate = new Date(birthdate);
    const minDate = new Date('1900-01-01'); // Establecer la fecha mínima como 1900-01-01

    if (birthdateDate < minDate) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "La fecha de nacimiento debe ser posterior a 1900-01-01.",
        });
        return;
    }

    const today = new Date();
    const age = today.getFullYear() - birthdateDate.getFullYear();
    const month = today.getMonth() - birthdateDate.getMonth();
    if (month < 0 || (month === 0 && today.getDate() < birthdateDate.getDate())) {
        age--;
    }
    if (age < 18) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Debes ser mayor de edad para registrarte.",
        });
        return;
    }

    form.submit();
}


function validateTravelReport(event, form) {
    event.preventDefault();
    const description = $('#description-id').val();

    if (description.trim() === "") {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Por favor, complete la descripción.",
        });
        return;
    }


    Swal.fire({
        title: '¿Confirmar cambios?',
        text: "Podrás editarlo mas tarde si está permitido.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            form.submit();
        }
    });
};

function validateDriver(event, form) {
    event.preventDefault();
    let inputs = form.querySelectorAll("input");
    const dni = $('#dni-id').val();
    const cuil = $('#cuil-id').val();
    const phoneNumber = $('#phoneNumber-id').val();
    const birthdate = $('#birthdate-id').val();
    let isError = false;

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
        isError = true;
        $('#phoneNumber-id').addClass("is-invalid");
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "El número de teléfono debe tener entre 10 y 15 caracteres.",
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
    const birthdateDate = new Date(birthdate);
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
        isError = true;
        $('#birthdate-id').addClass("is-invalid");
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "El chofer debe ser mayor de edad.",
        });
        return;
    }
    
    const minDate = new Date('1900-01-01'); // Establecer la fecha mínima como 1900-01-01

    if (birthdateDate < minDate) {
        isError = true;
        $('#birthdate-id').addClass("is-invalid");
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "La fecha de nacimiento debe ser posterior a 1900-01-01.",
        });
        return;
    }


    form.submit();
};

function updatePrice(event, form) {
    event.preventDefault();
    const price = $('#price').val();
    const discount = $('#discount').val();

    if (price.trim() === "") {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Por favor, complete el campo.",
        });
        return;
    }

    if (price < 0) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "El precio no puede ser negativo.",
        });
        return;
    }

    if (discount < 0) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "El descuento no puede ser negativo.",
        });
        return;
    }

    if (discount > 100) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "El descuento no puede ser mayor al 100%.",
        });
        return;
    }

    if (isNaN(price)) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "El precio debe ser un número.",
        });
        return;
    }

    if (isNaN(discount) ) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Ingrese un descuento válido entre 0 y 100.",
        });
        return;
    }

    Swal.fire({
        title: '¿Confirmar cambios?',
        text: "Podrás editarlo más tarde.",
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