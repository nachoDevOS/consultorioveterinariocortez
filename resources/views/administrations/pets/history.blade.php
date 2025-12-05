@extends('voyager::master')

@section('page_title', 'Historial de ' . $pet->name)

@section('page_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body" style="padding: 0px">
                        <div class="col-md-8" style="padding: 0px">
                            <h1 class="page-title">
                                <i class="fa-solid fa-notes-medical"></i> Historial de {{ $pet->name }}
                            </h1>
                        </div>
                        <div class="col-md-4 text-right" style="margin-top: 30px">
                            <a href="{{ route('voyager.pets.show', ['id' => $pet->id]) }}" class="btn btn-warning">
                                <i class="voyager-eye"></i> <span>Volver a Detalles</span>
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
                                <h3 class="panel-title">Dueño: {{ $pet->person->first_name }} {{ $pet->person->paternal_surname }}</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                {{-- 
                                    Aquí puedes empezar a construir la lógica para mostrar y registrar el historial.
                                    Por ejemplo, una tabla con las visitas, diagnósticos, tratamientos, etc.
                                --}}
                                <h4 class="text-center" style="margin-top: 50px; margin-bottom: 50px;">Aún no hay registros en el historial.</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop