@extends('voyager::master')

@section('page_title', 'Viendo Mascota')

@section('page_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body" style="padding: 0px">
                        <div class="col-md-8" style="padding: 0px">
                            <h1 class="page-title">
                                <i class="fa-solid fa-dog"></i> Viendo Mascota
                            </h1>
                        </div>
                        <div class="col-md-4 text-right" style="margin-top: 30px">
                            <a href="{{ route('voyager.pets.history.create', ['id' => $pet->id]) }}" class="btn btn-primary">
                                <i class="fa-solid fa-notes-medical"></i> <span>Ver Historial</span>
                            </a>
                            <a href="{{ route('voyager.pets.index') }}" class="btn btn-warning">
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
                                <h3 class="panel-title">Detalles de la Mascota</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        @php
                                            $image = $pet->image ? Voyager::image($pet->image) : asset('images/default.jpg');
                                        @endphp
                                        <img src="{{ $image }}" style="width: 100%; max-width: 250px; border-radius: 10px; margin-top: 20px; object-fit: cover;" alt="{{ $pet->name }}">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td><small style="font-size: 14px">Nombre:</small></td>
                                                        <td>{{ strtoupper($pet->name) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><small style="font-size: 14px">Dueño:</small></td>
                                                        <td>
                                                            @if($pet->person)
                                                                {{ strtoupper($pet->person->first_name) }} {{ strtoupper($pet->person->paternal_surname) }} <br>
                                                                <small><b>CI:</b> {{ $pet->person->ci }}</small> - <small><b>Telf:</b> {{ $pet->person->phone }}</small>
                                                            @else
                                                                <span class="text-muted">Sin dueño asignado</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><small style="font-size: 14px">Especie y Raza:</small></td>
                                                        <td>{{ $pet->animal->name ?? 'N/A' }} - {{ $pet->race->name ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><small style="font-size: 14px">Género y Color:</small></td>
                                                        <td>{{ $pet->gender ?? 'N/A' }} - {{ $pet->color ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><small style="font-size: 14px">Fecha de Nacimiento:</small></td>
                                                        <td>
                                                            @if ($pet->birthdate)
                                                                {{ \Carbon\Carbon::parse($pet->birthdate)->format('d/m/Y') }}
                                                                (@php
                                                                    $age = \Carbon\Carbon::parse($pet->birthdate)->diffForHumans(null, true);
                                                                @endphp
                                                                <small>{{ $age }}</small>)
                                                            @else
                                                                No registrada
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><small style="font-size: 14px">Estado:</small></td>
                                                        <td>
                                                            @if ($pet->status == 1)
                                                                <label class="label label-success">Activo</label>
                                                            @else
                                                                <label class="label label-warning">Inactivo</label>
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
                                <small>Registrado el {{ \Carbon\Carbon::parse($pet->created_at)->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Historial Clínico</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                @if($pet->anamnesisForms->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Problema Principal</th>
                                                    <th>Veterinario</th>
                                                    <th class="text-right">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pet->anamnesisForms as $history)
                                                    <tr>
                                                        <td>{{ \Carbon\Carbon::parse($history->date)->format('d/m/Y') }}</td>
                                                        <td>{{ $history->main_problem ?? 'No especificado' }}</td>
                                                        <td>{{ $history->doctor->name ?? 'No especificado' }}</td>
                                                        <td class="no-sort no-click" id="bread-actions">
                                                            {{-- Aquí puedes agregar botones para ver, editar o eliminar un historial --}}
                                                            <a href="#" title="Ver" class="btn btn-sm btn-info view"><i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">Ver</span></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <h4 class="text-center" style="margin-top: 50px; margin-bottom: 50px;">Aún no hay registros en el historial.</h4>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('javascript')
<script>
    $(document).ready(function () {
        // Aquí puedes añadir lógica JS si es necesario, por ejemplo para los modales de ver detalle.
    });
</script>
@endpush