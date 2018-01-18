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

// import questionPanel from '../development/components/grading/panels/question-panel.vue';
// Vue.component('question-panel', questionPanel); //importing globally so can use recursively

import AsyncComputed from 'vue-async-computed'
Vue.use( AsyncComputed )

import App from '../development/components/feedback/feedback-page.vue'

//Navigation bars
// import examSelectionBar from './components/top-nav/exam-selection-bar.vue';
// Vue.component( 'exam-selection-bar', examSelectionBar );
// import bottomNavbar from '../development/components/bottom-nav/bottom-navbar.vue';
// Vue.component('bottom-navbar', bottomNavbar)

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ API ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

import VueAxios from 'vue-axios'

window.axios.defaults.baseURL = routeRoot;

// This wrapper bind axios to Vue or this if you're using single file component.
Vue.use( VueAxios, window.axios );

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ STORE ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
import Vuex from 'vuex'
Vue.use( Vuex );
import store from '../store';


/* ~~~~~~~~~~~~~~~~~~~~~~~ Create and mount the root instance ~~~~~~~~~~~~~~~~~~ */
// Make sure to inject the router with the router option to make the
// whole app router-aware.
const app = new Vue( {
    store,

    render: h => h( App ),

    mounted: function () {
        console.log( 'new public feedback ready');
    }

} ).$mount( "#app" );
