// resources/js/app.js
import './bootstrap';
import '@iconify/iconify';
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";

window.toastr = toastr;
// Optional Toastr settings
toastr.options = {
    closeButton: true,
    progressBar: true,
    positionClass: 'toast-bottom-center',
    timeOut: '2500',
};
// toastr.success('test message')

console.log('Hello Vite + Laravel!');