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
import Vue from 'vue'
import Router from 'vue-router'
import App from './components/setupApp.vue.js'
import store from '../store'

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



// install router
// Vue.use(Router)

new Vue( {
    el: '#app',

    store,

    template: require( './templates/exam-editor.template.html' ),

    //may be a vue version problem
    //so temp doing import manually above
  //  render: h => h( App ),

    ready: function () {
        console.log( 'newSetup ready', this );
    },
} )

// routing
// var router = new Router()

// router.map({
//     // '/news/:page': {
//     //     component: NewsView
//     // },
//     // '/user/:id': {
//     //     component: UserView
//     // },
//     // '/item/:id': {
//     //     component: ItemView
//     // }
// })
//
// router.beforeEach(function () {
//     window.scrollTo(0, 0)
// })
//
// router.redirect({
// //    '*': '/news/1'
// })

// router.start(App, '#app')