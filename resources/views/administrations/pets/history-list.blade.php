<div class="col-md-12">
    <div class="table-responsive">
        <table id="dataTable" class="table table-hover">
            <thead>
                <tr>
                    <th style="text-align: center; width: 5%">Codigo</th>
                    <th style="text-align: center; width: 10%">Fecha</th>
                    <th style="text-align: center">Problema Principal</th>
                    {{-- <th style="text-align: center">Observaciones Adicionales</th> --}}
                    <th style="text-align: center; width: 15%">Veterinario</th>
                    <th style="width: 15%" class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $history)
                <tr>
                    <td>{{ str_pad($history->id, 6, '0', STR_PAD_LEFT) }}</td>
                    <td style="text-align: center">{{ \Carbon\Carbon::parse($history->date)->format('d/m/Y') }}</td>
                    <td>{{ Str::limit($history->main_problem, 70) ?? 'No especificado' }}</td>
                    {{-- <td>{{ Str::limit($history->additional_observations, 70) ?? 'No especificado' }}</td> --}}
                    <td>{{ $history->doctor->name ?? 'No especificado' }}</td>
                    <td class="no-sort no-click bread-actions text-right">
                        {{-- Aquí puedes agregar botones para ver, editar o eliminar un historial --}}
                        <a href="{{ route('voyager.pets.history.show', ['history' => $history->id]) }}" title="Ver" class="btn btn-sm btn-warning view">
                            <i class="voyager-eye"></i>
                        </a>
                        <a href="{{ route('voyager.pets.history.edit', ['anamnesis' => $history->id]) }}" title="Editar" class="btn btn-sm btn-primary">
                            <i class="voyager-edit"></i>
                        </a>
                        <a href="#" onclick="deleteItem('{{ route('voyager.pets.history.destroy', ['anamnesis' => $history->id]) }}')" title="Eliminar" data-toggle="modal" data-target="#modal-delete" class="btn btn-sm btn-danger delete">
                            <i class="voyager-trash"></i>
                        </a>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <h5 class="text-center" style="margin-top: 20px; margin-bottom: 20px;">
                                <img src="{{ asset('images/empty.png') }}" width="80px" alt="Vacio" style="opacity: 0.8;">
                                <br><br>
                                No hay resultados.
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
    $('.page-link').click(function(e){
        e.preventDefault();
        let link = $(this).attr('href');
        let page = link.split('page=')[1];
        list_histories(page);
    });


</script>