<template>
    <div class="well well-sm"
         v-show="visible">

        <slot name="settingsBody">
            <div>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs"
                    role="tablist">
                    <li role="presentation"
                        v-for="tab in tabs">
                        <a v-bind:href="'#' + tab + index"
                           v-bind:aria-controls="tab + index"
                           role="tab"
                           data-toggle="tab"
                        >
                        <span class="tabTitle">
                            {{ tab }}
                        </span>
                        </a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">

                    <div role="tabpanel"
                         class="tab-pane active"
                         v-bind:id="'details' + index"
                    >
                        <panel-detail :index="index"></panel-detail>
                    </div>

                    <div role="tabpanel"
                         class="tab-pane  "
                         v-bind:id="'comments' + index"
                    >
                        <panel-comments :index="index"></panel-comments>

                    </div>

                    <div role="tabpanel"
                         class="tab-pane "
                         v-bind:id="'stats' + index"
                    >
                        <panel-stats :index="index"></panel-stats>
                        <p>Stats here</p>
                    </div>

                    <div role="tabpanel"
                         class="tab-pane "
                         v-bind:id="'history' + index"
                    >
                        <panel-history :index="index"></panel-history>

                        <p>Which exams clones of this item have been used on</p>
                    </div>

                    <div role="tabpanel"
                         class="tab-pane fade"
                         v-bind:id="'notes' + index"
                    >
                        <p>Notes to self about item</p>

                        <panel-notes :index="index"></panel-notes>
                    </div>

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
        props: [ "index", 'id' ],

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
                return this.$store.getters[ gTypes.isItemSettingsVisible ]( this.index )
            }

        },

        methods: {
            show: function () {
                console.log( 'itemSetting', 'CALLED', 'show' );
                this.$store.commit(mTypes.showItemSettings(Payload.factory({index: this.index})));
            },
            hide: function () {
                console.log( 'itemSetting', 'CALLED', 'hide');
                this.$store.commit(mTypes.hideItemSettings(Payload.factory({index: this.index})));
            },

        },

        directives: {},

        events: {
            'display-settings': function () {
                console.log( 'itemSettings', 'CAUGHT', 'display-settings', this.hiding );
                //this.toggle();
            }
        },

        mounted: function () {
        },
//        components : {
//            'item-settings-detail': itemDetail,
//            'item-settings-comment-setup': commentSetup,
//        },
    }

</script>
