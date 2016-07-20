/**
 * Created by  adam on 7/11/16.
 */

var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

require( 'bootstrap' );

var Vue = require( 'vue' );

//dev
Vue.config.debug = true;


new Vue( {
    el: '#gradeExamPage',

    components: {
        'element-input': require( './components/elementInput.js' ),
        'current-student-area': require( './components/currentStudentArea.component.js' ),
        'student-list-item': require( './components/studentListItem' ),
        'letter-grade-button': require( './components/letterGradeButton.component.js' ),
        'question-score': require( './components/questionScore.component' ),
        'dashboard-timer': require('./components/dashboard.timer.component'),
        'dashboard-counts': require('./components/dashboard.counts.component')
    },


    data: {},

    computed: {},

    methods: {

        //     saveElementComment: function(){
        //
        //         //grab scores
        //         var oldScore = data.getElementScore( Roster.activeStudent, elementIndex );
        //         var score = slideEvt.value;
        //
        //         /* ---------- update the element's score visually and in data.elementScores[] --------- */
        //
        //         //store the new element score in the data object
        //         data.storeElementScore( Roster.activeStudent, elementIndex, score );
        //
        //
        //         /**
        //          * update comment text and save to DB.
        //          * Only replace text if the score has changed valence regions
        //          */
        //         if ( ! this.isSameValence( oldScore, score ) ) {
        //             //Score is in a new valence region.
        //             //So let's plug in the appropriate comment text and save to DB
        //
        //             //Store comment text in data object
        //             //Dear Adam, make sure you read the doc for storeCommentText before fucking with
        //             //anything in these lines
        //             data.storeCommentText( Roster.activeStudent, elementIndex, $elementComment.val() );
        //             var commentText = data.getCommentText( Roster.activeStudent, elementIndex, this.updateValence( score ) );
        //
        //             //update display
        //             this.updateDisplayedComment( $elementComment, commentText );
        //
        //             //send to the db
        //             AjaxHandler.saveComment( data, Roster, elementId, score, commentText );
        //
        //         } else {
        //             // Score is in the same valence region.
        //             // Jump straight to saving without changing the elementComment
        //             // Fear not. Changes directly to the comment text will be handled elsewhere.
        //             AjaxHandler.createGradeRequest( data, 'element_id', elementId, score, null, Roster );
        //         }
        //
        //         // If using bell curve (standardScoring), element score affects
        //         // the total question score, so update
        //         if ( Roster.standardScoring ) {
        //             //  updateStandardScores();
        //         }
        //
        //         callback();
        //         // //Update dashboard and roster data displayed
        //         // updateStudentDashboardAndRosterAreas( data, Dashboard, Roster );
        //         // //Sigh. The user forgot to restart the timer. Do it for them
        //         // Timer.resumeTime
        //     }
    },

    events: {
        /**
         * Handles anything not done by the elementInput when a slider stops moving
         */
        'element-slider-stop-event': function () {
            window.console.log( 'gradeVue', 'element-slider-stop-event' );
            // this.handleElementSliderStopEvent( slideEvt, data, Roster, function () {
            //     //Update dashboard and roster data displayed
            //     updateStudentDashboardAndRosterAreas( data, Dashboard, Roster );
            //Sigh. The user forgot to restart the timer. Do it for them
            //Timer.resumeTimerIfPaused( data, Roster, Dashboard );
        },

        'letter-grade-selected': function ( obj ) {
            window.console.log( 'gradeVue', 'letter-grade-selected', obj );
            this.$broadcast( 'letter-grade-selected', obj );
        },

        /**
         * Lets anyone who might be interested know that the visibility of
         * student names has been toggled.
         */
        'name-visibility-toggled': function () {
            window.console.log( 'gradeVue', 'name-visibility-toggled' );
        },

        /**
         * Catches the event fired upon student selection.
         * The object accompanying the event should have the properties:
         * obj.studentName
         * obj.studentIdentifier
         *
         * @param obj
         */
        'student-select-event': function ( obj ) {
            window.console.log( 'gradeVue', 'student-select-event' );
            this.$broadcast( 'student-select-event', obj );
        },

        /**
         * Handles the request to store comment text on the server
         * Accompanying object should contain:
         *      obj.elementIndex: Index of the element whose score needs updating
         */
        'store-comment-text-request': function ( obj ) {
            var elementIndex = obj.elementIndex;
            window.console.log( 'gradeVue', 'store-comment-text-request', obj );
        },

        /**
         * Handles the request to store element score on the server
         * Accompanying object should contain:
         *      obj.elementIndex: Index of the element whose score needs updating
         */
        'store-element-score-request': function ( obj ) {
            var elementIndex = obj.elementIndex;
            window.console.log( 'gradeVue', 'store-element-score-request', obj );
        },

        /**
         * Handles the request to store question score on the server
         * Accompanying object should contain:
         *      obj.questionIndex: Index of the question whose score needs updating
         * @param obj
         */
        'store-question-score-request': function ( obj ) {
            window.console.log( 'gradeVue', 'store-question-score-request', obj );
        },

        /**
         * Handles request to start the grading timer
         */
        'start-timer-request': function () {
            window.console.log( 'gradeVue', 'caught start-timer-request' );
        },

        /**
         * Handles the request to stop the grading timer
         */
        'stop-timer-request': function () {
            window.console.log( 'gradeVue', 'stop-timer-request' );
        },

        /**
         * Handles notification that the timer has started
         */
        'timer-start-event': function () {
            window.console.log('gradeVue', 'caught timer-start-event');
        },
        /**
         * Handles notification that the timer has stopped
         */
        'timer-stop-event': function () {
            window.console.log('gradeVue', 'caught timer-stop-event');
        },

    },


    directives: {},

    ready: function () {
        $.ajaxSetup( {
            headers: {
                'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
            }
        } );
        window.console.log( 'gradeVue.js ready' );

    }
} );

