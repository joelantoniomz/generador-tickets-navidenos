document.addEventListener('DOMContentLoaded', function () {
    const box = document.querySelector('#live-date-box');
    const show = document.querySelector('#designer-show-date');
    const replacement = document.querySelector('#designer-date-replacement');
    const date = document.querySelector('[name="designer_date"]');
    if (!box || !show || !replacement) return;

    function render() {
        if (show.checked) {
            const value = date && date.value ? new Date(date.value + 'T00:00:00') : null;
            const text = value && !Number.isNaN(value.getTime())
                ? String(value.getDate()).padStart(2, '0') + '/' + String(value.getMonth() + 1).padStart(2, '0') + '/' + value.getFullYear()
                : '24/12/2026';
            box.innerHTML = 'Fecha del Sorteo: <b class="live-date">' + text + '</b>';
            replacement.disabled = true;
        } else {
            box.textContent = replacement.value.trim() || 'Texto alternativo del sorteo';
            replacement.disabled = false;
        }
        box.hidden = false;
    }

    show.addEventListener('change', render);
    replacement.addEventListener('input', render);
    date?.addEventListener('change', render);
    render();
});
