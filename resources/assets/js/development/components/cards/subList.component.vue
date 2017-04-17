<template>
    <div class="card-list-component "
         v-bind:class="offset">

        <div class="row card-list">
            <!--<ul :id="sublistId" class="list-group col-md-9 col-lg-9" v-sortable="options">-->
                <!--<li class="item-cards list-group-item  handle"-->
                    <!--v-bind:class="sublistClass"-->
                    <!--v-for="item in items" :key="item.index"-->
                <!--&gt;-->
                    <!--<item-card :index="item.index" :parent-index="index"></item-card>-->
                <!--</li>-->
            <!--</ul>-->
        </div>
    </div>
</template>

<style lang="scss">

</style>

<script>
    var Sortable = require('sortablejs');


    import Item from '../../../models/Item'
    import Payload from '../../../models/Payload'
    import * as mTypes from '../../../store/mutation-types'
    import * as gTypes from '../../../store/getter-types'

    export default{

        props: [],

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

                    store: {
                        /**
                         * Get the order of elements. Called once during initialization.
                         * @param   {Sortable}  sortable
                         * @returns {Array}
                         */
                        get: function ( sortable ) {
                        },

                        /**
                         * Save the order of elements. Called onEnd (when the item is dropped).
                         * @param {Sortable}  sortable
                         */
                        set: function ( sortable ) {
                            let newOrder = me.determineOrdering();
                            window.console.log( 'cardList.component', 'onSet', 297, 'newOrder', newOrder );

                        }
                    },


                    onSort: function ( evt ) {
                        let newOrder = me.determineOrdering();
                        window.console.log( 'cardList.component', 'onSort', 297, 'newOrder', newOrder );

                    },

                }
            }
        },

        computed: {
            sublistId: function () {
                return 'card-sub-list' + this.$parent.index;
            },
            sublistClass: function () {
                return 'sublist-' + this.$parent.index;
            },

            //note that in this case,
            //we want depth and index to be tightly coupled
            depth: function () {
                return this.$parent.depth;

            },

            index: function () {
                return this.$parent.index;
            },

            parentIndex: function () {
                return this.$parent.$parent.index;
            },

            offset: function () {
                return "col-min-offset" + this.depth;
            },
            items: function () {
//                return [];
                //todo filter by parent index
                //Return everything in the items tree execpt the root
                //The root is the exam. It gets special treatment.
                let orig = this.$store.getters[ gTypes.getAllItems ];
                if(orig.length > 0) {
                    //filter out the exam and return everything else
                    return orig.filter( ( obj ) => {
                        return obj.index > 0;
                    } );
                }
                return [];
            },

            actualOrder: function () {
                let newOrderOfIds = [];
                let els = document.getElementsByClassName( 'item-card-component' );
                for (let i = 0; i < els.length; i++) {
                    newOrderOfIds.push( els[ i ].getAttribute( 'data-id' ) );
//                    console.log(els[i].getAttribute('data-id'));
                }
                return newOrderOfIds;
            }
        },

        methods: {},

//
//        directives: {
//            'sortable': {
//                inserted: function ( el, binding ) {
//                    var sortable = new Sortable( el, binding.value || {} );
//                }
//            }
//        },


        events: {},

        mounted: function () {
            let me = this;


            try {
//                var qList = document.getElementById( me.sublistId );
//                var editableList = Sortable.create( qList, {
//                    group: 'items', //name must be common to drag between lists
//                    filter: '.js-remove', // Selectors that do not lead to dragging (String or Function)
//                    animation: 150,
//                    handle: '.handle',  // Drag handle selector within list items
//                    ghostClass: "sortable-ghost", // Class name for the drop placeholder
//                    dataIdAttr: 'data-id',
//
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
//
//
//                    onSort: function ( evt ) {
//                        let newOrder = me.determineOrdering();
//                        window.console.log( 'cardList.component', 'onSort', 297, 'newOrder', newOrder );
//
//                    },
//
//                } );
            } catch (e) {
                window.console.log( e );
            }
        }
    }
</script>