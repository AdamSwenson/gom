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

import listDropdown from './components/field.list-dropdown.component.vue'

Vue.component( 'list-dropdown', listDropdown );

import progressDashboard from './components/dashboard.progress.component.vue'

Vue.component( 'progress-dashboard', progressDashboard );

import toolsDashboard from './components/dashboard.tools.component.vue'

Vue.component( 'tools-dashboard', toolsDashboard );


//Item card and parts
import depthControl from './components/input/buttons.depth-control.component.vue'
import maxScore from './components/input/max-score-input.vue'
import itemNumber from './components/field.item-number.component.vue'
import itemName from './components/input/item-name-input.vue'
import siblingAddButton from './components/items/add-sibling-button.vue'
import childAddButton from './components/items/add-child-button.vue'

import itemAddButton from './components/input/buttons.item.add.component.vue'


//Other buttons
import settingsButton from './components/input/settings-display-control.vue'
import childrenDisplayButton from './components/input/children-display-control.vue'
import valenceButton from './components/input/buttons.valence.component.vue'
import deleteButton from './components/input/item-delete-button.vue'
import removeButton from './components/items/item-remove-button.vue'

import publicIndicator from './components/input/visibility-control.vue'

// import subList from './components/cards/subList.component.vue'

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
import syncIndicator from './components/helpers/server-sync-indicator.vue';

//tags
import tagDisplay from './components/panels/tag/tag-display.vue';

//helpers
import infoButton from './components/helpers/info-button.vue';


/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ API ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

import VueAxios from 'vue-axios'

window.axios.defaults.baseURL = routeRoot;

// This wrapper bind axios to Vue or this if you're using single file component.
Vue.use( VueAxios, window.axios );


/* ~~~~~~~~~~~~~~~~~~~~~~~~ Globally register components ~~~~~~~~~~~~~~~~~~~~~~ */
Vue.component( 'api', api );
Vue.component( 'sync-indicator', syncIndicator );

//Register components globally
// Vue.component( 'exam-main', examMain );
// Vue.component('exam-edit-pane', examEditPane);


// Vue.component( 'item-nav', itemNav )
Vue.component( 'item-add-button', itemAddButton );
Vue.component( 'item-name', itemName );
// Vue.component( 'item-main', itemMain );
Vue.component( 'public-indicator', publicIndicator );
Vue.component( 'settings-button', settingsButton );

// Vue.component('item-edit-pane', itemEditPane);

//cards
// Vue.component( 'card-list', cardList );
// Vue.component( 'sub-list', subList );


// Vue.component( 'item-settings-comment-setup', commentSetup )
Vue.component( 'valence-button', valenceButton );
Vue.component( 'delete-item-button', deleteButton );

Vue.component( 'remove-item-button', removeButton );
Vue.component( 'depth-control', depthControl );

Vue.component( 'max-score', maxScore );
Vue.component( 'item-number', itemNumber );


//Items
Vue.component( 'add-sibling-button', siblingAddButton );
Vue.component( 'add-child-button', childAddButton );
Vue.component( 'children-display-control', childrenDisplayButton )


//Tags
Vue.component( 'tag-display', tagDisplay );

//Helpers
Vue.component( 'info-button', infoButton );

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ ROUTER ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
// 0. If using a module system (e.g. via vue-cli), import Vue and VueRouter and then call Vue.use(VueRouter).
import VueRouter from 'vue-router'

Vue.use( VueRouter );
// 1. Define route components.
// These can be imported from other files

// 2. Define some routes
// Each route should map to a component. The "component" can
// either be an actual component constructor created via
// Vue.extend(), or just a component options object.
// We'll talk about nested routes later.
import { routes } from './routes';

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = new VueRouter( {
    routes, // short for routes: routes
    base: window.routeRoot
} );


import Vuex from 'vuex'

Vue.use( Vuex );

import store from '../store';
// import vuexStore from '../store/index'
window.console.log( 'new-setup ***', 'store', 116, store );

// const store = new Vuex.Store(vuexStore);

// 4. Create and mount the root instance.
// Make sure to inject the router with the router option to make the
// whole app router-aware.
const app = new Vue( {
    store,

    router,

    render: h => h( App ),

    mounted: function () {
        console.log( 'newSetup ready', this );
    }

} ).$mount( "#app" );

// Now the app has started!