<template>
    <div id="examEditor"
         class="setup-main"
    >
        <div class="container is-fluid">

            <div class="columns">
                <div class="column"></div>
                <div class="column is-three-quarters ">
                    <!--<div class="column is-three-quarters  border-image-lft">-->
                    <div id="examCardArea" class="card">
                        <exam-card :serial-number="examSerialNumber"></exam-card>
                    </div>

                </div>

                <div class="column"></div>

            </div>

            <div class="tile">
                <div class="tile is-vertical is-4">

                    <p>{{ examId }}</p>
                    <p>Can sync {{ canSync}}</p>

                    <sync-indicator></sync-indicator>

                    <!--<existing-exams-menu>&lt;!&ndash;<p slot="row-content">taco</p>&ndash;&gt;</existing-exams-menu>-->
                </div>
                <div class="tile is-vertical is-4">
                    <!--<existing-items-menu></existing-items-menu>-->
                </div>
            </div>


            <input type="hidden" id="examId" v-model="examId"/>
        </div>
    </div>
</template>

<style lang="scss">
    @import '../../sass/development/newSetup';

    .setup-main {
        background-image: linear-gradient(bottom left, $main-background-color, $main-background-color-gradient-limit);
    }

    #examCardArea {
        /*<!--background-color: $color-primary-2;-->*/
        padding-left: 2px;
        padding-right: 2px;
        background-color: $main-background-color-gradient-limit;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .8), 0 3px 9px rgba(0, 0, 0, .2);
    }

    #itemCardArea {
        box-shadow: 0 1px 3px rgba(0, 0, 0, .8), 0 3px 9px rgba(0, 0, 0, .2);
    }

    .itemCol {
        border-left-color: $border-outline-color;
        border-left-width: thin;
        border-left-style: solid;
        border-right-color: $border-outline-color;
        border-right-width: thin;
        border-right-style: solid;
        /*-moz-border-image: url(http://localhost:8000/images/styling/border.png) 10 stretch round;*/
        /*-webkit-border-image: url(http://localhost:8000/images/styling/border.png) 10 stretch round;*/
        /*border-image: url(http://localhost:8000/images/styling/border.png) 10 stretch round;*/
        /*border-width: 10px;*/
        /*border-image : url('http://localhost:8000/images/styling/border.png') 10 repeat;*/

    }

    .infoCol {
        margin-top: 2em;
        /*background-color: #00496C;*/
    }

</style>
<script>

    import Exam from '../models/Exam'
    import Item from '../models/Item'
    import Payload from '../models/Payload'

    import * as aTypes from '../store/action-types'
    import * as mTypes from '../store/mutation-types'
    import * as gTypes from '../store/getter-types'

    import { updateItemsOrder } from '../api/requests'
    import { loadExamKumi } from '../api/requests/kumiRequests';
    import { loadAllStudents } from '../api/requests/studentRequests';

    var Sortable = require( 'sortablejs' );

    export default {

        data: function () {
            return {
//                isSyncable: this.$store.getters.canSync,
                defaults: {},

                options: {
                    group: 'items', //name must be common to drag between menus
                    filter: '.js-remove', // Selectors that do not lead to dragging (String or Function)
                    animation: 150,
                    handle: '.handle',  // Drag handle selector within list items
                    ghostClass: "sortable-ghost", // Class name for the drop placeholder
                    dataIdAttr: 'data-id',
                    onUpdate: function ( event ) {
                        this.$store.dispatch( 'onUpdate', event );
                    },
//                    store: {
//                        /**
//                         * Get the order of elements. Called once during initialization.
//                         * @param   {Sortable}  sortable
//                         * @returns {Array}
//                         */
//                        get: function ( sortable ) {
//                        },
//
//                        /**
//                         * Save the order of elements. Called onEnd (when the item is dropped).
//                         * @param {Sortable}  sortable
//                         */
//                        set: function ( sortable ) {
//                            let newOrder = me.determineOrdering();
//                            window.console.log( 'cardList.component', 'onSet', 297, 'newOrder', newOrder );
//
//                        }
//                    },
                }
            };
        },

        watch: {
            canSync: function ( newVal, oldVal ) {
                window.console.log( 'new-setup', 'canSync', 118, newVal, oldVal );
                //if the can Sync is newly true, call update
                if ( newVal ) updateItemsOrder( this.$store );
            }
        },

        computed: {
            canSync: function () {
                return this.$store.getters.canSync;
            },

            exam: function () {
                return this.$store.getters.currentExam;
            },

            examId: function () {
                return this.exam.id;
            },

            examSerialNumber: function () {
                return this.$store.getters.getExamSerialNumber;
            }
        },

        methods: {},

        directives: {},

        events: {},

        created: function () {
            window.console.log( 'new-setup', 'created', 169 );
            this.$store.commit( 'loadInitialData' );
            let p = loadExamKumi( this.$store, this.exam );
            let me = this;
//            setTimeout( function () {
            p.then( function () {


                //set the first kumi as the one to display
                //this needs to happen before associate exam is called
//                me.$store.commit( 'updateSelectedKumi' );

                loadAllStudents( me.$store, me.exam );
            } );

//            }, 3000 );
            //Tags for the items loaded
            //Does not load tags that aren't yet used on the
            //exam. That is done on the tags-panel creation
            //todo this is probably unnecessary
            this.$store.dispatch( 'processTagsOutOfLoadedItems' );

        },


    }
</script>
