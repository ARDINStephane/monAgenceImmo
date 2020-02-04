const $ = require('jquery');
require('../css/app.css');
require('select2');

let $contactButton = $('#contactButton');
$contactButton.click(e => {
    console.log('clic');
    e.preventDefault();
    $('#contactForm').slideDown();
    $contactButton.slideUp();
})

$('select').select2();

