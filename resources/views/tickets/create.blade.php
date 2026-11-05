@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <div style="display: grid; grid-template-columns: 1.1fr 1fr; gap: 14px;">
        <!-- Left: Vista Previa -->
        <div class="panel-card">
            <div class="panel-header-blue flex-between">
                <div class="panel-title-text">
                    <i class="fa-solid fa-eye"></i> &nbsp;Vista Previa del Ticket
                </div>
                <a href="{{ route('dashboard') }}" class="btn-header-pill">
                    <i class="fa-solid fa-arrow-left"></i> Volver al Dashboard
                </a>
            </div>
            <div class="panel-body-ticket">
                <div class="double-ticket" style="min-height: 280px; width:100%;">
                    <!-- Stub -->
                    <div class="ticket-half ticket-stub">
                        <!-- Festive Corner Holly -->
                        <div class="ticket-corner-ornament corner-top-left"></div>

                        <div class="ticket-brand-header">
                            <div class="ticket-laptop-logo">
                                <img src="{{ asset('images/laptop_logo_2x.png') }}" alt="Logo" class="ticket-logo-img">
                            </div>
                            <div class="ticket-brand-text">
                                <h3 class="ticket-store-name">{{ strtoupper($setting->store_name) }}</h3>
                                <p class="ticket-slogan">{{ $setting->slogan ?: 'Tecnología a tu alcance' }}</p>
                            </div>
                        </div>
                        <div class="ribbon-festive-wrapper">
                            <div class="ribbon-festive">GRAN SORTEO NAVIDEÑO 2026</div>
                        </div>
                        <div class="ticket-number-badge" id="previewStartNum">N.º 000001</div>
                        <div class="ticket-copy-pill pill-cyan">COPIA DE LA TIENDA</div>
                        <div class="ticket-form-lines">
                            <div class="ticket-form-row"><span class="form-row-label">Nombre:</span><span class="form-row-line"></span></div>
                            <div class="ticket-form-row"><span class="form-row-label">DNI:</span><span class="form-row-line"></span></div>
                            <div class="ticket-form-row"><span class="form-row-label">Celular:</span><span class="form-row-line"></span></div>
                        </div>
                        <div class="ticket-stub-footer-note">
                            <i class="fa-solid fa-box-archive"></i> Depositar este talón en el ánfora
                        </div>
                    </div>
                    <!-- Cut -->
                    <div class="ticket-perforation">
                        <div class="perforation-scissor"><i class="fa-solid fa-scissors"></i></div>
                        <div class="perforation-dashed-line"></div>
                    </div>
                    <!-- Customer -->
                    <div class="ticket-half ticket-customer">
                        <!-- Festive Corner Holly -->
                        <div class="ticket-corner-ornament corner-top-right"></div>

                        <div class="ticket-brand-header">
                            <div class="ticket-laptop-logo">
                                <img src="{{ asset('images/laptop_logo_2x.png') }}" alt="Logo" class="ticket-logo-img">
                            </div>
                            <div class="ticket-brand-text">
                                <h3 class="ticket-store-name">{{ strtoupper($setting->store_name) }}</h3>
                                <p class="ticket-slogan">{{ $setting->slogan ?: 'Tecnología a tu alcance' }}</p>
                            </div>
                        </div>
                        <div class="ribbon-festive-wrapper">
                            <div class="ribbon-festive">GRAN SORTEO NAVIDEÑO 2026</div>
                        </div>
                        <div class="ticket-number-badge">N.º 000001</div>
                        <div class="ticket-copy-pill pill-cyan">COPIA DEL CLIENTE</div>
                        <div class="ticket-prize-wrapper">
                            <div class="prize-canasta-thumb">
                                <img src="{{ asset('images/canasta_sorteo_2x.png') }}" alt="Canasta Navideña" class="prize-canasta-img">
                            </div>
                            <div class="prize-red-banner">
                                <span class="prize-banner-label">🎄 Premio:</span>
                                <strong class="prize-banner-title">{{ $setting->prize ?: 'Canasta Navideña' }}</strong>
                            </div>
                        </div>
                        <div class="ticket-draw-date-text">
                            @if($setting->show_draw_date)
                                Fecha del Sorteo: <strong>{{ $setting->draw_date->format('d/m/Y') }}</strong>
                            @else
                                {{ $setting->date_replacement ?: 'Texto alternativo del sorteo' }}
                            @endif
                        </div>
                        <div class="ticket-festive-greeting">
                            ¡Gracias por tu preferencia!
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Configuración de Generación -->
        <div class="panel-card">
            <div class="panel-header-blue">
                <div class="panel-title-text">
                    <i class="fa-solid fa-shapes"></i> &nbsp;Configuración de Generación de Lote
                </div>
            </div>
            <div class="panel-body-padded">
                <form method="POST" action="{{ route('tickets.store') }}">
                    @csrf
                    <div class="form-group-field">
                        <label class="form-label-small">Número Inicial:</label>
                        <input type="text" name="start_number" id="createStartNum" class="form-control-custom" value="000001" required>
                    </div>

                    <div class="form-group-field">
                        <label class="form-label-small">Número Final:</label>
                        <input type="text" name="end_number" id="createEndNum" class="form-control-custom" value="001000" required>
                    </div>

                    <div class="form-group-field">
                        <label class="form-label-small">Serie:</label>
                        <input type="text" name="series" class="form-control-custom" value="A" maxlength="10">
                    </div>

                    <div class="form-group-field">
                        <label class="form-label-small">Cantidad por Hoja:</label>
                        <select name="per_sheet" class="form-control-custom">
                            <option value="1">1 ticket por hoja</option>
                            <option value="2">2 tickets por hoja</option>
                            <option value="4">4 tickets por hoja</option>
                            <option value="6">6 tickets por hoja</option>
                            <option value="8">8 tickets por hoja (4 filas - Tamaño Grande)</option>
                            <option value="10" selected>10 tickets por hoja (Completa toda la hoja A4 - 5 filas)</option>
                        </select>
                    </div>

                    <div class="form-group-field">
                        <label class="form-label-small">Formato de Salida:</label>
                        <div class="radio-inline-group">
                            <label class="radio-item">
                                <input type="radio" name="format" value="pdf" checked>
                                <span>PDF para imprimir</span>
                            </label>
                            <label class="radio-item">
                                <input type="radio" name="format" value="word">
                                <span>Word editable (.docx)</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn-generate-submit" style="margin-top: 15px;">
                        <i class="fa-solid fa-rocket"></i> &nbsp;Generar Lote de Tickets
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const createStartNum = document.getElementById('createStartNum');
    if (createStartNum) {
        createStartNum.addEventListener('input', () => {
            const val = createStartNum.value ? String(createStartNum.value).padStart(6, '0') : '000001';
            document.querySelectorAll('.ticket-number-badge').forEach(b => b.textContent = 'N.º ' + val);
        });
    }
</script>
@endpush
