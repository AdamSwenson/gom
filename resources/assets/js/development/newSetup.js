/**
 * This runs the new setup app
 * Created by adam on 2/15/17.
 */


//require the file which contains all dependencies etc
require( './bootstrap' );

import 'babel-polyfill'

import Vue from  'vue/dist/vue.js'
// import store from '../store'

// import Vue from 'vue'
import App from './new-setup.vue'




import examName from './components/exam.name.component.vue'
//    import examProperties from './components/exam.properties.component.vue'
import propsDashboard from './components/dashboard.props.component.vue'
import toolsDashboard from './components/dashboard.tools.component.vue'
import cardList from './components/itemCards.list.component.vue'

import itemName from './components/item.name.component.vue'
import settingsArea from './components/item.settings.component.vue'
import itemDetail from './components/item.detail.component.vue'
import settingsButton from './components/buttons.item.settings.component.vue'
import valenceButton from './components/buttons.valence.component.vue'
import itemAddButton from './components/buttons.item.add.component.vue'
import deleteButton from './components/buttons.item.delete.component.vue'
import publicIndicator from './components/buttons.public-control.component.vue'
import itemCard from './components/itemCards.card.component.vue'
import commentSetup from './components/comment.setup.component.vue'

import depthControl from './components/buttons.depth-control.component.vue'
import maxScore from './components/field.max-score.component.vue'
import itemNumber from './components/field.item-number.component.vue'


Vue.component( 'exam-name', examName )
// Vue.component( 'exam-properties', examProperties )
Vue.component( 'props-dashboard', propsDashboard )
Vue.component( 'tools-dashboard', toolsDashboard )
// Vue.component( 'item-nav', itemNav )
Vue.component( 'item-add-button', itemAddButton )
Vue.component( 'item-name', itemName )
Vue.component( 'public-indicator', publicIndicator )
Vue.component( 'settings-button', settingsButton )
Vue.component( 'item-settings', settingsArea )
Vue.component( 'item-card', itemCard )
Vue.component( 'card-list', cardList )
Vue.component( 'item-settings-detail', itemDetail )
Vue.component( 'item-settings-comment-setup', commentSetup )
Vue.component('valence-button', valenceButton)
Vue.component('delete-item-button', deleteButton)
Vue.component('depth-control', depthControl)

Vue.component('max-score', maxScore)
Vue.component('item-number', itemNumber)



new Vue( {
    // store,
    render: h => h( App ),

    mounted: function () {
        console.log( 'newSetup ready', this );
    }

} ).$mount( "#app" );
