/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
import { TextController } from './controller/textController';
import { HttpServiceAyax } from './service/ajaxService';

require('../css/app.css');

require('@fortawesome/fontawesome-free/js/all.js');

const $ = require('jquery');

require('bootstrap');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});

$('#menu-toggle').click(function(e) {
    e.preventDefault();
    $('#wrapper').toggleClass('toggled');
});
// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// const $ = require('jquery');

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

window.addEventListener('load', event => {
    const pathName = window.location.pathname;
    if (pathName === '/text/') {
        const httpServiceAyax = new HttpServiceAyax();
        new TextController({ httpServiceAyax });
    }
});
