@extends('voyager::master')

@section('page_title', 'Ver Animal')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-paw"></i> Viendo Animal &nbsp;
        <a href="{{ route('voyager.animals.index') }}" class="btn btn-warning">
            <span class="glyphicon glyphicon-list"></span>&nbsp;
            Volver a la lista
        </a> 
    </h1>
@stop

@section('content')
    <div class="page-content read container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="padding-bottom:5px;">
                    <div class="row">
                        <div class="col-md-4">
                             <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Especie</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ $item->name }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-4">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Descripción</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ $item->observation ?? 'Sin descripción' }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-4">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Estado</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                @if ($item->status == 1)
                                    <label class="label label-success">Activo</label>
                                @else
                                    <label class="label label-warning">Inactivo</label>
                                @endif
                            </div>
                            <hr style="margin:0;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@stop

@section('css')
    <style>

    </style>
@stop

@section('javascript')
    
@stop