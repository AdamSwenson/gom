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

(function () {

    var Roster = {
        activeStudent: null,
        activeStudentTime: null,

        standardScoring: false,

        sortAsc: true,
        studentNamesVisible: true,
        nameHiddenString: "Name Hidden", // text to show when student names are invisible
        noActiveStudentString: "No Student Selected",
        activeStudentColor: '#337ab7',
        gradedStudentColor: '#5cb85c',

        /**
         * Returns the id of the student currently being graded
         * @returns {*}
         */
        getActiveStudentId: function () {
            if ( this.activeStudent === null ) {
                return null;
            }
            else {
                return $( '#studentListItem' + this.activeStudent ).attr( 'data-sid' );
            }
        },

        /**
         * sets the activeStudentName and studentId fields
         */
        setSelectedNameAndId: function () {
            var $student = $( '#studentListItem' + this.activeStudent );
            // only show names if set to visible
            var name = this.nameHiddenString;
            if ( this.studentNamesVisible ) {
                name = $student.attr( 'data-lName' ) + ", " + $student.attr( 'data-fName' );
            }
            // if no student has been selected, always display noActiveStudentString
            if ( ! this.activeStudent ) {
                name = this.noActiveStudentString;
            }
            var id = $student.data( 'student-identifier' );
            //$("#activeStudentName").text(name);
            $( "#activeStudentName" ).val( name );
            $( "#activeStudentIdentifier" ).val( id );
        },


        /**
         * When the pencil icon is selected, toggle visibility of roster names and selected name area
         */
        toggleNameVisibility: function () {
            this.studentNamesVisible = ! this.studentNamesVisible;
            var me = this;
            $( '[id^="studentListItem"]' ).each( function () {
                var nameToDisplay = me.nameHiddenString;
                if ( me.studentNamesVisible ) {
                    nameToDisplay = $( this ).attr( 'data-lName' ) + ", " + $( this ).attr( 'data-fName' );
                }
                $( this ).find( '[id^="studentName"]' ).text( nameToDisplay );
            } );
            setSelectedNameAndId();
        },

        /**
         * set the "grade" column in the student roster, or "--" if exam is not graded
         */
        updateRosterGradeDisplay: function ( data ) {
            for ( var i = 0; i < data.examGrades.length; i ++ ) {
                if ( data.examGrades[ i ] >= 0 ) {
                    $( '#examGrade' + i ).text( data.examGrades[ i ] );
                } else {
                    // the student has no grade (val of -1)
                    $( '#examGrade' + i ).text( '--' );
                }
            }
        },

        /**
         * set background colors in the student roster
         *  graded = green
         *  ungraded = white
         *  active = blue
         */
        setStudentBackgroundColors: function ( data ) {
            var me = this;
            for ( var i = 0; i < data.examGrades.length; i ++ ) {
                var name = "#studentListItem" + i;
                var item = $( '#studentRoster' ).find( name );
                if ( activeStudent == i ) {
                    me.setRosterBackgroundColor( item, me.activeStudentColor, 'white' )
                } else if ( data.examGrades[ i ] >= 0 ) {
                    me.setRosterBackgroundColor( item, me.gradedStudentColor, 'white' );
                } else {
                    me.setRosterBackgroundColor( item, 'white', 'black' );
                }
            }
        },

        /**
         * set background for the student roster row that is selected
         */
        setActiveStudentBackgroundColor: function ( activeStudent ) {
            if ( activeStudent ) {
                this.setStudentBackgroundColors(); // reset prev. selected student to it's color (white or green)
                var item = $( '#studentRoster' ).find( '#studentListItem' + activeStudent ); // set the activeStudent
                this.setRosterBackgroundColor( item, this.activeStudentColor, 'white' );
            }
        },

        /**
         * set color for a student roster row
         * @param item
         * @param backColor
         * @param textColor
         */
        setRosterBackgroundColor: function ( item, backColor, textColor ) {
            $( item ).find( '[class^="col"]' ).css( 'background-color', backColor );
            $( item ).css( 'color', textColor );
        },

        /**
         * Sorts the StudentRoster by the clicked header. Sort order reverses with each press.
         * @param value
         */
        sortRosterBy: function ( value ) {
            var me = this;
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
                    if ( ! me.sortAsc ) {
                        result *= - 1;
                    }
                    return result;
                } )
            );
            me.sortAsc = ! me.sortAsc;
        }

    };


    var SliderTools = {
        /*
         * Set valenceCutoffs for comments --  these represent the maximum value for each valence group.
         * Magic numbers for now, but will accept data from the server for valenceCutoffs, valenceLabels and valenceLabelPositions
         *
         */
        settings: {
            valenceCutoffs: [ 0, 3.25, 6.75, 10 ],
            valenceLabels: [ "Missing", "Poor", "Fair", "Excellent" ],
            valenceLabelPositions: [ 0, 33, 67, 100 ],
            sliderStep: .25
        },

        /**
         * Returns which valence group a [score] belongs to by comparing with valenceCutoffs[]
         * i.e. a score > 0 and <= 2.5 will be in the 'poor' valence (1)
         * @param score
         * @returns {number}
         */
        getValence: function ( score ) {
            var valence = 0;
            for ( var j = this.settings.valenceCutoffs.length - 2; j >= 0; j -- ) {
                if ( score > this.settings.valenceCutoffs[ j ] ) {
                    valence = j + 1;
                    break;
                }
            }
            return valence;
        }
    }


    /**
     * Responsible for managing and displaying grading statistics
     * @type {{updateExamGrades: Dashboard.updateExamGrades, examsGraded: Dashboard.examsGraded, updateGradedRemainingCounter: Dashboard.updateGradedRemainingCounter}}
     */
    var Dashboard = {

        /**
         * examGrades[] keeps a persistent total of the exam score for each student.
         * Exams without grades have a value of -1, because dealing with null and NaN is unpredictable across js and PHP.
         * This shouldn't be an issue, as the DB has no notion of exam grades, they're only used here as a shorthand
         * to store and quickly find information about the exam state.
         */
        updateExamGrades: function ( data ) {
            for ( var i = 0; i < data.questionScores.length; i ++ ) {
                var totalScore = null;
                data.questionScores[ i ].forEach( function ( gradeEntry ) {
                    if ( gradeEntry !== null && gradeEntry >= 0 ) {
                        if ( totalScore === null ) {
                            totalScore = 0;
                        }
                        totalScore += parseFloat( gradeEntry );
                    }
                } );
                if ( totalScore != null ) data.examGrades[ i ] = totalScore.toPrecision( 3 );
                else {
                    data.examGrades[ i ] = - 1;
                }
            }
        },

        /**
         * returns: # of exams graded
         * @returns {number}
         */
        examsGraded: function ( data ) {
            var graded = 0;
            for ( var i = 0; i < data.examGrades.length; i ++ ) {
                if ( data.examGrades[ i ] >= 0 ) graded ++;
            }
            return graded;
        },

        /**
         * update the "graded: xx remaining: xx" counters
         * also displays the "Save & Finish" button when remaining == 0
         */
        updateGradedRemainingCounter: function ( data ) {
            var total = data.examGrades.length;
            var graded = this.examsGraded( data );
            var remaining = total - graded;
            $( "#graded" ).text( graded );
            $( "#remaining" ).text( remaining );
            if ( remaining === 0 ) {
                $( '#finishButton' ).show();
            }
        }

    };


    /**
     * Responsible for all ajax server interactions
     * @type {{me: *, messages: {serverErrorTitle: string, serverErrorText: string, serverTimeoutTitle: string, serverTimeoutText: string}, updateAndSaveComment: AjaxHandler.updateAndSaveComment, createGradeRequest: AjaxHandler.createGradeRequest, saveDataWithTime: AjaxHandler.saveDataWithTime, deleteScoreRequest: AjaxHandler.deleteScoreRequest, showWarningMessage: AjaxHandler.showWarningMessage}}
     */
    var AjaxHandler = {
        /**
         * All messages which may be displayed to the
         * user in alerts or modals
         * @type {{}}
         */
        messages: {
            serverErrorTitle: "Error",
            serverErrorText: "<p class='errorText errorMessage'>Sorry, there was a problem saving this exam! <br /> Please try again.</p>",

            serverTimeoutTitle: 'No Response From Server',
            serverTimeoutText: "<p class='errorText timeoutMessage'>There was no response from the server. Either the server is down <br/> or you may be experiencing connection issues.</p>",
        },

        /**
         * updates a comment locally and saves to server
         * @param $comment
         */
        updateAndSaveComment: function ( $comment, data, Roster ) {
            $comment.removeAttr( 'readonly' );
            var eleIndex = $comment.parents( '[id^="element"]' ).attr( 'data-element-index' );
            var elementId = $comment.parents( '[id^="element"]' ).attr( 'data-element-id' );
            var score = data.elementScores[ Roster.activeStudent ][ eleIndex ];
            data.elementComments[ Roster.activeStudent ][ eleIndex ] = $comment.val();

            this.createGradeRequest( 'element_id', elementId, score, $comment.val(), Roster );
        },

        /**
         * Creates a key/value array GradeRequest to upload.
         * Params: dataType: the label for thing to be modified
         *      elementId: question or element ID to receive the update
         *      score: the score for the question or element
         *      comment: text of the comment to update. Null unless modifying an element comment.
         * Requests will only include non-null scores and comments
         */
        createGradeRequest: function ( dataType, dataId, score, comment, Roster ) {
            var gradeRequest = {};

            gradeRequest[ dataType ] = dataId;
            if ( score !== null ) {
                gradeRequest[ 'score' ] = score;
            }
            if ( comment !== null ) {
                gradeRequest[ 'comment_text' ] = comment;
            }
            gradeRequest[ 'student_id' ] = Roster.getActiveStudentId();

            this.saveDataWithTime( gradeRequest, data, Roster );
        },

        /**
         * add time info to the gradeRequest and pass to server
         * @param gradeRequest
         */
        saveDataWithTime: function ( gradeRequest, data, Roster ) {
            if ( ! gradeRequest ) {
                gradeRequest = {};
                gradeRequest[ 'student_id' ] = Roster.getActiveStudentId();
            }
            gradeRequest[ 'time' ] = data.examGradingTimes[ Roster.activeStudent ];
            var examId = $( 'h3' ).attr( 'data-exam-id' );

            $.ajax( {
                url: examId,
                data: gradeRequest,
                type: 'POST',
                success: function () {
                    //console.log('success! ');
                },
                error: function () {
                    this.showWarningMessage( this.messages.serverErrorTitle, this.messages.serverErrorText );
                },
                timeout: function () {
                    this.showWarningMessage( this.messages.serverTimeoutTitle, this.messages.serverTimeoutText );
                }
            } );
        },

        /**
         * Sends a request to delete a score
         * @param questionAssId
         * @param Roster
         */
        deleteScoreRequest: function ( questionAssId, Roster, ) {
            // delete the score
            var examId = $( 'h3' ).attr( 'data-exam-id' );
            var gradeRequest = {};
            gradeRequest[ 'question_assignment_id' ] = questionAssId;
            gradeRequest[ 'student_id' ] = Roster.getActiveStudentId();
            $.ajax( {
                url: examId,
                data: gradeRequest,
                type: 'DELETE',
                success: function () {
                },
                error: function () {
                    this.showWarningMessage( this.messages.serverErrorTitle, this.messages.serverErrorText );
                },
                timeout: function () {
                    AjaxHandler.showWarningMessage( this.messages.serverTimeoutTitle, this.messages.serverTimeoutText );
                }
            } );
        },

        /**
         * Displays a bootstrap warning modal
         * @param title
         * @param msg
         */
        showWarningMessage: function ( title, msg ) {
            msg = '<span class="glyphicon glyphicon-warning-sign text-danger" aria-hidden="true"></span> ' + msg;
            bootbox.dialog( {
                message: msg,
                title: title,
                buttons: {
                    default: {
                        label: 'Cancel',
                        className: "btn btn-sm btn-primary",
                        callback: function () {
                        }
                    }
                }
            } );
        }

    };


    /**
     * Controls the exam timer
     * @type {{me: *, timer: null, timerPaused: boolean, saveTimer: Timer.saveTimer, loadTimer: Timer.loadTimer, resumeTimerIfPaused: Timer.resumeTimerIfPaused, toggleTimer: Timer.toggleTimer, updateTimer: Timer.updateTimer, convertSecondsToHHMMSS: Timer.convertSecondsToHHMMSS}}
     */
    var Timer = {
        /** Holds the actual timer object once created */
        timer: null,
        /** Start in paused state */
        timerPaused: true,

        /**
         * Save timer for the active student and update the displays
         * for avg time, total time, and time remaining.
         * @param data
         * @param Roster
         * @param AjaxHandler
         */
        saveTimer: function ( data, Roster, AjaxHandler, Dashboard ) {
            if ( Roster.activeStudent === null ) return;
            data.examGradingTimes[ Roster.activeStudent ] = Roster.activeStudentTime;
            AjaxHandler.saveDataWithTime( null, data, Roster );
            this.updateTimer( data, Roster, Dashboard );
        },

        /**
         * Load timer for the active student and sets state to running
         * @param data
         * @param Roster
         */
        loadTimer: function ( data, Roster, Dashboard ) {
            if ( Roster.activeStudent === null ) return;
            clearInterval( this.timer );
            $( '#btnTimerLabel' ).text( 'Running' );
            $( '#btnTimer' ).attr( 'class', 'btn btn-success' );
            $( '#btnTimerIcon' ).attr( 'class', 'glyphicon glyphicon-play' );
            this.timerPaused = false;
            var me = this;

            // set a new timer to fire every second. Update examGradingTimes[]
            Roster.activeStudentTime = data.examGradingTimes[ Roster.activeStudent ];
            this.timer = setInterval( function () {
                data.examGradingTimes[ Roster.activeStudent ] = ++ Roster.activeStudentTime;
                me.updateTimer( data, Roster, Dashboard );
            }, 1000 );
        },

        /**
         * if the timer is paused, enable it
         */
        resumeTimerIfPaused: function ( data, Roster, Dashboard ) {
            if ( this.timerPaused ) this.toggleTimer( data, Roster, Dashboard );
        },

        /**
         * Toggle timer between running and paused state
         * @param data
         * @param Roster
         */
        toggleTimer: function ( data, Roster, Dashboard ) {
            if ( Roster.activeStudent === null ) return;
            this.timerPaused = ! this.timerPaused;
            if ( this.timerPaused ) {
                $( '#btnTimerLabel' ).text( 'Paused' );
                $( '#btnTimer' ).attr( 'class', 'btn btn-warning' );
                $( '#btnTimerIcon' ).attr( 'class', 'glyphicon glyphicon-pause' );
                clearInterval( this.timer );
            } else {
                this.loadTimer( data, Roster, Dashboard );
            }
        },

        /**
         * Updates the statistics area. Called once per second by the timer.
         * @param data
         * @param Roster
         * @param Dashboard
         */
        updateTimer: function ( data, Roster, Dashboard ) {
            var totalTime = 0;
            $.each( data.examGradingTimes, function ( index, value ) {
                totalTime += value;
            } );
            var avgTime = totalTime / ( (Dashboard.examsGraded( data ) == 0) ? 1 : Dashboard.examsGraded( data ) );
            var estTime = avgTime * data.numStudents;
            var timeRemaining = estTime - totalTime;

            if ( Roster.activeStudent ) {
                $( '#thisExamTime' ).text( this.convertSecondsToHHMMSS( data.examGradingTimes[ Roster.activeStudent ] ) );
            }
            $( '#avgTime' ).text( this.convertSecondsToHHMMSS( avgTime ) );
            $( '#totalTime' ).text( this.convertSecondsToHHMMSS( totalTime ) );
            $( '#timeRemaining' ).text( this.convertSecondsToHHMMSS( timeRemaining ) );
        },

        convertSecondsToHHMMSS: function ( seconds ) {
            if ( isNaN( seconds ) ) return "00:00:00";
            var date = new Date( null );
            date.setSeconds( seconds );
            if ( seconds < 3600 ) return date.toISOString().substr( 14, 5 );
            else return date.toISOString().substr( 11, 8 );
        }
    };

    //------------------------- Type ahead -----------------------
    var SearchBox = {
        /** studentNames supplies name data for the search box (typeahead) */
        studentNames: [],

        /** Student identifier data for the ID search box (typeahead) */
        studentIdents: [],

        /** Total number of students */
        numStudents: null,

        /**
         * grab the name of the student, and perform a click on the appropriate row in the student roster
         */
        handleStudentNameSearch: function () {
            this.initialize();
            var nameToFind = $( '#activeStudentName' ).val();
            var i = this.studentNames.indexOf( nameToFind );
            if ( i >= 0 ) {
                $( '#studentListItem' + i ).triggerHandler( 'click' );
            }
        },

        /**
         * do the same with ID search
         */
        handleStudentIdentifierSearch: function () {
            this.initialize();
            var idToFind = $( '#activeStudentIdentifier' ).val();
            var i = this.studentIdents.indexOf( idToFind );
            $( "#activeStudentIdentifier" ).blur();
            if ( i >= 0 ) {
                $( '#studentListItem' + i ).triggerHandler( 'click' );
            }
        },

        initialize: function () {
            //only do this once if the list is empty
            // should this also check idents? probably not because those are optional
            if ( this.studentNames.length > 0 ) return;
            var me = this;
            var $studentNames = $( '[id^="studentName"]' );
            $studentNames.each( function () {
                me.studentNames.push( $( this ).text() );
            } );

            //Calculate the number of students and store
            this.numStudents = $studentNames.length;

            //Load the student id numbers
            var $studentIdents = $( '[id^="studentIdentifier"]' );
            $studentIdents.each( function () {
                me.studentIdents.push( $( this ).text() );
            } );

            window.console.log( 'search box data initialized', this );
        }
    }


    /* -------------------------------- GENERAL FUNCTIONS ------------------------------ */

    /**
     * sums elements scores and sets question scores - will be used for StandardScoring
     */
    function updateStandardScores() {
        //
    }


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
        Timer.resumeTimerIfPaused();
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
        Timer.saveTimer( data, Roster, AjaxHandler, Dashboard );

        $( '#selectPrompt' ).hide();
        $( '#questionArea' ).show( "fast" );

        // set the active student
        Roster.activeStudent = $( row ).attr( "data-index" );
        Roster.setSelectedNameAndId();
        Roster.setActiveStudentBackgroundColor();

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

    // -------------------------------------- Document Ready -------------------------------------
