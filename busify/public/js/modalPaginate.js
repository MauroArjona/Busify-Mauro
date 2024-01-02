$(document).ready(function () {
    $('.modal-paginate a').click(function (e) {
        console.log("hola");
        e.preventDefault();

        var url = $(this).attr('href');

        // Hacemos una solicitud Ajax para obtener la siguiente página de resultados.
        $solicitud = $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json'
        });

        // Cuando la solicitud se complete, insertamos el HTML de la página en el contenedor.
        $solicitud.done(function (data) {
            //data es el html de la pagina, yo lo que hago es buscar el div que tiene dentro el tbody y lo inserto en el tbody de la pagina
            console.log(data);
        });

        // Cuando se completa la solicitud, cambiamos la URL en la barra de direcciones.
        $solicitud.always(function () {
            window.history.pushState('', '', url);
        });
    });
});