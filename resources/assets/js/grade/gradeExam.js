// (function () {
    // alert('aa');
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

var letterGradeButton = require( './letterGradeButton.js' )();

var Roster = require('./components/Roster.js');
var Dashboard = require('./components/Dashboard.js');
var AjaxHandler = require('./components/AjaxHandler.js');

var Timer = require('./components/Timer.js');
var SearchBox = require('./components/SearchBox.js');

var SliderTools = require('./components/SliderTools.js');



    /* initialize Sliders with valenceCutoffs */
    var $sliders = $( 'input.slider' ).slider( {
        tooltip: 'show',
        value: 0,
        step: SliderTools.settings.sliderStep,
        ticks: SliderTools.settings.valenceCutoffs,
        ticks_labels: SliderTools.settings.valenceLabels,
        ticks_position: SliderTools.settings.valenceLabels
    } );

    /* -------------------------------- GENERAL FUNCTIONS ------------------------------ */


    /**
     * Called when an element slider stops movement. Updates element
     * score and text (if necessary), then saves score, text and time
     * @param slideEvt
     */
    function handleElementSliderStopEvent( slideEvt, data, SliderTools, Roster, AjaxHandler, Dashboard ) {
        // update the element's score visually and in elementScores[]
        var elementNumber = $( slideEvt.target ).closest( '[id^="element"]' ).attr( 'data-element-index' );
        var oldScore = data.elementScores[ Roster.activeStudent ][ elementNumber ];
        var newScore = slideEvt.value;

        data.elementScores[ Roster.activeStudent ][ elementNumber ] = newScore;

        // update comment text -- only replace text if the score has changed valence regions
        var $parent = $( this ).parents( '[id^="element"]' );
        var $elementComment = $parent.find( 'textArea' );
        if ( SliderTools.getValence( newScore ) != SliderTools.getValence( oldScore ) ) {
            // Score is in a new valence region.
            // plug in the appropriate comment text and save to DB
            var stockResponse = data.stockComments[ elementNumber ][ SliderTools.getValence( newScore ) ];
            $elementComment.val( stockResponse );
            AjaxHandler.updateAndSaveComment( $elementComment, data, Roster  );
        } else {
            // Score is in the same valence region.
            // Jump straight to saving without changing the elementComment
            var elementId = $( this ).closest( '[id^="element"]' ).attr( 'data-element-id' );
            AjaxHandler.createGradeRequest( 'element_id', elementId, newScore, null,  Roster  );
        }

        // If using bell curve (standardScoring), element score affects the total question score, so update
        if ( Roster.standardScoring ) {
            updateStandardScores();
        }

        updateStudentDataArea( data, Dashboard, Roster );
        Timer.resumeTimerIfPaused(data, Roster, Dashboard);
    }

    /**
     * Bulk function updates all the dependent data in the roster area.
     * @param data
     * @param Dashboard
     * @param Roster
     */
    function updateStudentDataArea( data, Dashboard, Roster ) {
        Dashboard.updateExamGrades( data );
        Dashboard.updateGradedRemainingCounter( data );
        Roster.updateRosterGradeDisplay( data );
        Roster.setStudentBackgroundColors( data );
    }

    /**
     * Handle question score inputs. When focus is lost, store values,
     * update grades and save timers.
     *
     * @param me Context from bound input
     */
    function handleQuestionScoreChange( me, data, Roster, AjaxHandler ) {
        var qNumber = $( me ).attr( 'data-number' );
        var score = parseFloat( $( me ).val() );
        var maxScore = parseFloat( $( me ).attr( 'max' ) );
        if ( score > maxScore ) {
            score = maxScore;
            $( me ).val( maxScore );
        }
        data.questionScores[ Roster.activeStudent ][ qNumber - 1 ] = score;
        var questionAssId = $( me ).attr( 'data-question-assignment-id' );

        if ( score >= 0 ) {
            AjaxHandler.createGradeRequest( 'question_assignment_id', questionAssId, score, null, Roster );
        } else {
            AjaxHandler.deleteScoreRequest( questionAssId, Roster );
        }
    }


    /**
     * A student is selected from the roster - DO LOTS OF STUFF
     * @param row
     * @param data
     * @param Timer
     * @param Roster
     */
    function onStudentSelect( row, data, Timer, Roster, AjaxHandler, Dashboard ) {
        alert('ss');
        Timer.saveTimer( data, Roster, AjaxHandler, Dashboard );

        $( '#selectPrompt' ).hide();
        $( '#questionArea' ).show( "fast" );

        // set the active student
        Roster.activeStudent = $( row ).attr( "data-index" );
        Roster.setSelectedNameAndId();
        Roster.setActiveStudentBackgroundColor(data);

        // load the timer area with new values
        Timer.loadTimer( data, Roster, Dashboard );

        // set question scores
        $( "[id^='questionScore']" ).each( function ( index ) {
            var score = data.questionScores[ Roster.activeStudent ][ index ];
            $( this ).val( score );
        } );

        // set slider values, if any exist
        if ( $sliders ) {
            $sliders.each( function ( index, item ) {
                var score = data.elementScores[ Roster.activeStudent ][ index ];
                $( item ).slider( 'setValue', score );
            } );
        }

        // set comments
        $( '[name^="commentQ"]' ).each( function ( index ) {
            var thisComment = data.elementComments[ Roster.activeStudent ][ index ];
            // if NULL, disable comment text area until a slider is moved.
            if ( data.elementScores[ Roster.activeStudent ][ index ] === null ) {
                $( this ).prop( 'readonly', 'true' );
            } else {
                $( this ).val( thisComment );
            }
        } );

    }

    /**
     * sums elements scores and sets question scores - will be used for StandardScoring
     */
    function updateStandardScores() {
        //
    }


    // -------------------------------------- Document Ready -------------------------------------


    // set up typeahead [search] boxes for name and ID
    $( '#activeStudentName' ).typeahead( {
        source: SearchBox.studentNames
    } );

    $( '#activeStudentIdentifier' ).typeahead( {
        source: SearchBox.studentIdents
    } );

    //Listeners
    $( "#nameVisibilityControl" ).on( 'click', function () {
        Roster.toggleNameVisibility();
    } );

    $( "#activeStudentName" ).on( 'change', function () {
        SearchBox.handleStudentNameSearch();
    } );

    $( "#activeStudentIdentifier" ).on( 'change', function () {
        SearchBox.handleStudentIdentifierSearch();
    } );

    $( "#btnTimer" ).on( 'click', function () {
        Timer.toggleTimer( data, Roster, Dashboard );
    } );

    // $( "#studentListItem1" ).on( 'click', function () {

        $( "[id^='studentListItem']" ).on( 'click', function () {
        alert('sli');
        onStudentSelect( this, data, Timer, Roster, AjaxHandler, Dashboard );
    } );

    $( '[id^="questionScore"]' ).bind( 'change', function () {
        // Handle question score inputs. When focus is lost, store values,
        // update grades and save timers.
        handleQuestionScoreChange( this, data, Roster, AjaxHandler );
        updateStudentDataArea( data, Dashboard, Roster );
        Timer.resumeTimerIfPaused( data, Roster, Dashboard );
    } );

    /**
     * Handle changes to the comment TextArea when focus is lost. Saves data and timers.
     */
    $( '[name^="comment"]' ).focusout( function () {
        if ( Roster.activeStudent === null ) return;
        AjaxHandler.updateAndSaveComment( $( this ) );
        //saveTimer();
        Timer.resumeTimerIfPaused( data, Roster, Dashboard );
    } );


    /* When an element slider stops movement,
     update element score and text (if necessary),
     then save score, text and time
     *  */
    $( 'input.slider' ).on( 'slideStop', function ( slideEvt ) {
        handleElementSliderStopEvent( slideEvt, data, SliderTools, Roster, AjaxHandler, Dashboard );
    } );

    updateStudentDataArea( data, Dashboard, Roster );
    Roster.sortRosterBy( 'studentName' );
    Timer.updateTimer( data, Roster, Dashboard );

    Dashboard.updateExamGrades( data );

// ---------------------------------- end onload
// alert('zz');
// });
// })();

