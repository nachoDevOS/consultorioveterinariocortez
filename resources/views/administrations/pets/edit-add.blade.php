@extends('voyager::master')

@section('page_title', (isset($pet->id) ? 'Editar' : 'Agregar').' Mascota')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-paw"></i>
        {{ (isset($pet->id) ? 'Editar' : 'Agregar') }} Mascota
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        <form class="form-edit-add" role="form"
              action="{{ isset($pet->id) ? route('voyager.pets.update', $pet->id) : route('voyager.pets.store') }}"
              method="POST" enctype="multipart/form-data" autocomplete="off">
            
            @if(isset($pet->id))
                {{ method_field("PUT") }}
            @endif
            {{ csrf_field() }}

            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-bordered">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name">Nombre de la Mascota</label>
                                    <input type="text" class="form-control" name="name" placeholder="Nombre de la mascota" value="{{ old('name', $pet->name ?? '') }}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="person_id">Dueño</label>
                                    <div class="input-group">
                                        <select name="person_id" id="select-person_id" required class="form-control"></select>
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" title="Nueva persona" data-target="#modal-create-person" data-toggle="modal" style="margin: 0px" type="button">
                                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="animal_id">Especie</label>
                                    <select name="animal_id" id="select-animal_id" class="form-control select2" required>
                                        <option value="" selected disabled>Seleccione...</option>
                                        @foreach ($animals as $animal)
                                            <option value="{{$animal->id}}" >{{$animal->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="race_id">Raza</label>
                                    <select name="race_id" id="select-race_id" class="form-control select2" required>
                                        <option value="">-- Seleccione una especie primero --</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="birthdate">Fecha de Nacimiento</label>
                                    <input type="date" class="form-control" name="birthdate" value="{{ old('birthdate', $pet->birthdate ?? '') }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="gender">Género</label>
                                    <select name="gender" class="form-control select2" required>
                                        <option value="Macho" @if(old('gender', $pet->gender ?? '') == 'Macho') selected @endif>Macho</option>
                                        <option value="Hembra" @if(old('gender', $pet->gender ?? '') == 'Hembra') selected @endif>Hembra</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="color">Color</label>
                                    <input type="text" class="form-control" name="color" placeholder="Color" value="{{ old('color', $pet->color ?? '') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel panel panel-bordered panel-warning">
                        <div class="panel-body">
                            <div class="form-group">
                                @if(isset($pet->image))
                                    <img src="{{ Voyager::image( $pet->image ) }}" style="width:100%;" />
                                @endif
                                <label for="image">Imagen de la Mascota</label>
                                <input type="file" name="image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary pull-right save btn-submit">
                {{ __('voyager::generic.save') }}
            </button>
        </form>
    </div>

    @include('partials.modal-registerPerson')

@stop

@section('javascript')
    <script src="{{ asset('js/include/person-select.js') }}"></script>
    <script src="{{ asset('js/include/person-register.js') }}"></script>
    <script src="{{ asset('js/btn-submit.js') }}"></script>
    <script>
        $(document).ready(function () {
            // Deshabilitar el select de razas inicialmente
            $('#select-animal_id').select2();
            $('#select-race_id').prop('disabled', true);

            // Cargar razas al cambiar el tipo de animal
            // He cambiado el ID aquí para que coincida con el select
            $('#select-animal_id').change(function(){ 
                let animal_id = $(this).val();
                let raceSelect = $('#select-race_id');
                
                raceSelect.empty().append('<option value="">Cargando razas...</option>').prop('disabled', true);
                
                if(animal_id){
                    $.get(`/api/races/${animal_id}`, function(data){
                        let options = '<option value="" selected disabled>Seleccione una raza</option>';
                        if (data.length > 0) {
                            data.forEach(race => {
                                options += `<option value="${race.id}">${race.name}</option>`;
                            });
                        }
                        // Añadir la opción "Otra" como en welcome.blade.php
                        options += '<option value="">Otra</option>';

                        raceSelect.html(options).prop('disabled', false);
                        // Reinicializar select2 para el selector de razas
                        raceSelect.select2();
                    }).fail(function() {
                        raceSelect.html('<option value="">Error al cargar razas</option>').prop('disabled', true);
                        raceSelect.select2();
                    });
                } else {
                    raceSelect.empty().append('<option value="">-- Seleccione una especie primero --</option>').prop('disabled', true);
                    raceSelect.select2();
                }
            });
        });
    </script>
@stop