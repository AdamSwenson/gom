import Vue from 'vue'
//Panes (main container for edit tools)
import userPrefs from './components/preferences/user-preferences.vue';
Vue.component( 'user-prefs-panel', userPrefs );

import accountArea from './components/preferences/account-area.vue';
Vue.component( 'account-prefs', accountArea );

import connectionsArea from './components/preferences/connections-area.vue';
Vue.component( 'connections-prefs', connectionsArea );

import billsArea from './components/preferences/bills-area.vue';
Vue.component( 'bills-prefs', billsArea );


import gradeInputArea from './components/preferences/grade-input.vue';
Vue.component( 'grade-input-prefs', gradeInputArea );

import gradeDashArea from './components/preferences/grade-dash.vue';
Vue.component( 'grade-dash-prefs', gradeDashArea );


import setupLabelArea from './components/preferences/setup-labels.vue';
Vue.component( 'setup-label-area', setupLabelArea );

import setupStructureArea from './components/preferences/setup-structure.vue';
Vue.component( 'setup-structure-area', setupStructureArea );


module.exports =  [

    {
        path: '/preferences/user/account',
        components: {     prefsContentArea: accountArea },
        props:  true  //{default: true}
    }, //props: (route) => {return route.index;}},

    {
        path: '/preferences/user/connections',
        components: {     prefsContentArea: connectionsArea },
        props:  true  //{default: true}
    }, //props: (route) => {return route.index;}},

    {
        path: '/preferences/user/bills',
        components: { prefsContentArea: billsArea },
        props:  true  //{default: true}
    }, //props: (route) => {return route.index;}},


    {
        path: '/preferences/setup/structure',
        components: { prefsContentArea: setupStructureArea },
        props:  true  //{default: true}
    }, //props: (route) => {return route.index;}},


    {
        path: '/preferences/setup/labels',
        components: { prefsContentArea: setupLabelArea },
        props:  true  //{default: true}
    }, //props: (route) => {return route.index;}},

    {
        path: '/preferences/grade/input',
        components: { prefsContentArea: gradeInputArea },
        props:  true  //{default: true}
    }, //props: (route) => {return route.index;}},


    {
        path: '/preferences/grade/dash',
        components: { prefsContentArea: gradeDashArea },
        props:  true  //{default: true}
    }, //props: (route) => {return route.index;}},




    //
    // {
    //     path: '/preferences/user',
    //     components: { preferencePanelArea: userPrefs },
    //     props:  true  //{default: true}
    // }, //props: (route) => {return route.index;}},



];