//$( document ).ready( function () {
    updateStudentDataArea( data, Dashboard, Roster );
    Roster.sortRosterBy( 'studentName' );
    Timer.updateTimer( data, Roster, Dashboard );

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

    $( "[id^='studentListItem']" ).on( 'click', function () {
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

    /* initialize Sliders with valenceCutoffs */
    var $sliders = $( 'input.slider' ).slider( {
        tooltip: 'show',
        value: 0,
        step: SliderTools.settings.sliderStep,
        ticks: SliderTools.settings.valenceCutoffs,
        ticks_labels: SliderTools.settings.valenceLabels,
        ticks_position: SliderTools.settings.valenceLabels
    } );

    Dashboard.updateExamGrades( data );

// ---------------------------------- end onload

})();


//
//     var SearchBox = {
//         me : this,
//         // studentNames supplies name data for the search box (typeahead)
//         studentNames : [],
//         // studentIdents does the same for IDs
//         studentIdents : [],
//
//         numStudents : null,
//
//         initialize : function(){
//             var $studentNames = $( '[id^="studentName"]' );
//             $studentNames.each( function () {
//                 me.studentNames.push( $( this ).text() );
//             } );
//
//             me.numStudents = $studentNames.length;
//
//             var $studentIdents = $( '[id^="studentIdentifier"]' );
//             $studentIdents.each( function () {
//                 me.studentIdents.push( $( this ).text() );
//             } );
//
//             window.console.log('search box data initialized', me);
//         }
//     }
//
//
//     // studentNames supplies name data for the search box (typeahead)
//     var $studentNames = $( '[id^="studentName"]' );
//     var studentNames = [];
//     $studentNames.each( function () {
//         studentNames.push( $( this ).text() );
//     } );
//
// // studentIdents does the same for IDs
//     var $studentIdents = $( '[id^="studentIdentifier"]' );
//     var studentIdents = [];
//     $studentIdents.each( function () {
//         studentIdents.push( $( this ).text() );
//     } );
//
//     var numStudents = $studentNames.length;


