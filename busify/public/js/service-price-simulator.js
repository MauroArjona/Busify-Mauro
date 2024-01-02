const form = document.querySelector("form");
const result = document.querySelector("#result");

function validarFormulario(event, form) {
    event.preventDefault();

    const passengerComplete = document.querySelector("input[name='passengerComplete']").value;
    const distanceComplete = document.querySelector("input[name='distanceComplete']").value;
    const passengerSemi = document.querySelector("input[name='passengerSemi']").value;
    const distanceSemi = document.querySelector("input[name='distanceSemi']").value;

    if (distanceComplete && !passengerComplete) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor completa la cantidad de pasajeros para el servicio completo.'
        });
        return;
    }

    if (passengerComplete && !distanceComplete) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor completa la distancia para el servicio completo.'
        });
        return;
    }

    if (distanceSemi && !passengerSemi) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor completa la cantidad de pasajeros para el servicio semicompleto.'
        });
        return;
    }

    if (passengerSemi && !distanceSemi) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor completa la distancia para el servicio semicompleto.'
        });
        return;
    }

    form.submit();
}

    

/*form.addEventListener("submit", (event) => {
    event.preventDefault();

    const serviceType = document.querySelector("#floatingSelect").value;
    const distance = document.querySelector("#distancia").value;
    const numPassengers = document.querySelector("#cantPasajeros").value;

    // Calculate the price based on the service type, distance, and number of passengers
    let pricePerKm;
    if (serviceType === "1") {
        pricePerKm = 10;
    } else if (serviceType === "2") {
        pricePerKm = 15;
    } else {
        result.textContent = "Por favor selecciona un tipo de servicio válido.";
        return;
    }

    if (distance <= 0 || numPassengers <= 0) {
        result.textContent =
            "Por favor ingresa una distancia y cantidad de pasajeros válidos.";
        return;
    }

    const totalPrice = pricePerKm * distance * numPassengers;

    result.textContent = `El precio total del viaje es $${totalPrice}.`;
});*/
