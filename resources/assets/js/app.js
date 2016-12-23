
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import OrderElementsList from './components/OrderElementsList';
import OrderElement from './components/OrderElement';

var Bloodhound = require('typeahead.js');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

// Vue.component('example', require('./components/Example.vue'));
//
// const app = new Vue({
//     el: 'body'
// });

$( document ).ready(function () {
    if (window.innerWidth > 772) {
        $('.dropdown-toggle').addClass('disabled');
    }
    $('#serial_number').on('blur change input', function() {
        fetchSerialNumber($( this ));
    });
    $("input[name='inventory_status']").first().attr('checked', true);
    $('.clickable-row').on('click', function () {
        window.location = $('a', this)[0].href;
    });

    var bloodhoundSuggestions;
    var countriesInput = $('#countriesInput');
    var customerCountry = $('#customerCountry');
    if (customerCountry.length) {
        customerCountry = $('#customerCountry')[0].value;
    }

    $.ajax({
        url: "http://lenspector.localhost/api/countries",
        success: function(result){
            bloodhoundSuggestions = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                sufficient: 3,
                local: $.map(result.countries, function(c) {
                    return { value: c.name };
                })
            });
            countriesInput.typeahead({
                hint: true,
                highlight: true,
                minLength: 1
                },
                {
                name: 'suggestions',
                displayKey: 'value',
                source: bloodhoundSuggestions
            });
            if (customerCountry.length) {
                countriesInput.typeahead('val', customerCountry);
            }
        }
    });
    $(".tt-dataset-suggestions").css("width", countriesInput.css('width'));
    window.onresize = function(event) {
        $(".tt-dataset-suggestions").css("width", countriesInput.css('width'));
    };
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
