<div class="col-md-12">
    <div class="table-responsive">
        <table id="dataTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th style="text-align: center; width: 5%;">ID</th>
                    <th style="text-align: center">Servicio</th>
                    <th style="text-align: center">Fecha y Hora</th>
                    <th style="text-align: center">Estado</th>
                    <th style="text-align: center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    <tr>
                        <td style="text-align: center; width: 5%">{{ $item->id }}</td>
                        <td>{{ $item->service->name }}</td>
                        <td style="text-align: center">{{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }} {{ $item->time }}</td>
                        <td style="text-align: center">
                            @if ($item->status!="Pendiente")  
                                <label class="label label-success">Atendido</label>
                            @else
                                <label class="label label-warning">Pendiente</label>
                            @endif
                        </td>
                        <td style="width: 10%" class="no-sort no-click bread-actions text-right">
                            @if (auth()->user()->hasPermission('read_appointments'))
                                <a href="{{ route('voyager.people.show', ['id' => $item->id]) }}" title="Ver" class="btn btn-sm btn-warning view">
                                    <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm"></span>
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <h5 class="text-center" style="margin-top: 20px">
                                <img src="{{ asset('images/empty.png') }}" width="80px" alt="" style="opacity: 0.8">
                                <br><br>
                                No hay citas registradas.
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