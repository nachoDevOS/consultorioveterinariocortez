@extends('voyager::master')

@section('page_title', 'Añadir Historial Clínico')

@section('page_header')
    <h1 class="page-title">
        <i class="fa-solid fa-notes-medical"></i>
        Ficha de Anamnesis Veterinaria
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        <form class="form-edit-add" role="form"
              action="{{ route('voyager.pets.history.store', $pet->id) }}"
              method="POST" enctype="multipart/form-data" autocomplete="off">
            
            {{ csrf_field() }}

            <div class="row">
                <div class="col-md-12">
                    {{-- Panel de Información General --}}
                    <div class="panel panel-bordered">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa-solid fa-circle-info"></i> INFORMACIÓN GENERAL</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="owner_name">Propietario</label>
                                    <input type="text" class="form-control" id="owner_name" name="owner_name" value="{{ $pet->person->first_name ?? '' }} {{ $pet->person->paternal_surname ?? '' }}" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="owner_phone">Teléfono</label>
                                    <input type="text" class="form-control" id="owner_phone" name="owner_phone" value="{{ $pet->person->phone ?? '' }}" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="owner_address">Dirección</label>
                                    <input type="text" class="form-control" id="owner_address" name="owner_address" value="{{ $pet->person->address ?? '' }}" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="date">Fecha de Atención</label>
                                    <input type="date" class="form-control" id="date" name="date" value="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="vet_name">Veterinario</label>
                                    <input type="text" class="form-control" id="vet_name" name="vet_name" value="{{ Auth::user()->name }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Panel de Identificación del Paciente --}}
                    <div class="panel panel-bordered">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa-solid fa-paw"></i> IDENTIFICACIÓN DEL PACIENTE</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="pet_name">Nombre</label>
                                    <input type="text" class="form-control" id="pet_name" name="pet_name" value="{{ $pet->name }}" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="pet_species_race">Especie y Raza</label>
                                    <input type="text" class="form-control" id="pet_species_race" name="pet_species_race" value="{{ ($pet->animal->name ?? 'N/A') . ' - ' . ($pet->race->name ?? 'N/A') }}" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="pet_age">Edad</label>
                                    <input type="text" class="form-control" id="pet_age" name="pet_age" value="{{ $pet->birthdate ? \Carbon\Carbon::parse($pet->birthdate)->diffForHumans(null, true) : 'N/A' }}" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="pet_gender">Sexo</label>
                                    <input type="text" class="form-control" id="pet_gender" name="pet_gender" value="{{ $pet->gender }}" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="reproductive_status">Reproductivo</label>
                                    <input type="text" class="form-control" id="reproductive_status" name="reproductive_status" placeholder="Ej: Castrado">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="weight">Peso (kg)</label>
                                    <input type="number" step="0.01" class="form-control" id="weight" name="weight" placeholder="Peso en kg">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="identification">Identificación</label>
                                    <input type="text" class="form-control" id="identification" name="identification" placeholder="Ej: Microchip, Tatuaje">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Motivo de Consulta --}}
                    <div class="panel panel-bordered">
                        <div class="panel-heading"><h3 class="panel-title"><i class="fa-solid fa-file-waveform"></i> MOTIVO DE CONSULTA</h3></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="main_problem">Problema principal</label>
                                    <textarea class="form-control" id="main_problem" name="main_problem" rows="3"></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="evolution_time">Tiempo de evolución</label>
                                    <input type="text" class="form-control" id="evolution_time" name="evolution_time">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="recent_changes">Cambios recientes</label>
                                    <input type="text" class="form-control" id="recent_changes" name="recent_changes">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Historia Clínica Actual --}}
                    <div class="panel panel-bordered">
                        <div class="panel-heading"><h3 class="panel-title"><i class="fa-solid fa-stethoscope"></i> HISTORIA CLÍNICA ACTUAL</h3></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-md-12"><label for="observed_signs">Signos observados</label><textarea class="form-control" id="observed_signs" name="observed_signs" rows="3"></textarea></div>
                                <div class="form-group col-md-3">
                                    <label for="appetite">Apetito</label>
                                    <select name="appetite" id="appetite" class="form-control select2" required>
                                        <option value="" disabled selected>--Seleccione una opción--</option>
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                        <option value="Poco Apetito">Poco Apetito</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="water_intake">Ingesta de agua</label>
                                    <select name="water_intake" id="water_intake" class="form-control select2" required>
                                        <option value="" disabled selected>--Seleccione una opción--</option>
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                        <option value="Poco">Poco</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="activity">Actividad</label>
                                    <select name="activity" id="activity" class="form-control select2" required>
                                        <option value="" disabled selected>--Seleccione una opción--</option>
                                        <option value="Hiperactivo">Hiperactivo</option>
                                        <option value="Normal">Normal</option>
                                        <option value="Poca Actividad">Poca Actividad</option>
                                        <option value="Casi nulo">Casi nulo</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="urination">Micción</label>
                                    <select name="urination" id="urination" class="form-control select2" required>
                                        <option value="" disabled selected>--Seleccione una opción--</option>
                                        <option value="Excesivo">Excesivo</option>
                                        <option value="Normal">Normal</option>
                                        <option value="Muy Poco">Muy Poco</option>
                                        <option value="Ninguna">Ninguna</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="defecation">Defecación</label>
                                    <input type="text" class="form-control" id="defecation" name="defecation">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="temperature">Temperatura (°C)</label>
                                    <input type="text" class="form-control" id="temperature" name="temperature">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="heart_rate">Frecuencia Cardiaca (lpm)</label>
                                    <input type="text" class="form-control" id="heart_rate" name="heart_rate">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="respiratory_rate">Frecuencia Respiratoria (rpm)</label>
                                    <input type="text" class="form-control" id="respiratory_rate" name="respiratory_rate">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Historia Clínica Previa --}}
                    <div class="panel panel-bordered">
                        <div class="panel-heading"><h3 class="panel-title"><i class="fa-solid fa-book-medical"></i> HISTORIA CLÍNICA PREVIA</h3></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="previous_diseases">Enfermedades previas</label>
                                    <input type="text" class="form-control" id="previous_diseases" name="previous_diseases">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="previous_surgeries">Cirugías anteriores</label>
                                    <input type="text" class="form-control" id="previous_surgeries" name="previous_surgeries">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="current_medications">Medicamentos actuales</label>
                                    <input type="text" class="form-control" id="current_medications" name="current_medications">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="allergies">Alergias</label>
                                    <input type="text" class="form-control" id="allergies" name="allergies">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="vaccines">Vacunas</label>
                                    <input type="text" class="form-control" id="vaccines" name="vaccines" placeholder="Detallar últimas vacunas">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="deworming">Desparasitaciones</label>
                                    <input type="text" class="form-control" id="deworming" name="deworming" placeholder="Detallar últimas desparasitaciones">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Alimentación --}}
                    <div class="panel panel-bordered">
                        <div class="panel-heading"><h3 class="panel-title"><i class="fa-solid fa-bowl-food"></i> ALIMENTACIÓN</h3></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="diet_type">Tipo de dieta</label>
                                    <input type="text" class="form-control" id="diet_type" name="diet_type" placeholder="Ej: Balanceado, Casera">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="diet_brand">Marca</label>
                                    <input type="text" class="form-control" id="diet_brand" name="diet_brand">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="diet_frequency">Frecuencia</label>
                                    <input type="text" class="form-control" id="diet_frequency" name="diet_frequency" placeholder="Ej: 2 veces al día">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="diet_recent_changes">Cambios recientes</label>
                                    <input type="text" class="form-control" id="diet_recent_changes" name="diet_recent_changes">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Ambiente y Manejo --}}
                    <div class="panel panel-bordered">
                        <div class="panel-heading"><h3 class="panel-title"><i class="fa-solid fa-house-chimney-user"></i> AMBIENTE Y MANEJO</h3></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="housing">Vivienda</label>
                                    <select name="housing" id="housing" class="form-control select2" required>
                                        <option value="" disabled selected>--Seleccione una opción--</option>
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="access_to_exterior">Acceso al exterior</label>
                                    <select name="access_to_exterior" id="access_to_exterior" class="form-control select2" required>
                                        <option value="" disabled selected>--Seleccione una opción--</option>
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                        <option value="Algunas Veces">Algunas Veces</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="stay_place">Lugar donde permanece</label>
                                    <input type="text" class="form-control" id="stay_place" name="stay_place" placeholder="Ej: Dentro de casa, Patio">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="cohabiting_animals">Animales convivientes (Especie y Raza)</label>
                                    <div class="input-group">
                                        <select class="form-control select2" name="cohabiting_animals[]" id="cohabiting_animals" multiple="multiple">
                                            @if(isset($animals))
                                                @foreach ($animals->sortBy('name') as $animal)
                                                    @foreach ($animal->races->sortBy('name') as $race)
                                                        <option value="{{ $race->id }}">{{ $animal->name }} - {{ $race->name }}</option>
                                                    @endforeach
                                                @endforeach
                                            @endif
                                        </select>
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#addRaceModal" style="margin-top: 0; padding-top: 5px; padding-bottom: 5px;">
                                                <i class="voyager-plus"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="toxic_exposure">Exposición a tóxicos</label>
                                    <input type="text" class="form-control" id="toxic_exposure" name="toxic_exposure">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Reproducción --}}
                    <div class="panel panel-bordered">
                        <div class="panel-heading"><h3 class="panel-title"><i class="fa-solid fa-venus-mars"></i> REPRODUCCIÓN</h3></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="females_repro">Hembras</label>
                                    <input type="text" class="form-control" id="females_repro" name="females_repro" placeholder="Ej: Último celo, gestaciones">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="males_repro">Machos</label>
                                    <input type="text" class="form-control" id="males_repro" name="males_repro" placeholder="Ej: Montas, enfermedades">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="repro_complications">Complicaciones reproductivas</label>
                                    <input type="text" class="form-control" id="repro_complications" name="repro_complications">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Productos Utilizados --}}
                    <div class="panel panel-bordered">
                        <div class="panel-heading"><h3 class="panel-title"><i class="fa-solid fa-pills"></i> PRODUCTOS UTILIZADOS</h3></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="product_id">Buscar producto</label>
                                    <select class="form-control" id="select-product_id"></select>
                                </div>
                                <div class="col-md-12" style="height: 350px; max-height: 350px; overflow-y: auto">
                                    <div class="table-responsive">
                                        <table id="dataTable" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%">N&deg;</th>
                                                    <th style="">Detalles</th>
                                                    <th style="text-align: center; width:10%">Stock</th>
                                                    <th style="text-align: center; width:12%">Precio</th>
                                                    <th style="text-align: center; width:12%">Cantidad</th>
                                                    <th style="text-align: center; width:12%">Subtotal</th>
                                                    <th style="width: 5%"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="table-body">
                                                <tr id="tr-empty">
                                                    <td colspan="7" style="height: 250px">
                                                        <h4 class="text-center text-muted" style="margin-top: 50px">
                                                            <i class="fa-solid fa-flask" style="font-size: 50px"></i> <br><br>
                                                            Lista de productos vacía
                                                        </h4>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="pull-right">
                                        <h3 style="margin: 0px">
                                            <small>Total:</small>
                                            <b id="label-total">0.00</b>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- Observaciones y Firmas --}}
                    <div class="panel panel-bordered">
                        <div class="panel-heading"><h3 class="panel-title"><i class="fa-solid fa-file-signature"></i> OBSERVACIONES ADICIONALES</h3></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="additional_observations">Observaciones Adicionales</label>
                                    <textarea class="form-control" id="additional_observations" name="additional_observations" rows="4"></textarea>
                                </div>
                                {{-- <div class="form-group col-md-6">
                                    <label for="owner_signature">Firma del Propietario</label>
                                    <div style="border: 1px solid #ccc; height: 100px; background: #f9f9f9;">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="vet_signature">Firma y Sello del Veterinario</label>
                                    <div style="border: 1px solid #ccc; height: 100px; background: #f9f9f9;">
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <button type="submit" class="btn btn-primary pull-right save btn-submit">
                <i class="voyager-check"></i> Guardar Historial
            </button>
        </form>
    </div>

    {{-- Modal para añadir nueva raza --}}
    <div class="modal fade" id="addRaceModal" tabindex="-1" role="dialog" aria-labelledby="addRaceModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="addRaceForm">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="addRaceModalLabel">Añadir Nueva Raza</h4>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="alert alert-danger" id="addRaceErrors" style="display: none;">
                            <ul></ul>
                        </div>
                        <div class="form-group">
                            <label for="modal_animal_id">Especie</label>
                            <select name="animal_id" id="modal_animal_id" class="form-control select2" required>
                                <option value="" disabled selected>-- Seleccione una especie --</option>
                                @if(isset($animals))
                                    @foreach ($animals->sortBy('name') as $animal)
                                        <option value="{{ $animal->id }}">{{ $animal->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="modal_race_name">Nombre de la Raza</label>
                            <input type="text" class="form-control" id="modal_race_name" name="name" required placeholder="Ej: Labrador Retriever">
                        </div>
                        <div class="form-group">
                            <label for="modal_race_observation">Observación (Opcional)</label>
                            <textarea name="observation" id="modal_race_observation" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="saveRaceBtn">Guardar Raza</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script src="{{ asset('js/btn-submit.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#addRaceForm').on('submit', function(e) {
                e.preventDefault();
                $('#saveRaceBtn').prop('disabled', true).text('Guardando...');
                $('#addRaceErrors').hide().find('ul').empty();

                $.ajax({
                    url: '{{ route('voyager.races.ajax.store') }}',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(data) {
                        if (data.success) {
                            // Crear la nueva opción
                            var newOption = new Option(data.race.animal.name + ' - ' + data.race.name, data.race.id, false, false);
                            // Añadirla al select2 principal
                            $('#cohabiting_animals').append(newOption).trigger('change');

                            // Opcional: seleccionar la nueva raza
                            var selectedValues = $('#cohabiting_animals').val();
                            selectedValues.push(data.race.id);
                            $('#cohabiting_animals').val(selectedValues).trigger('change');

                            // Cerrar modal y mostrar mensaje
                            $('#addRaceModal').modal('hide');
                            toastr.success(data.message);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        var errors = jqXHR.responseJSON.errors;
                        var errorList = $('#addRaceErrors ul');
                        for (var key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                errorList.append('<li>' + errors[key][0] + '</li>');
                            }
                        }
                        $('#addRaceErrors').show();
                    },
                    complete: function() {
                        $('#saveRaceBtn').prop('disabled', false).text('Guardar Raza');
                    }
                });
            });

            // Limpiar el formulario del modal cuando se cierra
            $('#addRaceModal').on('hidden.bs.modal', function () {
                $('#addRaceForm')[0].reset();
                $('#modal_animal_id').val(null).trigger('change');
                $('#addRaceErrors').hide().find('ul').empty();
                $('#saveRaceBtn').prop('disabled', false).text('Guardar Raza');
            });
        });

        // =================================================
        // Lógica para agregar productos
        // =================================================
        var productSelected;
        $(document).ready(function() {
            $('<style>.select2-results__options { max-height: 450px !important; }</style>').appendTo('head');

            $('#select-product_id').select2({
                width: '100%',
                placeholder: '<i class="fa fa-search"></i> Buscar...',
                escapeMarkup: function(markup) { return markup; },
                language: {
                    inputTooShort: function(data) { return `Por favor ingrese ${data.minimum - data.input.length} o más caracteres`; },
                    noResults: function() { return `<i class="far fa-frown"></i> No hay resultados encontrados`; }
                },
                quietMillis: 250,
                minimumInputLength: 2,
                ajax: {
                    url: "{{ url('admin/item/stock/ajax') }}",
                    processResults: function(data) {
                        return { results: data };
                    },
                    cache: true
                },
                templateResult: formatResultProducts,
                templateSelection: (opt) => {
                    productSelected = opt;
                    return productSelected.id;
                }
            }).change(function() {
                if ($('#select-product_id option:selected').val()) {
                    let product = productSelected;
                    let image = "{{ asset('images/default.jpg') }}";
                    if (product.item.image) {
                        image = "{{ asset('storage') }}/" + product.item.image.replace('.avif', '-cropped.webp');
                    }

                    if ($('.table').find(`#tr-item-${product.id}`).val() === undefined) {
                        if (product.stock > 0) {
                            $('#table-body').append(`
                                <tr class="tr-item" id="tr-item-${product.id}">
                                    <td class="td-item"></td>
                                    <td>
                                        <input type="hidden" name="products[${product.id}][id]" value="${product.id}"/>
                                        <div style="display: flex; align-items: center;">
                                            <div style="flex-grow: 1; line-height: 1.5;">
                                                <div style="font-size: 15px; font-weight: bold; color: #000; margin-bottom: 8px;">
                                                    <i class="fa-solid fa-pills" style="color: #22A7F0;"></i> ${product.item.nameGeneric} ${product.item.nameTrade ? `<span style="color: #444; font-weight: normal;">| ${product.item.nameTrade}</span>` : ''}
                                                </div>
                                                <div style="font-size: 12px; color: #555;">
                                                    ${product.item.observation ? `<div style="font-size: 14px; margin-top: 5px;"><i class="fa-solid fa-clipboard-list" style="color: #f39c12; width: 14px; text-align: center;"></i> <strong style="color: #222;">Detalle:</strong> <span style="font-weight: bold; color: #222;">${product.item.observation}</span></div>` : ''}
                                                    <div style="margin-top: 5px;"><i class="fa-solid fa-tags" style="color: #2ecc71; width: 14px; text-align: center;"></i> <strong style="color: #444;">Categoría:</strong> ${product.item.category.name} | ${product.item.presentation.name}</div>
                                                    <div><i class="fa-solid fa-flask" style="color: #3498db; width: 14px; text-align: center;"></i> <strong style="color: #444;">Laboratorio:</strong> ${product.item.laboratory ? product.item.laboratory.name : 'SN'}</div>
                                                    <div><i class="fa-solid fa-copyright" style="color: #9b59b6; width: 14px; text-align: center;"></i> <strong style="color: #444;">Marca:</strong> ${product.item.brand ? product.item.brand.name : 'SN'}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="vertical-align: middle; text-align: center">
                                        <b class="text-${product.stock > 10 ? 'success' : (product.stock > 0 ? 'warning' : 'danger')}">${product.stock}</b>
                                    </td>
                                    <td style="vertical-align: middle; padding: 5px;">
                                        <input type="number" name="products[${product.id}][priceSale]" step="0.01" min="0.1" style="text-align: right" class="form-control" id="input-priceSale-${product.id}" value="${product.priceSale || 0}" onkeyup="getSubtotal(${product.id})" onchange="getSubtotal(${product.id})" required/>
                                    </td>
                                    <td style="vertical-align: middle; padding: 5px;">
                                        <input type="number" name="products[${product.id}][quantity]" step="1" min="1" max="${product.stock}" style="text-align: right" class="form-control" id="input-quantity-${product.id}" value="1" onkeyup="getSubtotal(${product.id})" onchange="getSubtotal(${product.id})" required/>
                                    </td>
                                    <td class="text-right" style="vertical-align: middle;">
                                        <b class="label-subtotal" id="label-subtotal-${product.id}" style="font-size: 1.2em;">0.00</b>
                                    </td>
                                    <td style="width: 5%">
                                        <button type="button" onclick="removeTr(${product.id})" class="btn btn-link"><i class="voyager-trash text-danger"></i></button>
                                    </td>
                                </tr>
                            `);
                            setNumber();
                            getSubtotal(product.id);
                            toastr.success(`+1 ${product.item.nameGeneric}`, 'Producto agregado');
                        } else {
                            toastr.error('No hay stock disponible para este producto.', 'Error');
                        }
                    } else {
                        toastr.info('EL producto ya está agregado', 'Información');
                    }
                    $('#select-product_id').val('').trigger('change');
                }
            });
        });

        function getSubtotal(id) {
            let quantity = $(`#input-quantity-${id}`).val() ? parseFloat($(`#input-quantity-${id}`).val()) : 0;
            let price = $(`#input-priceSale-${id}`).val() ? parseFloat($(`#input-priceSale-${id}`).val()) : 0;
            let subtotal = quantity * price;
            $(`#label-subtotal-${id}`).text(subtotal.toFixed(2));
            getTotal();
        }

        function getTotal() {
            let total = 0;
            $(".label-subtotal").each(function() {
                total += parseFloat($(this).text()) || 0;
            });
            $('#label-total').text(total.toFixed(2));
        }

        function setNumber() {

            var length = 0;
            $(".td-item").each(function(index) {
                $(this).text(index +1);
                length++;
            });

            if(length > 0){
                $('#tr-empty').css('display', 'none');
            }else{
                $('#tr-empty').fadeIn('fast');
            }
        }

        function removeTr(id) {
            $(`#tr-item-${id}`).remove();
            $('#select-product_id').val("").trigger("change");
            setNumber();
            getTotal();
            toastr.info('Producto eliminado del carrito', 'Eliminado');
        }

        // Definir variables globales para select2
        window.storagePath = "{{ asset('storage') }}/";
        window.defaultImage = "{{ asset('images/default.jpg') }}";

        function formatResultProducts(option) {
            if (option.loading) {
                return '<span class="text-center"><i class="fas fa-spinner fa-spin"></i> Buscando...</span>';
            }
            let image = window.defaultImage;
                
            if (option.image) {
                const lastDotIndex = option.image.lastIndexOf('.');
                const baseName = lastDotIndex !== -1 ? option.image.substring(0, lastDotIndex) : option.image;
                image = `${window.storagePath}${baseName}-cropped.webp`;
            }
            let stockLabel = option.stock > 10 ? 'success' : (option.stock > 0 ? 'warning' : 'danger');

            // Mostrar las opciones encontradas con diseño mejorado
            return $(`<div style="display: flex; align-items: center; padding: 10px 5px;">
                            <div style="flex-shrink: 0; margin-right: 15px;">
                                <img src="${image}" style="width: 60px; height: 60px; border-radius: 8px; object-fit: cover; box-shadow: 0 2px 4px rgba(0,0,0,0.1);" />
                            </div>
                            <div style="flex-grow: 1; line-height: 1.5;">
                                <div style="font-size: 16px; font-weight: bold; color: #000; margin-bottom: 8px;">
                                    <i class="fa-solid fa-pills" style="color: #22A7F0;"></i> ${option.item.nameGeneric} ${option.item.nameTrade ? `<span style="color: #444; font-weight: normal;">| ${option.item.nameTrade}</span>` : ''}
                                </div>
                                <div style="font-size: 12px; color: #555;">
                                    ${option.item.observation ? `<div style="font-size: 14px; margin-top: 5px;"><i class="fa-solid fa-clipboard-list" style="color: #f39c12; width: 14px; text-align: center;"></i> <strong style="color: #222;">Detalle:</strong> <span style="font-weight: bold; color: #222;">${option.observation}</span></div>` : ''}
                                    <div style="margin-top: 5px;"><i class="fa-solid fa-tags" style="color: #2ecc71; width: 14px; text-align: center;"></i> <strong style="color: #444;">Categoría:</strong> ${option.item.category.name} | ${option.item.presentation.name}</div>
                                    <div><i class="fa-solid fa-flask" style="color: #3498db; width: 14px; text-align: center;"></i> <strong style="color: #444;">Laboratorio:</strong> ${option.item.laboratory ? option.item.laboratory.name : 'SN'}</div>
                                    <div><i class="fa-solid fa-copyright" style="color: #9b59b6; width: 14px; text-align: center;"></i> <strong style="color: #444;">Marca:</strong> ${option.item.brand ? option.item.brand.name : 'SN'}</div>
                                </div>
                                <div class="text-right"><label class="label label-${stockLabel}">Stock: ${option.stock}</label></div>
                            </div>
                        </div>`);
        }
    </script>
@stop