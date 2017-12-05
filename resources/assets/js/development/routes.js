/**
 * Created by adam on 7/12/17.
 */
import Vue from 'vue'
//Panes (main container for edit tools)


//Panels (objects within pane)
import panelComments from './components/panels/comment-setup-panel.vue'
Vue.component( 'panel-comments', panelComments );

import panelExamDetail from './components/panels/exam-detail-panel.vue'

import panelHistory from './components/panels/history-panel.vue';
Vue.component( 'panel-history', panelHistory );

import panelNotes from './components/panels/notes-panel.vue';
Vue.component( 'panel-notes', panelNotes );

import panelItemDetail from './components/panels/item-detail-panel.vue'
Vue.component( 'panel-detail', panelItemDetail );

import panelStats from './components/panels/stats-panel.vue';
Vue.component( 'panel-stats', panelStats );

import panelExamStats from './components/panels/exam-stats-panel.vue'

import panelTags from './components/panels/tags-panel.vue'
Vue.component( 'panel-tags', panelTags );

import panelStudents from './components/panels/students-panel.vue'
Vue.component( 'panel-students', panelStudents );

import panelGrades from './components/panels/grades-panel.vue'
Vue.component( 'panel-grades', panelGrades );

export const routes = [

    //exams: change, grade, or new
    {
        name: 'load-exam',
        path: '',
    },

    { name: 'new-exam', path: '' },
    { name: 'grade-exam', path: '/grade/exam/:id' },


//comment setup
    {
        name: 'comments',
        path: '/panel-comments/:serialNumber',
        components: { itemPanels: panelComments },
        props: {itemPanels: true} //{default: true}
    }, //props: (route) => {return route.index;}},

    {
        name: 'exam-comments',
        path: '/exam-panel-comments/:serialNumber',
        components: { examPanels: panelComments },
        props: {
            isExam: true
        }
    },


    {
        name: 'exam-detail',
        path: '/panel-exam-detail/:serialNumber',
        components: { examPanels: panelExamDetail },
        props: true
    },
    //history
    {
        path: '/panel-history/:serialNumber',
        components: { itemPanels: panelHistory },
        props: true
    },
    //item detail
    {
        name: 'item-detail',
        path: '/panel-item-detail/:serialNumber',
        components: { itemPanels: panelItemDetail },
        props: true
    },
    //notes
    {
        path: '/panel-item-notes/:serialNumber',
        components: { itemPanels: panelNotes },
        props: true
    },
    {
        path: '/panel-exam-notes/:serialNumber',
        components: { examPanels: panelNotes },
        props: true
    },
    //stats
    {
        path: '/panel-stats/:serialNumber',
        components: { itemPanels: panelStats },
        props: true
    },

    //stats-exam
    {
        path: '/panel-exam-stats/:serialNumber',
        components: { examPanels: panelExamStats },
        props: true
    },

    //students
    {
        path: '/panel-students/:serialNumber',
        components: { examPanels: panelStudents },
        props: true
    },
    //tags
    {
        path: '/panel-tags/:serialNumber',
        components: { itemPanels: panelTags },
        props: {
            objectType: 'item'
        }
    },
    //grades
    {
        path: '/panel-grades/:serialNumber',
        components: { examPanels: panelGrades },
        props: true
    }
];
