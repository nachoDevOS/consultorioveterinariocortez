<div class="col-md-12">
    <div class="table-responsive">
        <table id="dataTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th style="text-align: center; width: 5%;">ID</th>
                    <th style="text-align: center">Servicios</th>
                    <th style="text-align: center">Nombre Cliente</th>     
                    <th style="text-align: center">Especie</th>     
                    <th style="text-align: center">Nombre Mascota</th>
                    <th style="text-align: center">Sexo</th>
                    <th style="text-align: center">Edad.</th>
                    <th style="text-align: center">Estado</th>
                    <th style="text-align: center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    <tr>
                        <td style="text-align: center; width: 5%">{{ $item->id }}</td>
                        <td>{{ $item->service->name }}</td>
                        <td>{{ $item->nameClient }}</td>
                        <td style="text-align: center">
                            {{ $item->animal->name }} <br>
                            @if ($item->race)
                                {{ $item->race->name }}
                            @endif
                        </td>
                        <td>{{ $item->nameAnimal }}</td>
                        <td style="text-align: center">{{ $item->gender }}</td>                      
           
                        <td style="text-align: center">{{ $item->phone?$item->phone:'SN' }}</td>
                        <td style="text-align: center">
                            @if ($item->status!="Pendiente")  
                                <label class="label label-success">Atendido</label>
                            @else
                                <label class="label label-warning">Pendiemte</label> <br>
                                @if ($item->view)
                                    <i class="fa-solid fa-eye"></i>
                                @else
                                    <i class="fa-solid fa-eye-slash"></i>
                                @endif
                            @endif
                        </td>
                        <td style="width: 10%" class="no-sort no-click bread-actions text-right">
                            @if (auth()->user()->hasPermission('read_appointments'))
                                <a href="{{ route('voyager.people.show', ['id' => $item->id]) }}" title="Ver" class="btn btn-sm btn-warning view">
                                    <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm"></span>
                                </a>
                            @endif
                
                            @if (auth()->user()->hasPermission('delete_appointments'))
                                <a href="#" onclick="deleteItem('{{ route('voyager.people.destroy', ['id' => $item->id]) }}')" title="Eliminar" data-toggle="modal" data-target="#modal-delete" class="btn btn-sm btn-danger delete">
                                    <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm"></span>
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">
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