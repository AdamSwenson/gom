<template xmlns="http://www.w3.org/1999/html">
    <div v-bind:id="divId"
         class="exam-card card "
         v-bind:data-id="serialNumber"
         v-bind:data-index="serialNumber"
    >

        <div class="card-content">
            <item-main
                    :serial-number="serialNumber"
                    :is-exam="true"
            ></item-main>
        </div>

        <div class="card-content" v-show="isPaneVisible">
            <edit-tabs
                    :serial-number="serialNumber"
                    :is-exam="true"
            ></edit-tabs>

            <router-view name="examPanels"></router-view>

        </div>

        <div class="card-footer">

            <div class="card-footer-item">
                <div class="field is-grouped">
                    <p class="control">
                        <add-child-button
                                :serial-number="serialNumber"
                        ></add-child-button>
                    </p>

                    <p class="control">
                        <button class="button is-primary is-outlined">
                                <span class="icon is-small">
                                    <i class="fa fa-clone" aria-hidden="true"></i>
                                </span>
                            <span>Clone</span>
                        </button>
                    </p>
                    <p class="control">
                        <public-indicator
                                :serial-number="serialNumber">
                        </public-indicator>
                    </p>
                    <p class="control">
                        <delete-item-button
                                :serial-number="serialNumber">
                        </delete-item-button>
                    </p>
                </div>

            </div>
            <div class="card-footer-item">
                <div class="field is-grouped">
                    <p class="control">

                        <button class="button add-child-button is-success is-outlined">
                            <span class="icon is-small">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </span>
                            <span>Grade it!</span>
                        </button>
                    </p>
                </div>
            </div>
        </div>

        <!--Check whether the item has children, if it does-->
        <!--we will make a box that will surround the children-->
        <div class="box graph-paper-background-big" v-if="numberChildren > 0">

            <div v-for="isn in children">
                <!--Now we make cards recursively-->
                <item-card :serial-number="isn"
                           :key="isn"></item-card>
            </div>
        </div>

        <progress-dashboard></progress-dashboard>
    </div>
</template>

<style lang="scss">

    .exam-card {
        margin-top: 2em;

        border-bottom: solid;

        /*!*width: 80%;*!*/
        /*.button-row {*/
        /*padding: 1em;*/
        /*}*/
        /*.panel-heading {*/

        background-color: #00496C;
        //background-color: #FFFDF4;

    }

</style>
<script>
    //    import deleteButton from './item-remove-button.vue'
    //    import itemEditPane from './item.edit-pane.component.vue'
    //    import depthControl from './buttons.depth-control.component.vue'
    //    import itemMain from './item-main.vue'

    import Item from '../../../models/Item'
    import Payload from '../../../models/Payload'
    import * as mTypes from '../../../store/mutation-types'
    import * as gTypes from '../../../store/getter-types'

    export default {

        //NB, the decisive consideration in favor of making this
        //a prop was that we may want to use the exam card on a page
        //with other exams. It thus won't do to assume that it is
        //the only exam and have it look up its serial number on its own
        props: [ 'serialNumber' ],

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


        computed: {
            /**
             * Returns an array of serial numbers belonging to
             * this item's children (in order)
             */
            children: function () {
                let node = this.$store.getters[ gTypes.getItemNodeFromOrder ]( this.serialNumber );
                let cdrn = [];
                if ( node.children.length > 0 ) {
                    for (let i = 0; i < node.children.length; i++) {
                        cdrn.push( node.children[ i ].data );
                    }
                }
                return cdrn;
            },

            divId: function () {
                return "exam-card-" + this.serialNumber
            },

            /**
             * The object representing the exam's intrinsic properties
             */
            exam: function () {
                return this.$store.getters.getItemBySerialNumber( this.serialNumber );
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
                return this.children.length;
            },

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
