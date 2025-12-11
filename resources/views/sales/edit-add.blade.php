@extends('voyager::master')

@section('page_title', 'Añadir Venta')

@section('page_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body" style="padding: 0px">
                        <div class="col-md-8" style="padding: 0px">
                            <h1 class="page-title">
                                <i class="fa-solid fa-cart-plus"></i> Añadir Venta
                            </h1>
                        </div>
                        <div class="col-md-4 text-right" style="margin-top: 30px">
                            <a href="{{ route('sales.index') }}" class="btn btn-warning">
                                <i class="voyager-plus"></i> <span>Volver</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        <form class="form-edit-add" action="{{ route('sales.store') }}" method="post">
            @csrf
            <div class="row">
                @if (setting('ventas.cashier_required') && !$cashier)
                    <div class="col-md-12" style="margin-bottom: 5px">
                        <div class="panel panel-bordered" style="border-left: 5px solid #CB4335">
                            <div class="panel-body" style="padding: 10px">
                                <div class="col-md-12">
                                    <h5 class="text-danger">Advertencia</h5>
                                    <h4>Debe abrir caja antes de registrar ventas. &nbsp; <a
                                            href="{{ route('cashiers.create') }}?redirect=admin/sales/create"
                                            class="btn btn-success">Abrir ahora <i class="voyager-plus"></i></a></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-md-8">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="product_id">Buscar producto</label>
                                    <select class="form-control" id="select-product_id"></select>
                                </div>
                            </div>
                            <div class="col-md-12" style="height: 800px; max-height: 400px; overflow-y: auto">
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
                                                <td colspan="7" style="height: 320px">
                                                    <h4 class="text-center text-muted" style="margin-top: 50px">
                                                        <i class="glyphicon glyphicon-shopping-cart"
                                                            style="font-size: 50px"></i> <br><br>
                                                        Lista de venta vacía
                                                    </h4>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <textarea name="observation" class="form-control" rows="2" placeholder="Observaciones"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-bordered">
                        <div class="panel-body" style="padding: 10px 0px">
                            @if (setting('admin.customer'))  
                                <div class="form-group col-md-12">
                                    <label for="person_id">Cliente</label>
                                    <div class="input-group">
                                        <select name="person_id" id="select-person_id" class="form-control"></select>
                                        <span class="input-group-btn">
                                            <button id="trash-person" class="btn btn-default" title="Quitar Cliente"
                                                style="margin: 0px" type="button">
                                                <i class="voyager-trash"></i>
                                            </button>
                                            <button class="btn btn-primary" title="Nuevo cliente"
                                                data-target="#modal-create-person" data-toggle="modal" style="margin: 0px"
                                                type="button">
                                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            @endif

                            <div class="form-group col-md-12">
                                <label for="date">Tipo</label>
                                <select class="form-control select2" name="typeSale" id="typeSale"
                                    onchange="funtion_typeSale()" required>
                                    <option value="" disabled selected>--Selecione una opción--</option>
                                    <option value="Venta al Contado">Venta al Contado</option>
                                    <option value="Venta al Credito">Venta al Credito</option>
                                    <option value="Proforma">Proforma</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="payment_type">Método de pago</label>
                                <select name="payment_type" id="select-payment_type" class="form-control" required>
                                    <option value="" disabled selected>--Seleccione una opción--</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Qr">Qr/Transferencia</option>
                                    <option value="Efectivo y Qr">Efectivo y Qr</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="amount_cash">Monto en Efectivo</label>
                                <input type="number" name="amount_cash" id="amount_cash" class="form-control"
                                    value="0" step="0.01" style="text-align: right" placeholder="0.00">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="amount_qr">Monto en Qr/Transferencia</label>
                                <input type="number" name="amount_qr" id="amount_qr" class="form-control"
                                    value="0" step="0.01" style="text-align: right" placeholder="0.00">
                            </div>
                            <div class="form-group col-md-12">
                                <input type="hidden" name="amountReceived" id="amountReceived" value="0">
                                <h3 class="text-right" id="change-message-error" style="display: none;"><small
                                        style="color: red !important">Ingrese un Monto igual o mayor al total de la
                                        venta</small></h3>
                                <h3 class="text-right" id="change-message-error-credito" style="display: none;"><small
                                        style="color: red !important">Ingrese un Monto menor a la venta al credito</small>
                                </h3>
                                <h3 class="text-right" id="change-message"><small>Cambio: Bs.</small> <b
                                        id="change-amount">0.00</b></h3>
                                <h3 class="text-right" id="change-message-credito"><small>Deuda Pendiente: Bs.</small> <b
                                        id="change-amount-credito">0.00</b></h3>
                                <h3 class="text-right"><small>Total a cobrar: Bs.</small> <b id="label-total">0.00</b>
                                </h3>
                                <input type="hidden" id="amountTotalSale" name="amountTotalSale" value="0">
                                <label class="checkbox-inline">
                                    <input type="checkbox" required>Confirmar registro..!
                                </label>
                            </div>
                            <div class="form-group col-md-12 text-center">
                                <button type="submit" class="btn btn-primary btn-block btn-submit"
                                    data-toggle="modal" data-target="#modal-confirm">Registrar <i
                                        class="voyager-basket"></i></button>
                                <a href="{{ route('sales.index') }}">Volver a la lista</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Popup para imprimir el recibo --}}
    <div id="popup-button">
        <div class="col-md-12" style="padding-top: 5px">
            <h4 class="text-muted">Desea imprimir el recibo?</h4>
        </div>
        <div class="col-md-12 text-right">
            <button onclick="javascript:$('#popup-button').fadeOut('fast')" class="btn btn-default">Cerrar</button>
            <a id="btn-print" href="#" target="_blank" title="Imprimir" class="btn btn-danger">Imprimir <i
                    class="glyphicon glyphicon-print"></i></a>
        </div>
    </div>

    {{-- Modal crear cliente --}}
    @include('partials.modal-registerPerson')
