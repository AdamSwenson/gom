/**
 * This runs the new setup app
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

import App from './new-setup.vue'

import listDropdown from './components/field.list-dropdown.component.vue'

import progressDashboard from './components/dashboard.progress.component.vue'
import toolsDashboard from './components/dashboard.tools.component.vue'

//Panes (main container for edit tools)
import itemEditPane from './components/pane.edit-item.component.vue'
import editTabs from './components/nav.edit-tabs.component.vue'

//Panels (objects within pane)
import panelComments from './components/panel.comment-setup.component.vue'
import panelExamDetail from './components/panel.exam-detail.component.vue'
import panelHistory from './components/panel.history.component.vue'
import panelNotes from './components/panel.notes.component.vue'
import panelItemDetail from './components/panel.item-detail.component.vue'
import panelStats from './components/panel.stats.component.vue'
import panelTags from './components/panel.tags.component.vue'


//Main editable objects
import examMain from './components/exam.main.component.vue'
import itemMain from './components/item.main.component.vue'

//Item card list
import cardList from './components/cards/cardList.component.vue'
import itemAddButton from './components/input/buttons.item.add.component.vue'

//Item card and parts
import itemCard from './components/cards/itemCard.component.vue'
import depthControl from './components/input/buttons.depth-control.component.vue'
import maxScore from './components/field.max-score.component.vue'
import itemNumber from './components/field.item-number.component.vue'
import itemName from './components/field.item-name.component.vue'
import siblingAddButton from './components/input/buttons.add-sibling.component.vue'
import childAddButton from './components/input/buttons.add-child.component.vue'



//Other buttons
import settingsButton from './components/input/buttons.settings-control.component.vue'
import valenceButton from './components/input/buttons.valence.component.vue'
import deleteButton from './components/input/buttons.item.delete.component.vue'
import publicIndicator from './components/input/buttons.public-control.component.vue'

import subList from './components/cards/subList.component.vue'
import examCard from './components/cards/examCard.component.vue'

//Server request handlers
import api from '../api/controller'

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ API ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

import VueAxios from 'vue-axios'
window.axios.defaults.baseURL = routeRoot;

// This wrapper bind axios to Vue or this if you're using single file component.
Vue.use( VueAxios, window.axios );


/* ~~~~~~~~~~~~~~~~~~~~~~~~ Globally register components ~~~~~~~~~~~~~~~~~~~~~~ */
Vue.component( 'api', api );

//Register components globally
Vue.component( 'exam-main', examMain );
// Vue.component('exam-edit-pane', examEditPane);

Vue.component( 'progress-dashboard', progressDashboard );
Vue.component( 'tools-dashboard', toolsDashboard );
// Vue.component( 'item-nav', itemNav )
Vue.component( 'item-add-button', itemAddButton );
Vue.component( 'item-name', itemName );
Vue.component( 'item-main', itemMain );
Vue.component( 'public-indicator', publicIndicator );
Vue.component( 'settings-button', settingsButton );

// Vue.component('item-edit-pane', itemEditPane);

//cards
Vue.component( 'card-list', cardList );
Vue.component( 'item-card', itemCard );
Vue.component( 'exam-card', examCard );
Vue.component( 'sub-list', subList );


//Panels
Vue.component( 'panel-detail', panelItemDetail );
Vue.component( 'panel-comments', panelComments );
Vue.component( 'panel-history', panelHistory );
Vue.component( 'panel-stats', panelStats );
Vue.component( 'panel-notes', panelNotes );
Vue.component('panel-tags', panelTags);
Vue.component( 'edit-tabs', editTabs );

// Vue.component( 'item-settings-comment-setup', commentSetup )
Vue.component( 'valence-button', valenceButton );
Vue.component( 'delete-item-button', deleteButton );
Vue.component( 'depth-control', depthControl );

Vue.component( 'max-score', maxScore );
Vue.component( 'item-number', itemNumber );

Vue.component( 'list-dropdown', listDropdown );

//Items
Vue.component('add-sibling-button', siblingAddButton);
Vue.component('add-child-button', childAddButton);

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
const routes = [
    {
        name: 'comments',
        path: '/panel-comments/:index',
        components: { itemPanels: panelComments },
        props: true, //{default: true}
    }
    , //props: (route) => {return route.index;}},
    {
        name: 'exam-detail',
        path: '/panel-exam-detail/:index',
        components: { examPanels: panelExamDetail },
        props: true
    },
    {
        path: '/panel-history/:index',
        components: { itemPanels: panelHistory },
        props: true
    },
    {
        name: 'item-detail',
        path: '/panel-item-detail/:index',
        components: { itemPanels: panelItemDetail },
        props: true
    },
    {
        path: '/panel-notes/:index',
        components: { itemPanels: panelNotes },
        props: true
    },
    {
        path: '/panel-stats/:index',
        components: { itemPanels: panelStats },
        props: true
    },
    {
        path: '/panel-tags/:index',
        components: { itemPanels: panelTags},
        props: true
    }
];

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = new VueRouter( {
    routes // short for routes: routes
} );


// import { routes } from './router-config';
//

import Vuex from 'vuex'
Vue.use(Vuex);

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

        console.log('newSetup ready', this);
    }

} ).$mount( "#app" );

// Now the app has started!