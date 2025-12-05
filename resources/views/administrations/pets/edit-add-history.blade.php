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
              action="#" {{-- route('voyager.pets.history.store', $pet->id) --}}
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
                                    <label for="pet_species">Especie</label>
                                    <input type="text" class="form-control" id="pet_species" name="pet_species" value="{{ $pet->animal->name ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="pet_race">Raza</label>
                                    <input type="text" class="form-control" id="pet_race" name="pet_race" value="{{ $pet->race->name ?? 'N/A' }}" readonly>
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
                                    <select name="appetite" id="appetite" required class="form-control select2">
                                        <option value="" disabled selected>--Seleccione una opción--</option>
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                        <option value="Poco Apetito">Poco Apetito</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="water_intake">Ingesta de agua</label>
                                    <select name="water_intake" id="water_intake" required class="form-control select2">
                                        <option value="" disabled selected>--Seleccione una opción--</option>
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                        <option value="Poco">Poco</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="activity">Actividad</label>
                                    <select name="activity" id="activity" required class="form-control select2">
                                        <option value="" disabled selected>--Seleccione una opción--</option>
                                        <option value="Iperactivo">Iperactivo</option>
                                        <option value="Normal">Normal</option>
                                        <option value="Poca Actividad">Poca Actividad</option>
                                        <option value="Casi nulo">Casi nulo</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="urination">Micción</label>
                                    <select name="urination" id="urination" required class="form-control select2">
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
                                    <input type="text" class="form-control" id="vaccines" placeholder="Detallar últimas vacunas">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="deworming">Desparasitaciones</label>
                                    <input type="text" class="form-control" id="deworming" placeholder="Detallar últimas desparasitaciones">
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
                                    <select name="housing" id="housing" required class="form-control select2">
                                        <option value="" disabled selected>--Seleccione una opción--</option>
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="access_to_exterior">Acceso al exterior</label>
                                    <select name="access_to_exterior" id="access_to_exterior" required class="form-control select2">
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
                                    <label for="cohabiting_animals">Animales convivientes</label>
                                    <input type="text" class="form-control" id="cohabiting_animals" name="cohabiting_animals">
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
@stop

@section('javascript')
    <script src="{{ asset('js/btn-submit.js') }}"></script>
@stop