<template>
    <div class="item-edit-pane "
         v-show="visible"
    >

        <slot name="settingsBody">

            <edit-tabs :index="index"></edit-tabs>

            <!-- Tab panels -->
            <div class="tab-panel-area">
                <div class="well well-sm">
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

            /**
             * Returns true if the settings pane for this item should be displayed
             */
            visible: function () {
                return this.$store.getters[ gTypes.isItemSettingsVisible ](this.index)
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
        'collapse-all': function (  ) {
            window.console.log('pane.edit-item.component', 'collapse-all', 85,);
            this.hide();
        },
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
