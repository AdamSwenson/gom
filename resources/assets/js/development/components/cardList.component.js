/**
 * Holds the item cards. Serves as their outer parent
 *
 * Created by adam on 2/19/17.
 */
var $ = require( 'jquery' );
window.$ = $;

import Item from '../../models/Item'

import * as mTypes from '../../store/mutation-types';
import * as aTypes from '../../store/action-types';

//For Vue.js 2.0
// var draggable = require('vuedraggable')

var Sortable = require( 'sortablejs' );

module.exports = {

    template: require( '../templates/card-list.template.html' ),

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

        myList: {
            get() {
                return this.$store.state.myList
            },
            set(value) {
                this.$store.commit(mTy, value)
            }
        }
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


        /**
         * Handle deletion - items will be deleted once the form is submitted
         * This is actually listening for an attempt to drag a filtered element.
         * It fires on mousedown, so it is practically equivalent to a click.
         *
         * evt.item is HTMLElement receiving the `mousedown|tapstart` event.
         *
         * @param evt
         */
        handleDelete: function ( evt, editableList ) {
            //get the element from the list
            var el = editableList.closest( evt.item );

            bootbox.dialog( {
                className: 'confirmationModal',
                message: "<p class='questionDeleteWarning' id='questionDeleteWarning'> <span class='glyphicon glyphicon-warning-sign'></span>" +
                " Warning: This will permanently delete all elements and scores associated with the question </p>",
                title: "Delete Question",
                buttons: {
                    success: {
                        label: 'Cancel',
                        className: "btn-sm bnt-primary cancelQuestionDelete",
                        callback: function () {
                        }
                    },
                    danger: {
                        label: '<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Delete',
                        className: "btn-danger btn-sm confirmQuestionDelete",
                        callback: function () {
                            if ( el && el.parentNode.removeChild( el ) )
                                updateNumbers();
                        }
                    }
                }
            } );

        },

        // Sortable is the lib for drag and drop questions
// // create an editable list and set up some filters to handle callbacks
//         initializeSort: function () {
//
//             try {
//
//                 localStorage.clear();
//                 var qList = this.$el;
//                 var editableList = Sortable.create( qList, {
//                     filter: '.js-remove', // Selectors that do not lead to dragging (String or Function)
//                     animation: 150,
//                     handle: '.handle',  // Drag handle selector within list items
//                     ghostClass: "sortable-ghost", // Class name for the drop placeholder
//
//                     onFilter: function ( evt ) {
//                         handleDelete( evt, editableList );
//                     },
//                     store: {
//                         // store the ordering to localStorage
//                         get: function ( sortable ) {
//                             var order = localStorage.getItem( sortable.options.group );
//                             //window.console.log(localStorage.getItem(sortable.options.group));
//                             return order ? order.split( '|' ) : [];
//                         },
//                         set: function ( sortable ) {
//                             var order = sortable.toArray();
//                             localStorage.setItem( sortable.options.group, order.join( '|' ) );
//                             updateNumbers();
//                         }
//                     }
//                 } );
//             } catch (e) {
//                 window.console.log( e );
//             }

// update all "questionItem" ids. These define the ordering when saved to the DB.
// function updateNumbers() {
//     $( '#questionForm' ).find( "[id^='questionItem']" ).each( function ( index, el ) {
//         updateListItemData( el, (index + 1) );
//     } );
// }


        // }
    },

    directives: {},

    events: {
        'add-item': function () {
            console.log( 'cardList', 'CAUGHT', 'add-item' );
            this.addItem();
        }
    },

    ready: function () {
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