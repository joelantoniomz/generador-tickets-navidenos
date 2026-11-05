@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <div class="panel-card">
        <div class="panel-header-blue flex-between">
            <div class="panel-title-text">
                <i class="fa-solid fa-clock-rotate-left"></i> &nbsp;Historial Completo de Generaciones
            </div>
            <a href="{{ route('dashboard') }}" class="btn-header-pill">
                <i class="fa-solid fa-arrow-left"></i> Volver al Dashboard
            </a>
        </div>
        <div class="panel-table-wrap">
            <table class="data-table-custom">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Lote</th>
                        <th>Serie</th>
                        <th>Desde</th>
                        <th>Hasta</th>
                        <th>Cantidad</th>
                        <th>Por Hoja</th>
                        <th>Formato</th>
                        <th>Usuario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($batches as $b)
                        <tr>
                            <td>{{ $b->created_at->format('d/m/Y H:i') }}</td>
                            <td><b>#{{ $b->id }}</b></td>
                            <td>{{ $b->series ?: 'A' }}</td>
                            <td>{{ str_pad($b->start_number, 6, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ str_pad($b->end_number, 6, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ number_format($b->quantity) }}</td>
                            <td>{{ $b->per_sheet }} tickets</td>
                            <td>{{ strtoupper($b->format ?: 'PDF') }}</td>
                            <td>{{ $b->user ? $b->user->name : 'Admin' }}</td>
                            <td>
                                <div class="table-actions-row">
                                    <a href="{{ route('downloads.file', [$b, $b->format === 'word' ? 'word' : 'pdf']) }}" class="btn-tbl-action text-blue" title="Descargar">
                                        <i class="fa-solid fa-download"></i>
                                    </a>
                                    <form method="POST" action="{{ route('tickets.destroy', $b) }}" class="form-inline-delete" onsubmit="return confirm('¿Seguro que deseas eliminar este lote?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-tbl-action text-red" title="Eliminar">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted" style="padding: 25px;">No hay registros en el historial.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($batches->hasPages())
            <div style="padding: 12px 16px; border-top: 1px solid var(--border-color);">
                {{ $batches->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
