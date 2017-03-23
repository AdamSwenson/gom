<template>
    <div class="well well-sm"
         v-show="hidden">

        <slot name="settingsBody">
            x
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
µ
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
    import itemDetail from './item.detail.component.vue'
    import commentSetup from './comment.setup.component.vue'



    export default {
        components : {
            'item-settings-detail': itemDetail,
            'item-settings-comment-setup': commentSetup,
        },

        props: [],

        data: function () {
            return {};
        },

        computed: {},

        methods: {
            /**
             * Requests that the item properties area
             * be displayed
             */
            openItemSettings: function () {
                console.log( 'CALLED', 'openItemSettings' );
                this.requestSettingsDisplay();
            },

            /**
             * Emits an event caught by the parent.
             * The catching object will handle the opening.
             * Thus there is no need for this button to know
             * who it belongs to
             */
            requestSettingsDisplay: function(){
                this.$store.dispatch('display-settings');
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        },
    };
</script>
