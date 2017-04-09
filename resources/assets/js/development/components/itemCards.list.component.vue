<template xmlns="http://www.w3.org/1999/html">
    <div class="card-list-component">

        <div class="row card-list">
            <!--<draggable v-model='items'>-->
            <ul id='card-list' class="list-group">
                <li
                        class="item-cards list-group-item  handle"
                        v-for="(item, index) in items"
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
        <!--</draggable>-->
    </div>

</template>
<style lang="scss">
    .card-list-component {


        .list-group-item {

            background-color: #FFFDF4;
        }
    }

</style>
<script>

    import * as aTypes from '../../store/action-types';
    import * as mTypes from '../../store/mutation-types';
    import * as gTypes from '../../store/getter-types';

    import Payload from '../../models/Payload'
    import Item from '../../models/Item'

    //    import itemCard from './itemCards.card.component.vue'
    //    import itemAddButton from './buttons.item.add.component.vue'

    //For Vue.js 2.0
    // var draggable = require('vuedraggable')

    var Sortable = require('sortablejs');

    /**
     * Holds the item cards. Serves as their outer parent
     *
     * Created by adam on 2/19/17.
     */
    export default{

        props: [],
//        components: {
//            'item-card': itemCard,
//            'item-add-button': itemAddButton,
//        },
        data: function () {
            return {};
        },

        computed: {
            //Return everything in the items tree execpt the root
            //The root is the exam. It gets special treatment.
            items: function () {
                let orig = this.$store.getters[ gTypes.getAllItems ];
                //filter out the exam and return everything else
                return orig.filter(( obj ) => {
                    return obj.index > 0;
                });
            },

            actualOrder: function () {
                let a = [];
                let f = [];
                let c = document.getElementsByClassName("item-card-component");
                for (let i = 0; i < c.length; i++) {
                    window.console.log('itemCards.list.component', 'actualOrder', 89, c[ i ]);
                    a.push(c[ i ].getAttribute('id'));
                }
                _.forEach(a, function () {
                    let d = _.split(this, '-', 3);
                    f.push(d[ 2 ]);
                });
                return f;

            },

            order: function () {
                let orig = this.$store.getters[ gTypes.getAllItems ];
                let ids = [];
                for (let i = 1; i < orig.length; i++) {
                    ids.push(orig[ i ].id);
                }
                return ids;
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


//
//                let cards = document.getElementsByClassName('item-card-component');
//                let out = [];
//                for (let i=0; i<cards.length; i++){
//                    let did = cards[i].getAttribute('data-id');
//                    out.push(did);
//                    window.console.log('itemCards.list.component', 'order', 88, did);
//                }
//return out;
//                let orig = this.$store.getters[ gTypes.getAllItems ];
//                //filter out the exam and return everything else
//                return orig.filter(( obj ) => {
//                    return obj.index > 0;
//                });
            },

            numberOfItems: function () {
                return this.$store.getters.getItemCount
            },

        },

        methods: {
            /**
             * This creates a new default item and pushes
             * onto stack
             * later this should be able to accept positional
             * and type info
             */
            addItem: function () {
                console.log('cardList.component', 'methods', 'setItem', this.$store);
                this.$store.dispatch(aTypes.createItem);
                window.console.log('itemCards.list.component', 'addItem', 116, this.order);
            },

        },

        directives: {},

        events: {
            'add-item': function () {
                console.log('cardList', 'CAUGHT', 'add-item');
                this.addItem();
            }
        },

        mounted: function () {
//            this.addItem();
            let me = this;
            try {
                var qList = document.getElementById('card-list');
                var editableList = Sortable.create(qList, {
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
//                            var order = localStorage.getItem(sortable.options.group.name);
//                            return order ? order.split('|') : [];
                        },

                        /**
                         * Save the order of elements. Called onEnd (when the item is dropped).
                         * @param {Sortable}  sortable
                         */
                        set: function ( sortable ) {
                            window.console.log('itemCards.list.component', 'set', 141, sortable.childNodes);
                            var order = sortable.toArray();
                            window.console.log('itemCards.list.component', 'set', 142, order);
                        }
                    },


                    onSort: function ( evt ) {
                        window.console.log('itemCards.list.component', 'onSort', 148, evt);
                        me.$store.commit(mTypes.updateOrder);
                    },

                    setData: function ( /** DataTransfer */dataTransfer, /** HTMLElement*/dragEl ) {
                        dataTransfer.setData('Text', dragEl.textContent); // `dataTransfer` object of HTML5 DragEvent
                    },

                    // Element is chosen
                    onChoose: function ( /**Event*/evt ) {
                        evt.oldIndex;  // element index within parent
                    },

                    // Element dragging started
                    onStart: function ( /**Event*/evt ) {
                        evt.oldIndex;  // element index within parent
                    },

                    // Element dragging ended
                    onEnd: function ( /**Event*/evt ) {
                        evt.oldIndex;  // element's old index within parent
                        evt.newIndex;  // element's new index within parent
                    },

                    // Element is dropped into the list from another list
                    onAdd: function ( /**Event*/evt ) {
                        var itemEl = evt.item;  // dragged HTMLElement
                        evt.from;  // previous list
                        // + indexes from onEnd
                    },

                    // Changed sorting within list
                    onUpdate: function ( /**Event*/evt ) {
                        var itemEl = evt.item;  // dragged HTMLElement
                        // + indexes from onEnd
                    },


                    // Element is removed from the list into another list
                    onRemove: function ( /**Event*/evt ) {
                        // same properties as onUpdate
                    },

                    // Attempt to drag a filtered element
                    onFilter: function ( /**Event*/evt ) {
                        var itemEl = evt.item;  // HTMLElement receiving the `mousedown|tapstart` event.
                    },

                    // Event when you move an item in the list or between lists
                    onMove: function ( /**Event*/evt, /**Event*/originalEvent ) {
                        // Example: http://jsbin.com/tuyafe/1/edit?js,output
                        evt.dragged; // dragged HTMLElement
                        evt.draggedRect; // TextRectangle {left, top, right и bottom}
                        evt.related; // HTMLElement on which have guided
                        evt.relatedRect; // TextRectangle
                        originalEvent.clientY; // mouse position
                        // return false; — for cancel
                    },

                    // Called when creating a clone of element
                    onClone: function ( /**Event*/evt ) {
                        var origEl = evt.item;
                        var cloneEl = evt.clone;
                    }

                });
            } catch (e) {
                window.console.log(e);
            }

            console.log('cardList ready');

        },
    }
</script>
