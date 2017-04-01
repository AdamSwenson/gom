<template>
    <div class="nav-edit-tabs-component">
        <div class="row">
            <div class="col-md-1" v-if="promotable">
                <depth-control
                        type="promote"
                        :index="index"></depth-control>
            </div>
            <div class="col-md-10">
                <!-- Nav tabs -->
                <ul class="nav nav-pills"
                    role="tablist">

                    <li v-if="isExam" role="presentation">
                        <router-link v-bind:to="routeToExamDetails">Edit details</router-link>
                    </li>
                    <li v-else role="presentation">
                        <router-link v-bind:to="routeToItemDetails">Edit details</router-link>
                    </li>

                    <li role="presentation">
                        <router-link :to="{name: 'comments', params: {index : index} }">Setup feedback</router-link>
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
            </div>
            <div class="col-md-1"  v-if="promotable">
                <depth-control
                        type="demote"
                        :index="index"></depth-control>
            </div>
        </div>
    </div>

</template>
<style>

</style>
<script>

    import * as mTypes from '../../store/mutation-types'
    import * as gTypes from '../../store/getter-types'
    import Item from '../../models/Item'
    import Payload from '../../models/Payload'


    /**
     * This holds all the tools for editing an item. It drops down
     * when called and has lots of tabs etc
     *
     * Created by adam on 2/18/17.
     */
    export default {
        props: [ 'index', 'is-exam' ],

        data: function () {
            return {
                defaults: {
                    types: [ 'question', 'element' ]
                },
                // currentView: 'item-settings-question',
                tabs: [
                    'details', 'comments', 'stats', 'history', 'notes'
                ],
                hiding: true,

            };
        },

        computed: {
            tabTitle: function () {
                //  return this.tab.
            },

            tabActive: function () {

            },

            /**
             * Returns true if the settings pane for this item should be displayed
             */
            visible: function () {
                return this.$store.getters[ gTypes.isItemSettingsVisible ](this.index)
            },


            routeToExamDetails: function () {
                return "/panel-exam-detail/" + this.index;
            },


            routeToItemDetails: function () {
                return "/panel-item-detail/" + this.index;
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

/**
Exams fail this and thus don't have the arrows shown
*/
            promotable: function (  ) {
            return this.index > 0;
            }

        },

        methods: {
            show: function () {
                console.log('itemSetting', 'CALLED', 'show');
                this.$store.commit(mTypes.showItemSettings(Payload.factory({index: this.index})));
            },
            hide: function () {
                console.log('itemSetting', 'CALLED', 'hide');
                this.$store.commit(mTypes.hideItemSettings(Payload.factory({index: this.index})));
            },

        },

        directives: {},

        events: {
            'display-settings': function () {
//                console.log('itemSettings', 'CAUGHT', 'display-settings', this.hiding);
                //this.toggle();
            }
        },

        mounted: function () {
//            window.console.log('nav.edit-tabs.component', 'mounted', 136, this.index);
        },

    }

</script>
