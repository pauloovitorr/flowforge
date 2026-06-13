import $ from 'jquery';
window.$ = window.jQuery = $;



import select2 from 'select2';
import 'select2/dist/css/select2.min.css';

select2($);

import Swal from 'sweetalert2';
window.Swal = Swal;

import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';