// /**
//  * sets the activeStudentName and studentId fields
//  */
// function setSelectedNameAndId() {
//     var $student = $( '#studentListItem' + activeStudent );
//     // only show names if set to visible
//     var name = nameHiddenString;
//     if ( studentNamesVisible ) {
//         name = $student.attr( 'data-lName' ) + ", " + $student.attr( 'data-fName' );
//     }
//     // if no student has been selected, always display noActiveStudentString
//     if ( ! activeStudent ) {
//         name = noActiveStudentString;
//     }
//     var id = $student.data( 'student-identifier' );
//     //$("#activeStudentName").text(name);
//     $( "#activeStudentName" ).val( name );
//     $( "#activeStudentIdentifier" ).val( id );
// }

// /**
//  * When the pencil icon is selected, toggle visibility of roster names and selected name area
//  */
// function toggleNameVisibility() {
//     studentNamesVisible = ! studentNamesVisible;
//     $( '[id^="studentListItem"]' ).each( function () {
//         var nameToDisplay = nameHiddenString;
//         if ( studentNamesVisible ) {
//             nameToDisplay = $( this ).attr( 'data-lName' ) + ", " + $( this ).attr( 'data-fName' );
//         }
//         $( this ).find( '[id^="studentName"]' ).text( nameToDisplay );
//     } );
//     setSelectedNameAndId();
// }

