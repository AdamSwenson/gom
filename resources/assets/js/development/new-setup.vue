<template>
    <div id="examEditor">
     <div class="row">
        <div class="col-lg-1"></div>

        <div class="examEditor col-lg-10">
            <div class="panel-heading">
                <exam-main></exam-main>
            </div>

            <div class="panel-body">
                <exam-edit-pane
                        :index="0"
                        :is-exam="true"
                ></exam-edit-pane>
            </div>
        </div>
        <div class="col-lg-1"></div>
    </div>

    <div id="examEditorBody"
         class="row"
    >

        <div class="col-lg-1"></div>

        <div id="itemCol"
             class="col-lg-9 well well-sm  "
        >
            <div class="itemRow row">
                <card-list></card-list>
            </div>
        </div>

        <div id="infoCol"
             class="col-lg-2 well well-sm"
        >

            <div class="row">
                <props-dashboard></props-dashboard>
            </div>

            <div class="row">
                <tools-dashboard></tools-dashboard>
            </div>

        </div>

        <div class="col-lg-1"></div>

    </div>
    </div>
</template>

<style>
    /*@import '../node_modules/bootstrap-vue/dist/bootstrap-vue.css';*/
    #itemCol.well {
        background-color: #385a7f
    }
</style>
<script>
    // Vuex store
    //this calls use vuex in addition to exposing all the modules
    //    import store from '../store'
    //
    //    import examName from './components/exam.main.component.vue'
    //    //    import examEditPane from './components/exam.edit-pane.component.vue'
    //    //    import propsDashboard from './components/dashboard.props.component.vue'
    //    import toolsDashboard from './components/dashboard.tools.component.vue'
    //    import cardList from './components/itemCards.list.component.vue'
    //
    //    import itemMain from './components/item.main.component.vue'
    //    import itemEditPane from './components/item.edit-pane.component.vue'
    //    import itemDetail from './components/panel.item-detail.component.vue'
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

    import Exam from '../models/Exam'
    import Item from '../models/Item'
    import Payload from '../models/Payload'

    import * as aTypes from '../store/action-types'
    import * as mTypes from '../store/mutation-types'
    import * as gTypes from '../store/getter-types'


    export default {
        store,

        data: function () {
            return {
                defaults: {},
            };
        },

        computed: {},

        methods: {},

        directives: {},

        events: {},

        mounted: function () {
            //On load the root exam object and first item are created but given no
            //ids. thus we will eventually need to create an exam object if one isn't set
            //however don't ask the server to create an id just yet
            let exam = this.store.getters.gTypes.getItem(Payload.factory({index: 0}));
//            let exam = this.$store.getters[ gTypes.getActiveExamObj ];
            if ( !exam ) {
            exam = new Exam();
                //lookup the exam object that resides at index 0
                //this will have either been newly created on page load
                //or it will be an existing exam object loaded from the db
//                let exam = this.$store.getters[ gTypes.getActiveExamObj ];
                //Call the set active exam method
                //We do this rather than call the mutation directly
                //because there may need to be various other events and
                //things which need to happen depending on the context.
//                this.$store.dispatch(aTypes.setActiveExam, Payload.factory({obj: exam}));
            this.store.getters[ mTypes.setItem ](Payload.factory({index: 0, obj: exam}));
            }
        },

        components: {
//            'exam-name': examName,
////            'exam-properties': examEditPane,
////dashboards and  tools
////            'props-dashboard': propsDashboard,
//            'tools-dashboard': toolsDashboard,
//            'card-list': cardList,
//
//
//            //Item
//            'item-name': itemMain,
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
        },

    }
</script>
