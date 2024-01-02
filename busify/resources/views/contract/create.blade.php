@extends('layouts.principal')
@section('title', 'Crear contrato')
@section('content')
<main class="page registration-page" style="height: 100%;">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <section class="clean-block clean-form dark" style="height: 100%;">
        <div class="container">
            {{-- Campo oculto con id de usuario --}}
            <input type="hidden" name="idUser" id="idUser" value="{{ Auth::user()->userable_id }}">
            <div class="block-heading">
                <h2 class="text-info">Crear contrato</h2>
                <p>Complete los datos solicitados y empiece a disfrutar de los servicios de Busify!.</p>
                <h3 class="text-start text-primary"><a class="btn btn-primary float-end" role="button" data-bs-toggle="modal" data-bs-target="#Modal"><i class="fas fa-plus-circle"></i><span style="background-color:rgb(13, 110, 253);">Agregar servicio</span></a>Servicios</h3>
                {{-- Modal        --}}
                <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="ModalLabel">Agregar servicio
                                </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">

                                <table class="table">
                                    <tr>
                                        <td><strong>Tipo de servicio:</strong></td>
                                        <td>
                                            <div class="dropdown">
                                                <select name="serviceType" id="serviceType" class="btn btn-primary dropdown-toggle">
                                                    <option value="0" selected disabled>Seleccione... </option>
                                                    servicio</option>
                                                    <option value="Semicompleto">Semicompleto</option>
                                                    <option value="Completo">Completo</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nombre de pasajero:</strong></td>
                                        <td><input placeholder="Obligatorio" class="form-control" type="text" id="name"></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Apellido de pasajero:</strong></td>
                                        <td><input placeholder="Obligatorio" class="form-control" type="text" id="lastName"></td>
                                    </tr>
                                    <tr>
                                        <td><strong>DNI de pasajero:</strong></td>
                                        <td><input placeholder="Obligatorio" class="form-control" type="number" id="dniPassenger"></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Grupo sanguineo:</strong></td>
                                        <td><input placeholder="Obligatorio" class="form-control" type="text" id="bloodType"></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Discapacidad:</strong></td>
                                        <td><input placeholder="No es obligatorio" class="form-control" type="text" id="disability"></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Dirección de origen:</strong></td>
                                        <td><input placeholder="Obligatorio" class="form-control" type="text" id="originGoing"></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Dirección de establecimiento:</strong></td>
                                        <td><input placeholder="Obligatorio" class="form-control" type="text" id="destinationGoing"></td>
                                    </tr>
                                    <tr title="Obligatorio">
                                        <td><strong>Distancia total:</strong></td>
                                        <td><input placeholder="Obligatorio (km)" class="form-control" type="number" id="distance"></td>
                                    </tr>
                                    <tr title="Obligatorio">
                                        <td><strong>Hora de recogida:</strong></td>
                                        <td><input placeholder="Obligatorio" class="form-control" type="time" id="hourPickup"></td>
                                    </tr>
                                    <tr title="Obligatorio">
                                        <td><strong>Hora de llegada:</strong></td>
                                        <td><input class="form-control" type="time" id="hourArrival"></td>
                                    </tr>
                                    <tr class="completo-escondido" title="Obligatorio">
                                        <td><strong>Dirección de vuelta:</strong></td>
                                        <td><input placeholder="Obligatorio" class="form-control" type="text" id="destinationReturn"></td>
                                    </tr>
                                    <tr class="completo-escondido" title="Obligatorio">
                                        <td><strong>Hora de retorno:</strong></td>
                                        <td><input placeholder="Obligatorio" class="form-control" type="time" id="hourReturn"></td>
                                    </tr>

                                </table>
                                <div class="error-datos" style="color: #ff0000">

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" onclick="agregarServicio()">Agregar</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Modal --}}
                <div class="table-responsive d-flex mx-auto" style="margin-top: 0px;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 15em;">Tipo de servicio</th>
                                <th style="width: 45em;">Pasajero</th>
                                <th style="width: 45em;">Origen</th>
                                <th style="padding-left: 4px;margin-left: 3px;width: 20em;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-principal">
                        </tbody>
                    </table>
                </div>
                <p>Cantidad de meses de contrato: <select name="months" id="months" class="btn btn-primary dropdown-toggle">
                        <option value="1" selected>1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                    </select></p>
                <div style="display: inline-flex; margin-top: 3em;"><button class="btn btn-primary" type="button" style="background: rgb(25,135,84);margin-right: 5em;border-style: none;" onClick="confirmarEnvio()">Confirmar</button><a href="{{route('contract.create')}}" class="btn btn-primary" type="button" style="background: rgb(220,53,69);border-style: none;">Cancelar</a></div>
            </div>
            @if (Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
            @endif
            @if (Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
            @endif
        </div>
    </section>
</main>
<script src="{{ asset('js/sweetalert2@11.js') }}"></script>
<script>

limitarLongitudCampo('#dniPassenger', 8);
limitarLongitudCampo('#distance', 3);
limitarLongitudCampo('#bloodType', 3);

function limitarLongitudCampo(selector, longitudMaxima) {
    $(selector).on('input', function() {
        if ($(this).val().length > longitudMaxima) {
            $(this).val($(this).val().slice(0, longitudMaxima));
        }
    });
}

    const selectTipoServicio = document.getElementById('serviceType');

    const completo = $('.completo-escondido');

    completo.hide();

    selectTipoServicio.addEventListener('change', (event) => {
        if (event.target.value == "Completo") {
            completo.show();
        } else {
            completo.hide();
        }
    });

    function alertaCompletarDatos(mensaje) {

        Swal.fire({
            title: mensaje,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar'
        });
    };


    // Array para almacenar servicios agregados
    let serviciosAgregados = [];

    function agregarServicio() {
        // Obtener datos del modal
        const tipoServicio = document.getElementById('serviceType').value;
        const distancia = document.getElementById('distance').value;
        const nombrePas = document.getElementById('name').value;
        const apellidoPas = document.getElementById('lastName').value;
        const dniPas = document.getElementById('dniPassenger').value;
        const grupoS = document.getElementById('bloodType').value;
        const discapacidad = document.getElementById('disability').value;
        const dirOrigen = document.getElementById('originGoing').value;
        const dirEstablecimiento = document.getElementById('destinationGoing').value;
        const horaRecogida = document.getElementById('hourPickup').value;
        const horaLlegada = document.getElementById('hourArrival').value;
        const dirVuelta = document.getElementById('destinationReturn').value; //completo
        const horaRetorno = document.getElementById('hourReturn').value; //completo

        if (tipoServicio == "0") {
            alertaCompletarDatos('Debe seleccionar un tipo de servicio');
            return;
        }

        if (distancia <= 0 || distancia >= 100) {
            alertaCompletarDatos('Debe ingresar una distancia mayor a 0 y menor que 100');
            return;
        }

        if (dniPas.length != 8) {
            alertaCompletarDatos('El DNI debe tener 8 digitos');
            return;
        }
        
        var regex = /^(a|b|ab|0)[+-]$/i;
        if (!regex.test(grupoS)) {
            alertaCompletarDatos("El grupo sanguíneo solo puede ser 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', '0+', o '0-'.");
            return;
        }


        if (new Date(`2000-01-01T${horaRecogida}`) >= new Date(`2000-01-01T${horaLlegada}`)) {
                alertaCompletarDatos('La hora de recogida debe ser anterior a la hora de llegada');
                return;
        }

        if (tipoServicio === "Completo") {
            if (new Date(`2000-01-01T${horaRetorno}`) <= new Date(`2000-01-01T${horaRecogida}`) ||
                new Date(`2000-01-01T${horaRetorno}`) <= new Date(`2000-01-01T${horaLlegada}`)) {
                alertaCompletarDatos('La hora de retorno debe ser mayor a las de recogida y llegada');
                return;
            }
        }
        
        if (tipoServicio == "Completo") {
            if (tipoServicio != "0" && distancia && nombrePas && apellidoPas && dniPas && grupoS &&
                dirEstablecimiento && dirOrigen && dirVuelta && horaLlegada && horaRetorno && horaRecogida) {
                serviciosAgregados.push({
                    tipoServicio: tipoServicio,
                    distancia: distancia,
                    nombre: nombrePas,
                    apellido: apellidoPas,
                    dni: dniPas,
                    grupoSan: grupoS,
                    discapacidad: discapacidad,
                    dirEstablecimiento: dirEstablecimiento,
                    dirOrigen: dirOrigen,
                    dirVuelta: dirVuelta,
                    horaLlegada: horaLlegada,
                    horaRetorno: horaRetorno,
                    horaRecogida: horaRecogida
                });
                // Limpiar campos del modal
                $(".form-control").val("");
                $("#Modal").modal('hide');
                actualizarTabla();
            } else {
                alertaCompletarDatos("Debe completar todos los campos obligatorios para continuar.");
            }
        } else if (tipoServicio == "Semicompleto") {
            if (tipoServicio != "0" && distancia && nombrePas && apellidoPas && dniPas && grupoS &&
                dirEstablecimiento && dirOrigen && horaLlegada && horaRecogida) {
                serviciosAgregados.push({
                    tipoServicio: tipoServicio,
                    distancia: distancia,
                    nombre: nombrePas,
                    apellido: apellidoPas,
                    dni: dniPas,
                    grupoSan: grupoS,
                    discapacidad: discapacidad,
                    dirEstablecimiento: dirEstablecimiento,
                    dirOrigen: dirOrigen,
                    dirVuelta: dirVuelta,
                    horaLlegada: horaLlegada,
                    horaRetorno: horaRetorno,
                    horaRecogida: horaRecogida
                });
                $(".form-control").val("");
                $("#Modal").modal('hide');
                actualizarTabla();
            } else {
                alertaCompletarDatos("Debe completar todos los campos obligatorios para continuar.");
            }
        }
    }

    function actualizarTabla() {
        // Limpia la tabla
        document.getElementById("tbody-principal").innerHTML = '';

        // Muestra servicios en la tabla
        serviciosAgregados.forEach(function(servicio) {
            var fila = document.createElement('tr');
            fila.innerHTML =
                `<td>${servicio.tipoServicio}</td>
                <td>${servicio.nombre + " " + servicio.apellido}</td>
                <td>${servicio.dirOrigen}</td>
                <td><button class="btn btn-primary" type="button" onclick='eliminarServicio(${serviciosAgregados.indexOf(servicio)})' style="background: rgb(220,53,69);border-style: none;">Eliminar</button></td>`;
            document.getElementById("tbody-principal").appendChild(fila);
        });
    }

    function eliminarServicio(servicio) {
        serviciosAgregados.splice(servicio, 1);
        actualizarTabla();
    }

    function alertaCompletarDatos(mensaje) {
        Swal.fire({
            title: mensaje,
            icon: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#198754',
            confirmButtonText: 'Aceptar'
        });
    }

    function confirmarEnvio() {
        var idUser = document.getElementById('idUser').value;
        var csrfToken = $('meta[name="csrf-token"]').attr('content'); //Token
        console.log(idUser);
        console.log(serviciosAgregados);
        if (serviciosAgregados.length > 0) {
            $.ajax({
                url: "{{ route('contract.store') }}",
                type: 'POST',
                data: {
                    _token: csrfToken,
                    servicios: serviciosAgregados,
                    id_cliente: idUser,
                    cantidadMeses: document.getElementById('months').value
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Contrato creado con éxito.',
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#198754',
                        confirmButtonText: 'Aceptar'
                    }).then((result) => {

                        window.location.href = "{{ route('fee.index') }}";
                    });
                },
                error: function(response) {
                    Swal.fire({
                        title: 'Error al crear el contrato.',
                        text: "Vuelve a intentarlo.",
                        icon: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#198754',
                        confirmButtonText: 'Aceptar'
                    }).then((result) => {
                        window.location.href = "{{ route('contract.create') }}";
                    });
                }
            });
        } else {
            alertaCompletarDatos("Debe agregar por lo menos un servicio para continuar.");
        }
    }
</script>
@endsection