//
// /**
//  * set the "grade" column in the student roster, or "--" if exam is not graded
//  */
// function updateRosterGradeDisplay( data ) {
//     for ( var i = 0; i < data.examGrades.length; i ++ ) {
//         if ( data.examGrades[ i ] >= 0 ) {
//             $( '#examGrade' + i ).text( data.examGrades[ i ] );
//         } else {
//             // the student has no grade (val of -1)
//             $( '#examGrade' + i ).text( '--' );
//         }
//     }
// }
//
// /**
//  * set background colors in the student roster
//  *  graded = green
//  *  ungraded = white
//  *  active = blue
//  */
// function setStudentBackgroundColors( data ) {
//     for ( var i = 0; i < data.examGrades.length; i ++ ) {
//         var name = "#studentListItem" + i;
//         var item = $( '#studentRoster' ).find( name );
//         if ( activeStudent == i ) {
//             setRosterBackgroundColor( item, activeStudentColor, 'white' )
//         } else if ( data.examGrades[ i ] >= 0 ) {
//             setRosterBackgroundColor( item, gradedStudentColor, 'white' );
//         } else {
//             setRosterBackgroundColor( item, 'white', 'black' );
//         }
//     }
// }
//
// /**
//  * set background for the student roster row that is selected
//  */
// function setActiveStudentBackgroundColor() {
//     if ( activeStudent ) {
//         setStudentBackgroundColors(); // reset prev. selected student to it's color (white or green)
//         var item = $( '#studentRoster' ).find( '#studentListItem' + activeStudent ); // set the activeStudent
//         setRosterBackgroundColor( item, activeStudentColor, 'white' );
//     }
// }
//
// /**
//  * set color for a student roster row
//  * @param item
//  * @param backColor
//  * @param textColor
//  */
// function setRosterBackgroundColor( item, backColor, textColor ) {
//     $( item ).find( '[class^="col"]' ).css( 'background-color', backColor );
//     $( item ).css( 'color', textColor );
// }
//
// /**
//  * bulk function updates all the dependent data in the roster area.
//  */
// function updateStudentDataArea( data ) {
//     updateExamGrades( data );
//     updateGradedRemainingCounter();
//     updateRosterGradeDisplay();
//     setStudentBackgroundColors();
// }
//
// /**
//  * Sorts the StudentRoster by the clicked header. Sort order reverses with each press.
//  * @param value
//  */
// function sortRosterBy( value ) {
//     var $roster = $( '#studentRosterBody' );
//     $roster.append(
//         $roster.find( '[id^="studentListItem"]' ).sort( function ( a, b ) {
//             var i = $( a ).find( '[id^="' + value + '"]' );
//             var j = $( b ).find( '[id^="' + value + '"]' );
//             var result;
//             if ( value == 'studentName' || value == 'studentIdentifier' ) {
//                 result = $( i ).text().toUpperCase().localeCompare(
//                     $( j ).text().toUpperCase() );
//             } else {
//                 // sort by exam grade
//                 var gradeA = examGrades[ $( a ).attr( 'data-index' ) ];
//                 var gradeB = examGrades[ $( b ).attr( 'data-index' ) ];
//                 result = gradeA - gradeB;
//             }
//             // flip results if we're sorting in DESC
//             if ( ! sortAsc ) {
//                 result *= - 1;
//             }
//             return result;
//         } )
//     );
//     sortAsc = ! sortAsc;
// }


