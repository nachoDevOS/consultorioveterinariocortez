@extends('voyager::master')

@section('page_title', 'Viendo Cita')

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
    </div>
@stop

@push('javascript')
<script></script>
@endpush