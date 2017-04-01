<template>
    <!--This is the hideable area via which we edit the exam's properties-->
    <div class="exam-detail-pane"
         v-show="visible"
    >

        <slot name="settingsBody">

            <edit-tabs :index="index" :is-exam="true"></edit-tabs>

        <div class="tab-panel-area">
            <div class="well well-sm">
                <router-view name="examPanels"></router-view>
            </div>
        </div>

        </slot>

    </div>

</template>

<style>

</style>

<script>

    import * as aTypes from '../../store/action-types';
    import * as mTypes from '../../store/mutation-types';
    import * as gTypes from '../../store/getter-types';

    import Payload from '../../models/Payload'

    import panelExamDetail from './panel.exam-detail.component.vue'
    // Vue.component('panel-exam-detail', panelExamDetail)

    export default{

        props: [ 'index', 'exam-id' ],

        data: function () {
            return {};
        },

        components: {
            panelExamDetail
        },

        computed: {
            /**
             * Returns true if the settings pane for this item should be displayed
             */
            visible: function () {
                return this.$store.getters[ gTypes.isItemSettingsVisible ](this.index)
            },


        },

        methods: {
            getExam: function () {
                //  return this.$store.getters[gTypes.getActiveExamObj];
            },
        },
        directives: {},

        events: {},

        mounted: function () {
            console.log('exam-edit-pane ready');
        },
    };
</script>
