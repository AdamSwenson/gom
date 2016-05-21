/**
 * Created by ars62917 on 11/2/15.
 */

var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

module.exports = function() {


    /**
     * Updates score by clicking on letter grade.
     * Also displays tooltip explaining the calculation to the user
     *
     * Decided not to update the button text at this time because
     * would have to store the value both locally and on the server.
     *
     * @param dthis The this context of the event handler
     */
    function handleLetterGradeClick( dthis ) {
        //The value of the letter grade selected
        var gradeValue = $( dthis ).attr( 'data-calc-value' );

        //The letter grade
        var letterGrade = $( dthis ).attr( 'data-display-value' );

        //The field to update with the grade
        var gradeTarget = $( dthis ).attr( "data-target-id" );

        //The maximum score for the question
        var maxScore = $( "#" + gradeTarget ).attr( "max" );

        //The new score to record
        var newScore = Number((gradeValue * .01) * maxScore).toFixed(2);

        //Update the questionScore and trigger update event
        $( "#" + gradeTarget ).val( newScore ).trigger( 'change' );

        //Display tooltip explaining the calculation
        showGradePopOver( gradeTarget, letterGrade, gradeValue, maxScore );
    }

    /**
     * Creates a tooltip over the score box explaining the calculation done
     * by selecting the letter grade for the question. The tooltip should
     * automatically disappear upon clicking elsewhere on the page.
     * @param targetId String id of the score div to attach to
     * @param letterGrade String representation of the grade (e.g., 'A')
     * @param integerGrade Integer Value of the grade as an integer between 0 and 100
     * @param maxScore Integer Maximum score possible on the question
     */
    function showGradePopOver( targetId, letterGrade, integerGrade, maxScore ) {
        //What the tooltip will attach to
        var $target = $( '#' + targetId );

        //The decimal to be used in the displayed calculation message
        var floatGrade = Number( integerGrade * 0.01 ).toFixed( 2 );

        //The resulting total to be displayed in the calculation message
        var total = Number( floatGrade * maxScore ).toFixed( 2 );

        //The message to display
        var message = "<p>" + letterGrade + " = " + integerGrade + "%<br/>" +
            maxScore + " * " + floatGrade + " = " + total + "</p>";

        //Make sure any previously attached tooltip is gone
        $target.tooltip( 'destroy' );

        //Add a tooltip to the body and show it
        //Note: attached to body so won't float away on screen resize
        $target.tooltip( {
            animation: true,
            container: 'body',
            html: true,
            trigger: 'manual',
            title: message
        } ).tooltip( 'show' );

        //Wait briefly for the tooltip to initialize and display
        setTimeout( function () {
            //Attach a handler to the body to destroy the tooltip when the user clicks elsewhere.
            $( 'body' ).on( 'click.tt', function () {
                $target.tooltip( 'destroy' );
                //Then remove the event handler so other tooltips will fire
                $( 'body' ).off( 'click.tt' );
            } );
        }, 10 );
    }

    /**
     * Initializes the letter grade button stuff
     */
    //function bindLetterGradeHandler() {
    //    window.console.log( 'bind letter grade called' );
    (function(){
        $( ".letterGrade" ).bind( 'click', function () {
            handleLetterGradeClick( this );
        } );
    })();
}