@extends('voyager::master')

@section('page_title', 'Viendo Cita')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
@stop

@section('page_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body" style="padding: 0px">
                        <div class="col-md-6" style="padding: 0px">
                            <h1 class="page-title">
                                <i class="fa-solid fa-calendar-check"></i> Viendo Cita
                            </h1>
                        </div>
                        <div class="col-md-6 text-right" style="margin-top: 30px">
                            <a href="#" class="btn btn-info" data-toggle="modal" data-target="#assign-worker-modal">
                                <i class="voyager-people"></i> <span>Asignar Personal</span>
                            </a>
                            <a href="#" class="btn btn-success" data-toggle="modal" data-target="#resend-modal">
                                <i class="fa-brands fa-whatsapp"></i> <span>Reenviar</span>
                            </a>
                            <a href="{{ route('voyager.appointments.index') }}" class="btn btn-warning">
                                <i class="voyager-list"></i> <span>Volver</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="page-content read container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="padding-bottom:5px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Detalles de la Cita</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        @php
                                            $image = $appointment->file ? Voyager::image($appointment->file) : asset('images/default.jpg');
                                        @endphp
                                        <img src="{{ $image }}" style="width: 100%; max-width: 250px; border-radius: 10px; margin-top: 20px; object-fit: cover;" alt="Imagen de la cita">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 20%"><small style="font-size: 14px">ID de la Cita:</small></td>
                                                        <td>{{ $appointment->id }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><small style="font-size: 14px">Servicio:</small></td>
                                                        <td>{{ $appointment->service->name ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><small style="font-size: 14px">Cliente:</small></td>
                                                        <td>
                                                            {{ $appointment->nameClient ?? 'N/A' }} <br>
                                                            @if ($appointment->phoneClient)
                                                                <small><b>Telf:</b> {{ $appointment->phoneClient }}</small>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><small style="font-size: 14px">Mascota:</small></td>
                                                        <td>
                                                            <b>Nombre:</b> {{ $appointment->nameAnimal ?? 'N/A' }} <br>
                                                            <small><b>Especie:</b> {{ $appointment->animal->name ?? 'N/A' }}</small> -
                                                            <small><b>Raza:</b> {{ $appointment->race->name ?? 'N/A' }}</small> -
                                                            <small><b>Sexo:</b> {{ $appointment->gender ?? 'N/A' }}</small>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><small style="font-size: 14px">Fecha y Hora:</small></td>
                                                        <td>
                                                            @if ($appointment->date && $appointment->time)
                                                                {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }} a las {{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}
                                                            @else
                                                                No registrada
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><small style="font-size: 14px">Observaciones:</small></td>
                                                        <td>{{ $appointment->observation ?? 'Ninguna' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><small style="font-size: 14px">Personal Asignado:</small></td>
                                                        <td>{{ $appointment->worker->first_name ?? 'No asignado' }} {{ $appointment->worker->paternal_surname ?? '' }} {{ $appointment->worker->maternal_surname ?? '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><small style="font-size: 14px">Estado:</small></td>
                                                        <td>
                                                            @if ($appointment->status != "Pendiente")
                                                                <label class="label label-success">Atendido</label>
                                                            @else
                                                                <label class="label label-warning">Pendiente</label>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <small>Registrado el {{ \Carbon\Carbon::parse($appointment->created_at)->format('d/m/Y H:i') }} por {{ $appointment->user->name ?? 'N/A' }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($appointment->latitud && $appointment->longitud)
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-bordered" style="padding-bottom:5px;">
                    <div class="panel-heading" style="border-bottom:0;">
                        <h3 class="panel-title">Ubicación de la Cita</h3>
                    </div>
                    <div class="panel-body" style="padding-top:0;">
                        <div id="appointment-map" style="height: 600px; width: 100%; border-radius: 5px;"></div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Modal para reenviar por WhatsApp --}}
    <form action="{{ route('voyager.appointments.resend', ['id' => $appointment->id]) }}" class="form-edit-add" method="POST">
        @csrf
        <div class="modal fade" id="resend-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Reenviar Cita por WhatsApp</h4>
                    </div>
                
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="phone_number">Número de WhatsApp</label>
                            <div class="input-group">
                                <span class="input-group-addon">+591</span>
                                <input type="tel" name="phone_number" class="form-control" placeholder="Ej: 71234567" pattern="[0-9]{8}" title="Ingrese un número de 8 dígitos." required maxlength="8" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-submit">Enviar</button>
                        <button type="button" class="btn btn-default btn-cancel" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- Modal para asignar personal --}}
    <form action="{{ route('appointments.assign.worker', ['id' => $appointment->id]) }}" class="form-edit-add" method="POST">
        @csrf
        @method('PUT')
        <div class="modal fade" id="assign-worker-modal" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Asignar Personal a la Cita</h4>
                    </div>
                
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="customer_id">Trabajador</label>
                            <div class="input-group">
                                <select name="worker_id" id="select-worker_id" required class="form-control"></select>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" title="Nuevo registro" data-target="#modal-create-worker" data-toggle="modal" style="margin: 0px" type="button">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type">Tipo de Asignación</label>
                            <select name="type" id="type" class="form-control select2" required>
                                <option value="" disabled selected>Seleccione una opción</option>
                                <option value="Consultorio">Consultorio</option>
                                <option value="Domicilio">Domicilio</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="observation">Observaciones</label>                     
                            <textarea name="observation" id="observation" class="form-control" rows="4"></textarea>
                        </div>
                        <label class="checkbox-inline">
                            <input type="checkbox" required>Confirmar asignación..!
                        </label>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-submit">Guardar</button>
                        <button type="button" class="btn btn-default btn-cancel" data-dismiss="modal">Cancelar</button>
                    </div>                
                </div>
            </div>
        </div>
    </form>
    @include('partials.modal-registerWorker')
@stop




@push('javascript')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="{{ asset('js/include/worker-select.js') }}"></script>
<script src="{{ asset('js/include/worker-register.js') }}"></script>
<script src="{{ asset('js/btn-submit.js') }}"></script>  
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if ($appointment->latitud && $appointment->longitud)
            const lat = {{ $appointment->latitud }};
            const lng = {{ $appointment->longitud }};
            const mapboxAccessToken = '{{ setting('system.mapsToken') }}';

            if (!mapboxAccessToken) {
                document.getElementById('appointment-map').innerHTML = '<div class="alert alert-danger" style="margin: 10px">Error: El mapa no se puede cargar. El token de acceso no está configurado.</div>';
                return;
            }

            const map = L.map('appointment-map').setView([lat, lng], 16);

            const satelliteLayer = L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/satellite-streets-v12/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
                tileSize: 512,
                zoomOffset: -1,
                accessToken: mapboxAccessToken
            }).addTo(map);

            const streetsLayer = L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/streets-v11/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
                tileSize: 512,
                zoomOffset: -1,
                accessToken: mapboxAccessToken
            });

            const baseMaps = {
                "Satélite": satelliteLayer,
                "Calles": streetsLayer
            };

            L.control.layers(baseMaps).addTo(map);

            L.marker([lat, lng]).addTo(map).bindPopup('Ubicación de la cita.').openPopup();
        @endif
    });
</script>


@endpush