@stop

@section('css')
    <style>
        .form-group {
            margin-bottom: 10px !important;
        }

        .label-description {
            cursor: pointer;
        }

        #popup-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 400px;
            height: 100px;
            background-color: white;
            box-shadow: 5px 5px 15px grey;
            z-index: 1000;

            /* Mostrar/ocultar popup */
            @if (session('sale_id'))
                animation: show-animation 1s;
            @else
                right: -500px;
            @endif
        }

        @keyframes show-animation {
            0% {
                right: -500px;
            }

            100% {
                right: 20px;
            }
        }
    </style>
@endsection

@section('javascript')
    <script src="{{ asset('js/btn-submit.js') }}"></script>
    <script src="{{ asset('js/include/person-select.js') }}"></script>
    <script src="{{ asset('js/include/person-register.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/es.min.js"></script>

    <script src="{{ asset('vendor/tippy/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/tippy/tippy-bundle.umd.min.js') }}"></script>
    <script>
        var productSelected, customerSelected, totalAmount;

        $(document).ready(function() {
            $('<style>.select2-results__options { max-height: 450px !important; }</style>').appendTo('head');

            $('#select-product_id').select2({
                width: '100%',
                placeholder: '<i class="fa fa-search"></i> Buscar...',
                escapeMarkup: function(markup) {
                    return markup;
                },
                language: {
                    inputTooShort: function(data) {
                        return `Por favor ingrese ${data.minimum - data.input.length} o más caracteres`;
                    },
                    noResults: function() {
                        return `<i class="far fa-frown"></i> No hay resultados encontrados`;
                    }
                },
                quietMillis: 250,
                minimumInputLength: 2,
                ajax: {
                    url: "{{ url('admin/item/stock/ajax') }}",

                    processResults: function(data) {
                        let results = [];
                        data.map(data => {
                            results.push({
                                ...data,
                                disabled: false
                            });
                        });
                        return {
                            results
                        };
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
                    if(product.item.image){
                        image = "{{ asset('storage') }}/"+product.item.image.replace('.avif','-cropped.webp')
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

            $('#form-sale').submit(function(e) {
                if (this.checkValidity()) {
                    $('.btn-confirm').val('Guardando...');
                    $('.btn-confirm').attr('disabled', true);
                }
            });

            // Ocultar mensajes al inicio
            $('#change-message-credito, #change-message, #change-message-error, #change-message-error-credito').hide();

            // Eventos que disparan la actualización de la lógica de pago
            $('#typeSale, #select-payment_type').on('change', updatePaymentLogic);
            $('#amount_cash, #amount_qr').on('keyup change', handleAmountInputs);

            // Inicializar la lógica de pago al cargar la página
            updatePaymentLogic();
        });

        function funtion_typeSale() {
            getTotal();
        }

        function getSubtotal(id) {
            let price = $(`#input-price-${id}`).val() ? parseFloat($(`#input-price-${id}`).val()) : 0;
            let quantity = $(`#input-quantity-${id}`).val() ? parseFloat($(`#input-quantity-${id}`).val()) : 0;
            let stock = parseFloat($(`#input-quantity-${id}`).attr('max')) || 0;
            if (quantity > stock) {
                $(`#input-quantity-${id}`).val(stock);
                quantity = stock;
            }
            $(`#label-subtotal-${id}`).text((price * quantity).toFixed(2));
            $(`#subTotal-${id}`).val((price * quantity).toFixed(2));
            getTotal();
        }

        function setNumber() {
            var length = 0;
            $(".td-item").each(function(index) {
                $(this).text(index + 1);
                length++;
            });
            if (length > 0) {
                $('#tr-empty').css('display', 'none');
            } else {
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


        function formatResultProducts(option) {
            if (option.loading) {
                return '<span class="text-center"><i class="fas fa-spinner fa-spin"></i> Buscando...</span>';
            }
            let image = window.defaultImage;
            if (option.item && option.item.image) {
                const lastDotIndex = option.item.image.lastIndexOf('.');
                const baseName = lastDotIndex !== -1 ? option.item.image.substring(0, lastDotIndex) : option.item.image;
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
                                    ${option.item.observation ? `<div style="font-size: 14px; margin-top: 5px;"><i class="fa-solid fa-clipboard-list" style="color: #f39c12; width: 14px; text-align: center;"></i> <strong style="color: #222;">Detalle:</strong> <span style="font-weight: bold; color: #222;">${option.item.observation}</span></div>` : ''}
                                    <div style="margin-top: 5px;"><i class="fa-solid fa-tags" style="color: #2ecc71; width: 14px; text-align: center;"></i> <strong style="color: #444;">Categoría:</strong> ${option.item.category.name} | ${option.item.presentation.name}</div>
                                    <div><i class="fa-solid fa-flask" style="color: #3498db; width: 14px; text-align: center;"></i> <strong style="color: #444;">Laboratorio:</strong> ${option.item.laboratory ? option.item.laboratory.name : 'SN'}</div>
                                    <div><i class="fa-solid fa-copyright" style="color: #9b59b6; width: 14px; text-align: center;"></i> <strong style="color: #444;">Marca:</strong> ${option.item.brand ? option.item.brand.name : 'SN'}</div>
                                </div>
                                <div class="text-right"><label class="label label-${stockLabel}">Stock: ${option.stock}</label></div>
                            </div>
                        </div>`);
        }

        $('#trash-person').on('click', function() {
            $('#input-dni').val('');
            $('#select-person_id').val('').trigger('change');
            toastr.success('Cliente eliminado', 'Eliminado');
        });

        // =================================================================
        // ====================== NEW PAYMENT LOGIC ========================
        // =================================================================

        function updatePaymentLogic() {
            let typeSale = $('#typeSale').val();
            let paymentType = $('#select-payment_type').val();
            var paymentSelect = $('#select-payment_type');
            let total = totalAmount;

            // Hide all dynamic sections by default
            paymentSelect.closest('.form-group').hide();
            $('#amount_cash').closest('.form-group').hide();
            $('#amount_qr').closest('.form-group').hide();
            $('#change-message-credito, #change-message, #change-message-error, #change-message-error-credito').hide();

            if (typeSale === 'Proforma') {
                paymentSelect.prop('required', false);
            } 
            else if (typeSale === 'Venta al Contado') {
                paymentSelect.prop('required', true).closest('.form-group').show();
                $('#amount_cash').closest('.form-group').show();
                $('#amount_qr').closest('.form-group').show();
                $('#change-message-error').show(); // Show "monto faltante" by default

                switch (paymentType) {
                    case 'Efectivo':
                        $('#amount_cash').prop('readonly', false).removeAttr('max').attr('min', total.toFixed(2));
                        $('#amount_qr').prop('readonly', true).val(0).attr('min', 0).attr('max', 0);
                        break;
                    case 'Qr':
                        $('#amount_cash').prop('readonly', true).val(0).attr('min', 0).attr('max', 0);
                        $('#amount_qr').prop('readonly', true).val(total.toFixed(2)).attr('min', total.toFixed(2)).attr('max', total.toFixed(2));
                        break;
                    case 'Efectivo y Qr':
                        $('#amount_cash').prop('readonly', false).val(0).attr('min', 0).attr('max', total.toFixed(2));
                        $('#amount_qr').prop('readonly', true).val(total.toFixed(2)).attr('min', 0).attr('max', total.toFixed(2));
                        break;
                    default:
                        $('#amount_cash').prop('readonly', true).val(0);
                        $('#amount_qr').prop('readonly', true).val(0);
                }
            } 
            else if (typeSale === 'Venta al Credito') {
                paymentSelect.prop('required', true).closest('.form-group').show();
                $('#change-message-credito').show();

                switch (paymentType) {
                    case 'Efectivo':
                        $('#amount_cash').closest('.form-group').show();
                        $('#amount_qr').closest('.form-group').hide();
                        $('#amount_cash').prop('readonly', false).val(0).attr('min', 0).attr('max', total.toFixed(2));
                        $('#amount_qr').val(0);
                        break;
                    case 'Qr':
                        $('#amount_cash').closest('.form-group').hide();
                        $('#amount_qr').closest('.form-group').show();
                        $('#amount_cash').val(0);
                        $('#amount_qr').prop('readonly', false).val(0).attr('min', 0).attr('max', total.toFixed(2));
                        break;
                    case 'Efectivo y Qr':
                        $('#amount_cash').closest('.form-group').show();
                        $('#amount_qr').closest('.form-group').show();
                        $('#amount_cash').prop('readonly', false).val(0).attr('min', 0).attr('max', total.toFixed(2));
                        $('#amount_qr').prop('readonly', false).val(0).attr('min', 0).attr('max', total.toFixed(2));
                        break;
                    default:
                        $('#amount_cash').closest('.form-group').hide();
                        $('#amount_qr').closest('.form-group').hide();
                        $('#amount_cash').val(0);
                        $('#amount_qr').val(0);
                        break;
                }
            }
            
            handleAmountInputs();
        }

        function handleAmountInputs() {
            let typeSale = $('#typeSale').val();
            let paymentType = $('#select-payment_type').val();
            const EPSILON = 0.001; // Small tolerance for float comparisons

            let total = totalAmount;
            let cash = parseFloat($('#amount_cash').val()) || 0;
            let qr = parseFloat($('#amount_qr').val()) || 0;

            // Logic for 'Venta al Contado' with 'Efectivo y Qr'
            if (typeSale === 'Venta al Contado' && paymentType === 'Efectivo y Qr') {
                if ($(document.activeElement).is('#amount_cash')) {
                    if (cash > total) {
                        $('#amount_qr').val(0);
                    } else {
                        let newQr = total - cash;
                        $('#amount_qr').val(newQr.toFixed(2));
                    }
                }
            }
            
            // Recalculate values after potential changes
            cash = parseFloat($('#amount_cash').val()) || 0;
            qr = parseFloat($('#amount_qr').val()) || 0;
            let totalPaid = cash + qr;

            // For credit sales, prevent payment from exceeding the total
            if (typeSale === 'Venta al Credito') {
                // Compare with a small tolerance for floating point issues
                if (totalPaid > total + EPSILON) {
                    $('#change-message-error-credito').show();
                    
                    // Adjust the currently active input to not exceed the total
                    if ($(document.activeElement).is('#amount_cash')) {
                        let maxCash = total - qr;
                        $('#amount_cash').val(maxCash > 0 ? maxCash.toFixed(2) : 0);
                    } else if ($(document.activeElement).is('#amount_qr')) {
                        let maxQr = total - cash;
                        $('#amount_qr').val(maxQr > 0 ? maxQr.toFixed(2) : 0);
                    }
                } else {
                    $('#change-message-error-credito').hide();
                }
            }

            // Recalculate totalPaid after adjustments
            cash = parseFloat($('#amount_cash').val()) || 0;
            qr = parseFloat($('#amount_qr').val()) || 0;
            totalPaid = cash + qr;

            $('#amountReceived').val(totalPaid.toFixed(2));
            calculateChange();
        }

        function calculateChange() {
            let typeSale = $('#typeSale').val();
            let totalPaid = parseFloat($('#amountReceived').val()) || 0;
            let total = totalAmount;
            const EPSILON = 0.001;

            // Hide all messages by default, then show the correct one
            $('#change-message, #change-message-credito, #change-message-error, #change-message-error-credito').hide();

            if (typeSale === 'Venta al Contado') {
                if (totalPaid >= total - EPSILON && total > 0) {
                    $('#change-message').show();
                    let change = totalPaid - total;
                    $('#change-amount').text(change > 0 ? change.toFixed(2) : '0.00');
                } else if (total > 0) {
                    $('#change-message-error').show();
                }
            } else if (typeSale === 'Venta al Credito') {
                $('#change-message-credito').show();
                let pending = total - totalPaid;
                
                // Prevent showing -0.00 or tiny negative values due to float issues
                if (Math.abs(pending) < EPSILON) {
                    pending = 0;
                }
                $('#change-amount-credito').text(pending.toFixed(2));
            }
        }

        function getTotal() {
            totalAmount = 0;
            $(".label-subtotal").each(function() {
                totalAmount += parseFloat($(this).text()) || 0;
            });
            $('#label-total').text(totalAmount.toFixed(2));
            $('#amountTotalSale').val(totalAmount.toFixed(2));
            updatePaymentLogic();
        }

    </script>
@stop
