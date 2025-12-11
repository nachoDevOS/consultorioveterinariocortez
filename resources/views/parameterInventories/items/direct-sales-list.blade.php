<div class="col-md-12">
    <div class="table-responsive">
        <table id="dataTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th style="text-align: center; width: 5%">ID Venta</th>
                    <th style="text-align: center; width: 25%">Cliente</th>
                    <th style="text-align: center; width: 10%">Lote</th>
                    <th style="text-align: center; width: 10%">Cantidad</th>
                    <th style="text-align: center; width: 10%">Precio</th>
                    <th style="text-align: center; width: 10%">Subtotal</th>
                    <th style="text-align: center; width: 15%">Fecha de Venta</th>
                    <th style="text-align: center; width: 15%">Vendido por</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sales as $saleDetail)
                <tr>
                    <td style="text-align: center">
                        <a href="{{ route('sales.show', ['sale' => $saleDetail->sale->id]) }}" target="_blank">
                            {{ $saleDetail->sale->id }}
                        </a>
                    </td>
                    <td>
                        @if ($saleDetail->sale->person)
                            {{ strtoupper($saleDetail->sale->person->first_name) }} {{ strtoupper($saleDetail->sale->person->paternal_surname) }}
                        @else
                            <span class="text-muted">Sin Cliente</span>
                        @endif
                    </td>
                    <td style="text-align: center">{{ $saleDetail->itemStock->lote ?? 'N/A' }}</td>
                    <td style="text-align: center">{{ $saleDetail->quantity }}</td>
                    <td style="text-align: right">{{ number_format($saleDetail->price, 2, ',', '.') }}</td>
                    <td style="text-align: right">{{ number_format($saleDetail->amount, 2, ',', '.') }}</td>
                    <td style="text-align: center">
                        {{ \Carbon\Carbon::parse($saleDetail->sale->dateSale)->isoFormat('DD/MM/Y HH:mm') }}<br>
                        <small>{{ \Carbon\Carbon::parse($saleDetail->sale->dateSale)->diffForHumans() }}</small>
                    </td>
                    <td>
                        {{ $saleDetail->sale->register->name ?? 'N/A' }}
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="8">
                            <h5 class="text-center" style="margin-top: 20px; margin-bottom: 20px;">
                                <i class="fa-solid fa-box-open" style="font-size: 50px;"></i>
                                <br><br>
                                No hay ventas directas registradas para este producto.
                            </h5>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="col-md-12">
    <div class="col-md-4" style="overflow-x:auto">
        @if(count($sales)>0)
            <p class="text-muted">Mostrando del {{$sales->firstItem()}} al {{$sales->lastItem()}} de {{$sales->total()}} registros.</p>
        @endif
    </div>
    <div class="col-md-8" style="overflow-x:auto">
        <nav class="text-right">
            {{ $sales->links() }}
        </nav>
    </div>
</div>

<script>
   var page = "{{ request('page') }}";
    $(document).ready(function(){
        $('.page-link').click(function(e){
            e.preventDefault();
            let link = $(this).attr('href');
            if(link){
                page = link.split('=')[1];
                listDirectSales(page);
            }
        });
    });
</script>