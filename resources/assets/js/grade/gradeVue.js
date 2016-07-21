/**
 * Created by  adam on 7/11/16.
 */

var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

require( 'bootstrap' );
var bootbox = require( 'bootbox' );

var Vue = require( 'vue' );
//dev
Vue.config.debug = true;


var ajaxTools = require('./components/ajax.tools.js');

new Vue( {
    el: '#gradeExamPage',

    components: {
        'element-input': require( './components/elementInput.js' ),
        'current-student-area': require( './components/currentStudentArea.component.js' ),
        'student-list-item': require( './components/studentListItem' ),
        'letter-grade-button': require( './components/letterGradeButton.component.js' ),
        'question-score': require( './components/questionScore.component' ),
        'dashboard-timer': require( './components/dashboard.timer.component' ),
        'dashboard-counts': require( './components/dashboard.counts.component' )
    },


    data: {
        store: store,

        ajaxTools: ajaxTools,

    },

    computed: {},

    methods: {

        /**
         * Saves a comment (and score if present) to the database
         * @param elementId Database id of the element
         * @param commentText Text of the comment to save
         * @param score Associated score to save (can be left null)
         * @returns boolean
         */
        saveCommentWithTime: function ( elementId, commentText, score ) {
            var me = this;

            let studentId = this.store.getActiveStudentId();
            let examId = this.store.getExamId();
            let time = this.store.getActiveStudentGradingTime();

            let request = new this.ajaxTools.requests.commentRequest(studentId, elementId, commentText, score, time);

            return this.ajaxTools.sendRequest(examId, request);
        },

        /**
         * Records grading time to the db
         */
        saveTime: function(){
            let studentId = this.store.getActiveStudentId();
            let examId = this.store.getExamId();
            let time = this.store.getActiveStudentGradingTime();

            let request = new this.ajaxTools.requests.timeRequest(studentId, time);
            return this.ajaxTools.sendRequest(examId, request);
        },

        /**
         * Save a question or element score (along with grading time) to the server
         * @param studentId
         * @param gradeRequest
         * @param store
         */
        saveScoreWithTime: function ( dataType, dataId, score) {
            var me = this;

            let studentId = this.store.getActiveStudentId();
            let examId = this.store.getExamId();
            let time = this.store.getActiveStudentGradingTime();

            let request = this.ajaxTools.createGradeRequestObject(studentId, dataType, dataId, score, null, time);

            return this.ajaxTools.sendRequest(examId, request);
        },

        /**
         * Sends a request to delete a score from the database
         * @param questionAssignmentId
         * @returns boolean
         */
        deleteScore: function(questionAssignmentId){
            var me = this;

            let studentId = this.store.getActiveStudentId();
            let examId = this.store.getExamId();

            return this.ajaxTools.deleteScoreRequest(examId, studentId, questionAssignmentId);
        }
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
            window.console.log( 'gradeVue', 'caught timer-start-event' );
            this.saveTime();
        },
        /**
         * Handles notification that the timer has stopped
         */
        'timer-stop-event': function () {
            window.console.log( 'gradeVue', 'caught timer-stop-event' );
            this.saveTime();
        },

        /**
         * Handles the request to save the time to the db
         */
        'time-save-request': function(){
            window.console.log( 'gradeVue', 'caught time-save-request' );
            this.saveTime();
        }

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

