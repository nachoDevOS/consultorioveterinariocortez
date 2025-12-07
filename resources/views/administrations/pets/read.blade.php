@extends('voyager::master')

@section('page_title', 'Viendo Mascota')

@section('page_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body" style="padding: 0px">
                        <div class="col-md-6" style="padding: 0px; display: flex; align-items: center;">
                            <h1 class="page-title">
                                <i class="fa-solid fa-dog"></i> Viendo Mascota
                            </h1>
                        </div>
                        <div class="col-md-6 text-right" style="margin-top: 30px">
                            <a href="{{ route('voyager.pets.history.create', ['id' => $pet->id]) }}" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-notes-medical"></i> <span>Agregar Historial</span>
                            </a>
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#reminder-modal">
                                <i class="fa-solid fa-bell"></i> <span>Agregar Recordatorio</span>
                            </button>
                            <a href="{{ route('voyager.pets.index') }}" class="btn btn-warning btn-sm">
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
                        <div class="col-md-7">
                            <div class="panel panel-bordered">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <h3 class="panel-title" style="padding-top: 10px;"><i class="fa-solid fa-book-medical"></i> Historial Clínico</h3>
                                        </div>
                                        <div class="col-sm-4" style="margin-bottom: 0px">
                                            <input type="text" id="input-search-history" placeholder="🔍 Buscar en historial..." class="form-control">
                                        </div>
                                    </div>
                                    <div class="row" id="div-results-history" style="min-height: 120px"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="panel panel-bordered">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <h3 class="panel-title" style="padding-top: 10px;"><i class="fa-solid fa-bell"></i> Recordatorio</h3>
                                        </div>
                                        <div class="col-sm-4" style="margin-bottom: 0px">
                                            <input type="text" id="input-search-reminder" placeholder="🔍 Buscar recordatorio..." class="form-control">
                                        </div>
                                    </div>
                                    <div class="row" id="div-results-reminder" style="min-height: 120px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Reminder modal --}}
    <form id="form-store-reminder" action="{{ route('reminders.store') }}" method="POST">
        @csrf
        <input type="hidden" name="pet_id" value="{{ $pet->id }}">
        <div class="modal modal-primary fade" tabindex="-1" id="reminder-modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa-solid fa-bell"></i> Nuevo Recordatorio</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Fecha</label>
                                <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Hora</label>
                                <input type="time" name="time" class="form-control" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Descripción</label>
                                <textarea name="description" class="form-control" rows="3" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-dark">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- Reminder Delete Modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="delete-modal-reminder" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> ¿Estás seguro de que quieres eliminar este recordatorio?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirm-delete-reminder">Sí, ¡Bórralo!</button>
                </div>
            </div>
        </div>
    </div>

    @include('partials.modal-delete')

@stop

@push('javascript')
<script>
    var timeout = null;
    $(document).ready(function () {
        var reminderIdToDelete;
        list_histories();

        $('#input-search-history').on('keyup', function(e){
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                list_histories();
            }, 1000); // 1 segundo de espera
        });

        // Reminders
        list_reminders();
        $('#input-search-reminder').on('keyup', function(e){
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                list_reminders();
            }, 1000); // 1 segundo de espera
        });

        // Manejar el envío del formulario de recordatorios con AJAX
        $('#form-store-reminder').on('submit', function(e) {
            e.preventDefault();
            let form = $(this);
            let button = form.find('button[type="submit"]');
            button.prop('disabled', true);

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        list_reminders(); // Recargar la lista de recordatorios
                        form.trigger('reset');
                        $('#reminder-modal').modal('hide');
                    } else {
                        toastr.error(response.message);
                    }
                    button.prop('disabled', false);
                },
                error: function() {
                    toastr.error('Ocurrió un error inesperado.');
                    button.prop('disabled', false);
                }
            });
        });

        // Manejar el clic en el botón de confirmación de borrado
        $('#confirm-delete-reminder').on('click', function() {
            $.ajax({
                url: '{{ url("admin/reminders") }}/' + reminderIdToDelete,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        list_reminders(); // Recargar la lista de recordatorios
                    } else {
                        toastr.error(response.message);
                    }
                    $('#delete-modal-reminder').modal('hide');
                },
                error: function() {
                    toastr.error('Ocurrió un error al intentar eliminar el recordatorio.');
                }
            });
        });
    });

    function list_histories(page = 1){
        $('#div-results-history').loading({message: 'Cargando...'});

        let url = '{{ route("voyager.pets.history.list", ["pet" => $pet->id]) }}';
        let search = $('#input-search-history').val() ? $('#input-search-history').val() : '';

        $.ajax({
            url: `${url}?search=${search}&page=${page}`,
            type: 'get',
            success: function(result){
                $("#div-results-history").html(result);
                $('#div-results-history').loading('toggle');
            }
        });
    }

    function list_reminders(page = 1){
        $('#div-results-reminder').loading({message: 'Cargando...'});

        let url = '{{ url("admin/reminders/list") }}/{{ $pet->id }}';
        let search = $('#input-search-reminder').val() ? $('#input-search-reminder').val() : '';

        $.ajax({
            url: `${url}?search=${search}&page=${page}`,
            type: 'get',
            success: function(result){
                $("#div-results-reminder").html(result);
                $('#div-results-reminder').loading('toggle');
            }
        });
    }

    // Almacena el ID del recordatorio a eliminar y muestra el modal
    function deleteItem(id){
        reminderIdToDelete = id;
        // No es necesario cambiar el action del form, ya que usamos AJAX
    }
</script>
@endpush