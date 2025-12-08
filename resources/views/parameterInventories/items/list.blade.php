<div class="col-md-12">
    <div class="table-responsive">
        <table id="dataTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th style="text-align: center; width: 3%">ID</th>
                    <th style="text-align: center; width: 50%">Item</th>
                    <th style="text-align: center">Descripción</th>
                    <th style="text-align: center; width: 5%">Estado</th>
                    <th style="text-align: center; width: 10%">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    @php
                        $image = asset('images/default.jpg');
                        if($item->image){
                            $image = asset('storage/' . str_replace('.avif', '', $item->image) . '-cropped.webp');
                        }
                        $stock = $item->itemStocks->sum('stock');
                    @endphp
                    <tr>
                        <td style="text-align: center">{{ $item->id }}</td>
                        <td>
                            <div style="display: flex; align-items: center;">
                                <img src="{{ $image }}" alt="{{ $item->name }}"
                                    class="image-expandable"
                                    style="width: 70px; height: 70px; border-radius: 8px; margin-right: 10px; object-fit: cover; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                <div>
                                    <strong style="font-size: 12px">{{ strtoupper($item->nameGeneric) }} {{ $item->nameTrade? '  |  '.strtoupper($item->nameTrade):null }}</strong> <br>
                                    <div style="font-size: 10px; color: #555; margin-top: 5px;">
                                        <span>CATEGORÍA:</span> {{ $item->category?strtoupper($item->category->name):'SN' }} <br>
                                        <span>PRESENTACIÓN:</span> {{ $item->presentation?strtoupper($item->presentation->name):'SN' }} <br>
                                        <span>LABORATORIO:</span> {{ $item->laboratory?strtoupper($item->laboratory->name):'SN' }} <br>
                                        <span>MARCA:</span> {{ $item->brand?strtoupper($item->brand->name):'SN' }} 
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td> 
                            <strong style="font-size: 12px">{{$item->observation}}</strong>
                            <table class="table table-bordered table-condensed">
                                <thead>
                                    <tr>
                                        <th style="font-size: 10px; padding: 2px 5px;">Lote</th>
                                        <th style="font-size: 10px; padding: 2px 5px;">Stock</th>
                                        <th style="font-size: 10px; padding: 2px 5px;">Precio de Venta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($item->itemStocks as $itemStock)
                                        <tr>
                                            <td style="font-size: 10px;">{{ $itemStock->lote }}</td>
                                            <td style="font-size: 10px;">{{ $itemStock->stock }}</td>
                                            <td style="font-size: 10px;">{{ $itemStock->priceSale }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                
                        <td style="text-align: center">
                            @if ($item->status==1)  
                                <label class="label label-success">Activo</label>
                            @else
                                <label class="label label-warning">Inactivo</label>
                            @endif    
                            <br>
                            @if ($stock == 0)
                                <label class="label label-danger">Agotado</label>
                            @elseif ($stock <= 5)
                                <label class="label label-warning">{{ $stock }}</label>
                            @else
                                <label class="label label-success">{{ $stock }}</label>
                            @endif                    
                        </td>
                        <td class="no-sort no-click bread-actions text-right">
                            @if (auth()->user()->hasPermission('read_items'))
                                <a href="{{ route('voyager.items.show', ['id' => $item->id]) }}" title="Ver" class="btn btn-sm btn-warning view">
                                    <i class="voyager-eye"></i> 
                                </a>
                            @endif
                            @if (auth()->user()->hasPermission('edit_items'))
                                <a href="{{ route('voyager.items.edit', ['id' => $item->id]) }}" title="Editar" class="btn btn-sm btn-primary edit">
                                    <i class="voyager-edit"></i>
                                </a>
                            @endif
                            @if (auth()->user()->hasPermission('delete_items'))
                                <a href="#" onclick="deleteItem('{{ route('voyager.items.destroy', ['id' => $item->id]) }}')" title="Eliminar" data-toggle="modal" data-target="#modal-delete" class="btn btn-sm btn-danger delete">
                                    <i class="voyager-trash"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
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