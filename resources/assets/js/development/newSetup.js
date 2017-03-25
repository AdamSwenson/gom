/**
 * This runs the new setup app
 * Created by adam on 2/15/17.
 */


//require the file which contains all dependencies etc
require( './bootstrap' );

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

import examMain from './components/exam.main.component.vue'
import examEditPane from './components/exam.edit-pane.component.vue'
// import panelExamDetail from './components/panel.exam-detail.component.vue'

import listDropdown from './components/field.list-dropdown.component.vue'

import propsDashboard from './components/dashboard.props.component.vue'
import toolsDashboard from './components/dashboard.tools.component.vue'


//item settings and properties edit panels
import itemEditPane from './components/item.edit-pane.component.vue'
import panelComments from './components/panel.comment-setup.component.vue'
import panelDetail from './components/panel.item-detail.component.vue'
import panelStats from './components/panel.stats.component.vue'
import panelHistory from './components/panel.history.component.vue'
import panelNotes from './components/panel.notes.component.vue'

//Item card list
import cardList from './components/itemCards.list.component.vue'
import itemAddButton from './components/buttons.item.add.component.vue'

//Item card parts
import itemCard from './components/itemCards.card.component.vue'
import itemMain from './components/item.main.component.vue'
import depthControl from './components/buttons.depth-control.component.vue'
import maxScore from './components/field.max-score.component.vue'
import itemNumber from './components/field.item-number.component.vue'
import itemName from './components/field.item-name.component.vue'

import settingsButton from './components/buttons.settings-control.component.vue'
import valenceButton from './components/buttons.valence.component.vue'
import deleteButton from './components/buttons.item.delete.component.vue'
import publicIndicator from './components/buttons.public-control.component.vue'



//Register components globally
Vue.component( 'exam-main', examMain )
Vue.component( 'exam-edit-pane', examEditPane )

Vue.component( 'props-dashboard', propsDashboard )
Vue.component( 'tools-dashboard', toolsDashboard )
// Vue.component( 'item-nav', itemNav )
Vue.component( 'item-add-button', itemAddButton )
Vue.component( 'item-name', itemName )
Vue.component( 'item-main', itemMain )
Vue.component( 'public-indicator', publicIndicator )
Vue.component( 'settings-button', settingsButton )
Vue.component( 'item-edit-pane', itemEditPane )
Vue.component( 'item-card', itemCard )
Vue.component( 'card-list', cardList )

//Panels
Vue.component( 'panel-detail', panelDetail )
Vue.component( 'panel-comments', panelComments )
Vue.component( 'panel-history', panelHistory )
Vue.component( 'panel-stats', panelStats )
Vue.component('panel-notes', panelNotes)

// Vue.component( 'item-settings-comment-setup', commentSetup )
Vue.component('valence-button', valenceButton)
Vue.component('delete-item-button', deleteButton)
Vue.component('depth-control', depthControl)

Vue.component('max-score', maxScore)
Vue.component('item-number', itemNumber)

Vue.component('list-dropdown', listDropdown)


new Vue( {
    // store,
    render: h => h( App ),

    mounted: function () {
        console.log( 'newSetup ready', this );
    }

} ).$mount( "#app" );
