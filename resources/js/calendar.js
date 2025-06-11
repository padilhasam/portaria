import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import timeGridPlugin from '@fullcalendar/timegrid';
import bootstrap5Plugin from '@fullcalendar/bootstrap5';
import ptBrLocale from '@fullcalendar/core/locales/pt-br';

document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;

    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, interactionPlugin, timeGridPlugin, bootstrap5Plugin],
        initialView: 'dayGridMonth',
        locale: ptBrLocale,
        themeSystem: 'bootstrap',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: window.agendamentos ?? [],
        height: 'auto',

        eventClick: function(info) {
            // Preenche os campos do modal
            document.getElementById('modalMorador').textContent = info.event.extendedProps.morador || 'Não informado';
            document.getElementById('modalArea').textContent = info.event.extendedProps.area || 'Não informado';
            document.getElementById('modalInicio').textContent = info.event.extendedProps.horario_inicio || '';
            document.getElementById('modalFim').textContent = info.event.extendedProps.horario_fim || '';
            document.getElementById('modalObs').textContent = info.event.extendedProps.observacoes || 'Nenhuma observação';
            document.getElementById('modalLinkEditar').href = info.event.url || '#';

            // Exibe o modal Bootstrap
            const eventoModal = new bootstrap.Modal(document.getElementById('eventoModal'));
            eventoModal.show();

            // Impede o redirecionamento padrão
            info.jsEvent.preventDefault();
        }
    });

    calendar.render();
});