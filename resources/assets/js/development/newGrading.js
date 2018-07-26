/**
 * This runs the new setup app
 * Created by adam on 2/15/17.
 */
// require( './bootstrap' );

// import Vue from  'vue/dist/vue.js'
import Vue from 'vue'

import AsyncComputed from 'vue-async-computed'
Vue.use( AsyncComputed )

import App from '../development/components/grading/grading-page.vue'

//Navigation bars
// import examSelectionBar from './components/top-nav/exam-selection-bar.vue';
// Vue.component( 'exam-selection-bar', examSelectionBar );
// import bottomNavbar from '../development/components/bottom-nav/bottom-navbar.vue';
// Vue.component('bottom-navbar', bottomNavbar)

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ API ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
import VueAxios from 'vue-axios'
window.axios.defaults.baseURL = routeRoot;
// This wrapper bind axios to Vue or this if you're using single file component.
Vue.use( VueAxios, window.axios );


/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ ROUTER ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
// 0. If using a module system (e.g. via vue-cli), import Vue and VueRouter and then call Vue.use(VueRouter).
import VueRouter from 'vue-router'
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
import Vuex from 'vuex'
Vue.use( Vuex );
import store from '../store';


/* ~~~~~~~~~~~~~~~~~~~~~~~ Create and mount the root instance ~~~~~~~~~~~~~~~~~~ */
// Make sure to inject the router with the router option to make the
// whole app router-aware.
const app = new Vue( {
    store,

    router,

    render: h => h( App ),

    mounted: function () {
        console.log( 'newGrading ready');
    }

} ).$mount( "#app" );
