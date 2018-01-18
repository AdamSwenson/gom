<template xmlns="http://www.w3.org/1999/html">
    <div v-bind:id="divId"
         class="exam-card card "
         v-bind:data-id="serialNumber"
         v-bind:data-index="serialNumber"
    >

        <div class="card-content main-body">
            <item-main
                    :serial-number="serialNumber"
                    :is-exam="true"
            ></item-main>
        </div>

        <div class="card-content  main-body" v-show="isPaneVisible">
            <nav-tabs
                    :serial-number="serialNumber"
                    :is-exam="true"
            ></nav-tabs>

            <router-view name="examPanels"></router-view>

        </div>

        <div class="card-footer main-body">

            <div class="card-footer-item">
                <div class="columns  is-mobile is-multiline ">

                    <div class="column is-narrow">

                        <add-child-button
                                :serial-number="serialNumber"
                        ></add-child-button>
                    </div>

                    <div class="column is-narrow">

                        <!--<p class="control">-->
                        <button class="button is-primary is-outlined">
                                <span class="icon is-small">
                                    <i class="fa fa-clone" aria-hidden="true"></i>
                                </span>
                            <span>Clone</span>
                        </button>
                    </div>
                    <div class="column is-narrow">

                        <!--<p class="control">-->
                        <public-indicator
                                :serial-number="serialNumber">
                        </public-indicator>
                    </div>


                    <div class="column is-narrow">
                        <!--<p class="control">-->
                        <delete-item-button
                                :serial-number="serialNumber">
                        </delete-item-button>
                    </div>
                    <!--</div>-->

                    <!--</div>-->
                    <!--<div class="card-footer-item">-->
                    <!--<div class="field is-grouped">-->
                    <!--<p class="control">-->
                    <div class="column is-narrow">


                    </div>
                </div>
            </div>
        </div>

        <!--Check whether the item has children, if it does-->
        <!--we will make a box that will surround the children-->
        <div class="box graph-paper-background-big" v-if="numberChildren > 0">

            <div v-for="item in items">
                <!--Now we make cards recursively-->
                <item-card :item="item"
                           :key="item.serialNumber"></item-card>
            </div>
        </div>

    </div>
</template>

<style lang="scss">

    .exam-card {
        /*margin-top: 2em;*/

        border-bottom: solid;

        /*!*width: 80%;*!*/
        /*.button-row {*/
        /*padding: 1em;*/
        /*}*/
        /*.panel-heading {*/
        .main-body {
            background-color: #00496C;
        }
        //background-color: #FFFDF4;

    }

</style>
<script>
    //    import deleteButton from './item-remove-button.vue'
    //    import itemEditPane from './item.edit-pane.component.vue'
    //    import depthControl from './buttons.depth-control.component.vue'
    //    import itemMain from './item-main.vue'

    import AddChildButton from '../items/add-child-button.vue';
    import PublicIndicator from '../input/visibility-control.vue';


    import Item from '../../../models/Item'
    import Payload from '../../../models/Payload'
    import * as mTypes from '../../../store/mutation-types'
    import * as gTypes from '../../../store/getter-types'

    import itemMain from '../items/item-main.vue';
    import navTabs from '../navigation/exam-card-navigation-tabs';

    export default {

        //NB, the decisive consideration in favor of making this
        //a prop was that we may want to use the exam card on a page
        //with other exams. It thus won't do to assume that it is
        //the only exam and have it look up its serial number on its own
        props: [ 'exam' ], //, 'serialNumber' ],

        components: {
            AddChildButton,
            PublicIndicator,
            'nav-tabs': navTabs,
            'item-main': itemMain
        },

        data: function () {
            return {
                defaults: {},
                isCommented: false,
                /**
                 * Whether students can see the name of the item
                 */
                isNamePublic: false,
            };
        },

        asyncComputed: {


            /**
             * The children of the item
             */
            items: function () {
                if ( _.isUndefined( this.exam ) ) return [];

                let c = this.$store.getters.getItemChildren( this.exam );
                return !_.isUndefined( c ) ? c : [];
            },
        },

        computed: {


            divId: function () {
                return "exam-card-" + this.serialNumber
            },

            index: function () {
                return this.serialNumber;
            },

            /**
             * Returns true if the settings pane for this item should be displayed
             */
            isPaneVisible: function () {
                return this.$store.getters[ gTypes.isExamSettingsVisible ]
            },

            /**
             * The Node representing the item's assignment
             */
            node: function () {
                this.$store.getters[ gTypes.getItemNodeFromOrder ]( this.serialNumber );
            },

            numberChildren: function () {
                return (!_.isUndefined( this.items ) && ! _.isNull(this.items) ) ? this.items.length : 0;
            },
            serialNumber: function () {
                return this.exam.serialNumber;
            }

        },

        methods: {

            /**
             * Toggles whether comments are shown for this item.
             * Turning comments off does not delete any existing
             * comments.
             */
            toggleCommentsOn: function () {
//                console.log( 'CALLED', 'toggleCommentsOn' );
                this.isCommented = !this.isCommented;
            },

            /**
             * Toggles whether comments are shown for this item.
             * Turning comments off does not delete any existing
             * comments.
             */
            toggleNameVisibility: function () {
//                console.log( 'CALLED', 'toggleNameVisibility' );
                this.isNamePublic = !this.isNamePublic;
            },


        },

        mounted: function () {
        },

        directives: {
            'sortable': {
                inserted: function ( el, binding ) {
//                    var sortable = new Sortable( el, binding.value || {} );
                }
            }
        },

        events: {
            'display-settings': function () {
                console.log( 'itemMain', 'CAUGHT', 'display-settings', this.index );
            },
        },

    }
</script>
