<template>
    <div id="examEditor"
         class="setup-main"
    >
        <div class="container is-fluid">

            <div class="columns">
                <div class="column"></div>
                <div class="column is-two-thirds graph-paper-background-small border-image-lft">

                    <div id="examCardArea" class="card">
                        <exam-card :index="0"></exam-card>
                    </div>

                    <div id="itemCardArea" class="card ">
                        <div class="itemCol">
                            <item-card
                                    :serial-number="examSerialNumber"
                                    :index="examSerialNumber"
                            ></item-card>
                        </div>
                    </div>

                </div>
                <div class="column"></div>
            </div>

            <!--<progress-dashboard></progress-dashboard>-->


        </div>
    </div>
</template>

<style lang="scss">
    @import '../../sass/development/newSetup';

    .setup-main {
        background-image: linear-gradient(bottom left, $main-background-color, $main-background-color-gradient-limit);
    }

    #examCardArea {
        background-color: $color-primary-2;

        /*<!--background-color: $main-background-color-gradient-limit;-->*/

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

    var Sortable = require( 'sortablejs' );

    //    import store from '../store'
    //    window.console.log( 'new-setup', 'store', 116, store );
    export default {

//        store,

        data: function () {
            return {
                defaults: {},
                options: {
                    group: 'items', //name must be common to drag between lists
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

        computed: {
            examSerialNumber: function () {
                return this.$store.getters.getRootNodeSerialNumber;
            }
        },

        methods: {},

        directives: {},

        events: {},

        mounted: function () {
//            window.console.log( 'new-setup', 'mounted', 166, store);
            this.$store.dispatch( 'setupOnMount' ).then( () => {
                this.$emit( 'items-ready' );
//                var qList = document.getElementsByClassName( 'card-list' );
                var qList = document.getElementById( 'card-list' );
                var editableList = Sortable.create( qList, this.options );
            } );
        },

        components: {},

    }
</script>
