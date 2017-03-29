/**
 * This runs the new setup app
 * Created by adam on 2/15/17.
 */


//require the file which contains all dependencies etc
require('./bootstrap');

import 'babel-polyfill'

import Vue from  'vue/dist/vue.js'
// import Vue from 'vue'


// ES build is more efficient by reducing unneeded components with tree-shaking.
// (Needs Webpack 2 or Rollup)
// import BootstrapVue from 'bootstrap-vue/dist/bootstrap-vue.esm';
// Use commonjs version if es build is not working
import BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue);


import App from './new-setup.vue'

// ------------------------------- Globally register components
import listDropdown from './components/field.list-dropdown.component.vue'

import propsDashboard from './components/dashboard.props.component.vue'
import toolsDashboard from './components/dashboard.tools.component.vue'

//Panes (main container for edit tools)
import examEditPane from './components/pane.edit-exam.component.vue'
import itemEditPane from './components/pane.edit-item.component.vue'

//Panels (objects within pane)
import panelComments from './components/panel.comment-setup.component.vue'
import panelExamDetail from './components/panel.exam-detail.component.vue'
import panelHistory from './components/panel.history.component.vue'
import panelNotes from './components/panel.notes.component.vue'
import panelItemDetail from './components/panel.item-detail.component.vue'
import panelStats from './components/panel.stats.component.vue'

//Main editable objects
import examMain from './components/exam.main.component.vue'
import itemMain from './components/item.main.component.vue'

//Item card list
import cardList from './components/itemCards.list.component.vue'
import itemAddButton from './components/buttons.item.add.component.vue'

//Item card and parts
import itemCard from './components/itemCards.card.component.vue'
import depthControl from './components/buttons.depth-control.component.vue'
import maxScore from './components/field.max-score.component.vue'
import itemNumber from './components/field.item-number.component.vue'
import itemName from './components/field.item-name.component.vue'

//Other buttons
import settingsButton from './components/buttons.settings-control.component.vue'
import valenceButton from './components/buttons.valence.component.vue'
import deleteButton from './components/buttons.item.delete.component.vue'
import publicIndicator from './components/buttons.public-control.component.vue'


//Register components globally
Vue.component('exam-main', examMain)
Vue.component('exam-edit-pane', examEditPane)

Vue.component('props-dashboard', propsDashboard)
Vue.component('tools-dashboard', toolsDashboard)
// Vue.component( 'item-nav', itemNav )
Vue.component('item-add-button', itemAddButton)
Vue.component('item-name', itemName)
Vue.component('item-main', itemMain)
Vue.component('public-indicator', publicIndicator)
Vue.component('settings-button', settingsButton)
Vue.component('item-edit-pane', itemEditPane)
Vue.component('item-card', itemCard)
Vue.component('card-list', cardList)

//Panels
Vue.component('panel-detail', panelItemDetail)
// Vue.component('panel-comments', panelComments)
Vue.component('panel-history', panelHistory)
Vue.component('panel-stats', panelStats)
Vue.component('panel-notes', panelNotes)

// Vue.component( 'item-settings-comment-setup', commentSetup )
Vue.component('valence-button', valenceButton)
Vue.component('delete-item-button', deleteButton)
Vue.component('depth-control', depthControl)

Vue.component('max-score', maxScore)
Vue.component('item-number', itemNumber)

Vue.component('list-dropdown', listDropdown)


// 0. If using a module system (e.g. via vue-cli), import Vue and VueRouter and then call Vue.use(VueRouter).
import VueRouter from 'vue-router'
Vue.use(VueRouter);
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
        components: {itemPanels: panelComments},
        props: true, //{default: true}
    }
    , //props: (route) => {return route.index;}},
    {path: '/panel-exam-detail/:index', components: {examPanels: panelExamDetail}, props: true},
    {path: '/panel-history/:index', components: {itemPanels: panelHistory}, props: true},
    {path: '/panel-item-detail/:index', components: {itemPanels: panelItemDetail}, props: true},
    {path: '/panel-notes/:index', components: {itemPanels: panelNotes}, props: true},
    {path: '/panel-stats/:index', components: {itemPanels: panelStats}, props: true}
];

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = new VueRouter({
    routes // short for routes: routes
});


// 4. Create and mount the root instance.
// Make sure to inject the router with the router option to make the
// whole app router-aware.
const app = new Vue({
    // store,

    router,

    render: h => h(App),

    mounted: function () {
        console.log('newSetup ready', this);
    }

}).$mount("#app");

// Now the app has started!