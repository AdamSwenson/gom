<template>
    <div class="item-edit-pane well well-sm"
         v-show="visible">

        <slot name="settingsBody">
            <div>
                <!-- Nav tabs -->
                <ul class="nav nav-pills"
                    role="tablist">
                    <li role="presentation">
                        <router-link :to="{name: 'comments', params: {index : index} }">Edit details</router-link>

                        <!--<router-link :to="{name: 'comments', params: {index : index} }">Edit details</router-link>-->
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
                    <router-view name="itemPanels"></router-view>
                </div>

            </div>

        </slot>

        <slot name="controlsArea"></slot>
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
        props: ['index'],

        data: function () {
            return {
                defaults: {
                    types: ['question', 'element']
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
                return this.$store.getters[gTypes.isItemSettingsVisible](this.index)
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
                console.log('itemSettings', 'CAUGHT', 'display-settings', this.hiding);
                //this.toggle();
            }
        },

        mounted: function () {
            window.console.log('pane.edit-item.component', 'mounted', 141, this.index);
        },

    }

</script>
