/**
 * This runs the new setup app
 * Created by adam on 2/15/17.
 */
// require( './bootstrap' );

// import Vue from  'vue/dist/vue.js'
import Vue from 'vue'

// ES build is more efficient by reducing unneeded components with tree-shaking.
// (Needs Webpack 2 or Rollup)
// import BootstrapVue from 'bootstrap-vue/dist/bootstrap-vue.esm';
// Use commonjs version if es build is not working
// import BootstrapVue from 'bootstrap-vue';
// Vue.use( BootstrapVue );
// Vue.use( Sortable );

import AsyncComputed from 'vue-async-computed'
Vue.use( AsyncComputed )

import App from './new-setup.vue'

/* ~~~~~~~~~~~~~~~~~~~~~~~~ Globally register components ~~~~~~~~~~~~~~~~~~~~~~ */


import toolsDashboard from './components/dashboard.tools.component.vue'
Vue.component( 'tools-dashboard', toolsDashboard );


//Item card and parts
// import depthControl from './components/input/buttons.depth-control.component.vue'
// Vue.component( 'depth-control', depthControl );

// import maxScore from './components/input/max-score-input.vue'
// Vue.component( 'max-score', maxScore );

import itemNumber from './components/field.item-number.component.vue'
Vue.component( 'item-number', itemNumber );
//
// import itemAddButton from './components/input/new-item-button.vue'
// Vue.component( 'item-add-button', itemAddButton );

import valenceButton from './components/setup/comment/valence-buttons.vue'
Vue.component( 'valence-button', valenceButton );

import deleteButton from './components/input/item-delete-button.vue'
Vue.component( 'delete-item-button', deleteButton );

import removeButton from './components/items/item-remove-button.vue'
Vue.component( 'remove-item-button', removeButton );


//Cards
import itemCard from './components/cards/item-card.vue'
Vue.component( 'item-card', itemCard );


// //lists
// import examList from './components/menus/existing-exams-list.vue'
// Vue.component( 'existing-exams-menu', examList )
//
// import itemList from './components/menus/existing-items-list.vue'
// Vue.component( 'existing-items-menu', itemList )


//Tags
import tagDisplay from './components/setup/tag/tag-display.vue';
Vue.component( 'tag-display', tagDisplay );

//Universal helpers
import infoButton from './components/helpers/info-button.vue';
Vue.component( 'info-button', infoButton );



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
        console.log( 'newSetup ready');
    }

} ).$mount( "#app" );
