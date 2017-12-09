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

import listDropdown from './components/field.list-dropdown.component.vue'
Vue.component( 'list-dropdown', listDropdown );

import progressDashboard from './components/dashboard.progress.component.vue'
Vue.component( 'progress-dashboard', progressDashboard );

import toolsDashboard from './components/dashboard.tools.component.vue'
Vue.component( 'tools-dashboard', toolsDashboard );


//Item card and parts
import depthControl from './components/input/buttons.depth-control.component.vue'
Vue.component( 'depth-control', depthControl );

import maxScore from './components/input/max-score-input.vue'
Vue.component( 'max-score', maxScore );

import itemNumber from './components/field.item-number.component.vue'
Vue.component( 'item-number', itemNumber );

import itemName from './components/input/item-name-input.vue'
Vue.component( 'item-name', itemName );

import siblingAddButton from './components/items/add-sibling-button.vue'
Vue.component( 'add-sibling-button', siblingAddButton );

import childAddButton from './components/items/add-child-button.vue'
Vue.component( 'add-child-button', childAddButton );

import itemAddButton from './components/input/buttons.item.add.component.vue'
Vue.component( 'item-add-button', itemAddButton );

import settingsButton from './components/input/settings-display-control.vue'
Vue.component( 'settings-button', settingsButton );

import childrenDisplayButton from './components/input/children-display-control.vue'
Vue.component( 'children-display-control', childrenDisplayButton )

import valenceButton from './components/panels/comment/valence-buttons.vue'
Vue.component( 'valence-button', valenceButton );

import deleteButton from './components/input/item-delete-button.vue'
Vue.component( 'delete-item-button', deleteButton );

import removeButton from './components/items/item-remove-button.vue'
Vue.component( 'remove-item-button', removeButton );

import publicIndicator from './components/input/visibility-control.vue'
Vue.component( 'public-indicator', publicIndicator );


//Cards
import itemCard from './components/cards/item-card.vue'
Vue.component( 'item-card', itemCard );

import examCard from './components/cards/exam-card.vue'
Vue.component( 'exam-card', examCard );


//menus
import examSelectionBar from './components/exams/exam-selection-bar.vue';
Vue.component( 'exam-selection-bar', examSelectionBar );

import examList from './components/exams/existing-exams-list.vue'
Vue.component( 'existing-exams-menu', examList )

import itemList from './components/items/existing-items-list.vue'
Vue.component( 'existing-items-menu', itemList )

//Server request handlers
import api from '../api/old/controller'
Vue.component( 'api', api );


//Tags
import tagDisplay from './components/panels/tag/tag-display.vue';
Vue.component( 'tag-display', tagDisplay );

//Helpers
import infoButton from './components/helpers/info-button.vue';
Vue.component( 'info-button', infoButton );

import syncIndicator from './components/helpers/server-sync-indicator.vue';
Vue.component( 'sync-indicator', syncIndicator );




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
