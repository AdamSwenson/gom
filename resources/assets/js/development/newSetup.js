/**
 * This runs the new setup app
 * Created by adam on 2/15/17.
 */


//require the file which contains all dependencies etc
require( './bootstrap' );

import 'babel-polyfill'

import Vue from  'vue/dist/vue.js'
// import Vue from 'vue'
import App from './new-setup.vue'
import store from '../store'

new Vue( {
    store,
    render: h => h( App ),

    mounted: function () {
        console.log( 'newSetup ready', this );
    }

} ).$mount( "#app" );
