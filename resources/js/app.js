import './bootstrap';

import Alpine from 'alpinejs';

import jQuery from 'jquery';
window.$ = jQuery;
window.jQuery = jQuery;

import Swal from 'sweetalert2';
window.Swal = Swal;

window.Alpine = Alpine;
Alpine.start();
