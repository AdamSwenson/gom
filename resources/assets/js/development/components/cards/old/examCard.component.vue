<template>
    <div class="exam-card-component">

        <div class="row">
            <div class="col-md-12 text-left ">

                <exam-main></exam-main>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-left ">
                <progress-dashboard></progress-dashboard>
            </div>
        </div>

        <div class="exam-edit-pane row" v-show="paneVisible">
            <div class="col-md-12">

                <edit-tabs :index="index" :is-exam="true"></edit-tabs>

                <div class="tab-panel-area">
                    <router-view name="examPanels"></router-view>
                </div>
            </div>
        </div>


        <div class="row" v-show="paneVisible">
            <div class="col-md-12 text-left ">
                <div class="btn-group"
                     role="group"
                     aria-label="Item tool buttons">

                    <delete-button :index="index"></delete-button>

                    <public-indicator :index="index"></public-indicator>
                </div>
            </div>
        </div>

    </div>

</template>

<style lang="scss">
    @import '../../../../sass/development/newSetup';

    .exam-card-component {
        /*width: 80%;*/

        .panel-heading {

            /*background-color: #FFFDF4;*/
        }

        .bottom-stripe {
            /*line-height: 3em;*/
            /*background-color: #385a7f;*/
        }

    }

</style>
<script>
    import deleteButton from '../input/buttons.item.delete.component.vue'
    import panelExamDetail from '../exam-detail-panel.vue'

    import Item from '../../../models/Item'
    import Payload from '../../../models/Payload'

    import * as aTypes from '../../../store/action-types';
    import * as mTypes from '../../../store/mutation-types';
    import * as gTypes from '../../../store/getter-types';


    export default{

        props: [ 'index' ],
        components: {'delete-button': deleteButton},

        data: function () {
            return {}
        },

        computed: {
            /**
             * Returns true if the settings pane for this item should be displayed
             */
            paneVisible: function () {
                return this.$store.getters[ gTypes.isExamSettingsVisible ];
            },
        },

        methods: {
            /**
             * Toggles whether comments are shown for this item.
             * Turning comments off does not delete any existing
             * comments.
             */
            toggleCommentsOn: function () {
                console.log('CALLED', 'toggleCommentsOn');
                this.isCommented = !this.isCommented;
            },

            /**
             * Toggles whether comments are shown for this item.
             * Turning comments off does not delete any existing
             * comments.
             */
            toggleNameVisibility: function () {
                console.log('CALLED', 'toggleNameVisibility');
                this.isNamePublic = !this.isNamePublic;
            },


        },

        directives: {},

        events: {
            'please-hide-all' :function (  ) {
                this.$dispatch(mTypes.hideItemSettings, Payload.factory({index: 0}));

            },
            'please-show-all' :function (  ) {
                this.$dispatch(mTypes.showItemSettings, Payload.factory({index: 0}));
            },


            'display-settings': function () {
                console.log('itemMain', 'CAUGHT', 'display-settings', this.index);
            },
        },

        mounted: function () {
        },
    }
</script>
