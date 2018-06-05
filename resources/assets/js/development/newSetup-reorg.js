/**
 * This runs the new setup app
 *
 *
 *
 * THIS DOES NOT WORK YET!!!
 *
 *
 *
 *
 *
 *
 * Created by adam on 2/15/17.
 */
require( './bootstrap' );

// import Vue from  'vue/dist/vue.js'
import Vue from 'vue'

// ES build is more efficient by reducing unneeded components with tree-shaking.
// (Needs Webpack 2 or Rollup)
// import BootstrapVue from 'bootstrap-vue/dist/bootstrap-vue.esm';
// Use commonjs version if es build is not working
import BootstrapVue from 'bootstrap-vue';
Vue.use( BootstrapVue );
// Vue.use( Sortable );

import AsyncComputed from 'vue-async-computed'
Vue.use( AsyncComputed )

import App from './new-setup.vue'

import listDropdown from './components/field.list-dropdown.component.vue'
Vue.component( 'list-dropdown', listDropdown );

import progressDashboard from './components/dashboard.progress.component.vue';
Vue.component( 'progress-dashboard', progressDashboard );

import toolsDashboard from './components/dashboard.tools.component.vue';
Vue.component( 'tools-dashboard', toolsDashboard );

//Panes (main container for edit tools)
// import editTabs from './components/navigation/item-card-navigation-tabs.vue'

//Panels (objects within pane)
// import panelComments from './components/panels/comment-setup-panel.vue'
// import panelExamDetail from './components/panels/exam-detail-panel.vue'
// import panelHistory from './components/panels/history-panel.vue'
// import panelNotes from './components/panels/notes-panel.vue'
// import panelItemDetail from './components/panels/item-detail-panel.vue'
// import panelStats from './components/panels/stats-panel.vue'
// import panelTags from './components/panels/tags-panel.vue'
// import panelStudents from './components/panels/students-panel.vue'
// import panelGrades from './components/panels/grades-panel.vue'

//Main editable objects
import examMain from './components/old/exam.main.component.vue';
Vue.component( 'exam-main', examMain );

import itemMain from './components/items/item-main.vue';
Vue.component( 'item-main', itemMain );


//Item card list
import cardList from './components/cards/old/cardList.component.vue';
Vue.component( 'card-list', cardList );

import itemAddButton from './components/input/buttons.item.add.component.vue';
Vue.component( 'item-add-button', itemAddButton );


//Item card and parts
import itemCard from './components/cards/item-card.vue';
Vue.component( 'item-card', itemCard );

import depthControl from './components/input/buttons.depth-control.component.vue';
Vue.component( 'depth-control', depthControl );

import maxScore from './components/input/max-score-input.vue';
Vue.component( 'max-score', maxScore );

import itemNumber from './components/field.item-number.component.vue';
Vue.component( 'item-number', itemNumber );

import itemName from './components/input/item-name-input.vue';
Vue.component( 'item-name', itemName );

//cards
import examCard from './components/cards/exam-card.vue'
Vue.component( 'exam-card', examCard );


//Items

import siblingAddButton from './components/items/add-sibling-button.vue'
Vue.component( 'add-sibling-button', siblingAddButton );

import childAddButton from './components/items/add-child-button.vue'
Vue.component( 'add-child-button', childAddButton );

import movementControl from './components/items/card-movement-control.vue';
Vue.component( 'card-movement-control', movementControl );


//Other buttons
import settingsButton from './components/input/settings-display-control.vue';
Vue.component( 'settings-button', settingsButton );

import valenceButton from './components/setup/comments/buttons.valence.component.vue';
Vue.component( 'valence-button', valenceButton );

import deleteButton from './components/input/item-delete-button.vue';
Vue.component( 'delete-item-button', deleteButton );

import removeButton from './components/items/item-remove-button.vue';
Vue.component( 'remove-item-button', removeButton );

import childrenDisplayButton from './components/input/children-display-control.vue';
Vue.component( 'children-display-control', childrenDisplayButton );

import publicIndicator from './components/input/visibility-control.vue';
Vue.component( 'public-indicator', publicIndicator );



//menus
import examList from './components/exams/existing-exams-list.vue'
Vue.component( 'existing-exams-menu', examList )

import itemList from './components/menus/existing-items-list.vue'
Vue.component( 'existing-items-menu', itemList )


//Server request handlers

import syncIndicator from './components/helpers/server-sync-indicator.vue';
Vue.component('sync-indicator', syncIndicator);

import api from '../api/old/controller';
Vue.component(api, api);

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ API ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

import VueAxios from 'vue-axios'
window.axios.defaults.baseURL = routeRoot;

// This wrapper bind axios to Vue or this if you're using single file component.
Vue.use( VueAxios, window.axios );


/* ~~~~~~~~~~~~~~~~~~~~~~~~ Globally register components ~~~~~~~~~~~~~~~~~~~~~~ */

//Register components globally
// Vue.component('exam-edit-pane', examEditPane);

// Vue.component( 'item-nav', itemNav )

// Vue.component('item-edit-pane', itemEditPane);


//
// //Panels
// Vue.component( 'panel-detail', panelItemDetail );
// Vue.component( 'panel-comments', panelComments );
// Vue.component( 'panel-history', panelHistory );
// Vue.component( 'panel-stats', panelStats );
// Vue.component( 'panel-notes', panelNotes );
// Vue.component('panel-tags', panelTags);
// Vue.component( 'edit-tabs', editTabs );
// Vue.component('panel-students', panelStudents);
// Vue.component('panel-grades', panelGrades);

// Vue.component( 'item-settings-comment-setup', commentSetup )




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
    routes // short for routes: routes
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