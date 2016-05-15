var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

require( 'bootstrap' );
var bootbox = require( 'bootbox' );
var Sortable = require( 'sortablejs' );
// var Sortable = require('../utilities/Sortable.js');
var common = require( '../common.js' );

//var navs = require('./navControls.js')();

// (function () {
        $( "#backNavButton" ).on( 'click', function () {
            submitForm( backNavTarget );
        } );

        $( "#forwardNavButton" ).on( 'click', function () {
            submitForm( forwardNavTarget );
        } );

// handle addQuestion button
        $( "#addQuestion" ).on( 'click', function () {
            // copy empty form
            var order = getQuestionCount() + 1;
            var myClone = $( '#questionItem0' ).clone();

            // add to editableList and refresh
            myClone.appendTo( $( "#questionList" ) );
            updateListItemData( myClone, order );
            updateNumbers();
        } );


// Basic form validation and prompts.
// Exams must have 1 question and they must all have names.
        function submitForm( targetForm ) {
            if ( numberOfQuestions() == 0 ) {
                bootbox.alert( 'Exams must have at least one question.' );
            } else if ( formFieldsValid() ) {
                $( '#nextAction' ).val( targetForm );
                $( '#questionForm' ).submit();
            }
        }

        function numberOfQuestions() {
            return $( '#questionForm' ).find( '[id^="questionName"]' ).length;
        }

        function formFieldsValid() {
            var msg = '';
            var valid = true;
            var $names = $( '#questionForm' ).find( '[id^="questionName"]' );
            $names.each( function () {
                if ( $( this ).val() == '' ) {
                    valid = false;
                    msg = 'One or more questions is missing a name.';
                }
            } );
            var $maxScores = $( '#questionForm' ).find( '[id^="maxScore"]' );
            $maxScores.each( function () {
                if ( $( this ).val() == '' ) {
                    valid = false;
                    msg = 'One or more questions is missing a maximum score.'
                }
            } );

            if ( ! valid ) {
                bootbox.alert( msg );
            }

            return valid;
        }

/**
 * Handle deletion - items will be deleted once the form is submitted
 * This is actually listening for an attempt to drag a filtered element.
 * It fires on mousedown, so it is practically equivalent to a click.
 *
 * evt.item is HTMLElement receiving the `mousedown|tapstart` event.
 *
 * @param evt
 */
function handleDelete(evt, editableList){
    //get the element from the list
    var el = editableList.closest( evt.item );

    bootbox.dialog( {
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

}

(function(){
// Sortable is the lib for drag and drop questions
// create an editable list and set up some filters to handle callbacks
$(document).ready(function () {

        localStorage.clear();
        var qList = document.getElementById( 'questionList' );
        var editableList = Sortable.create( qList, {
            filter: '.js-remove', // Selectors that do not lead to dragging (String or Function)
            animation: 150,
            handle: '.handle',  // Drag handle selector within list items
            ghostClass: "sortable-ghost", // Class name for the drop placeholder

            onFilter: function ( evt ) {
                handleDelete(evt, editableList);
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

    // $(".js-remove").on('click', function(){
    //
    //     var el = $(this);
    //
    //     bootbox.dialog( {
    //         message: "<p class='questionDeleteWarning' id='questionDeleteWarning'> <span class='glyphicon glyphicon-warning-sign'></span>" +
    //         " Warning: This will permanently delete all elements and scores associated with the question </p>",
    //         title: "Delete Question",
    //         buttons: {
    //             success: {
    //                 label: 'Cancel',
    //                 className: "btn-sm bnt-primary cancelQuestionDelete",
    //                 callback: function () {
    //                 }
    //             },
    //             danger: {
    //                 label: '<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Delete',
    //                 className: "btn-danger btn-sm confirmQuestionDelete",
    //                 callback: function () {
    //                     if ( el )
    //                         window.console.log(el);
    //                         var questionNumber = el.data('question-number');
    //
    //                         var parent = $("#questionItem" + questionNumber)
    //                         parent.remove();
    //                     // if ( el && el.parentNode.removeChild( el ) )
    //                         updateNumbers();
    //                 }
    //             }
    //         }
    //     });
    // });

});
})();
// update all "questionItem" ids. These define the ordering when saved to the DB.
        function updateNumbers() {
            $( '#questionForm' ).find( "[id^='questionItem']" ).each( function ( index, el ) {
                updateListItemData( el, (index + 1) );
            } );
        }

// set all relevant names and ids of [item] to value [order]
        function updateListItemData( item, order ) {
            $( item ).attr( 'id', 'questionItem' + order );
            $( item ).find( '#displayNumber' ).text( 'Question #' + (order) );
            $( item ).find( "[id^='questionName']" ).attr( 'id', 'questionName' + order );
            $( item ).find( "[id^='questionName']" ).attr( 'name', 'questionName' + order );
            $( item ).find( 'textarea' ).attr( 'id', 'questionText' + order );
            $( item ).find( 'textarea' ).attr( 'name', 'questionText' + order );
            $( item ).find( '#questionId' ).attr( 'name', 'questionId' + order );
            $( item ).find( "[id^='maxScore']" ).attr( 'id', 'maxScore' + order );
            $( item ).find( "[id^='maxScore']" ).attr( 'name', 'maxScore' + order );

        }

        function getQuestionCount() {
            // return number of questions currently in the questionList
            return $( "[id^='questionItem']" ).length;
        }

//        return false;
//     }
// );