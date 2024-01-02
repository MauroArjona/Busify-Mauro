//Este script guarda la información del tipo de servicio seleccionado en una cookie y redirige a el simulador de tarifa

// Evento de click boton semicompleto
document
    .getElementById("semicompleto-btn")
    .addEventListener("click", function () {
        const serviceType = "semicompleto";

        // Setear la cookie con service type
        document.cookie = `serviceType=${serviceType}; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/`;

        // Redireccionar
        window.location.href = "{{ route('service.service-price-simulator') }}";
    });

// Evento de click boton completo
document.getElementById("completo-btn").addEventListener("click", function () {
    const serviceType = "completo";
    console.log(serviceType);
    // Setear la cookie con service type
    document.cookie = `serviceType=${serviceType}; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/`;

    // Redireccionar
    window.location.href = "{{ route('service.service-price-simulator') }}";
});
