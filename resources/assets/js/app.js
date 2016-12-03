
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: 'body'
});

$( document ).ready(function () {
    $('#serial_number').on('blur change input', function() {
        fetchSerialNumber($( this ));
    });
    $("input[name='inventory_status']").first().attr('checked', true);
});

/**
 * Fonction permettant de rechercher un numéro de série dans une balise
 * input.
 *
 * @param DocumentNode input_field Noeud HTML de type input.
 */
function fetchSerialNumber(input_field) {
        var patt = /F[0-9]{8}/;
        var serial_number = patt.exec("" + input_field.val());
        if (serial_number != null) {
            input_field.val(serial_number);
        }
}
