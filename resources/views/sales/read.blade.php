@extends('voyager::master')

@section('page_title', 'Ver Ventas')

@php
    $total = $sale->saleDetails->sum('amount');
    $debt = $total - $sale->amortization;
@endphp

@section('page_header')
    <h1 class="page-title">
        <i class="fa-solid fa-cart-shopping"></i> Viendo Ventas &nbsp;
        <a href="{{ route('sales.index') }}" class="btn btn-warning">
            <i class="voyager-list"></i> &nbsp;
            Volver a la lista
        </a> 
        <a href="{{ route('sales.prinf', ['id' => $sale->id]) }}" target="_blank" title="Imprimir" class="btn btn-default">
            <i class="fa-solid fa-print"></i> &nbsp;
            Imprimir
        </a>
    </h1>
@stop

@section('content')
    <div class="page-content read container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <p><strong><i class="fa-solid fa-barcode"></i> Código:</strong> {{ $sale->id }}</p>
                                <p><strong><i class="fa-solid fa-tag"></i> Tipo:</strong> {{ $sale->typeSale }}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong><i class="fa-solid fa-user"></i> Cliente:</strong> {{$sale->person ? $sale->person->first_name.' '.$sale->person->paternal_surname.' '.$sale->person->maternal_surname : 'Cliente ocasional'}}</p>
                                <p><strong><i class="fa-solid fa-id-card"></i> CI/NIT:</strong> {{$sale->person ? $sale->person->ci : 'Sin documento'}}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong><i class="fa-solid fa-calendar"></i> Fecha:</strong> {{date('d/m/Y h:i a', strtotime($sale->dateSale))}}</p>
                                <p><strong><i class="fa-solid fa-user-pen"></i> Atendido por:</strong> {{$sale->register->name}}</p>
                            </div>
                            <div class="col-md-12">
                                <hr>
                                <p><strong><i class="fa-solid fa-pen-to-square"></i> Observación:</strong> {{$sale->observation ?? 'Ninguna'}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa-solid fa-list-ul"></i> Detalles de la Venta</h3>
                        <div class="panel-actions">
                            @if ($sale->typeSale != 'Proforma' && auth()->user()->hasPermission('read_sales') && $sale->status=='Pendiente')
                                <button class="btn btn-success" data-target="#modal-register-stock" data-toggle="modal">
                                    <i class="fa-solid fa-plus"></i> Amortizar
                                </button>
                            @endif
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th style="width:5%">N&deg;</th>
                                                <th style="text-align: center">Descripción</th>
                                                <th style="text-align: center; width:10%">Lote</th>
                                                <th style="text-align: center; width:10%">Cantidad</th>
                                                <th style="text-align: right; width:12%">P. Unit.</th>
                                                <th style="text-align: right; width:12%">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=1;
                                            @endphp 
                                            @forelse ($sale->saleDetails as $item)
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>{{ $item->itemStock->item->name }}</td>
                                                    <td style="text-align: center">{{ $item->itemStock->lote }}</td>
                                                    <td style="text-align: center">
                                                        {{number_format($item->quantity, 2, ',', '.')}}
                                                    </td>
                                                    <td style="text-align: right">
                                                        {{number_format($item->price, 2, ',', '.')}}
                                                    </td>
                                                    <td style="text-align: right">
                                                        {{number_format($item->amount, 2, ',', '.')}}
                                                    </td>

                                                </tr>
                                                @php
                                                    $i++;
                                                @endphp
                                            @empty
                                                <tr>
                                                    <td colspan="5">
                                                        <h5 class="text-center" style="margin-top: 50px">
                                                            <img src="{{ asset('images/empty.png') }}" width="120px" alt="" style="opacity: 0.8">
                                                            <br><br>
                                                            No hay resultados
                                                        </h5>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="well">
                                    <p><strong>Total a Pagar:</strong> <span class="pull-right">Bs. {{ number_format($total, 2, ',', '.') }}</span></p>
                                    @if ($sale->typeSale != 'Proforma')
                                        <p><strong>Total Pagado:</strong> <span class="pull-right text-success">Bs. {{ number_format($sale->amortization, 2, ',', '.') }}</span></p>
                                        <hr style="margin: 10px 0px;">
                                        <h4 class="text-right">Deuda Total: <b class="text-danger">Bs. {{ number_format($debt, 2, ',', '.') }}</b></h4>
                                    @endif
                                </div>

                                @if ($sale->typeSale != 'Proforma')
                                    <h4 style="margin-top: 20px;"><i class="fa-solid fa-money-bill-wave"></i> Historial de Pagos</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="width:5%">N&deg;</th>
                                                    <th>Registrado por</th>
                                                    <th style="text-align: right">Monto</th>
                                                    <th style="text-align: center">Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i=1;
                                                @endphp
                                                @forelse ($sale->saleTransactions as $item)
                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        <td>
                                                            {{ $item->register->name }} <br>
                                                            <small>{{date('d/m/Y h:i:s a', strtotime($item->created_at))}} <br> {{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</small>
                                                        </td>
                                                        <td style="text-align: right">
                                                            {{number_format($item->amount, 2, ',', '.')}}
                                                        </td>
                                                        <td style="text-align: center">
                                                            <a href="{{ route('sales-payment.prinf', ['id'=>$sale->id,'payment' => $item->id]) }}" target="_blank" title="Imprimir" class="btn btn-sm btn-dark view">
                                                                <i class="fa-solid fa-print"></i>
                                                            </a>
                                                            {{-- <a href="#" onclick="deleteItem('{{ route('sales-payment.destroy', ['id'=>$sale->id,'payment' => $item->id]) }}')" title="Eliminar" data-toggle="modal" data-target="#modal-delete" class="btn btn-sm btn-danger delete">
                                                                <i class="voyager-trash"></i>
                                                            </a> --}}
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $i++;
                                                    @endphp
                                                @empty
                                                    <tr>
                                                        <td colspan="4">
                                                            <h5 class="text-center" style="margin-top: 50px">
                                                                <img src="{{ asset('images/empty.png') }}" width="120px" alt="" style="opacity: 0.8">
                                                                <br><br>
                                                                No hay resultados
                                                            </h5>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($sale->typeSale != 'Proforma')                

        <form action="{{ route('sales-payment.store', ['id' => $sale->id]) }}" class="form-edit-add" method="POST">
            <div class="modal fade modal-success" data-backdrop="static" id="modal-register-stock" role="dialog">
                <div class="modal-dialog modal-success">
                    <div class="modal-content">
                        <div class="modal-header" style="color: #fff !important;">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" style="color: #ffffff !important"><i class="voyager-plus" ></i> Registrar Pagos</h4>
                        </div>
                        <div class="modal-body">
                            @csrf

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="date">Sucursal</label>
                                    <select class="form-control select2" name="branch_id" id="branch_id" required>
                                        <option value="" disabled selected>--Selecione una opción--</option>
                                        @foreach ($branches as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>                                        
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="payment_type">Método de pago</label>
                                    <select name="payment_type" id="select-payment_type-modal" class="form-control" required>
                                        <option value="" disabled selected>--Seleccione una opción--</option>
                                        <option value="Efectivo">Efectivo</option>
                                        <option value="Qr">Qr/Transferencia</option>
                                        <option value="Efectivo y Qr">Efectivo y Qr</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="amount_cash_modal">Monto en Efectivo</label>
                                    <input type="number" name="amount_cash" id="amount_cash_modal" class="form-control" value="0" step="0.01" style="text-align: right" placeholder="0.00">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="amount_qr_modal">Monto en Qr/Transferencia</label>
                                    <input type="number" name="amount_qr" id="amount_qr_modal" class="form-control" value="0" step="0.01" style="text-align: right" placeholder="0.00">
                                </div>
                                <div class="form-group col-md-12">
                                    <input type="hidden" name="amount" id="amount_modal" value="0" max={{$debt}}>
                                </div>
                            </div>    
                            {{-- <div class="form-group">
                                <label for="observation">Observación / Detalles</label>
                                <textarea name="observation" class="form-control" rows="3"></textarea>
                            </div> --}}

                            <label class="checkbox-inline">
                                <input type="checkbox" required>Confirmar..!
                            </label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-cancel" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success btn-submit">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @include('partials.modal-delete')
    @endif
    
@stop

@section('css')
    <style>
        .well {
            padding: 15px;
            background-color: #f5f5f5;
            border: 1px solid #e3e3e3;
            border-radius: 4px;
        }
    </style>
@stop

@section('javascript')

    <script>
        $(document).ready(function(){   
            $('.form-submit').submit(function(e){
                $('.btn-form-submit').attr('disabled', true);
                $('.btn-form-submit').val('Guardando...');
            });

            $('#delete_form').submit(function(e){
                $('.btn-form-delete').attr('disabled', true);
                $('.btn-form-delete').val('Eliminando...');
            });

            $('#modal-register-stock #select-payment_type-modal').on('change', updatePaymentInputsModal);

            $('#amount_cash_modal, #amount_qr_modal').on('keyup change', function() {
                let cash = parseFloat($('#amount_cash_modal').val()) || 0;
                let qr = parseFloat($('#amount_qr_modal').val()) || 0;
                let total = cash + qr;
                let max_payment = {{$debt}};

                if (total > max_payment) {
                    if ($(this).is('#amount_cash_modal')) {
                        $('#amount_cash_modal').val(max_payment - qr);
                    } else {
                        $('#amount_qr_modal').val(max_payment - cash);
                    }
                }
                updateTotalPaymentModal();
            });

            function updateTotalPaymentModal() {
                let cash = parseFloat($('#amount_cash_modal').val()) || 0;
                let qr = parseFloat($('#amount_qr_modal').val()) || 0;
                $('#amount_modal').val((cash + qr).toFixed(2));
            }

            function updatePaymentInputsModal() {
                let paymentType = $('#modal-register-stock #select-payment_type-modal').val();
                $('#amount_cash_modal').prop('readonly', true).val(0);
                $('#amount_qr_modal').prop('readonly', true).val(0);

                if (paymentType === 'Efectivo' || paymentType === 'Efectivo y Qr') {
                    $('#amount_cash_modal').prop('readonly', false);
                }
                if (paymentType === 'Qr' || paymentType === 'Efectivo y Qr') {
                    $('#amount_qr_modal').prop('readonly', false);
                }
                updateTotalPaymentModal();
            }
        });

        function deleteItem(url){
            $('#delete_form').attr('action', url);
        }
    </script>
    
@stop