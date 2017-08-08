/**
 * Created by adam on 7/12/17.
 */
import Vue from 'vue'
//Panes (main container for edit tools)
import editTabs from './components/navigation/settings-navigation-tabs.vue'

//Panels (objects within pane)
import panelComments from './components/panels/comment-setup-panel.vue'
import panelExamDetail from './components/panels/exam-detail-panel.vue'
import panelHistory from './components/panels/history-panel.vue'
import panelNotes from './components/panels/notes-panel.vue'
import panelItemDetail from './components/panels/item-detail-panel.vue'
import panelStats from './components/panels/stats-panel.vue'
import panelTags from './components/panels/tags-panel.vue'
import panelStudents from './components/panels/students-panel.vue'
import panelGrades from './components/panels/grades-panel.vue'

//Panels
Vue.component( 'panel-detail', panelItemDetail );
Vue.component( 'panel-comments', panelComments );
Vue.component( 'panel-history', panelHistory );
Vue.component( 'panel-stats', panelStats );
Vue.component( 'panel-notes', panelNotes );
Vue.component('panel-tags', panelTags);
Vue.component( 'edit-tabs', editTabs );
Vue.component('panel-students', panelStudents);
Vue.component('panel-grades', panelGrades);


export const routes = [
    {
        name: 'comments',
        path: '/panel-comments/:serialNumber',
        components: { itemPanels: panelComments },
        props: true, //{default: true}
    }, //props: (route) => {return route.index;}},

    {
        name: 'exam-comments',
        path: '/exam-panel-comments/:serialNumber',
        components: { examPanels: panelComments},
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
    //students
    {
        path: '/panel-students/:serialNumber',
        components: { examPanels: panelStudents },
        props: true
    },
    //tags
    {
        path: '/panel-tags/:serialNumber',
        components: { itemPanels: panelTags},
        props :{
            objectType: 'item'
        }
    },
    //grades
    {
        path: '/panel-grades/:serialNumber',
        components: { itemPanels: panelGrades},
        props: true
    }
];