//     // studentNames supplies name data for the search box (typeahead)
//     var $studentNames = $( '[id^="studentName"]' );
//     var studentNames = [];
//     $studentNames.each( function () {
//         studentNames.push( $( this ).text() );
//     } );
//
// // studentIdents does the same for IDs
//     var $studentIdents = $( '[id^="studentIdentifier"]' );
//     var studentIdents = [];
//     $studentIdents.each( function () {
//         studentIdents.push( $( this ).text() );
//     } );
//
//     var numStudents = $studentNames.length;

//
// /**
//  * grab the name of the student, and perform a click on the appropriate row in the student roster
//  */
// function handleStudentNameSearch() {
//     var nameToFind = $( '#activeStudentName' ).val();
//     var i = studentNames.indexOf( nameToFind );
//     if ( i >= 0 ) {
//         $( '#studentListItem' + i ).triggerHandler( 'click' );
//     }
// }
//
// /**
//  * do the same with ID search
//  */
// function handleStudentIdentifierSearch() {
//     var idToFind = $( '#activeStudentIdentifier' ).val();
//     var i = studentIdents.indexOf( idToFind );
//     $( "#activeStudentIdentifier" ).blur();
//     if ( i >= 0 ) {
//         $( '#studentListItem' + i ).triggerHandler( 'click' );
//     }
// }


