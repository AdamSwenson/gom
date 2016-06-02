/**
 * Created by adam on 5/15/16.
 */

var $ = require('jquery');
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;
var AjaxHandler = require( './AjaxHandler.js' );

module.exports = {
    /*
     * Set valenceCutoffs for comments --  these represent the maximum value for each valence group.
     * Magic numbers for now, but will accept data from the server for valenceCutoffs, valenceLabels and valenceLabelPositions
     *
     */
    settings: {
        sliderStep: 0.25,
        valenceCutoffs: [ 0, 3.25, 6.75, 10 ],
        valenceLabels: [ "Missing", "Poor", "Fair", "Excellent" ],
        valenceLabelPositions: [ 0, 33, 67, 100 ]
    },

    /**
     * Returns which valence group a [score] belongs to by comparing with valenceCutoffs[]
     * i.e. a score > 0 and <= 2.5 will be in the 'poor' valence (1)
     * @param score
     * @returns {number}
     */
    getValence: function ( score ) {
        var valence = 0;
        var me = this;

        //TODO Decide what should do if this gets null for the score

        for ( var j = me.settings.valenceCutoffs.length - 2; j >= 0; j -- ) {
            if ( score > me.settings.valenceCutoffs[ j ] ) {
                valence = j + 1;
                break;
            }
        }
        return valence;
    },

    /**
     * Check whether the old and new scores have the same valence.
     * If they are, return true.
     * If not or if oldScore wasn't set, return false
     * @param oldScore
     * @param newScore
     * @returns {boolean}
     */
    isSameValence: function( oldScore, newScore){
        //if there was no old score, return false
        if(typeof oldScore == 'undefined' || oldScore == null){
            return false;
        }
        if( this.getValence( newScore ) != this.getValence( oldScore )){
            return false;
        }
        return true;
    },


    /**
     * Changes the text of the displayed comment
     * @param $comment
     * @param commentText
     */
    updateDisplayedComment : function ( $comment, commentText ) {
    //make writable
    $comment.removeAttr( 'readonly' );

    //set text
    $comment.val( commentText );
},


/**
     * Called when an element slider stops movement. Updates element
     * score and text (if necessary), then saves score, text and time
     * @param slideEvt
     */
    handleElementSliderStopEvent : function ( slideEvt, data, Roster, callback ) {


    //grab the info related to elements
    var $element = $( slideEvt.target ).closest( '[id^="element"]' );
    var $parent = $element.parents( '[id^="element"]' );
    var commentAreaId = $element.attr( 'data-comment-area-id' );
    var $elementComment = $( '#' + commentAreaId );
    var elementIndex = $element.attr( 'data-element-index' ); //the subtask number of the element
    var elementId = $element.attr( 'data-element-id' ); //the DB's id for the element

    //grab scores
    var oldScore = data.getElementScore( Roster.activeStudent, elementIndex );
    var score = slideEvt.value;

    /* ---------- update the element's score visually and in data.elementScores[] --------- */

    //store the new element score in the data object
    data.storeElementScore( Roster.activeStudent, elementIndex, score );


    /**
     * update comment text and save to DB.
     * Only replace text if the score has changed valence regions
     */
    if ( ! this.isSameValence( oldScore, score ) ) {
        //Score is in a new valence region.
        //So let's plug in the appropriate comment text and save to DB

        //Store comment text in data object
        //Dear Adam, make sure you read the doc for storeCommentText before fucking with
        //anything in these lines
        data.storeCommentText( Roster.activeStudent, elementIndex, $elementComment.val() );
        var commentText = data.getCommentText( Roster.activeStudent, elementIndex, this.getValence( score ) );

        //update display
        this.updateDisplayedComment( $elementComment, commentText );

        //send to the db
        AjaxHandler.saveComment( data, Roster, elementId, score, commentText );

    } else {
        // Score is in the same valence region.
        // Jump straight to saving without changing the elementComment
        // Fear not. Changes directly to the comment text will be handled elsewhere.
        AjaxHandler.createGradeRequest( data, 'element_id', elementId, score, null, Roster );
    }

    // If using bell curve (standardScoring), element score affects
    // the total question score, so update
    if ( Roster.standardScoring ) {
      //  updateStandardScores();
    }

    callback();
    // //Update dashboard and roster data displayed
    // updateStudentDashboardAndRosterAreas( data, Dashboard, Roster );
    // //Sigh. The user forgot to restart the timer. Do it for them
    // Timer.resumeTimerIfPaused( data, Roster, Dashboard );
}

};