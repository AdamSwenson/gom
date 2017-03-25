<template>
    <!--This is the hideable area via which we edit the exam's properties-->
    <div class="exam-detail-pane well well-sm"
         v-show="visible">

        <slot name="settingsBody">
            <div>
                <!-- Nav tabs -->
                <ul class="nav nav-pills"
                    role="tablist">
                    <li role="presentation">
                        <router-link v-bind:to="routeToExamDetails">Edit details</router-link>
                    </li>

                    <li role="presentation">
                        <router-link v-bind:to="routeToComments">Setup feedback</router-link>
                    </li>

                    <li role="presentation">
                        <router-link v-bind:to="routeToStats">Stats</router-link>
                    </li>

                    <li role="presentation">
                        <router-link v-bind:to="routeToHistory">History</router-link>
                    </li>

                    <li role="presentation">
                        <router-link v-bind:to="routeToNotes">Notes</router-link>
                    </li>
                </ul>

                <!-- Tab panels -->
                <div class="tab-panel-area">
                    <router-view name="examPanels"></router-view>
                </div>

            </div>

        </slot>

        <slot name="controlsArea"></slot>
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

        props: ['exam-id'],

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
                return this.$store.getters[gTypes.isItemSettingsVisible](this.index)
            },

            routeToExamDetails: function () {
                return "/panel-exam-detail/" + this.index;
            },

            routeToComments: function () {
                return "/panel-comments/" + this.index;
            },

            routeToStats: function () {
                return "/panel-stats/" + this.index;
            },


            routeToHistory: function () {
                return "/panel-history/" + this.index;
            },


            routeToNotes: function () {
                return "/panel-notes/" + this.index;
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
