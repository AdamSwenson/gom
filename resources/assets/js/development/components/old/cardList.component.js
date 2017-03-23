/**
 * Holds the item cards. Serves as their outer parent
 *
 * Created by adam on 2/19/17.
 */
var $ = require( 'jquery' );
window.$ = $;

import Item from '../../../models/Item'

import * as mTypes from '../../../store/mutation-types';
import * as aTypes from '../../../store/action-types';

//For Vue.js 2.0
// var draggable = require('vuedraggable')

var Sortable = require( 'sortablejs' );

module.exports = {

    template: require( '../../templates/card-list.template.html' ),

    props: [],

    data: function () {
        return {};
    },

    computed: {
        items: function () {
            return this.$store.getters.getAllItems;
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
            console.log( 'cardList.component', 'methods', 'setItem', this.$store );
            this.$store.dispatch( aTypes.createItem );
        },

    },

    directives: {},

    events: {
        'add-item': function () {
            console.log( 'cardList', 'CAUGHT', 'add-item' );
            this.addItem();
        }
    },

    mounted: function () {
        this.addItem();
let me = this;
        try {
            var qList = document.getElementById('card-list');
            var editableList = Sortable.create( qList, {
                filter: '.js-remove', // Selectors that do not lead to dragging (String or Function)
                animation: 150,
                handle: '.handle',  // Drag handle selector within list items
                ghostClass: "sortable-ghost", // Class name for the drop placeholder

                onSort: function(evt){
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

            } );
        } catch (e) {
            window.console.log( e );
        }

        console.log( 'cardList ready');

    },
};