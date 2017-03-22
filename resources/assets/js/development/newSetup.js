/**
 * Created by adam on 2/15/17.
 */
//
var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

require( 'bootstrap' );
// var bootbox = require( 'bootbox' );
import 'babel-polyfill'

//Vue libraries
import Vue from 'vue'

// Vue router
//import Router from 'vue-router'
// install router
// Vue.use(Router)

// Vuex store
//this calls use vuex in addition to exposing all the modules
import store from '../store'

//Components
import examName from './components/examName.component'
import examProperties from './components/exam.properties.vue'
import propsDashboard from './components/propsDashboard.component'
import toolsDashboard from './components/toolsDashboard.component'
import itemNav from './components/itemNav.component'
import itemAddButton from './components/itemAddButton.component'
import itemName from './components/itemName.component'
import publicIndicator from './components/publicIndicator.component'
import settingsButton from './components/settingsButton.component'
import settingsArea from './components/itemSettings.component'
import itemCard from './components/itemCard.component'
import cardList from './components/cardList.component'

import itemDetail from './components/itemSettings.detail.component'
import commentSetup from './components/itemSettings.commentSetup.component'

import valenceButton from './components/valenceButton.component'
import deleteButton from './components/deleteItemButton.component'
import depthControl from './components/depthControl.component'

//Other folks' libraries
var draggable = require('vuedraggable');


Vue.component( 'exam-name', examName )
Vue.component( 'exam-properties', examProperties )
Vue.component( 'props-dashboard', propsDashboard )
Vue.component( 'tools-dashboard', toolsDashboard )
Vue.component( 'item-nav', itemNav )
Vue.component( 'item-add-button', itemAddButton )
Vue.component( 'item-name', itemName )
Vue.component( 'public-indicator', publicIndicator )
Vue.component( 'settings-button', settingsButton )
Vue.component( 'item-settings', settingsArea )
Vue.component( 'item-card', itemCard )
Vue.component( 'card-list', cardList )
Vue.component( 'item-settings-detail', itemDetail )
Vue.component( 'item-settings-comment-setup', commentSetup )
Vue.component('valence-button', valenceButton)
Vue.component('delete-item-button', deleteButton)
Vue.component('depth-control', depthControl)

Vue.component('draggable', draggable)

new Vue( {
    el: '#app',

    store,

    template: require( './templates/exam-editor.template.html' ),

    //may be a vue version problem
    //so temp doing import manually above
  //  render: h => h( App ),

    mounted: function () {
        console.log( 'newSetup ready', this );
    },
} )