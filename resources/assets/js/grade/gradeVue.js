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
        'element-input': require( './components/elementInput.component.js' ),
        'current-student-area': require( './components/currentStudentArea.component.js' ),
        'student-list-item': require( './components/studentListItem.component' ),
        'letter-grade-button': require( './components/letterGradeButton.component.js' ),
        'question-score': require( './components/questionScore.component' ),
        'dashboard-timer': require( './components/dashboard.timer.component' ),
        'dashboard-counts': require( './components/dashboard.counts.component' ),

        'student-table': require('./components/studentTable.component')
    },


    data: {
        store: store,

        ajaxTools: ajaxTools,

        sortAsc: true
    },

    computed: {},

    methods: {
        /* ------------------------------ Display ------------------------------ */

        showQuestionPanel: function(){
            $( '#selectPrompt' ).hide();
            $( '#questionArea' ).show( "fast" );
        },


        /* ------------------------------ Server ------------------------------ */

        /**
         * Saves a comment (and score if present) to the database
         * @param elementId Database id of the element
         * @param commentText Text of the comment to save
         * @param score Associated score to save (can be left null)
         * @returns boolean
         */
        saveCommentWithTime: function ( studentIndex, elementId, commentText ) {
            var me = this;

            let student = this.store.getStudent(studentIndex);
            let examId = this.store.getExamId();
            let time = this.store.getStudentGradingTime(studentIndex);
            let score = false;

            let request = new this.ajaxTools.requests.commentRequest(student.studentId, elementId, commentText, score, time);

            window.console.log('saveCommentWTime', request);
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
            window.console.log('saveTime', request);
            return this.ajaxTools.sendRequest(examId, request);
        },

        /**
         * Save a question or element score (along with grading time) to the server
         *
         * NB, To avoid race conditions, don't use the active student shortcuts in store to get the values.
         *
         * @param elementId
         * @param score
         */
        saveElementScoreWithTime: function ( studentIndex, elementId, score) {
            let student = this.store.getStudent(studentIndex);
            let examId = this.store.getExamId();
            let time = this.store.getStudentGradingTime(studentIndex);

            let request = new this.ajaxTools.requests.elementScoreRequest(student.studentId, elementId, score, time );
            window.console.log('saveElementScoreWTime', request);
            return this.ajaxTools.sendRequest(examId, request);
        },

        /**
         * Save a question or element score (along with grading time) to the server
         *
         * NB, To avoid race conditions, don't use the active student shortcuts in store to get the values.
         *
         * @param studentIndex
         * @param questionIndex
         * @param questionAssignmentId
         */
        saveQuestionScoreWithTime: function ( studentIndex, questionIndex, questionAssignmentId) {
            let student = this.store.getStudent(studentIndex);
            let examId = this.store.getExamId();
            let time = this.store.getStudentGradingTime(studentIndex);
            let score = this.store.getQuestionScore(studentIndex, questionIndex);
            let request = new this.ajaxTools.requests.questionScoreRequest(student.studentId, questionAssignmentId, score, time );
            window.console.log('saveQuestionScoreWTime', request);
            return this.ajaxTools.sendRequest(examId, request);
        },

        /**
         * Sends a request to delete a score from the database
         * @param studentIndex
         * @param questionAssignmentId
         * @returns boolean
         */
        deleteScore: function(studentIndex, questionAssignmentId){
            let student = this.store.getStudent(studentIndex);
            let examId = this.store.getExamId();
            // window.console.log('deleteQuestionScore', );
            return this.ajaxTools.deleteScoreRequest(examId, student.studentId, questionAssignmentId);
        },

        /* ------------------------------ Events ------------------------------ */

        /**
         * Sends an event requesting that the timer start
         */
        requestTimerStart: function(){
            window.console.log('gradeVue', 'sending start-timer-request');
            this.$broadcast('start-timer-request');
        },

        /**
         * Sends an event requesting that the timer stop
         */
        requestTimerStop: function(){
            window.console.log('gradeVue', 'sending stop-timer-request');
            this.$broadcast('stop-timer-request');
        },

/* ------------------------------ other ------------------------------ */

    },

    events: {
        /**
         * Handles anything not done by the elementInput when a slider stops moving
         */
        'element-slider-stop-event': function () {
            window.console.log( 'gradeVue', 'element-slider-stop-event' );

            //Sigh. The user might have forgotten to restart the timer. Do it for them
            this.requestTimerStart();
        },

        /**
         * Save the question score
         * obj.questionIndex
         * obj.questionNumber
         * obj.score
         * @param obj
         */
        'letter-grade-selected': function ( obj ) {
            window.console.log( 'gradeVue', 'letter-grade-selected', obj );
            this.store.storeQuestionScoreForActiveStudent(obj.questionIndex, obj.score);
            //save to server

            this.$broadcast( 'letter-grade-selected', obj );
        },

        /**
         * Lets anyone who might be interested know that the visibility of
         * student names has been toggled.
         */
        'name-visibility-toggled': function () {
            window.console.log( 'gradeVue', 'name-visibility-toggled' );
            this.$broadcast('name-visibility-toggled')
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
            window.console.log( 'gradeVue', 'caught student-select-event', obj );
            this.showQuestionPanel();
            this.$broadcast('start-timer-request');
            this.requestTimerStart();
            this.$broadcast( 'student-select-event', obj );
        },

        /**
         * Handles the request to store comment text on the server
         * Accompanying object should contain:
         *      obj.elementIndex: Index of the element whose score needs updating
         */
        'store-comment-text-request': function ( commentRequestObj ) {
            window.console.log( 'gradeVue', 'store-comment-text-request', commentRequestObj );
            let commentText = this.store.getStoredCommentText(commentRequestObj.studentIndex, commentRequestObj.elementIndex)
            this.saveCommentWithTime(commentRequestObj.studentIndex, commentRequestObj.elementId, commentText);
        },

        /**
         * Handles the request to store element score on the server
         * Accompanying object should contain:
         *      obj.elementIndex: Index of the element whose score needs updating
         */
        'store-element-score-request': function ( elementScoreRequestObj ) {
            window.console.log( 'gradeVue', 'caught store-element-score-request', elementScoreRequestObj );
            let elementId = elementScoreRequestObj.elementId;
            let studentIndex = elementScoreRequestObj.studentIndex
            //store on server
            this.saveElementScoreWithTime(studentIndex, elementId, elementScoreRequestObj.score)
        },

        /**
         * Handles the request to store question score on the server
         * Accompanying object should contain:
         *      obj.questionAssignmentId: Db id of the question assignment
         *      obj.questionIndex: Index of the question whose score needs updating
         *      obj.studentIndex: Index of the student to record grades for.
         *          This is here to avoid a race condition
         * @param questionScoreRequestObj
         */
        'store-question-score-request': function ( questionScoreRequestObj ) {
            window.console.log( 'gradeVue', 'caught store-question-score-request', questionScoreRequestObj );
            let score = this.store.getQuestionScoreForActiveStudent(questionScoreRequestObj.questionIndex);
            if( score == '' || score == null){
                this.deleteScore(questionScoreRequestObj.studentIndex, questionScoreRequestObj.questionAssignmentId);
            }else{
                this.saveQuestionScoreWithTime(questionScoreRequestObj.studentIndex, questionScoreRequestObj.questionIndex, questionScoreRequestObj.questionAssignmentId )
            }
        },

        /**
         * Handles request to start the grading timer
         */
        'start-timer-request': function () {
            window.console.log( 'gradeVue', 'caught start-timer-request' );
            this.requestTimerStart();
        },

        /**
         * Handles the request to stop the grading timer by
         * retransmitting it back down the chain
         */
        'stop-timer-request': function () {
            window.console.log( 'gradeVue', 'stop-timer-request' );
           this.requestTimerStop();
            // this.$broadcast('stop-timer-request');
        },

        /**
         * Handles notification that the timer has started
         */
        'timer-start-event': function () {
            window.console.log( 'gradeVue', 'caught timer-start-event' );
            this.saveTime();
            // this.$broadcast('timer-start-event');
        },
        /**
         * Handles notification that the timer has stopped
         */
        'timer-stop-event': function () {
            window.console.log( 'gradeVue', 'caught timer-stop-event' );
            this.saveTime();
            this.$broadcast('timer-stop-event');
        },

        /**
         * Handles the request to save the time to the db
         */
        'time-save-request': function(){
            window.console.log( 'gradeVue', 'caught time-save-request' );
            this.saveTime();
            this.$broadcast('time-save-request');
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

