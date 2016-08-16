/**
 * JavaScript for edit_element.blade
 */

var $ = require('jquery');
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

require('bootstrap');

var bootbox = require('bootbox');
var Sortable = require('sortablejs');
// var Sortable = require('../utilities/Sortable.js');
var common = require( '../common.js' );

(function(){
$("#prev-question" ).on('click', function(){
    submitForm(backNavTarget);
});

$("#next-question" ).on('click', function(){
    submitForm(forwardNavTarget);
});

// handle add element button
$( "#addElement" ).on('click', function () {
    // copy empty form
    var order = getElementCount() + 1;
    var myClone = $( '#elementItem0' ).clone();
    // set values

    // add to editableList and refresh
    myClone.appendTo( $( "#elementList" ) );
    updateListItemData( myClone, order );
    updateNumbers();
    registerCustomtizeHandlers();
});



// validate and submit form. Currently, questions are valid with 0 elements.
    function submitForm( target ) {
        if ( formFieldsValid() ) {
            $( '#nextAction' ).val( target );
            $( '#elementForm' ).submit();
        } else {
            bootbox.alert( 'One or more elements is missing a name.' );
        }
    }

    function numberOfElements() {
        return $( '#elementForm' ).find( '[id^="elementName"]' ).length;
    }

    function formFieldsValid() {
        var valid = true;
        var $names = $( '#elementForm' ).find( '[id^="elementName"]' );
        $names.each( function () {
            if ( $( this ).val() == '' ) {
                valid = false;
            }
        } );
        return valid;
    }

    // clear local storage to dump Sortable data - or it may display items out of order
    localStorage.clear();
    // magic 4 for now... this could change if given as an option
    var numValences = 4;
    // set up Sortable list
    var eList = document.getElementById( 'elementList' );
    var editableList = Sortable.create( eList, {
        filter: '.js-remove',
        animation: 150,
        handle: '.handle',
        ghostClass: 'sortable-ghost',
        onFilter: function ( evt ) {
            var el = editableList.closest( evt.item ); // get dragged item

            // show warning message on delete
            bootbox.dialog( {
                className: 'confirmationModal',
                message: "<span class='glyphicon glyphicon-warning-sign'></span> " +
                "Warning: This will delete any scores associated with this element",
                title: "Delete Element",
                buttons: {
                    success: {
                        label: 'Cancel',
                        className: "cancelDelete btn-sm btn-default",
                        callback: function () {
                        }
                    },
                    danger: {
                        label: '<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Delete',
                        className: "confirmDelete btn-danger btn-sm",
                        callback: function () {
                            deleteElement( el );
                        }
                    }
                }
            } );
        },
        store: {
            // store the ordering to localStorage
            get: function ( sortable ) {
                var order = localStorage.getItem( sortable.options.group );
                return order ? order.split( '|' ) : [];
            },
            set: function ( sortable ) {
                var order = sortable.toArray();
                localStorage.setItem( sortable.options.group, order.join( '|' ) );
                updateNumbers();
            }
        }
    } );

    // 'Customize responses': Copy base response into empty comments
    function registerCustomtizeHandlers() {
        $( "[id^='commentForm']" ).on( 'shown.bs.modal', function () {
            // find closest elementText and copy to all blank valences
            var parent = $( this ).closest( "[id^='elementItem']" );
            var elementText = $( parent ).find( "[id^='elementText']" ).val();

            for ( var i = 0; i < numValences; i ++ ) {
                var valenceText = $( parent ).find( "[name$='valence" + i + "']" );
                if ( valenceText.val() == '' ) {
                    valenceText.val( elementText );
                }
            }
        } );
    }

    registerCustomtizeHandlers();


    // update all elements
    function updateNumbers() {

        $( '#elementForm' ).find( "[id^='elementItem']" ).each( function ( index, el ) {
            updateListItemData( el, (index + 1) );
        } );
    }

    // set all relevant names and ids of [item] to value [order]
    function updateListItemData( item, order ) {
        $( item ).attr( 'id', 'elementItem' + order );
        $( item ).find( '#displayNumber' ).text( 'Element #' + (order) );
        $( item ).find( "[id^='elementName']" ).attr( 'id', 'elementName' + order );
        $( item ).find( "[id^='elementName']" ).attr( 'name', 'elementName' + order );
        $( item ).find( "[id^='elementText']" ).attr( 'id', 'elementText' + order );
        $( item ).find( "[id^='elementText']" ).attr( 'name', 'elementText' + order );
        $( item ).find( '#elementId' ).attr( 'name', 'elementId' + order );

        // update customizeResponse button and set which modal it opens
        $( item ).find( "[id^='btnCustomizeResponse']" ).attr( 'id', 'btnCustomizeResponse' + order );
        $( item ).find( "[id^='btnCustomizeResponse']" ).attr( 'data-target', '#commentForm' + order );

        // update items within comment_form
        $( item ).find( "[id^='commentForm']" ).attr( 'id', 'commentForm' + order );

        for ( var i = 0; i < numValences; i ++ ) {
            $( item ).find( '#tab' + i ).attr( 'href', '#e' + order + "area" + i );
            var toFind = 'valence' + i;
            $( item ).find( "[id$='area" + i + "']" ).attr( 'id', 'e' + order + 'area' + i );
            $( item ).find( "[name$='" + toFind + "']" ).attr( 'name', "e" + order + toFind );
        }
    }

    function getElementCount() {
        return $( 'elementForm' ).find( "[id^='elementItem']" ).length;
    }

    function deleteElement( el ) {
        if ( el && el.parentNode.removeChild( el ) )
            updateNumbers();
        if ( ! numberOfElements() )
            bootbox.alert( 'A question can have no elements, however, students will not ' +
                'receive written feedback' );
    }
})();