<template>
    <!--<div id="app">-->
    <div id="examEditor">
        <div class="row">
            <exam-name></exam-name>
            <!--<exam-properties></exam-properties>-->
        </div>

        <div id="examEditorBody"
             class="row">

            <div id="itemCol"
                 class="col-lg-12 well well-lg">

                <div class="itemRow row">
                    <card-list></card-list>
                </div>

            </div>
        </div>
        <div class="row">

            <div id="infoCol"
                 class="col-lg-3"
            >
                <!--<exam-properties></exam-properties>-->
                <div class="row">

                    <!--<props-dashboard></props-dashboard>-->

                </div>

                <div class="row">

                    temp location
                    <tools-dashboard></tools-dashboard>
                </div>

            </div>

        </div>

    </div>
</template>

<style>

</style>
<script>
    // Vuex store
    //this calls use vuex in addition to exposing all the modules
    //    import store from '../store'
//
//    import examName from './components/exam.name.component.vue'
//    //    import examProperties from './components/exam.properties.component.vue'
//    //    import propsDashboard from './components/dashboard.props.component.vue'
//    import toolsDashboard from './components/dashboard.tools.component.vue'
//    import cardList from './components/itemCards.list.component.vue'
//
//    import itemName from './components/item.main.component.vue'
//    import itemEditPane from './components/item.edit-pane.component.vue'
//    import itemDetail from './components/panel.detail.component.vue'
//    import settingsButton from './components/buttons.settings-control.component.vue'
//    import valenceButton from './components/buttons.valence.component.vue'
//    import itemAddButton from './components/buttons.item.add.component.vue'
//    import deleteButton from './components/buttons.item.delete.component.vue'
//    import publicIndicator from './components/buttons.public-control.component.vue'
//    import itemCard from './components/itemCards.card.component.vue'
//    import commentSetup from './components/panel.comment-setup.component.vue'
//
//    import depthControl from './components/buttons.depth-control.component.vue'
    import store from '../store'

    export default {
        store,

        //Components
        //exam
        components: {
//            'exam-name': examName,
////            'exam-properties': examProperties,
////dashboards and  tools
////            'props-dashboard': propsDashboard,
//            'tools-dashboard': toolsDashboard,
//            'card-list': cardList,
//
//
//            //Item
//            'item-name': itemName,
////            'item-settings': settingsArea,
//            'item-settings-detail': itemDetail,
//            //buttons
//            'settings-button': settingsButton,
//            'valence-button': valenceButton,
//            'item-add-button': itemAddButton,
//            'delete-item-button': deleteButton,
//            'public-indicator': publicIndicator,
//            // card structure
//            'item-card': itemCard,
//            //comments
//            'item-settings-comment-setup': commentSetup,
//
//            'depth-control': depthControl,
        }
    }
</script>
