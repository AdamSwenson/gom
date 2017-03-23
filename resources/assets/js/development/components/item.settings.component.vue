<template>
    <div class="well well-sm"
         v-show="hidden">

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
                        <item-settings-detail :index="index"></item-settings-detail>
                    </div>

                    <div role="tabpanel"
                         class="tab-pane  "
                         v-bind:id="'comments' + index"
                    >
                        <item-settings-comment-setup :index="index"></item-settings-comment-setup>
                    </div>

                    <div role="tabpanel"
                         class="tab-pane "
                         v-bind:id="'stats' + index"
                    >
                        <p>Stats here</p>
                    </div>

                    <div role="tabpanel"
                         class="tab-pane "
                         v-bind:id="'history' + index"
                    >
                        <p>Which exams clones of this item have been used on</p>
                    </div>

                    <div role="tabpanel"
                         class="tab-pane fade"
                         v-bind:id="'notes' + index"
                    >
                        <p>Notes to self about item</p>
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
    /**
     * Created by adam on 2/18/17.
     */
//    import itemDetail from './item.detail.component.vue'
//    import commentSetup from './comment.setup.component.vue'
//


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

            hidden: {
                get: function () {
                    console.log( this.hiding );
                    return this.hiding;
                },
                /**
                 * Maybe this should be disabled?
                 * @param v
                 */
                set: function ( v ) {
                    this.hiding = v;
                }
            }
        },

        methods: {
            show: function () {
                console.log( 'itemSetting', 'CALLED', 'show' );
                this.hiding = false;
            },
            hide: function () {
                console.log( 'itemSetting', 'CALLED', 'hide', this.hiding );
                this.hiding = true;
                console.log( this.hiding );
            },
            toggle: function () {
                console.log( 'itemSetting', 'CALLED', 'hide', this.hiding );

                this.hiding = !this.hiding;

                console.log( this.hiding );
            }
        },

        directives: {},

        events: {
            'display-settings': function () {
                console.log( 'itemSettings', 'CAUGHT', 'display-settings', this.hiding );
                this.toggle();
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
