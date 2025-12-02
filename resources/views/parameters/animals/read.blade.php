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

        {{-- Races list --}}
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-8">
                                <h4>
                                    <i class="voyager-categories"></i> Razas de esta Especie
                                </h4>
                            </div>
                            <div class="col-sm-4 text-right">
                                @if (auth()->user()->hasPermission('add_races'))
                                    <button class="btn btn-success" data-target="#modal-register-race" data-toggle="modal" style="margin: 5px">
                                        <i class="voyager-plus"></i> <span>Agregar Raza</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="row" id="div-results" style="min-height: 120px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal for register race --}}
    <form action="{{ route('voyager.races.store') }}" class="form-submit" method="POST">
        @csrf
        <input type="hidden" name="animal_id" value="{{ $item->id }}">
        <div class="modal fade" data-backdrop="static" id="modal-register-race" role="dialog">
            <div class="modal-dialog modal-success">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" style="color: #ffffff !important"><i class="voyager-plus"></i> Registrar Raza</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" name="name" class="form-control" placeholder="Ej: Poodle" required>
                        </div>
                        <div class="form-group">
                            <label for="observation">Observación</label>
                            <textarea name="observation" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-success btn-form-submit" value="Guardar">
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- Include delete modal --}}
    @include('partials.modal-delete')
    
@stop

@section('css')
    <style>
        .panel-body h4{
            margin: 0;
        }
    </style>
@stop

@section('javascript')
    <script>
        $(document).ready(function() {
            // Load races list
            list();

            // Submit form
            $('.form-submit').submit(function(e){
                // Prevenir el envío tradicional
                e.preventDefault();

                // Deshabilitar botón y mostrar carga
                $('.btn-form-submit').attr('disabled', true);
                $('.btn-form-submit').val('Guardando...');

                // Enviar datos por AJAX
                $.post($(this).attr('action'), $(this).serialize(), function(res){
                    if(res.success){
                        // Si el controlador devuelve éxito
                        toastr.success(res.message);
                        $('#modal-register-race').modal('hide');
                        list(); // Recargar la lista de razas
                    }else{
                        toastr.error(res.message || 'Ocurrió un error.');
                    }
                }).fail(function(res){
                    toastr.error('Ocurrió un error inesperado.');
                }).always(function(){
                    // Volver a habilitar el botón y restaurar texto
                    $('.btn-form-submit').attr('disabled', false);
                    $('.btn-form-submit').val('Guardar');
                    $('.form-submit')[0].reset(); // Limpiar el formulario
                });
            });
        });

        function list(page = 1){
            $('#div-results').loading({message: 'Cargando...'});
            let url = '{{ route("animals.races.ajax", ["id" => $item->id]) }}';
            $.ajax({
                url: `${url}?page=${page}`,
                type: 'get',
                success: function(result){
                    $("#div-results").html(result);
                    $('#div-results').loading('toggle');
                }
            });
        }

        function deleteItem(url){
            $('#delete_form').attr('action', url);
        }

        $('#div-results').on('click', '.pagination a', function(e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            list(page);
        });
    </script>
@stop