/**
 * Created by adam on 1/10/17.
 */

import Vue from 'vue'
import Vuex from 'vuex'
import * as actions from './actions'
import * as getters from './getters'
import * as mutations from './mutations'
import * as state from './state'

// import createLogger from '../../../src/plugins/logger'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
    actions,
    getters,
    mutations,
    modules: {
        activeStudent: require('./modules/vuex.active'),
        comments: require('./modules/vuex.comments'),
        elementScores: require('./modules/vuex.escores'),
        grades: require('./modules/vuex.grades'),
        questionScores: require('./modules/vuex.qscores'),
        questions: require('./modules/vuex.questions'),
        students: require('./modules/vuex.students'),
        times: require('./modules/vuex.times')
    },
    state,

    strict: debug,
    // plugins: debug ? [createLogger()] : []
})
