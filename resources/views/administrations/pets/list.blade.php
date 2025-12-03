<div class="col-md-12">
    <div class="table-responsive">
        <table id="dataTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th style="text-align: center">ID</th>
                    <th style="text-align: center">Mascota</th>
                    <th style="text-align: center">Dueño</th>
                    <th style="text-align: center">Especie / Raza</th>
                    <th style="text-align: center">Género / Color</th>
                    <th style="text-align: center">Estado</th>
                    <th style="text-align: center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                @php
                    $image = $item->image ? Voyager::image($item->image) : asset('images/default.jpg');
                @endphp
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>
                        <div style="display: flex; align-items: center;">
                            <img src="{{ $image }}" alt="{{ $item->name }}" class="image-expandable" style="width: 60px; height: 60px; border-radius: 30px; margin-right: 10px; object-fit: cover;">
                            <div>
                                <strong>{{ strtoupper($item->name) }}</strong> <br>
                                @if ($item->birthdate)
                                    @php
                                        $age = \Carbon\Carbon::parse($item->birthdate)->diffForHumans(null, true);
                                    @endphp
                                    <small>{{ $age }}</small>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($item->person)
                            {{ strtoupper($item->person->first_name) }} {{ strtoupper($item->person->paternal_surname) }} <br>
                            <small>{{ $item->person->phone }}</small>
                        @else
                            <span class="text-muted">Sin dueño asignado</span>
                        @endif
                    </td>
                    <td style="text-align: center">
                        {{ $item->animal->name ?? 'N/A' }} <br>
                        <small>{{ $item->race->name ?? 'N/A' }}</small>
                    </td>
                    <td style="text-align: center">
                        {{ $item->gender ?? 'N/A' }} <br>
                        <small>{{ $item->color ?? 'N/A' }}</small>
                    </td>
                    <td style="text-align: center">
                        @if ($item->status==1)
                            <label class="label label-success">Activo</label>
                        @else
                            <label class="label label-warning">Inactivo</label>
                        @endif
                    </td>
                    <td style="width: 18%" class="no-sort no-click bread-actions text-right">
                        @if (auth()->user()->hasPermission('read_pets'))
                            <a href="{{ route('voyager.pets.show', ['id' => $item->id]) }}" title="Ver" class="btn btn-sm btn-warning view">
                                <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm"></span>
                            </a>
                        @endif
                        @if (auth()->user()->hasPermission('edit_pets'))
                            <a href="{{ route('voyager.pets.edit', ['id' => $item->id]) }}" title="Editar" class="btn btn-sm btn-primary edit">
                                <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm"></span>
                            </a>
                        @endif
                        @if (auth()->user()->hasPermission('delete_pets'))
                            <a href="#" onclick="deleteItem('{{ route('voyager.pets.destroy', ['id' => $item->id]) }}')" title="Eliminar" data-toggle="modal" data-target="#modal-delete" class="btn btn-sm btn-danger delete">
                                <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm"></span>
                            </a>
                        @endif
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="7">
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