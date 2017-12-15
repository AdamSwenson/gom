import Vue from 'vue'

import panelComments from './components/panels/comment-setup-panel.vue'
// import panelExamStats from './components/panels/exam-stats-panel.vue';
import panelExamDetail from './components/panels/exam-detail-panel.vue'
import panelGrades from './components/panels/grades-panel.vue'
// import panelStats from './components/panels/stats-panel.vue';
import panelStudents from './components/panels/students-panel.vue'
import panelQuality from './components/panels/quality-control-panel.vue';

import panelNotes from './components/panels/notes-panel.vue';

Vue.component( 'panel-exam-detail', panelExamDetail);
Vue.component( 'panel-comments', panelComments );
Vue.component( 'panel-grades', panelGrades );
Vue.component( 'panel-quality', panelQuality );

Vue.component( 'panel-students', panelStudents );


Vue.component( 'panel-notes', panelNotes );

module.exports = [
    //comments-exam
    {
        name: 'exam-comments',
        path: '/exam-panel-comments/:serialNumber',
        components: { examPanels: panelComments },
        props: {
            isExam: true
        }
    },

    //detail-exam
    {
        name: 'exam-detail',
        path: '/panel-exam-detail/:serialNumber',
        components: { examPanels: panelExamDetail },
        props: true
    },

    //quality control
    {
        path: '/panel-quality/:serialNumber',
        components: { examPanels: panelQuality },
        props: true
    },


    //grades
    {
        path: '/panel-grades/:serialNumber',
        components: { examPanels: panelGrades },
        props: true
    },

    //notes
    {
        path: '/panel-exam-notes/:serialNumber',
        components: { examPanels: panelNotes },
        props: true
    },


    // //stats-exam
    // {
    //     path: '/panel-exam-stats/:serialNumber',
    //     components: { examPanels: panelExamStats },
    //     props: true
    // },

    //students
    {
        path: '/panel-students/:serialNumber',
        components: { examPanels: panelStudents },
        props: true
    },


];