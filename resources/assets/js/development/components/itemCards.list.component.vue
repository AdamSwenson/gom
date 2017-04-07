<template>
    <div class="card-list card-list-component">
        <!--<draggable v-model='items'>-->
        <ul id='card-list' class="list-group">
            <li
                    class="item-cards list-group-item list-group-item-warning handle"
                    v-for="(item, index) in items"
            >
                <item-card
                        :index="item.index"
                        :id="item.id"
                ></item-card>
            </li>
        </ul>
        <!--</div>-->

        <div class="row">
            <div class="col-lg-12 ">
                <div class="text-right">
                    <item-add-button></item-add-button>
                </div>
            </div>
        </div>
        <!--</draggable>-->
    </div>
</template>
<style>

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
                let orig = this.$store.getters[gTypes.getAllItems];
                //filter out the exam and return everything else
                return  orig.filter((obj) => { return obj.index >  0; });
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

                    onSort: function (evt) {
                        me.$store.commit(mTypes.updateOrder);
                    },

                    setData: function (/** DataTransfer */dataTransfer, /** HTMLElement*/dragEl) {
                        dataTransfer.setData('Text', dragEl.textContent); // `dataTransfer` object of HTML5 DragEvent
                    },

                    // Element is chosen
                    onChoose: function (/**Event*/evt) {
                        evt.oldIndex;  // element index within parent
                    },

                    // Element dragging started
                    onStart: function (/**Event*/evt) {
                        evt.oldIndex;  // element index within parent
                    },

                    // Element dragging ended
                    onEnd: function (/**Event*/evt) {
                        evt.oldIndex;  // element's old index within parent
                        evt.newIndex;  // element's new index within parent
                    },

                    // Element is dropped into the list from another list
                    onAdd: function (/**Event*/evt) {
                        var itemEl = evt.item;  // dragged HTMLElement
                        evt.from;  // previous list
                        // + indexes from onEnd
                    },

                    // Changed sorting within list
                    onUpdate: function (/**Event*/evt) {
                        var itemEl = evt.item;  // dragged HTMLElement
                        // + indexes from onEnd
                    },


                    // Element is removed from the list into another list
                    onRemove: function (/**Event*/evt) {
                        // same properties as onUpdate
                    },

                    // Attempt to drag a filtered element
                    onFilter: function (/**Event*/evt) {
                        var itemEl = evt.item;  // HTMLElement receiving the `mousedown|tapstart` event.
                    },

                    // Event when you move an item in the list or between lists
                    onMove: function (/**Event*/evt, /**Event*/originalEvent) {
                        // Example: http://jsbin.com/tuyafe/1/edit?js,output
                        evt.dragged; // dragged HTMLElement
                        evt.draggedRect; // TextRectangle {left, top, right и bottom}
                        evt.related; // HTMLElement on which have guided
                        evt.relatedRect; // TextRectangle
                        originalEvent.clientY; // mouse position
                        // return false; — for cancel
                    },

                    // Called when creating a clone of element
                    onClone: function (/**Event*/evt) {
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
