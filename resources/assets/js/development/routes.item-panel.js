import Vue from 'vue'

//Panels (objects within pane)
import panelComments from './components/setup/comment-setup-panel.vue'
import panelHistory from './components/setup/history-panel.vue';
import panelItemDetail from './components/setup/item-detail-panel.vue'

import panelNotes from './components/setup/notes-panel.vue';
import panelStats from './components/setup/stats-panel.vue';
import panelTags from './components/setup/tags-panel.vue'

Vue.component( 'panel-comments', panelComments );
Vue.component( 'panel-notes', panelNotes );
Vue.component( 'panel-history', panelHistory );
Vue.component( 'panel-detail', panelItemDetail );
Vue.component( 'panel-stats', panelStats );
Vue.component( 'panel-tags', panelTags );

module.exports = [
//comment setup
    {
        name: 'comments',
        path: '/panel-comments/:serialNumber',
        components: { itemPanels: panelComments },
        props: { itemPanels: true } //{default: true}
    }, //props: (route) => {return route.index;}},


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

    //stats
    {
        path: '/panel-stats/:serialNumber',
        components: { itemPanels: panelStats },
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


];