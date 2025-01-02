import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';
import Flash from "./elements/flash.js";

customElements.define('app-flash', Flash)

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
