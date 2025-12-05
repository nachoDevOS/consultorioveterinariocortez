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
                            <a href="{{ route('voyager.pets.history', ['id' => $pet->id]) }}" class="btn btn-primary">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop