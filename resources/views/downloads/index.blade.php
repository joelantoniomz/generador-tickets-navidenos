@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <div class="panel-card">
        <div class="panel-header-blue flex-between">
            <div class="panel-title-text">
                <i class="fa-solid fa-download"></i> &nbsp;Centro de Descargas
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
                        <th>Archivo</th>
                        <th>Formato</th>
                        <th>Rango</th>
                        <th>Descargar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($batches as $b)
                        <tr>
                            <td>{{ $b->created_at->format('d/m/Y H:i') }}</td>
                            <td><b>#{{ $b->id }}</b></td>
                            <td class="file-cell">{{ $b->format === 'word' ? ($b->file_docx ?: 'tickets_navidenos.docx') : ($b->file_pdf ?: 'tickets_navidenos.pdf') }}</td>
                            <td>{{ strtoupper($b->format ?: 'PDF') }}</td>
                            <td>N.º {{ str_pad($b->start_number, 6, '0', STR_PAD_LEFT) }} a N.º {{ str_pad($b->end_number, 6, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div class="table-actions-row">
                                    <a href="{{ route('downloads.file', [$b, 'pdf']) }}" class="btn-tbl-action text-red" title="Descargar PDF">
                                        <i class="fa-solid fa-file-pdf"></i> PDF
                                    </a>
                                    <a href="{{ route('downloads.file', [$b, 'docx']) }}" class="btn-tbl-action text-blue" title="Descargar Word">
                                        <i class="fa-solid fa-file-word"></i> Word
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted" style="padding: 25px;">No hay archivos generados todavía.</td>
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
