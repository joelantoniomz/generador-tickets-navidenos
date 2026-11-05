@extends('layouts.app')

@section('content')
<div class="card form-card">
    <small>DATOS DEL SORTEO</small>
    <h2>Configuración</h2>
    <form method="post" action="{{ route('settings.update') }}">
        @csrf @method('PUT')
        <label>Nombre de tienda<input name="store_name" value="{{ old('store_name', $setting->store_name) }}" required></label>
        <label>Compra mínima (S/)<input type="number" step="0.01" name="minimum_purchase" value="{{ $setting->minimum_purchase }}" required></label>
        <label>Premio<input name="prize" value="{{ $setting->prize }}" required></label>
        <label class="switch-line"><input type="checkbox" name="show_draw_date" value="1" {{ $setting->show_draw_date ? 'checked' : '' }}> Mostrar fecha del sorteo en el ticket</label>
        <label>Fecha del sorteo<input type="date" name="draw_date" value="{{ $setting->draw_date->format('Y-m-d') }}" required></label>
        <label>Texto alternativo si la fecha está desactivada<input name="date_replacement" value="{{ old('date_replacement', $setting->date_replacement) }}" placeholder="Ej.: Válido durante noviembre y diciembre"></label>
        <label>Color de acento<input type="color" name="accent_color" value="{{ $setting->accent_color }}" required></label>
        <button class="btn primary">Guardar cambios</button>
    </form>
</div>
@endsection
