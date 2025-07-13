import 'bootstrap/dist/css/bootstrap.min.css';

// Importar toastr e atribuir ao global
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

window.toastr = toastr; // Torna acessível globalmente (opcional)

// Importar jQuery e atribuir ao global
import $ from 'jquery';
window.$ = $;
window.jQuery = $;

// Importar bootstrap.js (o JS do bootstrap que depende de jQuery)
import 'bootstrap';

// Seus scripts personalizados
import 'egalink-toasty.js';
import './alerts';
import './button.js'
import './calendar.js';
import './exportarPDF.js';
import './grafico-registros.js';
import './grafico-relatorios.js';
import './loader.js';
import './mascara.js';
import './preencher_campos.js';
import './registro.js';
import './tom-select-init';
import './validarCPF';
import './view-dados';
import './dselect';
import './placa.js';
