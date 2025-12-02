<div class="table-responsive">
    <table class="table table-hover" id="dataTable">
        <thead>
            <tr>
                <th>N&deg;</th>
                <th>Nombre</th>
                <th>Observación</th>
                <th>Estado</th>
                <th class="text-right">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @php
                $cont = 1;
            @endphp
            @forelse ($races as $item)
                <tr>
                    <td>{{ $cont }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->observation ?? 'Sin observación' }}</td>
                    <td>
                        @if ($item->status == 1)
                            <label class="label label-success">Activo</label>
                        @else
                            <label class="label label-warning">Inactivo</label>
                        @endif
                    </td>
                    <td class="no-sort no-click bread-actions text-right">
                        @if (auth()->user()->hasPermission('delete_races'))
                            <a href="#" title="Borrar" class="btn btn-sm btn-danger pull-right delete" data-id="{{ $item->id }}" data-toggle="modal" data-target="#delete_modal" onclick="deleteItem('{{ route('voyager.races.destroy', ['race' => $item->id]) }}')">
                                <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Borrar</span>
                            </a>
                        @endif
                    </td>
                </tr>
                @php $cont++; @endphp
            @empty
                <tr>
                    <td colspan="5" class="text-center">No hay datos registrados</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="col-md-12">
    <div class="col-md-6" style="overflow-x:auto">
        @if(count($races)>0)
            <p class="text-muted">Mostrando del {{ $races->firstItem() }} al {{ $races->lastItem() }} de {{ $races->total() }} registros.</p>
        @endif
    </div>
    <div class="col-md-6">
        <nav class="pull-right">
            {{ $races->links() }}
        </nav>
    </div>
</div>