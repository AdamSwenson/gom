/**
 * Created by ars62917 on 11/2/15.
 */


function bindLetterGradeHandler() {
    window.console.log('bind letter grade called');
    $(".letterGradeButton").bind('click', function()
    {
        handleLetterGradeClick(this);
    });

}

/**
 * Updates score by clicking on letter grade.
 *
 * Decided not to update the button text at this time because
 * would have to store the value both locally and on the server.
 */
function handleLetterGradeClick(dthis)
{
    //The value of the letter grade selected
    var gradeValue = $(dthis).attr('data-calc-value');

    //The letter grade
    var letterGrade = $(dthis).attr('data-display-value');

    //The field to update with the grade
    var gradeTarget = $(dthis).attr("data-target-id");

    //The id of the button to change to display letter grade
    var buttonTarget = $(dthis).attr("data-letter-grade-button-id");

    //The maximum score for the question
    var maxScore = $("#" + gradeTarget).attr("max");

    //The new score to record
    var newScore = (gradeValue * .01) * maxScore;

    //Store the grade locally (this will confuse people when they return)
    //  examGrades[activeStudent] = gradeText;
    //Update the button label with assigned grade
    // $("#" + buttonTarget).text(gradeText);\

    //Update the questionScore and trigger update event
    $("#" + gradeTarget).val(newScore).trigger('change');


    showGradePopOver(gradeTarget, letterGrade, gradeValue, maxScore);
}

function showGradePopOver(targetId, letterGrade, integerGrade, maxScore)
{
    var $target = $('#' + targetId);
    var floatGrade = integerGrade * 0.01;
    var total = floatGrade * maxScore;
    var message = "<p>" + letterGrade + " = " + integerGrade + "%<br/>" +
            maxScore + " * " + floatGrade + " = " + total + "</p>";

    //Make sure any previously attached tooltip is gone
    $target.tooltip('destroy');

    //Add a tooltip to the body and show it
    //Note: attached to body so won't float away on screen resize
    $target.tooltip({
        animation: true,
        container: 'body',
        html: true,
        trigger: 'manual',
        title: message
    }).tooltip('show');

    //Wait briefly and then attach a handler to destroy the tooltip when
    //the user clicks elsewhere.
    setTimeout(function() {
        $('body').on('click.tt', function () {
            $target.tooltip('destroy');
            //Then remove the event handler so other tooltips will fire
            $('body').off('click.tt');
        });
    }, 10);
}
