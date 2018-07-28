/**
 * This runs the new setup app
 * Created by adam on 2/15/17.
 */
import Vue from 'vue'


import AsyncComputed from 'vue-async-computed'
Vue.use( AsyncComputed )


/* ~~~~~~~~~~~~~~~~~~~~~~~~ Global directives  ~~~~~~~~~~~~~~~~~~~~~~ */

// Register a global custom directive called `v-focus`
// which auto-focuses an element when the page loads.
// See: https://vuejs.org/v2/guide/custom-directive.html#Intro
Vue.directive('focus', {
    // When the bound element is inserted into the DOM...
    inserted: function (el) {
        // Focus the element
        el.focus()
    }
})



/* ~~~~~~~~~~~~~~~~~~~~~~~~ Globally registered components ~~~~~~~~~~~~~~~~~~~~~~ */

//Universal helpers
import infoButton from './components/helpers/info-button.vue';
Vue.component( 'info-button', infoButton );



/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ API ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

import VueAxios from 'vue-axios'

window.axios.defaults.baseURL = routeRoot;

// This wrapper bind axios to Vue or this if you're using single file component.
Vue.use( VueAxios, window.axios );



/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ ROUTER ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
import {VueRouter} from 'vue-router'
Vue.use( VueRouter );

// Define some routes
// Each route should map to a component. The "component" can
// either be an actual component constructor created via
// Vue.extend(), or just a component options object.
import { routes } from './routes';

// Create the router instance and pass the `routes` option
const router = new VueRouter( {
    routes, // short for routes: routes
    base: window.routeRoot
} );



/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ STORE ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
import {Vuex} from 'vuex'
Vue.use( Vuex );
import store from '../store';



/* ~~~~~~~~~~~~~~~~~~~~~~~ Create and mount the root instance ~~~~~~~~~~~~~~~~~~ */
import App from './new-setup.vue'

// Make sure to inject the router with the router option to make the
// whole app router-aware.
const app = new Vue( {
    store,

    router,

    render: h => h( App ),

    mounted: function () {
        console.log( 'newSetup ready');
    }

} ).$mount( "#app" );
