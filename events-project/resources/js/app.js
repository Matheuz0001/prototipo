import './bootstrap';

import Alpine from 'alpinejs';
import flatpickr from 'flatpickr';
import { Portuguese } from 'flatpickr/dist/l10n/pt.js';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', function() {
    flatpickr(".flatpickr-datetime", {
        enableTime: true,
        dateFormat: "Y-m-d H:i", // Formato esperado pelo Laravel backend
        altInput: true, // Mostra um input secundário formatado
        altFormat: "d/m/Y H:i", // O formato visual amigável (PT-BR)
        time_24hr: true,
        locale: Portuguese, // Força o calendário em Português
        disableMobile: "true", // Força o uso da UI do Flatpickr no mobile
        allowInput: true // Permite que o usuário digite se preferir
    });
});