/* When an element slider stops movement,
 update element score and text (if necessary),
 then save score, text and time
 *  */
// $( 'input.slider' ).on( 'slideStop', function ( slideEvt ) {
//     handleElementSliderStopEvent( slideEvt, data.elementScores, data.stockComments, SliderTools );
//     // // update the element's score visually and in elementScores[]
// var elementNumber = $( this ).closest( '[id^="element"]' ).attr( 'data-element-index' );
// var oldScore = elementScores[ activeStudent ][ elementNumber ];
// var newScore = slideEvt.value;
//
// elementScores[ activeStudent ][ elementNumber ] = newScore;
//
// // update comment text -- only replace text if the score has changed valence regions
// var $parent = $( this ).parents( '[id^="element"]' );
// var $elementComment = $parent.find( 'textArea' );
// if ( getValence( newScore ) != getValence( oldScore ) ) {
//     // Score is in a new valence region.
//     // plug in the appropriate comment text and save to DB
//     var stockResponse = stockComments[ elementNumber ][ getValence( newScore ) ];
//     $elementComment.val( stockResponse );
//     updateAndSaveComment( $elementComment );
// } else {
//     // Score is in the same valence region.
//     // Jump straight to saving without changing the elementComment
//     var elementId = $( this ).closest( '[id^="element"]' ).attr( 'data-element-id' );
//     createGradeRequest( 'element_id', elementId, newScore, null );
// }
//
// // If using bell curve (standardScoring), element score affects the total question score, so update
// if ( standardScoring ) {
//     updateStandardScores();
// }
//
// updateStudentDataArea();
// resumeTimerIfPaused();
//    } );


//bindLetterGradeHandler();
//    return false;
//} );
