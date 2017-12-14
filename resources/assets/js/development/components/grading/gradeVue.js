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
        'dashboard-timer': require( './dashboard/dashboard-timer' ),
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

