import 'bootstrap/dist/css/bootstrap.min.css';

// Importar jQuery e atribuir ao global
import $ from 'jquery';
window.$ = $;
window.jQuery = $;

// Importar bootstrap.js (o JS do bootstrap que depende de jQuery)
import 'bootstrap';

// Seus scripts personalizados
import 'egalink-toasty.js';
import './alerts';
import './exportarPDF';
import './grafico-registros';
import './grafico-relatorios';
import './loader';
import './mascara';
import './preencher_campos';
import './registro';
import './tom-select-init';
import './validarCPF';
import './view-morador';
import './dselect';