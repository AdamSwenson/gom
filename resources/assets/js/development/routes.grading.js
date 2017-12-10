import Vue from 'vue'
//Panes (main container for edit tools)
import questionPanel from './components/grade/panels/question-panel';
Vue.component( 'grading-question-panel', questionPanel );

export const routes = [


//grading
    {
        name: 'grading-questions',
        path: '/grading/question/:questionlNumber',
        components: { questionPanelArea: questionPanel },
        props: { questionPanelArea: true } //{default: true}
    }, //props: (route) => {return route.index;}},
];