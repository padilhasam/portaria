import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import timeGridPlugin from '@fullcalendar/timegrid';
import bootstrap5Plugin from '@fullcalendar/bootstrap5';
import ptBrLocale from '@fullcalendar/core/locales/pt-br';

document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');

    if (calendarEl) {
        const calendar = new Calendar(calendarEl, {
            plugins: [ dayGridPlugin, interactionPlugin, timeGridPlugin ],
            initialView: 'dayGridMonth',
            locale: ptBrLocale,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: window.agendamentos ?? [],
            height: 800  // define altura fixa em pixels
        });

        calendar.render();
    }
});