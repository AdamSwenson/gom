/**
 * Created by adam on 2/15/17.
 */
//This pulls together the various components used in
// exam and question setup

import 'babel-polyfill'
import Vue from 'vue'
// import examName from './examName.component'
import examName from './examName.vue'
import examProperties from './examProperties.component'
import propsDashboard from './propsDashboard.component'
import toolsDashboard from './toolsDashboard.component'

export default {
    components: {
        'exam-name': examName,
        'exam-properties': examProperties,
        'props-dashboard': propsDashboard,
        'tools-dashboard': toolsDashboard
    }
}