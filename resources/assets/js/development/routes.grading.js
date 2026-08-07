import Vue from 'vue'
//Panes (main container for edit tools)
import questionPanel from './components/grading/panels/question-panel.vue';
Vue.component( 'grading-question-panel', questionPanel );

export default [


//grading
    {
        path: '/grading-questions/:serialNumber',
        components: { questionPanelArea: questionPanel },
        props:  true  //{default: true}
    }, //props: (route) => {return route.index;}},
];