/**
 * Created by adam on 1/10/17.
 *
 * Notes about how to use
 * However, this pattern causes the component to rely on the global store singleton. When using a module system, it requires importing the store in every component that uses store state, and also requires mocking when testing the component.

 Vuex provides a mechanism to "inject" the store into all child components from the root component with the store option (enabled by Vue.use(Vuex)):

 const app = new Vue({
  el: '#app',
  // provide the store using the "store" option.
  // this will inject the store instance to all child components.
  store,
  components: { Counter },
  template: `
    <div class="app">
      <counter></counter>
    </div>
  `
})

 By providing the store option to the root instance, the store will be injected into all child components of the root and will be available on them as this.$store. Let's update our Counter implementation:

 const Counter = {
  template: `<div>{{ count }}</div>`,
  computed: {
    count () {
      return this.$store.state.count
    }
  }
}

 *
 */

import Vue from  'vue/dist/vue.js'
// import Vue from 'vue'
import Vuex from 'vuex'

import * as actions from './actions'
import * as getters from './getters'
import * as mutations from './mutations'
import * as state from './state'

import activestudent from './modules/activestudent.js'
import activeexam from './modules/activeexam.js'
import comments from './modules/comments.js'
import escores from './modules/escores.js'
import items from './modules/items.js'
import grades from './modules/grades.js'
import qscores from './modules/qscores.js'
import questions from './modules/questions.js'
import students from './modules/students.js'
import settings from './modules/settings'
import times from './modules/times.js'

import visibility from './modules/visibility'
// import orderings from './modules/items.order';

// import gradeStateDefault from './modules/grade.defaultstate'
// import createLogger from '../../../src/plugins/logger'

Vue.use(Vuex);

/**
 * This subscribes the api package which
 * handles data exchange with the server
 * to mutations in the store.
 */
import apiPlugin from '../api/apiPlugin';
import websocketPlugin from '../api/websocketPlugin';


const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({

    strict: debug, //letting check determine whether to turn on or off. should be off for production to avoid performance hit

    /**
     * From instances and components where store has been
     * injected, actions are called
     * like so: store.dispatch( 'string-action-name' )
     */
    actions,
    getters,
    mutations,
    state,

    plugins: [ apiPlugin, websocketPlugin ],

    modules: {
        activeexam,
        activestudent,
        comments,
        escores,
        items,
        grades,
        // orderings,
        qscores,
        questions,
        settings,
        students,
        times,
        visibility
    },


    // plugins: debug ? [createLogger()] : []
})
