/**
 * Holds the item cards. Serves as their outer parent
 *
 * Created by adam on 2/19/17.
 */
var $ = require( 'jquery' );
window.$ = $;

import {mapGetters} from 'vuex'

var Sortable = require( 'sortablejs' );
import Item from '../../models/Item'

import * as aTypes from '../../store/action-types';

module.exports = {

    template: require( '../templates/card-list.template.html' ),

    props: [],

    data: function () {
        return {};
    },

    computed: {
        // mix the getters into computed with object spread operator
        // ...mapGetters( {
        //     items: 'getAllItemsList'
        // } ),
        items: function () {
            return this.$store.getters.getAllItems;
        },


//         },
        numberOfItems: function () {
            return this.$store.itemsRepo.length;
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
// create an editable list and set up some filters to handle callbacks
        initializeSort: function () {

            try {

                localStorage.clear();
                var qList = this.$el;
                var editableList = Sortable.create( qList, {
                    filter: '.js-remove', // Selectors that do not lead to dragging (String or Function)
                    animation: 150,
                    handle: '.handle',  // Drag handle selector within list items
                    ghostClass: "sortable-ghost", // Class name for the drop placeholder

                    onFilter: function ( evt ) {
                        handleDelete( evt, editableList );
                    },
                    store: {
                        // store the ordering to localStorage
                        get: function ( sortable ) {
                            var order = localStorage.getItem( sortable.options.group );
                            //window.console.log(localStorage.getItem(sortable.options.group));
                            return order ? order.split( '|' ) : [];
                        },
                        set: function ( sortable ) {
                            var order = sortable.toArray();
                            localStorage.setItem( sortable.options.group, order.join( '|' ) );
                            updateNumbers();
                        }
                    }
                } );
            } catch (e) {
                window.console.log( e );
            }

// update all "questionItem" ids. These define the ordering when saved to the DB.
// function updateNumbers() {
//     $( '#questionForm' ).find( "[id^='questionItem']" ).each( function ( index, el ) {
//         updateListItemData( el, (index + 1) );
//     } );
// }

// // set all relevant names and ids of [item] to value [order]
// function updateListItemData( item, order ) {
//     $( item ).attr( 'id', 'questionItem' + order );
//     $( item ).find( '#displayNumber' ).text( 'Question #' + (order) );
//     $( item ).find( "[id^='questionName']" ).attr( 'id', 'questionName' + order );
//     $( item ).find( "[id^='questionName']" ).attr( 'name', 'questionName' + order );
//     $( item ).find( 'textarea' ).attr( 'id', 'questionText' + order );
//     $( item ).find( 'textarea' ).attr( 'name', 'questionText' + order );
//     $( item ).find( '#questionId' ).attr( 'name', 'questionId' + order );
//     $( item ).find( "[id^='maxScore']" ).attr( 'id', 'maxScore' + order );
//     $( item ).find( "[id^='maxScore']" ).attr( 'name', 'maxScore' + order );
//
// }

// function getQuestionCount() {
//     // return number of questions currently in the questionList
//     return $( "[id^='questionItem']" ).length;
// }
//
        }
    },

    directives: {},

    events: {
        'add-item': function () {
            console.log( 'cardList', 'CAUGHT', 'add-item' );
            this.addItem();
        }
    },

    ready: function () {
        console.log( '.....', this.items );
        this.addItem();
        console.log( 'cardList ready', this.$store );

        //
        // try {
        //     var qList = this.el;
        //     var editableList = Sortable.create( qList, {
        //         filter: '.js-remove', // Selectors that do not lead to dragging (String or Function)
        //         animation: 150,
        //         handle: '.handle',  // Drag handle selector within list items
        //         ghostClass: "sortable-ghost", // Class name for the drop placeholder
        //     } );
        // } catch (e) {
        //     window.console.log( e );
        // }


    },
};