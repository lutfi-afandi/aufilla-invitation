import './bootstrap';

import Alpine from 'alpinejs';
import Swal from 'sweetalert2';

if (!window.Swal) {
    window.Swal = Swal;
}

window.Alpine = Alpine;
Alpine.start();
