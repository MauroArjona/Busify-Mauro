//Carga la cookie en el formulario

const serviceTypeCookie =
    '{{ isset($_COOKIE["serviceType"]) ? $_COOKIE["serviceType"] : "" }}';
if (serviceTypeCookie !== "") {
    document.getElementById("floatingSelect").value = serviceTypeCookie;
}
