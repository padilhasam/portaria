import 'bootstrap/dist/css/bootstrap.min.css';

// Importar jQuery e atribuir ao global
import $ from 'jquery';
window.$ = $;
window.jQuery = $;

// Importar bootstrap.js (o JS do bootstrap que depende de jQuery)
import 'bootstrap';

// Seus scripts personalizados
import './loader';
import 'egalink-toasty.js';
import './alerts';
import './grafico-acessos';
import './mascara';
import './preencher_campos';
import './registro';
import './tom-select-init';
import './validarCPF';
import './view-morador';