/**
 * This runs the new setup app
 * Created by adam on 2/15/17.
 */

window.$ = window.jQuery = require('jquery');
window.Laravel = { csrfToken: $('meta[name=csrf-token]').attr("content") };

//require the file which contains all dependencies etc
require('./bootstrap');

import 'babel-polyfill'

import Vue from 'vue'
import App from './new-setup.vue'

new Vue( {
    el: '#app',

    store,

   render: h => h( App ),

    mounted: function () {
        console.log( 'newSetup ready', this );
    },
} )
