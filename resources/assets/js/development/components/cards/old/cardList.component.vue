<template xmlns="http://www.w3.org/1999/html">
    <div class="card-list-component">

        <div class="row outer-card-list">

            <ul id='card-list'
                class="card-list list-group col-md-9 col-lg-10"
            >
                <!--v-sortable="options"-->

                <li class="item-cards list-group-item  handle"
                    v-for="item in items" :key="item.index"
                >
                    <item-card :index="item.index"></item-card>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-7">
                <tools-dashboard></tools-dashboard>
            </div>

            <div class="col-md-5">
                <div class="text-right">
                    <item-add-button></item-add-button>
                </div>
            </div>
        </div>
        <!--</draggable>   -->
    </div>

</template>
<style lang="scss">
    @import '../../../../sass/development/newSetup';

    .card-list-component {

        .item-cards {
            margin-top: 1em;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .8), 0 3px 9px rgba(0, 0, 0, .2);

            /*border-color: #990002;*/
            /*border-width: thin;*/
            /*border-style: solid;*/

        }

        .list-group-item {

            background-color: #FFFDF4;
        }

    }

</style>
<script>

    import * as aTypes from '../../../store/action-types';
    import * as mTypes from '../../../store/mutation-types';
    import * as gTypes from '../../../store/getter-types';

    import Payload from '../../../models/Payload'
    import Item from '../../../models/Item'
    var Sortable = require( 'sortablejs' );

    //    import itemCard from './itemCard.component.vue'
    //    import itemAddButton from './buttons.item.add.component.vue'


    /**
     * Holds the item cards. Serves as their outer parent
     *
     * Created by adam on 2/19/17.
     */
    export default{

        props: [],

        data: function () {
            return {
                defaults: {},
//                options: {
//                    group: 'items', //name must be common to drag between menus
//                    filter: '.js-remove', // Selectors that do not lead to dragging (String or Function)
//                    animation: 150,
//                    handle: '.handle',  // Drag handle selector within list items
//                    ghostClass: "sortable-ghost", // Class name for the drop placeholder
//                    dataIdAttr: 'data-id',
//
////                    onEnd: this.reorder,
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
//                    }
//                }
            }
        },


        computed: {
            ids: function () {
          return this.$store.getters.getSortedIds;
            },

            //Return everything in the items tree except the root
            //The root is the exam. It gets special treatment.
            items: function () {

                let orig = this.$store.getters[ gTypes.getAllItems ];
                if ( _.isEmpty( orig ) ) return [];

                //filter out the exam and return everything else
                return orig.filter( ( obj ) => {
                    return obj.index > 0;
                } );
            },

            actualOrder: function () {
                let newOrderOfIds = [];
                let els = document.getElementsByClassName( 'item-card-component' );
                for (let i = 0; i < els.length; i++) {
                    newOrderOfIds.push( els[ i ].getAttribute( 'data-id' ) );
//                    console.log(els[i].getAttribute('data-id'));
                }
                return newOrderOfIds;
//
//
//                let a = [];
//                let f = [];
//                let c = document.getElementsByClassName("item-card-component");
//                for (let i = 0; i < c.length; i++) {
//                    window.console.log('itemCards.list.component', 'actualOrder', 89, c[ i ]);
//                    a.push(c[ i ].getAttribute('id'));
//                }
//                _.forEach(a, function () {
//                    let d = _.split(this, '-', 3);
//                    f.push(d[ 2 ]);
//                });
//                return f;

            },

            order: function () {
                let orig = this.$store.getters[ gTypes.getAllItems ];
                let ids = [];
                for (let i = 1; i < orig.length; i++) {
                    ids.push( orig[ i ].id );
                }
                return ids;
            },

            numberOfItems: function () {
                return this.$store.getters.getItemCount
            },


        },

//
//                return orig.filter(( obj ) => {
//                    return obj.index > 0;
//                }).id;
//
//
//                let i = 0;
//                let ids = [];
//                _.forEach(orig, function ( )  {
//                    window.console.log('itemCards.list.component', '', 90, this);
//                   ids.push(this.id);
//                });
//                return ids;
//                //filter out the exam and return everything else
//                return orig.filter(( obj ) => {
//                    if (obj.index > 0){
//                        ids.push(obj.id);
//                        window.console.log('itemCards.list.component', '', 93, ids);
////                        i += 1;
//                        return true;
//                    }
//                });

        methods: {

            reorder ( { oldIndex, newIndex } ) {
                const movedItem = this.items.splice( oldIndex, 1 )[ 0 ];
                this.items.splice( newIndex, 0, movedItem )
            },


            determineOrdering: function () {
//                return this.actualOrder;
                let newOrderOfIds = [];
                let els = document.getElementsByClassName( 'item-card-component' );
                for (let i = 0; i < els.length; i++) {
                    newOrderOfIds.push( els[ i ].getAttribute( 'data-id' ) );
//                    console.log(els[i].getAttribute('data-id'));
                }
                return newOrderOfIds;
            },


            /**
             * This creates a new default item and pushes
             * onto stack
             * later this should be able to accept positional
             * and type info
             */
            addItem: function () {
                console.log( 'cardList.component', 'methods', 'setItem', this.$store );
                this.$store.dispatch( aTypes.createItem );
                window.console.log( 'itemCards.list.component', 'addItem', 116, this.order );
            },

        },

        directives: {
//            'sortable': {
//                componentUpdated: function ( el, binding ) {
////                    window.console.log( 'cardList.component', 'inserted', 234, el);
//                    var sortable = new Sortable( el, binding.value || {} );
//                }
//            }
        },

        events: {
            'add-item': function () {
                console.log( 'cardList', 'CAUGHT', 'add-item' );
                this.addItem();
            },
            'items-ready': function () {
                window.console.log( 'cardList.component', 'items-ready', 248, 'caught' );
//                var qList = document.getElementById( 'card-list' );
//                var editableList = Sortable.create( qList, this.options );

            }
        },

        mounted: function () {
//            this.$store.commit('addMappedItem', [0,1,1], {thing: 'taco'});
            //   this.$store.commit( 'addMappedItem', { index: [ 0 ], item: 'taco' } );

            console.log( 'cardList ready' );
        },
    }
</script>