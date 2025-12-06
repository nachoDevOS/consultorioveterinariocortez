<div class="col-md-12">
    <div class="table-responsive">
        <table id="dataTable" class="table table-hover">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Problema Principal</th>
                    <th>Veterinario</th>
                    <th class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $history)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($history->date)->format('d/m/Y') }}</td>
                    <td>{{ Str::limit($history->main_problem, 70) ?? 'No especificado' }}</td>
                    <td>{{ $history->doctor->name ?? 'No especificado' }}</td>
                    <td class="no-sort no-click bread-actions text-right">
                        {{-- Aquí puedes agregar botones para ver, editar o eliminar un historial --}}
                        <a href="{{ route('voyager.pets.history.show', ['history' => $history->id]) }}" title="Ver" class="btn btn-sm btn-warning view">
                            <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">Ver</span>
                        </a>
                        <a href="{{ route('voyager.pets.history.edit', ['anamnesis' => $history->id]) }}" title="Editar" class="btn btn-sm btn-primary">
                            <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">Editar</span>
                        </a>
                        <button type="button" title="Eliminar" class="btn btn-sm btn-danger delete" data-id="{{ $history->id }}" data-toggle="modal" data-target="#delete_modal">
                            <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Eliminar</span>
                        </button>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="4">
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

{{-- Modal de Confirmación de Eliminación --}}
<div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="voyager-trash"></i> ¿Estás seguro de que quieres eliminar este historial?</h4>
            </div>
            <div class="modal-body">
                <p>Esta acción no se puede deshacer. Si este historial tiene productos asociados, el stock será restituido.</p>
            </div>
            <div class="modal-footer">
                <form id="delete_form" method="POST">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger pull-right">Sí, ¡Eliminar!</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('.page-link').click(function(e){
        e.preventDefault();
        let link = $(this).attr('href');
        let page = link.split('page=')[1];
        list_histories(page);
    });

    // Script para el modal de eliminación
    $('.delete').on('click', function (e) {
        let id = $(this).data('id');
        let url = '{{ route("voyager.pets.history.destroy", ["anamnesis" => ":id"]) }}';
        url = url.replace(':id', id);
        $('#delete_form').attr('action', url);
    });
</script>