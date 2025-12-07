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
                        <div class="col-md-8" style="padding: 0px">
                            <h1 class="page-title">
                                <i class="fa-solid fa-calendar-check"></i> Viendo Cita
                            </h1>
                        </div>
                        <div class="col-md-4 text-right" style="margin-top: 30px">
                            <a href="#" class="btn btn-success" data-toggle="modal" data-target="#resend-modal">
                                <i class="fa-brands fa-whatsapp"></i> <span>Reenviar por WhatsApp</span>
                            </a>
                            <a href="{{ route('voyager.appointments.index') }}" class="btn btn-warning">
                                <i class="voyager-list"></i> <span>Volver a la lista</span>
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
                                            // Si en el futuro el modelo Appointment tiene una imagen, puedes cambiar 'null' por $appointment->image
                                            $image = null ? Voyager::image(null) : asset('images/default.jpg');
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
            <div class="col-md-12">
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
    <div class="modal fade" id="resend-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Reenviar Cita por WhatsApp</h4>
                </div>
                <form action="{{ route('voyager.appointments.resend', ['id' => $appointment->id]) }}" method="POST">
                    @csrf
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
                        <button type="submit" class="btn btn-primary">Enviar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@push('javascript')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
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