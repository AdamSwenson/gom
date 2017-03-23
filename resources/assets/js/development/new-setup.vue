<template>
    <!--<div id="app">-->
        <div id="examEditor">

            <!--<div class="row">-->
            <!--<div class="col-lg-8">-->
            <exam-name></exam-name>

            <exam-properties></exam-properties>

            <div id="examEditorBody"
                 class="row">

                <div id="itemCol"
                     class="col-lg-9 well well-lg">

                    <div class="itemRow row">
                        <div class="col-lg-12">
                            <card-list></card-list>
                        </div>
                    </div>

                </div>

                <div id="infoCol"
                     class="col-lg-3">

                    <div class="row">
                        <div class="col-lg-12">
                            <props-dashboard></props-dashboard>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <tools-dashboard></tools-dashboard>
                        </div>
                    </div>

                </div>

            </div>
        <!--</div>-->

    </div>
</template>

<style>

</style>
<script>
    // Vuex store
    //this calls use vuex in addition to exposing all the modules
//    import store from '../store'

    import examName from './components/exam.name.component.vue'
    import examProperties from './components/exam.properties.component.vue'
    import propsDashboard from './components/dashboard.props.component.vue'
    import toolsDashboard from './components/dashboard.tools.component.vue'
    import cardList from './components/itemCards.list.component.vue'

    //    import itemName from './components/item.name.component.vue'
//    import settingsArea from './components/item.settings.component.vue'
//    import itemDetail from './components/item.detail.component.vue'
//    import settingsButton from './components/buttons.item.settings.component.vue'
//    import valenceButton from './components/buttons.valence.component.vue'
//    import itemAddButton from './components/buttons.item.add.component.vue'
//    import deleteButton from './components/buttons.item.delete.component.vue'
//    import publicIndicator from './components/buttons.public-control.component.vue'
//    import itemCard from './components/itemCards.card.component.vue'
//    import commentSetup from './components/comment.setup.component.vue'

//    import depthControl from './components/buttons.depth-control.component.vue'

    export default {
//        store,

        //Components
        //exam
        components: {
            'exam-name': examName,
            'exam-properties': examProperties,
//dashboards and  tools
            'props-dashboard': propsDashboard,
            'tools-dashboard': toolsDashboard,
            'card-list': cardList,


            //Item
//            'item-name': itemName,
//            'item-settings': settingsArea,
//            'item-settings-detail': itemDetail,
            //buttons
//            'settings-button': settingsButton,
//            'valence-button': valenceButton,
//            'item-add-button': itemAddButton,
//            'delete-item-button': deleteButton,
//            'public-indicator': publicIndicator,
            //card structure
//            'item-card': itemCard,
            //comments
//            'item-settings-comment-setup': commentSetup,

//            'depth-control': depthControl,
        }
    }
</script>
