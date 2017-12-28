import Vue from 'vue'
//Panes (main container for edit tools)
import userPrefs from './components/preferences/user-preferences.vue';
Vue.component( 'user-prefs-panel', userPrefs );

import accountArea from './components/preferences/account-area.vue';
Vue.component( 'account-prefs', accountArea );

module.exports =  [

    {
        path: '/preferences/user/account',
        components: {     prefsContentArea: accountArea },
        props:  true  //{default: true}
    }, //props: (route) => {return route.index;}},


    {
        path: '/preferences/user',
        components: { preferencePanelArea: userPrefs },
        props:  true  //{default: true}
    }, //props: (route) => {return route.index;}},



];