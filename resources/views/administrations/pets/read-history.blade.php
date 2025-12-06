@extends('voyager::master')

@section('page_title', 'Detalle del Historial Clínico')

@section('page_header')7
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body" style="padding: 0px">
                        <div class="col-md-8" style="padding: 0px">
                            <h1 class="page-title">
                                <i class="fa-solid fa-file-medical"></i>
                                Detalle del Historial Clínico
                            </h1>
                        </div>
                        <div class="col-md-4 text-right" style="margin-top: 30px">
                            <a href="{{ route('voyager.pets.history.edit', $history->id) }}" class="btn btn-info">
                                <i class="voyager-edit"></i> <span>Editar</span>
                            </a>
                            <a href="{{ route('voyager.pets.show', $history->pet_id) }}" class="btn btn-warning">
                                <i class="voyager-list"></i> <span>Volver al Historial</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                {{-- Panel de Información General --}}
                <div class="panel panel-bordered">
                    <div class="panel-heading"><h3 class="panel-title"><i class="fa-solid fa-circle-info"></i> INFORMACIÓN GENERAL</h3></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3"><strong>Propietario:</strong><p>{{ $history->pet->person->first_name ?? '' }} {{ $history->pet->person->paternal_surname ?? '' }}</p></div>
                            <div class="col-md-3"><strong>Teléfono:</strong><p>{{ $history->pet->person->phone ?? 'N/A' }}</p></div>
                            <div class="col-md-3"><strong>Fecha de Atención:</strong><p>{{ \Carbon\Carbon::parse($history->date)->format('d/m/Y') }}</p></div>
                            <div class="col-md-3"><strong>Veterinario:</strong><p>{{ $history->doctor->name ?? 'N/A' }}</p></div>
                        </div>
                    </div>
                </div>

                {{-- Panel de Identificación del Paciente --}}
                <div class="panel panel-bordered">
                    <div class="panel-heading"><h3 class="panel-title"><i class="fa-solid fa-paw"></i> IDENTIFICACIÓN DEL PACIENTE</h3></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3"><strong>Nombre:</strong><p>{{ $history->pet->name }}</p></div>
                            <div class="col-md-3"><strong>Especie y Raza:</strong><p>{{ ($history->pet->animal->name ?? 'N/A') . ' - ' . ($history->pet->race->name ?? 'N/A') }}</p></div>
                            <div class="col-md-3"><strong>Edad en la consulta:</strong><p>{{ $history->pet->birthdate ? \Carbon\Carbon::parse($history->pet->birthdate)->diffForHumans($history->date, true) : 'N/A' }}</p></div>
                            <div class="col-md-3"><strong>Sexo:</strong><p>{{ $history->pet->gender }}</p></div>
                            <div class="col-md-3"><strong>Reproductivo:</strong><p>{{ $history->reproductive_status ?: 'N/A' }}</p></div>
                            <div class="col-md-3"><strong>Peso (kg):</strong><p>{{ $history->weight ?: 'N/A' }}</p></div>
                            <div class="col-md-3"><strong>Identificación:</strong><p>{{ $history->identification ?: 'N/A' }}</p></div>
                        </div>
                    </div>
                </div>

                {{-- Motivo de Consulta --}}
                <div class="panel panel-bordered">
                    <div class="panel-heading"><h3 class="panel-title"><i class="fa-solid fa-file-waveform"></i> MOTIVO DE CONSULTA</h3></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12"><strong>Problema principal:</strong><p>{{ $history->main_problem ?: 'N/A' }}</p></div>
                            <div class="col-md-6"><strong>Tiempo de evolución:</strong><p>{{ $history->evolution_time ?: 'N/A' }}</p></div>
                            <div class="col-md-6"><strong>Cambios recientes:</strong><p>{{ $history->recent_changes ?: 'N/A' }}</p></div>
                        </div>
                    </div>
                </div>

                {{-- Historia Clínica Actual --}}
                <div class="panel panel-bordered">
                    <div class="panel-heading"><h3 class="panel-title"><i class="fa-solid fa-stethoscope"></i> HISTORIA CLÍNICA ACTUAL</h3></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12"><strong>Signos observados:</strong><p>{{ $history->observed_signs ?: 'N/A' }}</p></div>
                            <div class="col-md-3"><strong>Apetito:</strong><p>{{ $history->appetite ?: 'N/A' }}</p></div>
                            <div class="col-md-3"><strong>Ingesta de agua:</strong><p>{{ $history->water_intake ?: 'N/A' }}</p></div>
                            <div class="col-md-3"><strong>Actividad:</strong><p>{{ $history->activity ?: 'N/A' }}</p></div>
                            <div class="col-md-3"><strong>Micción:</strong><p>{{ $history->urination ?: 'N/A' }}</p></div>
                            <div class="col-md-3"><strong>Defecación:</strong><p>{{ $history->defecation ?: 'N/A' }}</p></div>
                            <div class="col-md-3"><strong>Temperatura (°C):</strong><p>{{ $history->temperature ?: 'N/A' }}</p></div>
                            <div class="col-md-3"><strong>Frecuencia Cardiaca (lpm):</strong><p>{{ $history->heart_rate ?: 'N/A' }}</p></div>
                            <div class="col-md-3"><strong>Frecuencia Respiratoria (rpm):</strong><p>{{ $history->respiratory_rate ?: 'N/A' }}</p></div>
                        </div>
                    </div>
                </div>

                {{-- Historia Clínica Previa --}}
                <div class="panel panel-bordered">
                    <div class="panel-heading"><h3 class="panel-title"><i class="fa-solid fa-book-medical"></i> HISTORIA CLÍNICA PREVIA</h3></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6"><strong>Enfermedades previas:</strong><p>{{ $history->previous_diseases ?: 'N/A' }}</p></div>
                            <div class="col-md-6"><strong>Cirugías anteriores:</strong><p>{{ $history->previous_surgeries ?: 'N/A' }}</p></div>
                            <div class="col-md-6"><strong>Medicamentos actuales:</strong><p>{{ $history->current_medications ?: 'N/A' }}</p></div>
                            <div class="col-md-6"><strong>Alergias:</strong><p>{{ $history->allergies ?: 'N/A' }}</p></div>
                            <div class="col-md-6"><strong>Vacunas:</strong><p>{{ $history->vaccines ?: 'N/A' }}</p></div>
                            <div class="col-md-6"><strong>Desparasitaciones:</strong><p>{{ $history->deworming ?: 'N/A' }}</p></div>
                        </div>
                    </div>
                </div>

                {{-- Alimentación --}}
                <div class="panel panel-bordered">
                    <div class="panel-heading"><h3 class="panel-title"><i class="fa-solid fa-bowl-food"></i> ALIMENTACIÓN</h3></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3"><strong>Tipo de dieta:</strong><p>{{ $history->diet_type ?: 'N/A' }}</p></div>
                            <div class="col-md-3"><strong>Marca:</strong><p>{{ $history->diet_brand ?: 'N/A' }}</p></div>
                            <div class="col-md-3"><strong>Frecuencia:</strong><p>{{ $history->diet_frequency ?: 'N/A' }}</p></div>
                            <div class="col-md-3"><strong>Cambios recientes:</strong><p>{{ $history->diet_recent_changes ?: 'N/A' }}</p></div>
                        </div>
                    </div>
                </div>

                {{-- Ambiente y Manejo --}}
                <div class="panel panel-bordered">
                    <div class="panel-heading"><h3 class="panel-title"><i class="fa-solid fa-house-chimney-user"></i> AMBIENTE Y MANEJO</h3></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3"><strong>Vivienda:</strong><p>{{ $history->housing ?: 'N/A' }}</p></div>
                            <div class="col-md-3"><strong>Acceso al exterior:</strong><p>{{ $history->access_to_exterior ?: 'N/A' }}</p></div>
                            <div class="col-md-3"><strong>Lugar donde permanece:</strong><p>{{ $history->stay_place ?: 'N/A' }}</p></div>
                            <div class="col-md-3"><strong>Exposición a tóxicos:</strong><p>{{ $history->toxic_exposure ?: 'N/A' }}</p></div>
                            <div class="col-md-12">
                                <strong>Animales convivientes:</strong>
                                @if($cohabitingAnimals && $cohabitingAnimals->count() > 0)
                                    <ul>
                                        @foreach($cohabitingAnimals as $animal)
                                            <li>{{ $animal->animal->name }} - {{ $animal->name }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>N/A</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Reproducción --}}
                <div class="panel panel-bordered">
                    <div class="panel-heading"><h3 class="panel-title"><i class="fa-solid fa-venus-mars"></i> REPRODUCCIÓN</h3></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4"><strong>Hembras:</strong><p>{{ $history->females_repro ?: 'N/A' }}</p></div>
                            <div class="col-md-4"><strong>Machos:</strong><p>{{ $history->males_repro ?: 'N/A' }}</p></div>
                            <div class="col-md-4"><strong>Complicaciones reproductivas:</strong><p>{{ $history->repro_complications ?: 'N/A' }}</p></div>
                        </div>
                    </div>
                </div>

                {{-- Productos Utilizados --}}
                <div class="panel panel-bordered">
                    <div class="panel-heading"><h3 class="panel-title"><i class="fa-solid fa-pills"></i> PRODUCTOS UTILIZADOS</h3></div>
                    <div class="panel-body">
                        @if($history->anamnesisItemStocks && $history->anamnesisItemStocks->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Categoría</th>
                                            <th class="text-right">Precio</th>
                                            <th class="text-right">Cantidad</th>
                                            <th class="text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $total = 0; @endphp
                                        @foreach($history->anamnesisItemStocks as $item)
                                            @php
                                                $product = $item->itemStock->item;
                                                $subtotal = $item->price * $item->quantity;
                                                $total += $subtotal;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <strong>{!! $product->nameGeneric . ($product->nameTrade ? ' | ' . $product->nameTrade : '') !!}</strong><br>
                                                    <small>
                                                        @if($product->laboratory) Lab: {{ $product->laboratory->name }} @endif
                                                        @if($product->brand) | Marca: {{ $product->brand->name }} @endif
                                                    </small>
                                                </td>
                                                <td>{{ $product->category->name ?? 'N/A' }} | {{ $product->presentation->name ?? 'N/A' }}</td>
                                                <td class="text-right">{{ number_format($item->price, 2, ',', '.') }}</td>
                                                <td class="text-right">{{ $item->quantity }}</td>
                                                <td class="text-right">{{ number_format($subtotal, 2, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" class="text-right"><strong>TOTAL</strong></td>
                                            <td class="text-right"><strong>{{ number_format($total, 2, ',', '.') }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <p class="text-center text-muted">No se utilizaron productos en esta consulta.</p>
                        @endif
                    </div>
                </div>

                {{-- Observaciones Adicionales --}}
                <div class="panel panel-bordered">
                    <div class="panel-heading"><h3 class="panel-title"><i class="fa-solid fa-file-signature"></i> OBSERVACIONES ADICIONALES</h3></div>
                    <div class="panel-body">
                        <p>{{ $history->additional_observations ?: 'N/A' }}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop

@section('css')
<style>
    .panel-body .col-md-3, .panel-body .col-md-4, .panel-body .col-md-6, .panel-body .col-md-12 {
        margin-bottom: 15px;
    }
    .panel-body p {
        margin: 0;
        color: #555;
        border-left: 3px solid #f0f0f0;
        padding-left: 10px;
    }
    .panel-body ul {
        padding-left: 30px;
        margin-bottom: 0;
    }
</style>
@stop