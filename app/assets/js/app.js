/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
import { TextController } from './controller/textController';
import { HttpServiceAyax } from './service/ajaxService';

import { GeneralController } from './controller/generalController';

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

const pathName = window.location.pathname;

console.log(pathName);

window.addEventListener('load', event => {
    const pathName = window.location.pathname;
    const httpServiceAyax = new HttpServiceAyax();

    if (pathName === '/admin/text/') {
        new TextController({ httpServiceAyax });
    }

    if (pathName === '/') {
        console.log('cargo controlador inicial');

        const prev = window.document.getElementById('prev');
        const next = window.document.getElementById('next');

        let slideIndex = 1;

        const showSlides = function(n) {
            const slides = document.getElementsByClassName('mySlides');
            if (n > slides.length) {
                slideIndex = 1;
            }
            if (n < 1) {
                slideIndex = slides.length;
            }
            for (let i = 0; i < slides.length; i++) {
                slides[i].style.display = 'none';
            }
            slides[slideIndex - 1].style.display = 'flex';
        };

        showSlides(slideIndex);

        next.addEventListener('click', () => {
            showSlides((slideIndex += 1));
        });

        prev.addEventListener('click', () => {
            showSlides((slideIndex += -1));
        });
    }

    if (pathName !== '/' && pathName !== '/admin/text/') {
        new GeneralController({ httpServiceAyax });
    }
});
