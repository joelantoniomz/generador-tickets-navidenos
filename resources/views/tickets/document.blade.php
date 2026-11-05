<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Tickets Navideños</title>
    @php
        $perSheet = max(1, (int) ($download->per_sheet ?? 10));
        $chunks = array_chunk($numbers, $perSheet);
        $fontFamily = $setting->font_family ?: 'Arial';
        $fontColor = $setting->font_color ?: '#123e76';
        $accentColor = preg_match('/^#[0-9a-fA-F]{6}$/', (string) $setting->accent_color) ? $setting->accent_color : '#0877f9';
        $ribbonText = $setting->ribbon_text ?: 'GRAN SORTEO NAVIDEÑO 2026';
        $thanksText = $setting->thanks_text ?: '¡Gracias por tu preferencia!';
        $dateText = $setting->show_draw_date
            ? 'Fecha del Sorteo: ' . ($setting->draw_date ? $setting->draw_date->format('d/m/Y') : '24/12/2026')
            : ($setting->date_replacement ?: '');
        $logoPath = $setting->logo_path ? public_path(ltrim($setting->logo_path, '/')) : public_path('images/laptop_logo_2x.png');
        $prizePath = $setting->prize_image_path ? public_path(ltrim($setting->prize_image_path, '/')) : public_path('images/canasta_sorteo_2x.png');
        $cornerLeftPath = public_path('images/festive_holly_corner.svg');
        $cornerRightPath = public_path('images/festive_holly_corner_right.svg');
        $scissorsPath = public_path('images/scissors_blue.png');
    @endphp
    <style>
        @page { size: A4 landscape; margin: 3mm; }
        * { box-sizing: border-box; }
        body { margin: 0; color: {{ $fontColor }}; font-family: '{{ $fontFamily }}', Arial, sans-serif; background: #fff; }
        .sheet { page-break-after: always; width: 100%; }
        .sheet:last-child { page-break-after: avoid; }
        .grid { width: 100%; border-collapse: separate; border-spacing: 1.5mm 1.5mm; table-layout: fixed; }
        .cell { width: 50%; padding: 0; vertical-align: top; border: 1px solid #174993; border-radius: 4px; overflow: hidden; }
        .ticket { width: 100%; border-collapse: collapse; table-layout: fixed; }
        .half { width: 48%; padding: 3mm 4mm 2.5mm; text-align: center; vertical-align: top; height: 31mm; position: relative; }
        .cut { width: 4%; border-left: 1px dashed #174993; border-right: 1px dashed #174993; text-align: center; vertical-align: middle; position: relative; }
        .cut-icon { display: block; width: 4mm; height: 4mm; margin: 0 auto; object-fit: contain; }
        .cut-dashes { height: 13mm; border-left: 1px dotted #174993; margin: 1mm auto 0; width: 0; }
        .brand { height: 9mm; text-align: center; color: #0754bb; font-weight: 900; font-size: 12px; line-height: 1; white-space: nowrap; }
        .brand img { width: 28px; height: 18px; object-fit: contain; vertical-align: middle; }
        .slogan { display: block; color: #173c82; font-size: 6.5px; margin-top: 1px; }
        .ribbon { margin: 1.5mm 0 1mm; padding: 1.45mm 1mm; background: {{ $accentColor }}; border-top: 1px solid #f8d323; border-bottom: 1px solid #f8d323; color: #fff; font-size: 9px; font-weight: 900; white-space: nowrap; overflow: hidden; }
        .number { display: block; width: 34mm; margin: 0 auto 1mm; padding: 1mm; border-radius: 4px; background: #123e76; color: #fff; font-size: 11px; font-weight: 900; }
        .copy { display: block; width: 29mm; margin: 0 auto 2mm; padding: .8mm; border-radius: 8px; background: #0875c9; color: #fff; font-size: 6.5px; font-weight: 900; }
        .fields { width: 95%; margin: 0 auto; border-collapse: collapse; text-align: left; }
        .fields td { padding: .8mm 0; font-size: 8px; font-weight: 800; white-space: nowrap; }
        .fields .line { width: 75%; border-bottom: 1px solid #122952; }
        .note { display: block; margin: 1.5mm auto 0; padding: .6mm 2mm; border: 1px dashed #8cb9ea; border-radius: 5px; color: #20518b; background: #eef6ff; font-size: 4.5px; }
        .prize { display: table; width: 90%; margin: 2mm auto 1mm; border-collapse: separate; border-spacing: 1mm; }
        .prize-img { display: table-cell; width: 13mm; height: 10mm; border: 1px solid #f2a900; vertical-align: middle; }
        .prize-img img { max-width: 12mm; max-height: 10mm; object-fit: contain; }
        .prize-box { display: table-cell; vertical-align: middle; border-radius: 5px; padding: 1.5mm; background: #e63129; color: #fff; font-size: 6px; font-weight: 900; }
        .prize-box strong { display: block; font-size: 7px; }
        .date { display: block; margin: 1mm auto 0; max-width: 90%; padding: 1mm 2mm; border: 1px solid #e53528; border-radius: 4px; color: #143870; font-size: 7px; font-weight: 900; }
        .thanks { margin-top: 1mm; color: #df3027; font-size: 9px; font-style: italic; font-weight: 900; }
        .corner-image { position: absolute; width: 6mm; height: 6mm; object-fit: contain; }
        .corner-image.top { top: 1mm; left: 1.5mm; }
        .corner-image.bottom { bottom: 1mm; right: 1.5mm; transform: rotate(180deg); }
    </style>
</head>
<body>
@foreach($chunks as $sheet)
    <div class="sheet">
        <table class="grid">
            @foreach(array_chunk($sheet, 2) as $row)
                <tr>
                @foreach($row as $number)
                    <td class="cell">
                        <table class="ticket"><tr>
                            <td class="half">
                                @if(file_exists($cornerLeftPath))<img class="corner-image top" src="{{ $cornerLeftPath }}">@endif
                                @if(file_exists($cornerRightPath))<img class="corner-image bottom" src="{{ $cornerRightPath }}">@endif
                                <div class="brand">@if(file_exists($logoPath))<img src="{{ $logoPath }}">@endif {{ strtoupper($setting->store_name) }}<span class="slogan">Tecnología a tu alcance</span></div>
                                <div class="ribbon">{{ $ribbonText }}</div>
                                <span class="number">N.º {{ str_pad($number, 6, '0', STR_PAD_LEFT) }}</span>
                                <span class="copy">COPIA DE LA TIENDA</span>
                                <table class="fields"><tr><td>Nombre:</td><td class="line"></td></tr><tr><td>DNI:</td><td class="line"></td></tr><tr><td>Celular:</td><td class="line"></td></tr></table>
                            </td>
                            <td class="cut">@if(file_exists($scissorsPath))<img class="cut-icon" src="{{ $scissorsPath }}">@endif<div class="cut-dashes"></div></td>
                            <td class="half">
                                @if(file_exists($cornerLeftPath))<img class="corner-image top" src="{{ $cornerLeftPath }}">@endif
                                @if(file_exists($cornerRightPath))<img class="corner-image bottom" src="{{ $cornerRightPath }}">@endif
                                <div class="brand">@if(file_exists($logoPath))<img src="{{ $logoPath }}">@endif {{ strtoupper($setting->store_name) }}<span class="slogan">Tecnología a tu alcance</span></div>
                                <div class="ribbon">{{ $ribbonText }}</div>
                                <span class="number">N.º {{ str_pad($number, 6, '0', STR_PAD_LEFT) }}</span>
                                <span class="copy">COPIA DEL CLIENTE</span>
                                <div class="prize"><div class="prize-img">@if(file_exists($prizePath))<img src="{{ $prizePath }}">@endif</div><div class="prize-box">PREMIO:<strong>{{ $setting->prize }}</strong></div></div>
                                @if($dateText)<span class="date">{{ $dateText }}</span>@endif
                                <div class="thanks">{{ $thanksText }}</div>
                            </td>
                        </tr></table>
                    </td>
                @endforeach
                @if(count($row) === 1)<td class="cell"></td>@endif
                </tr>
            @endforeach
        </table>
    </div>
@endforeach
</body>
</html>
