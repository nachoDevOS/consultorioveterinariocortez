<div class="col-md-12">
    <div class="table-responsive">
        <table id="dataTable" class="table table-hover" style="width:100%">
            <thead class="thead-light">
                <tr>
                    <th style="text-align: center" style="width: 5%;">ID</th>
                    <th style="text-align: center">Cliente</th>
                    <th style="text-align: center">Monto</th>
                    <th style="text-align: center">Fecha</th>
                    <th style="text-align: center">Estado</th>
                    <th class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                <tr>
                    <td style="text-align: center">{{ $item->id }}</td>
                    <td>
                        @if ($item->person)
                            <div class="d-flex align-items-center">
                                @php
                                    $image = asset('images/default.jpg');
                                    if($item->person->image){
                                        $image = asset('storage/'.str_replace('.', '-cropped.', $item->person->image));
                                    }
                                @endphp
                                <img src="{{ $image }}" alt="{{ $item->person->first_name }}" class="rounded-circle" style="width: 40px; height: 40px; margin-right: 10px;">
                                <div>
                                    <strong>{{ strtoupper($item->person->first_name) }} {{ $item->person->middle_name??strtoupper($item->person->middle_name) }} {{ strtoupper($item->person->paternal_surname) }}  {{ strtoupper($item->person->maternal_surname) }}</strong>
                                </div>
                            </div>
                        @else
                            <span class="text-muted">Sin Datos</span>
                        @endif
                    </td>
                    <td style="text-align: center">
                        <strong>Bs. {{ number_format($item->amount, 2, ',', '.') }}</strong><br>
                        @if ($item->typeSale == 'Venta al Credito')
                            <span class="badge badge-danger">Al Credito</span>
                        @elseif ($item->typeSale == 'Venta al Contado')
                            <span class="badge badge-success">Al Contado</span>
                        @else
                            <span class="badge badge-dark">Proforma</span>
                        @endif
                    </td>
                    <td class="text-center">
                        {{date('d/m/Y h:i:s a', strtotime($item->dateSale))}}<br>
                        <small>{{\Carbon\Carbon::parse($item->dateSale)->diffForHumans()}}</small><br>
                        <small>Por: {{$item->register->name}}</small>
                    </td>
                    <td class="text-center">
                        @if ($item->status=='Pendiente' && $item->typeSale=='Venta al Credito')
                            <div>
                                <span class="badge badge-warning">Pendiente</span><br>
                                <small>Pagado: Bs. {{ number_format($item->amortization, 2, ',', '.') }}</small><br>
                                <small class="text-danger">Deuda: Bs. {{ number_format($item->amount-$item->amortization, 2, ',', '.') }}</small>
                            </div>
                        @elseif ($item->status=='Pagado')
                            <span class="badge badge-success">Pagado</span>
                        @else
                            <span class="badge badge-info">{{$item->status}}</span>
                        @endif
                    </td>
                    <td style="width: 18%" class="no-sort no-click bread-actions text-right">
                        {{-- @if ($item->status=='Pendiente' && $item->typeSale=='Venta al Credito' && $item->amount == $item->amortization)  
                            <a href="{{ route('sales.prinf', ['id' => $item->id]) }}" title="Amortizar" class="btn btn-sm btn-success view">
                                <i class="voyager-dollar"></i>
                            </a>                           
                        @endif  --}}
                        
                        <a href="{{ route('sales.prinf', ['id' => $item->id]) }}" target="_blank" title="Imprimir" class="btn btn-sm btn-dark view">
                                <i class="fa-solid fa-print"></i>
                        </a>
                    
                        @if (auth()->user()->hasPermission('read_sales'))
                            <a href="{{ route('sales.show', ['sale' => $item->id]) }}" title="Ver" class="btn btn-sm btn-warning view">
                                <i class="voyager-eye"></i>
                            </a>
                        @endif
                        
                        @if (auth()->user()->hasPermission('delete_sales'))
                            <a href="#" onclick="deleteItem('{{ route('sales.destroy', ['sale' => $item->id]) }}')" title="Eliminar" data-toggle="modal" data-target="#modal-delete" class="btn btn-sm btn-danger delete">
                                <i class="voyager-trash"></i>
                            </a>
                        @endif
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            <div class="py-5">
                                <img src="{{ asset('images/empty.png') }}" width="120px" alt="No hay resultados" style="opacity: 0.8">
                                <h4 class="mt-3">No se encontraron ventas</h4>
                                <p class="text-muted">Parece que aún no se ha registrado ninguna venta.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="col-md-12">
    <div class="col-md-4" style="overflow-x:auto">
        @if(count($data)>0)
            <p class="text-muted">Mostrando del {{$data->firstItem()}} al {{$data->lastItem()}} de {{$data->total()}} registros.</p>
        @endif
    </div>
    <div class="col-md-8" style="overflow-x:auto">
        <nav class="text-right">
            {{ $data->links() }}
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
                list(page);
            }
        });
    });
</script>