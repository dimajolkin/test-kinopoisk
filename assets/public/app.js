import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.css'
require('bootstrap-datepicker');

var $ = require('jquery');
$.fn.datepicker.defaults.format = "yyyy-mm-dd";

$(document).ready(() => {
    var getParameter = require('get-parameter');

    var date = $('#date');
    date.datepicker();
    date.datepicker('update', getParameter('date'));
    date.change(function() {

        location.href = '?date=' + $(this).val();
    });

});