<template>
</template>

<style>

</style>
<script>

export 
    //Vue libraries
    import Vue from 'vue'

    // Vue router
    //import Router from 'vue-router'
    // install router
    // Vue.use(Router)

    // Vuex store
    //this calls use vuex in addition to exposing all the modules
    import store from '../store'

    //Components
    //exam
    import examName from './components/exam.name.component.vue'
    Vue.component( 'exam-name', examName )

    import examProperties from './components/exam.properties.component.vue'
    Vue.component( 'exam-properties', examProperties )

    //Item
    import itemName from './components/item.name.component.vue'
    Vue.component( 'item-name', itemName )

    import settingsArea from './components/item.settings.component.vue'
    Vue.component( 'item-settings', settingsArea )

    import itemDetail from './components/item.detail.component.vue'
    Vue.component( 'item-settings-detail', itemDetail )

    //buttons
    import settingsButton from './components/buttons.item.settings.component.vue'
    Vue.component( 'settings-button', settingsButton )

    import valenceButton from './components/buttons.valence.component.vue'
    Vue.component('valence-button', valenceButton)

    import itemAddButton from './components/buttons.item.add.component.vue'
    Vue.component( 'item-add-button', itemAddButton )

    import deleteButton from './components/buttons.item.delete.component.vue'
    Vue.component('delete-item-button', deleteButton)

    import publicIndicator from './components/buttons.public-control.component.vue'
    Vue.component( 'public-indicator', publicIndicator )

    //card structure
    import itemCard from './components/itemCards.card.component.vue'
    Vue.component( 'item-card', itemCard )

    import cardList from './components/itemCards.list.component.vue'
    Vue.component( 'card-list', cardList )

    //comments
    import commentSetup from './components/comment.setup.component.vue'
    Vue.component( 'item-settings-comment-setup', commentSetup )

    //dashboards and  tools
    import propsDashboard from './components/dashboard.props.component.vue'
    Vue.component( 'props-dashboard', propsDashboard )

    import toolsDashboard from './components/dashboard.tools.component.vue'
    Vue.component( 'tools-dashboard', toolsDashboard )

    import depthControl from './components/buttons.depth-control.component.vue'
    Vue.component('depth-control', depthControl)

//    Other folks' libraries
//    var draggable = require('vuedraggable');
//    Vue.component('draggable', draggable)

    new Vue( {
        el: '#app',

        store,

        //may be a vue version problem
        //so temp doing import manually above
        //  render: h => h( App ),

        mounted: function () {
            console.log( 'newSetup ready', this );
        },
    } )
</script>
