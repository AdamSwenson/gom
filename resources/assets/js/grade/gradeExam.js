window.onload = function () {
    var $ = require( 'jquery' );
    window.$ = $;
    var jQuery = $;
    window.jQuery = jQuery;

    require( 'bootstrap' );

    var common = require( '../common.js' );
    var bootbox = require( 'bootbox' );

    var Slider = require( "../libraries/bootstrap-slider-modified.js" );

// //TODO figure out which typeahead to use
    var typeahead = require( '../libraries/bootstrap3-typeahead.min.js' );
    // var typeahead = require( '../libraries/typeahead.bundle.js' );

    var LetterGradeButton = require( './components/letterGradeButton.js' )();
    var Roster = require( './components/Roster.js' );
    var Dashboard = require( './components/Dashboard.js' );
    var AjaxHandler = require( './components/AjaxHandler.js' );
    var Timer = require( './components/Timer.js' );
    var SearchBox = require( './components/SearchBox.js' );
    var SliderTools = require( './components/SliderTools.js' );


    // /* -------------------------------- GENERAL FUNCTIONS ------------------------------ */


    /**
     * Called when an element slider stops movement. Updates element
     * score and text (if necessary), then saves score, text and time
     * @param slideEvt
     */
    function handleElementSliderStopEvent( slideEvt, data, SliderTools, Roster, AjaxHandler, Dashboard ) {
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
        if ( ! SliderTools.isSameValence( oldScore, score ) ) {
            //Score is in a new valence region.
            //So let's plug in the appropriate comment text and save to DB

            //Store comment text in data object
            //Dear Adam, make sure you read the doc for storeCommentText before fucking with
            //anything in these lines
            data.storeCommentText( Roster.activeStudent, elementIndex, $elementComment.val() );
            var commentText = data.getCommentText( Roster.activeStudent, elementIndex, SliderTools.getValence( score ) );

            //update display
            updateDisplayedComment( $elementComment, commentText );

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
            updateStandardScores();
        }

        //Update dashboard and roster data displayed
        updateStudentDashboardAndRosterAreas( data, Dashboard, Roster );
        //Sigh. The user forgot to restart the timer. Do it for them
        Timer.resumeTimerIfPaused( data, Roster, Dashboard );
    }


    /**
     * Changes the text of the displayed comment
     * @param $comment
     * @param commentText
     */
    function updateDisplayedComment( $comment, commentText ) {
        //make writable
        $comment.removeAttr( 'readonly' );

        //set text
        $comment.val( commentText );
    }

    /**
     * Bulk function updates all the dependent data in the roster area.
     * @param data
     * @param Dashboard
     * @param Roster
     */
    function updateStudentDashboardAndRosterAreas( data, Dashboard, Roster ) {
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
     * @param data
     * @param Roster
     * @param AjaxHandler
     */
    function handleQuestionScoreChange( me, data, Roster, AjaxHandler ) {
        var qNumber = $( me ).attr( 'data-number' );
        var questionIndex = qNumber - 1;
        var score = parseFloat( $( me ).val() );
        var maxScore = parseFloat( $( me ).attr( 'max' ) );
        if ( score > maxScore ) {
            score = maxScore;
            $( me ).val( maxScore );
        }
        data.storeQuestionScore( Roster.activeStudent, questionIndex, score );
        data.updateExamGrade( Roster.activeStudent );

        var questionAssId = $( me ).attr( 'data-question-assignment-id' );

        if ( score >= 0 ) {
            AjaxHandler.createGradeRequest( data, 'question_assignment_id', questionAssId, score, null, Roster );
        } else {
            AjaxHandler.deleteScoreRequest( questionAssId, Roster );
        }
    }

    function handleCommentFieldChange( dthis, data, AjaxHandler, Dashboard, Roster, Timer ) {
        //grab element and its properties
        var $element = $( dthis ).parents( '[id^="element"]' );
        var elementId = $element.attr( 'data-element-id' );
        var elementIndex = $element.attr( 'data-element-index' );
        var commentText = $( dthis ).val();

        data.storeCommentText( Roster.activeStudent, elementIndex, commentText );

        //TODO make sure that score being null doesn't overwrite actual score

        AjaxHandler.saveComment( data, Roster, elementId, null, commentText );
        Timer.resumeTimerIfPaused( data, Roster, Dashboard );
    }


    /**
     * A student is selected from the roster - DO LOTS OF STUFF
     * @param row
     * @param data
     * @param Timer
     * @param Roster
     */
    function onStudentSelect( row, data, Timer, Roster, AjaxHandler, Dashboard ) {
        Timer.saveTimer( data, Roster, AjaxHandler, Dashboard );

        $( '#selectPrompt' ).hide();
        $( '#questionArea' ).show( "fast" );

        // set the active student
        Roster.activeStudent = $( row ).attr( "data-index" );
        Roster.setSelectedNameAndId();
        Roster.setStudentBackgroundColors( data );
        // Roster.setActiveStudentBackgroundColor( data );

        // load the timer area with new values
        Timer.loadTimer( data, Roster, Dashboard );

        // set question scores
        $( "[id^='questionScore']" ).each( function ( index ) {
            var score = data.getQuestionScore( Roster.activeStudent, index );
            $( this ).val( score );
        } );

        // set slider values, if any exist
        var $sliders = $( 'input.slider' );
        if ( typeof $sliders != 'undefined' && $sliders ) {
            $sliders.each( function ( index, item ) {
                var score = data.getElementScore( Roster.activeStudent, index );
                //avoid causing an error when slider gets null as a value
                var modScore = score === null ? 0 : score;
                $( item ).slider( 'setValue', modScore );
            } );
        }

        // set comments
        $( '[name^="commentQ"]' ).each( function ( index ) {
            // var thisComment = data.elementComments[ Roster.activeStudent ][ index ];
            var elementScore = data.getElementScore( Roster.activeStudent, index );

            //TODO Add a test for the potential corner cases making the default null creates

            if ( elementScore === null ) {
                // clear any text that might have been left over from another user
                $( this ).val( '' );
                // if NULL, disable comment text area until a slider is moved.
                // this is so that the user doesn't enter custom text, move the slider,
                // and then see their custom text irreversibly wiped out.
                $( this ).prop( 'readonly', 'true' );
            } else {
                // It has already been scored, so retrieve and set the comment text
                var valence = SliderTools.getValence( elementScore );
                var thisComment = data.getCommentText( Roster.activeStudent, index, valence );
                $( this ).val( thisComment );
                //no need for it to remain read only
                $( this ).prop( 'readonly', '' );
            }
        } );

    }

    /*
     * The problem:
     * Add custom text to an element.
     * Switch to a different user.
     * Switch back to the first user
     * Go to the question where added text to element
     * ----> shows stock text
     * If reload page, will show custom text
     * */

    /**
     * sums elements scores and sets question scores - will be
     * used for StandardScoring
     */
    function updateStandardScores() {
        //
    }


    /* -------------------------------------- Listeners ------------------------------------ */

    /* ------------------ Timer listeners --------- */
    $( "#btnTimer" ).on( 'click', function () {
        Timer.toggleTimer( data, Roster, Dashboard );
    } );

    /* ------------------ Roster display and search listeners --------- */
    $( "#nameVisibilityControl" ).on( 'click', function () {
        Roster.toggleNameVisibility();
    } );

    // $( "#activeStudentName" ).on( 'change', function () {
    //     SearchBox.handleStudentNameSearch();
    // } );
    //
    // $( "#activeStudentIdentifier" ).on( 'change', function () {
    //     SearchBox.handleStudentIdentifierSearch();
    // } );

    /* ------------------ table sorting listeners --------- */
    $( "#nameHeader" ).on( 'click', function () {
        Roster.sortRosterBy( 'studentName', data );
    } );
    $( "#idHeader" ).on( 'click', function () {
        Roster.sortRosterBy( 'studentIdentifier', data );
    } );
    $( "#gradeHeader" ).on( 'click', function () {
        Roster.sortRosterBy( 'examGrade', data );
    } );

    /* ------------------ Student selection listeners --------- */
    $( "[id^='studentListItem']" ).on( 'click', function () {
        onStudentSelect( this, data, Timer, Roster, AjaxHandler, Dashboard );
    } );

    /* ------------------ Listeners for scores and other grade fields ------------------- */

    /**  Listener for changes to the question score field */
    $( '[id^="questionScore"]' ).bind( 'change', function () {
        // Handle question score inputs. When focus is lost, store values,
        // update grades and save timers.
        handleQuestionScoreChange( this, data, Roster, AjaxHandler );
        updateStudentDashboardAndRosterAreas( data, Dashboard, Roster );
        Timer.resumeTimerIfPaused( data, Roster, Dashboard );
    } );

    /** Handle changes to the comment TextArea when focus is lost. Saves data and timers. */
    $( '[name^="comment"]' ).focusout( function () {
        if ( ! Roster.isActiveStudent() ) return;
        handleCommentFieldChange( this, data, AjaxHandler, Dashboard, Roster, Timer );
    } );


    /* ----------------- slider listeners --------------- */
    /* When an element slider stops movement,
     update element score and text (if necessary),
     then save score, text and time
     *  */
    $( 'input.slider' ).on( 'slideStop', function ( slideEvt ) {
        SliderTools.handleElementSliderStopEvent( slideEvt, data, Roster, function(){
            //Update dashboard and roster data displayed
        updateStudentDashboardAndRosterAreas( data, Dashboard, Roster );
        //Sigh. The user forgot to restart the timer. Do it for them
        Timer.resumeTimerIfPaused( data, Roster, Dashboard );});
        // handleElementSliderStopEvent( slideEvt, data, SliderTools, Roster, AjaxHandler, Dashboard );
    } );


    $( document ).ready( function () {
        /**
         * Utility to give each slider a unique id
         * @returns {string}
         * @constructor
         */
        function Counter() {
            if ( ! Counter.i ) {
                Counter.i = 0;
            }
            Counter.i ++;
            return "Qs" + Counter.i;
        };

        /* initialize Sliders with valenceCutoffs */
        $.each( $( 'input.slider' ), function () {
            $( this ).slider( {
                tooltip: 'show',
                value: 0,
                step: SliderTools.settings.sliderStep,
                ticks: SliderTools.settings.valenceCutoffs,
                ticks_labels: SliderTools.settings.valenceLabels,
                ticks_position: SliderTools.settings.valenceLabels,
                id: Counter()
            } );
        } );

        var $sliders = $( 'input.slider' );


        // set up typeahead [search] boxes for name and ID
        SearchBox.initialize();
        $( '#activeStudentName' ).typeahead( {
            source: SearchBox.studentNames
        } );

        $( '#activeStudentIdentifier' ).typeahead( {
            source: SearchBox.studentIdents
        } );

        $( "#activeStudentName" ).on( 'change', function () {
            SearchBox.handleStudentNameSearch();
        } );

        $( "#activeStudentIdentifier" ).on( 'change', function () {
            SearchBox.handleStudentIdentifierSearch();
        } );

        /* ----------------- stuff to do at end of load --------------- */
        updateStudentDashboardAndRosterAreas( data, Dashboard, Roster );
        Roster.sortRosterBy( 'studentName' );
        Timer.updateTimer( data, Roster, Dashboard );
    } );
};

