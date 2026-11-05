@extends('layouts.app')

@section('content')
<div class="full-page">
    <div class="card-title"><div><small>PERSONALIZA TU PLANTILLA</small><h2>Diseño de Plantilla</h2></div><a class="btn primary" href="{{ route('tickets.create') }}">Ir a Generar Tickets</a></div>
    <div class="hero-grid">
        <div class="panel preview-panel"><div class="panel-head"><h2>◉ &nbsp;Vista previa del ticket</h2><button class="head-btn green" type="button" onclick="window.print()">▣ Imprimir vista</button></div><div class="panel-body"><div class="ticket-stage"><div class="ticket"><div class="ticket-half store"><div class="ticket-brand" id="brand-store">💻 &nbsp;{{ strtoupper($setting->store_name) }}</div><div class="ticket-ribbon">GRAN SORTEO NAVIDEÑO 2026</div><span class="ticket-number">N.º 000125</span><span class="copy-label">COPIA DE LA TIENDA</span><p>Nombre: __________________________</p><p>DNI: ______________________________</p><p>Celular: ___________________________</p></div><div class="ticket-cut">✂<br>⋮<br>⋮<br>⋮</div><div class="ticket-half client"><div class="ticket-brand" id="brand-client">💻 &nbsp;{{ strtoupper($setting->store_name) }}</div><div class="ticket-ribbon">GRAN SORTEO NAVIDEÑO 2026</div><span class="ticket-number">N.º 000125</span><span class="copy-label">COPIA DEL CLIENTE</span><div class="prize-box" id="brand-prize">🎁 Premio:<br>{{ $setting->prize }}</div><div class="draw-date" id="brand-date">Fecha del Sorteo: {{ $setting->draw_date->format('d/m/Y') }}</div><div class="thanks">¡Gracias por tu preferencia!</div></div></div></div></div></div>
        <div class="panel"><div class="panel-head"><h2>🎨 &nbsp;Diseñador de Plantilla</h2><button class="head-btn green" type="button">▣ Guardar Diseño</button></div><div class="designer"><div class="designer-nav"><button class="active" type="button">⚙ General</button><button type="button">● Colores</button><button type="button">▧ Imágenes</button><button type="button">Aa Textos</button><button type="button">★ Estilos</button></div><div class="designer-form"><h3>Información del sorteo</h3><div class="field"><label>Nombre de la tienda</label><input id="design-store" value="{{ $setting->store_name }}"></div><div class="field"><label>Slogan</label><input value="Tecnología a tu alcance"></div><div class="field"><label>Premio principal</label><input id="design-prize" value="{{ $setting->prize }}"></div><div class="field"><label>Fecha del sorteo</label><input id="design-date" type="date" value="{{ $setting->draw_date->format('Y-m-d') }}"></div><div class="info">Vista previa en tiempo real. Para guardar los datos permanentes usa Configuración.</div></div></div></div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const store=document.getElementById('design-store'), prize=document.getElementById('design-prize'), date=document.getElementById('design-date');
store?.addEventListener('input',()=>document.querySelectorAll('#brand-store,#brand-client').forEach(e=>e.innerHTML='💻 &nbsp;'+store.value.toUpperCase()));
prize?.addEventListener('input',()=>document.getElementById('brand-prize').innerHTML='🎁 Premio:<br>'+prize.value);
date?.addEventListener('input',()=>{if(!date.value)return;const d=new Date(date.value+'T00:00:00');document.getElementById('brand-date').textContent='Fecha del Sorteo: '+String(d.getDate()).padStart(2,'0')+'/'+String(d.getMonth()+1).padStart(2,'0')+'/'+d.getFullYear();});
</script>
@endpush
