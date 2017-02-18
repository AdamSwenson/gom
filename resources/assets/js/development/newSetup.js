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
import examProperties from './components/examProperties.component'
import propsDashboard from './components/propsDashboard.component'
import toolsDashboard from './components/toolsDashboard.component'
import itemNav from './components/itemNav.component'
import itemAddButton from './components/itemAddButton.component'
import itemName from './components/itemName.component'
import publicIndicator from './components/publicIndicator.component'

Vue.component( 'exam-name', examName )
Vue.component( 'exam-properties', examProperties )
Vue.component( 'props-dashboard', propsDashboard )
Vue.component( 'tools-dashboard', toolsDashboard )
Vue.component( 'item-nav', itemNav )
Vue.component( 'item-add-button', itemAddButton )
Vue.component( 'item-name', itemName )
Vue.component( 'public-indicator', publicIndicator )

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