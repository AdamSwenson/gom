import Vue from 'vue'
//Panes (main container for edit tools)

// =============== User
import accountArea from './components/preferences/user/account-area.vue';
Vue.component( 'account-prefs', accountArea );

import connectionsArea from './components/preferences/user/connections-area.vue';
Vue.component( 'connections-prefs', connectionsArea );

import billsArea from './components/preferences/user/bills-area.vue';
Vue.component( 'bills-prefs', billsArea );

import permissionsArea from './components/preferences/user/permissions.vue';
Vue.component( 'permissions-area', permissionsArea );


import gradeInputArea from './components/preferences/grade/grade-input.vue';
Vue.component( 'grade-input-prefs', gradeInputArea );

import gradeDashArea from './components/preferences/grade/grade-dash.vue';
Vue.component( 'grade-dash-prefs', gradeDashArea );


import setupLabelArea from './components/preferences/setup/setup-labels.vue';
Vue.component( 'setup-label-area', setupLabelArea );

import setupStructureArea from './components/preferences/setup/setup-structure.vue';
Vue.component( 'setup-structure-area', setupStructureArea );


module.exports =  [
    // ======== User

    {
        name: 'prefs-account',
        path: '/preferences/user/account',
        components: {     prefsContentArea: accountArea },
        props:  true,
        group: 'user',
        isDefaultRoute : true,
        tabText : 'Manage account'
    }, //props: (route) => {return route.index;}},

    {
        name: 'prefs-connections',
        path: '/preferences/user/connections',
        components: {     prefsContentArea: connectionsArea },
        props:  true ,
        group: 'user',
        tabText : 'Manage connections'//{default: true}
    }, //props: (route) => {return route.index;}},

    {
        name: 'prefs-bills',
        path: '/preferences/user/bills',
        components: { prefsContentArea: billsArea },
        props:  true,
        group: 'user',
        tabText : 'Pay yo bills'  //{default: true}
    }, //props: (route) => {return route.index;}},

    {
        name: 'prefs-permissions',
        path: '/preferences/user/permissions',
        components: { prefsContentArea: permissionsArea },
        props: true,
        group: 'user',
        tabText: 'Manage permissions'
    },

    // ======== Setup


    {
        name: 'prefs-setup-structure',
        path: '/preferences/setup/structure',
        components: { prefsContentArea: setupStructureArea },
        props:  true,
        group: 'setup',
        tabText: 'Assignment structure options'//{default: true}
    }, //props: (route) => {return route.index;}},


    {
        name: 'prefs-label',
        path: '/preferences/setup/labels',
        components: { prefsContentArea: setupLabelArea },
        props:  true,
     group: 'setup',

        isDefaultRoute : true,
        tabText: 'What things are called'//{default: true}
    }, //props: (route) => {return route.index;}},


    // ======== Grade
    {
        name: 'prefs-grade-input',
        path: '/preferences/grade/input',
        components: { prefsContentArea: gradeInputArea },
        props:  true ,
        group: 'grade',

        isDefaultRoute : true,
        tabText: 'Inputs'//{default: true}
    }, //props: (route) => {return route.index;}},


    {
        name: 'prefs-grade-dash',
        path: '/preferences/grade/dash',
        components: { prefsContentArea: gradeDashArea },
        props:  true,
        group: 'grade',
        tabText: 'Dash'//{default: true}
    }, //props: (route) => {return route.index;}},




    //
    // {
    //     path: '/preferences/user',
    //     components: { preferencePanelArea: userPrefs },
    //     props:  true  //{default: true}
    // }, //props: (route) => {return route.index;}},



];