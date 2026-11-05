document.addEventListener('DOMContentLoaded', function () {
    const button = document.querySelector('#save-design');
    if (!button) return;
    button.addEventListener('click', function () {
        window.setTimeout(async function () {
            const q = (s) => document.querySelector(s);
            const token = q('input[name="_token"]')?.value;
            const data = {
                _token: token,
                store_name: q('[name="designer_store"]')?.value || '',
                prize: q('[name="designer_prize"]')?.value || '',
                draw_date: q('[name="designer_date"]')?.value || '',
                minimum_purchase: '50',
                accent_color: getComputedStyle(document.documentElement).getPropertyValue('--blue').trim() || '#0877f9',
                show_draw_date: q('#designer-show-date')?.checked ? '1' : '0',
                date_replacement: q('#designer-date-replacement')?.value || '',
                font_family: q('#designer-font')?.value || 'Arial',
                font_color: q('#designer-font-color')?.value || '#123e76',
                font_size: q('#designer-font-size')?.value || 'normal',
                ribbon_text: q('#designer-ribbon')?.value || 'GRAN SORTEO NAVIDEÑO 2026',
                thanks_text: q('#designer-thanks')?.value || '¡Gracias por tu preferencia!'
            };
            try {
                await fetch('/configuracion/ajax', { method: 'POST', headers: {'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': token}, body: JSON.stringify(data) });
            } catch (_) {}
        }, 120);
    });
});
