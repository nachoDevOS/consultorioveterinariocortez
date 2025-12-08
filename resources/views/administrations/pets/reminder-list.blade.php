<div class="table-responsive">
    <table class="table table-hover" id="dataTable">
        <thead>
            <tr>
                <th>N&deg;</th>
                <th>Descripción</th>
                <th>Fecha y hora</th>
                <th style="width: 5%">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reminders as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->observation }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }} {{ $item->time }}</td>
                 
                    <td class="no-sort no-click bread-actions">
                        {{-- <a href="#" title="Editar" class="btn btn-sm btn-info edit">
                            <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">Editar</span>
                        </a> --}}
                        <a href="#" title="Borrar" class="btn btn-sm btn-danger delete" onclick="deleteItem({{ $item->id }})" data-toggle="modal" data-target="#delete-modal-reminder">
                            <i class="voyager-trash"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4"><h5 class="text-center">No hay recordatorios registrados</h5></td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="col-md-12">
    <div class="col-md-6" style="overflow-x:auto">{!! $reminders->links() !!}</div>
</div>