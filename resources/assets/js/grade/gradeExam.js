var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;
require( 'bootstrap' );

var common = require( '../common.js' );
var bootbox = require( 'bootbox' );
//TODO figure out which typeahead to use
//var typeahead = require('../libraries/bootstrap3-typeahead.min.js');
var typeahead = require( '../libraries/typeahead.bundle.js' );

//var Slider = require( "bootstrap-slider" );
var Slider = require( "../libraries/bootstrap-slider-modified.js" );

//var mySlider = new Slider();
var letterGradeButton = require( './letterGradeButton.js' )();

(function () {

// studentNames supplies name data for the search box (typeahead)
    var $studentNames = $( '[id^="studentName"]' );
    var studentNames = [];
    $studentNames.each( function () {
        studentNames.push( $( this ).text() );
    } );

// studentIdents does the same for IDs
    var $studentIdents = $( '[id^="studentIdentifier"]' );
    var studentIdents = [];
    $studentIdents.each( function () {
        studentIdents.push( $( this ).text() );
    } );

    var numStudents = $studentNames.length;

    var activeStudent = null;
    var standardScoring = false;
    var sortAsc = true;
    var timer;
    var timerPaused = true;
    var studentNamesVisible = true;
    const nameHiddenString = "Name Hidden"; // text to show when student names are invisible
    const noActiveStudentString = "No Student Selected";
    var activeStudentTime;
    const activeStudentColor = '#337ab7';
    const gradedStudentColor = '#5cb85c';

    updateExamGrades();

//Controls
    $( "#nameVisibilityControl" ).on( 'click', function () {
        toggleNameVisibility();
    } );

    $( "#activeStudentName" ).on( 'change', function () {
        handleStudentNameSearch();
    } );

    $( "#activeStudentIdentifier" ).on( 'change', function () {
        handleStudentIdentifierSearch();
    } );

    $( "#btnTimer" ).on( 'click', function () {
        toggleTimer();
    } );

    $( "[id^='studentListItem']" ).on('click', function () {
        onStudentSelect(this);
    });

    /*
     * Set valenceCutoffs for comments --  these represent the maximum value for each valence group.
     * Magic numbers for now, but will accept data from the server for valenceCutoffs, valenceLabels and valenceLabelPositions
     *
     */
    var valenceCutoffs = [ 0, 3.25, 6.75, 10 ];
    var valenceLabels = [ "Missing", "Poor", "Fair", "Excellent" ];
    var valenceLabelPositions = [ 0, 33, 67, 100 ];
    var sliderStep = .25;

    /* initialize Sliders with valenceCutoffs */
    var $sliders = $( 'input.slider' ).slider( {
        tooltip: 'show',
        value: 0,
        step: sliderStep,
        ticks: valenceCutoffs,
        ticks_labels: valenceLabels,
        ticks_position: valenceLabels
    } );


    /*
     * GENERAL FUNCTIONS
     */

// Returns which valence group a [score] belongs to by comparing with valenceCutoffs[]
// i.e. a score > 0 and <= 2.5 will be in the 'poor' valence (1)
    function getValence( score ) {
        var valence = 0;
        for ( var j = valenceCutoffs.length - 2; j >= 0; j -- ) {
            if ( score > valenceCutoffs[ j ] ) {
                valence = j + 1;
                break;
            }
        }
        return valence;
    }

    /**
     * examGrades[] keeps a persistent total of the exam score for each student.
     * Exams without grades have a value of -1, because dealing with null and NaN is unpredictable across js and PHP.
     * This shouldn't be an issue, as the DB has no notion of exam grades, they're only used here as a shorthand
     * to store and quickly find information about the exam state.
     */
    function updateExamGrades() {
        for ( var i = 0; i < questionScores.length; i ++ ) {
            var totalScore = null;
            questionScores[ i ].forEach( function ( gradeEntry ) {
                if ( gradeEntry !== null && gradeEntry >= 0 ) {
                    if ( totalScore === null ) {
                        totalScore = 0;
                    }
                    totalScore += parseFloat( gradeEntry );
                }
            } );
            if ( totalScore != null ) examGrades[ i ] = totalScore.toPrecision( 3 );
            else {
                examGrades[ i ] = - 1;
            }
        }
    }

    /**
     * returns: # of exams graded
     * @returns {number}
     */
    function examsGraded() {
        var graded = 0;
        for ( var i = 0; i < examGrades.length; i ++ ) {
            if ( examGrades[ i ] >= 0 ) graded ++;
        }
        return graded;
    }

    /**
     * updates a comment locally and saves to server
     * @param $comment
     */
    function updateAndSaveComment( $comment ) {
        $comment.removeAttr( 'readonly' );
        var eleIndex = $comment.parents( '[id^="element"]' ).attr( 'data-element-index' );
        var elementId = $comment.parents( '[id^="element"]' ).attr( 'data-element-id' );
        var score = elementScores[ activeStudent ][ eleIndex ];
        elementComments[ activeStudent ][ eleIndex ] = $comment.val();

        createGradeRequest( 'element_id', elementId, score, $comment.val() );
    }

    /* Creates a key/value array GradeRequest to upload.
     * Params: dataType: the label for thing to be modified
     *      elementId: question or element ID to receive the update
     *      score: the score for the question or element
     *      comment: text of the comment to update. Null unless modifying an element comment.
     * Requests will only include non-null scores and comments
     */
    function createGradeRequest( dataType, dataId, score, comment ) {
        var gradeRequest = {};

        gradeRequest[ dataType ] = dataId;
        if ( score !== null ) {
            gradeRequest[ 'score' ] = score;
        }
        if ( comment !== null ) {
            gradeRequest[ 'comment_text' ] = comment;
        }
        gradeRequest[ 'student_id' ] = getActiveStudentId();

        saveDataWithTime( gradeRequest );
    }

    /**
     * add time info to the gradeRequest and pass to server
     * @param gradeRequest
     */
    function saveDataWithTime( gradeRequest ) {
        if ( ! gradeRequest ) {
            gradeRequest = {};
            gradeRequest[ 'student_id' ] = getActiveStudentId();
        }
        gradeRequest[ 'time' ] = examGradingTimes[ activeStudent ];
        var examId = $( 'h3' ).attr( 'data-exam-id' );

        $.ajax( {
            url: examId,
            data: gradeRequest,
            type: 'POST',
            success: function () {
                //console.log('success! ');
            },
            error: function () {
                showWarningMessage( "Error", "Sorry, there was a problem saving this exam!\nPlease try again." );
            },
            timeout: function () {
                showWarningMessage( 'No Response From Server', 'There was no response from the server. Either the server is down\n' +
                    'or you may be experiencing connection issues.' );
            }
        } );
    }

    function showWarningMessage( title, msg ) {
        msg = '<span class="glyphicon glyphicon-warning-sign text-danger" aria-hidden="true"></span> ' + msg;
        bootbox.dialog( {
            message: msg,
            title: title,
            buttons: {
                default: {
                    label: 'Cancel',
                    className: "btn-sm",
                    callback: function () {
                    }
                }
            }
        } );
    }

    function getActiveStudentId() {
        if ( activeStudent === null ) {
            return null;
        }
        else return $( '#studentListItem' + activeStudent ).attr( 'data-sid' );
    }

    /**
     * sets the activeStudentName and studentId fields
     */
    function setSelectedNameAndId() {
        var $student = $( '#studentListItem' + activeStudent );
        // only show names if set to visible
        var name = nameHiddenString;
        if ( studentNamesVisible ) {
            name = $student.attr( 'data-lName' ) + ", " + $student.attr( 'data-fName' );
        }
        // if no student has been selected, always display noActiveStudentString
        if ( ! activeStudent ) {
            name = noActiveStudentString;
        }
        var id = $student.data( 'student-identifier' );
        //$("#activeStudentName").text(name);
        $( "#activeStudentName" ).val( name );
        $( "#activeStudentIdentifier" ).val( id );
    }

    /**
     * When the pencil icon is selected, toggle visibility of roster names and selected name area
     */
    function toggleNameVisibility() {
        studentNamesVisible = ! studentNamesVisible;
        $( '[id^="studentListItem"]' ).each( function () {
            var nameToDisplay = nameHiddenString;
            if ( studentNamesVisible ) {
                nameToDisplay = $( this ).attr( 'data-lName' ) + ", " + $( this ).attr( 'data-fName' );
            }
            $( this ).find( '[id^="studentName"]' ).text( nameToDisplay );
        } );
        setSelectedNameAndId();
    }

    /**
     * update the "graded: xx remaining: xx" counters
     * also displays the "Save & Finish" button when remaining == 0
     */
    function updateGradedRemainingCounter() {
        var total = examGrades.length;
        var graded = examsGraded();
        var remaining = total - graded;
        $( "#graded" ).text( graded );
        $( "#remaining" ).text( remaining );
        if ( remaining === 0 ) {
            $( '#finishButton' ).show();
        }
    }

    /**
     * set the "grade" column in the student roster, or "--" if exam is not graded
     */
    function updateRosterGradeDisplay() {
        for ( var i = 0; i < examGrades.length; i ++ ) {
            if ( examGrades[ i ] >= 0 ) {
                $( '#examGrade' + i ).text( examGrades[ i ] );
            } else {
                // the student has no grade (val of -1)
                $( '#examGrade' + i ).text( '--' );
            }
        }
    }

    /**
     * set background colors in the student roster
     *  graded = green
     *  ungraded = white
     *  active = blue
     */
    function setStudentBackgroundColors() {
        for ( var i = 0; i < examGrades.length; i ++ ) {
            var name = "#studentListItem" + i;
            var item = $( '#studentRoster' ).find( name );
            if ( activeStudent == i ) {
                setRosterBackgroundColor( item, activeStudentColor, 'white' )
            } else if ( examGrades[ i ] >= 0 ) {
                setRosterBackgroundColor( item, gradedStudentColor, 'white' );
            } else {
                setRosterBackgroundColor( item, 'white', 'black' );
            }
        }
    }

    /**
     * set background for the student roster row that is selected
     */
    function setActiveStudentBackgroundColor() {
        if ( activeStudent ) {
            setStudentBackgroundColors(); // reset prev. selected student to it's color (white or green)
            var item = $( '#studentRoster' ).find( '#studentListItem' + activeStudent ); // set the activeStudent
            setRosterBackgroundColor( item, activeStudentColor, 'white' );
        }
    }

    /**
     * set color for a student roster row
     * @param item
     * @param backColor
     * @param textColor
     */
    function setRosterBackgroundColor( item, backColor, textColor ) {
        $( item ).find( '[class^="col"]' ).css( 'background-color', backColor );
        $( item ).css( 'color', textColor );
    }

    /**
     * bulk function updates all the dependent data in the roster area.
     */
    function updateStudentDataArea() {
        updateExamGrades();
        updateGradedRemainingCounter();
        updateRosterGradeDisplay();
        setStudentBackgroundColors();
    }

    /**
     * Sorts the StudentRoster by the clicked header. Sort order reverses with each press.
     * @param value
     */
    function sortRosterBy( value ) {
        var $roster = $( '#studentRosterBody' );
        $roster.append(
            $roster.find( '[id^="studentListItem"]' ).sort( function ( a, b ) {
                var i = $( a ).find( '[id^="' + value + '"]' );
                var j = $( b ).find( '[id^="' + value + '"]' );
                var result;
                if ( value == 'studentName' || value == 'studentIdentifier' ) {
                    result = $( i ).text().toUpperCase().localeCompare(
                        $( j ).text().toUpperCase() );
                } else {
                    // sort by exam grade
                    var gradeA = examGrades[ $( a ).attr( 'data-index' ) ];
                    var gradeB = examGrades[ $( b ).attr( 'data-index' ) ];
                    result = gradeA - gradeB;
                }
                // flip results if we're sorting in DESC
                if ( ! sortAsc ) {
                    result *= - 1;
                }
                return result;
            } )
        );
        sortAsc = ! sortAsc;
    }

// sums elements scores and sets question scores - will be used for StandardScoring
    function updateStandardScores() {
        //
    }

    /**
     * save timer for the active student and update the displays for avg time, total time, and time remaining
     */
    function saveTimer() {
        if ( activeStudent === null ) return;
        examGradingTimes[ activeStudent ] = activeStudentTime;
        saveDataWithTime( null );
        updateTimer();
    }

    /**
     * load timer for the active student and sets state to running
     */
    function loadTimer() {
        if ( activeStudent === null ) return;
        clearInterval( timer );
        $( '#btnTimerLabel' ).text( 'Running' );
        $( '#btnTimer' ).attr( 'class', 'btn btn-success' );
        $( '#btnTimerIcon' ).attr( 'class', 'glyphicon glyphicon-play' );
        timerPaused = false;

        // set a new timer to fire every second. Update examGradingTimes[]
        activeStudentTime = examGradingTimes[ activeStudent ];
        timer = setInterval( function () {
            examGradingTimes[ activeStudent ] = ++ activeStudentTime;
            updateTimer();
        }, 1000 );
    }

    /**
     * if the timer is paused, enable it
     */
    function resumeTimerIfPaused() {
        if ( timerPaused ) toggleTimer();
    }

    /**
     * toggle timer between running and paused state
     */
    function toggleTimer() {
        if ( activeStudent === null ) return;
        timerPaused = ! timerPaused;
        if ( timerPaused ) {
            $( '#btnTimerLabel' ).text( 'Paused' );
            $( '#btnTimer' ).attr( 'class', 'btn btn-warning' );
            $( '#btnTimerIcon' ).attr( 'class', 'glyphicon glyphicon-pause' );
            clearInterval( timer );
        } else {
            loadTimer();
        }
    }

    /**
     * Updates the statistics area. Called once per second by the timer.
     */
    function updateTimer() {
        var totalTime = 0;
        $.each( examGradingTimes, function ( index, value ) {
            totalTime += value;
        } );
        var avgTime = totalTime / ( (examsGraded() == 0) ? 1 : examsGraded() );
        var estTime = avgTime * numStudents;
        var timeRemaining = estTime - totalTime;

        if ( activeStudent ) {
            $( '#thisExamTime' ).text( convertSecondsToHHMMSS( examGradingTimes[ activeStudent ] ) );
        }
        $( '#avgTime' ).text( convertSecondsToHHMMSS( avgTime ) );
        $( '#totalTime' ).text( convertSecondsToHHMMSS( totalTime ) );
        $( '#timeRemaining' ).text( convertSecondsToHHMMSS( timeRemaining ) );
    }

    function convertSecondsToHHMMSS( seconds ) {
        var date = new Date( null );
        date.setSeconds( seconds );
        if ( seconds < 3600 ) return date.toISOString().substr( 14, 5 );
        else return date.toISOString().substr( 11, 8 );
    }

    /**
     * grab the name of the student, and perform a click on the appropriate row in the student roster
     */
    function handleStudentNameSearch() {
        var nameToFind = $( '#activeStudentName' ).val();
        var i = studentNames.indexOf( nameToFind );
        if ( i >= 0 ) {
            $( '#studentListItem' + i ).triggerHandler( 'click' );
        }
    }

    /**
     * do the same with ID search
     */
    function handleStudentIdentifierSearch() {
        var idToFind = $( '#activeStudentIdentifier' ).val();
        var i = studentIdents.indexOf( idToFind );
        $( "#activeStudentIdentifier" ).blur();
        if ( i >= 0 ) {
            $( '#studentListItem' + i ).triggerHandler( 'click' );
        }
    }

// -------------------------------------- Document Ready -------------------------------------
//$( document ).ready( function () {
    updateStudentDataArea();
    sortRosterBy( 'studentName' );
    updateTimer();

// set up typeahead [search] boxes for name and ID
    $( '#activeStudentName' ).typeahead( {
        source: studentNames
    } );

    $( '#activeStudentIdentifier' ).typeahead( {
        source: studentIdents
    } );

    /* When an element slider stops movement,
     update element score and text (if necessary),
     then save score, text and time
     *  */
    $( 'input.slider' ).on( 'slideStop', function ( slideEvt ) {

        // update the element's score visually and in elementScores[]
        var elementNumber = $( this ).closest( '[id^="element"]' ).attr( 'data-element-index' );
        var oldScore = elementScores[ activeStudent ][ elementNumber ];
        var newScore = slideEvt.value;

        elementScores[ activeStudent ][ elementNumber ] = newScore;

        // update comment text -- only replace text if the score has changed valence regions
        var $parent = $( this ).parents( '[id^="element"]' );
        var $elementComment = $parent.find( 'textArea' );
        if ( getValence( newScore ) != getValence( oldScore ) ) {
            // Score is in a new valence region.
            // plug in the appropriate comment text and save to DB
            var stockResponse = stockComments[ elementNumber ][ getValence( newScore ) ];
            $elementComment.val( stockResponse );
            updateAndSaveComment( $elementComment );
        } else {
            // Score is in the same valence region.
            // Jump straight to saving without changing the elementComment
            var elementId = $( this ).closest( '[id^="element"]' ).attr( 'data-element-id' );
            createGradeRequest( 'element_id', elementId, newScore, null );
        }

        // If using bell curve (standardScoring), element score affects the total question score, so update
        if ( standardScoring ) {
            updateStandardScores();
        }

        updateStudentDataArea();
        resumeTimerIfPaused();
    } );

// Handle question score inputs. When focus is lost, store values, update grades and save timers.
    $( '[id^="questionScore"]' ).bind( 'change', function () {
        var qNumber = $( this ).attr( 'data-number' );
        var score = parseFloat( $( this ).val() );
        var maxScore = parseFloat( $( this ).attr( 'max' ) );
        if ( score > maxScore ) {
            score = maxScore;
            $( this ).val( maxScore );
        }
        questionScores[ activeStudent ][ qNumber - 1 ] = score;
        var questionAssId = $( this ).attr( 'data-question-assignment-id' );

        if ( score >= 0 ) {
            createGradeRequest( 'question_assignment_id', questionAssId, score, null );
        } else {
            // delete the score
            var examId = $( 'h3' ).attr( 'data-exam-id' );
            var gradeRequest = {};
            gradeRequest[ 'question_assignment_id' ] = questionAssId;
            gradeRequest[ 'student_id' ] = getActiveStudentId();
            $.ajax( {
                url: examId,
                data: gradeRequest,
                type: 'DELETE',
                success: function () {
                },
                error: function () {
                    // Error...
                    //var errors = $.parseJSON(data.responseText);
                    //console.log(errors);
                    showWarningMessage( "Error", "Sorry, there was a problem saving this exam!\nPlease try again." );
                },
                timeout: function () {
                    showWarningMessage( 'No Response From Server', 'There was no response from the server. Either' +
                        ' the server is down\n or you may be experiencing connection issues.' );
                }
            } );
        }

        updateStudentDataArea();
        resumeTimerIfPaused();
    } );


//  Handle changes to the comment TextArea when focus is lost. Saves data and timers.
    $( '[name^="comment"]' ).focusout( function () {
        if ( activeStudent === null ) return;
        updateAndSaveComment( $( this ) );
        //saveTimer();
        resumeTimerIfPaused();
    } );

    /*
     * A student is selected from the roster - DO LOTS OF STUFF
     */
    function onStudentSelect(row){
    // $( "[id^='studentListItem']" ).on('click', function () {
        saveTimer();
        $( '#selectPrompt' ).hide();
        $( '#questionArea' ).show( "fast" );

        // set the active student
        activeStudent = $( row ).attr( "data-index" );
        setSelectedNameAndId();
        setActiveStudentBackgroundColor();

        // load the timer area with new values
        loadTimer();

        // set question scores
        $( "[id^='questionScore']" ).each( function ( index ) {
            var score = questionScores[ activeStudent ][ index ];
            $( this ).val( score );
        } );

        // set slider values, if any exist
        if ( $sliders ) {
            $sliders.each( function ( index, item ) {
                var score = elementScores[ activeStudent ][ index ];
                $( item ).slider( 'setValue', score );
            } );
        }

        // set comments
        $( '[name^="commentQ"]' ).each( function ( index ) {
            var thisComment = elementComments[ activeStudent ][ index ];
            // if NULL, disable comment text area until a slider is moved.
            if ( elementScores[ activeStudent ][ index ] === null ) {
                $( this ).prop( 'readonly', 'true' );
            } else {
                $( this ).val( thisComment );
            }
        } );

    // } );
}
//bindLetterGradeHandler();
//    return false;
//} );

    if (jQuery) {
        alert("jquery is loaded");
    } else {
        alert("Not loaded");
    }
})();