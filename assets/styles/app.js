/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './app.css';
import './css/bootstrap.min.css';
import './css/mdb.min.css';
import './css/style.min.css';
import '@fortawesome/fontawesome-free/js/fontawesome';
import '@fortawesome/fontawesome-free/js/solid';
import '@fortawesome/fontawesome-free/js/regular';
import '@fortawesome/fontawesome-free/js/brands';




// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.


window.jQuery = window.$ = require("jquery");


const jquery = require('./js/jquery-3.4.1.min.js');
const popper = require('./js/popper.min.js');
const bootstrap = require('./js/bootstrap.min.js');



console.log('Hello Webpack Encore! Edit me in assets/app.js');
