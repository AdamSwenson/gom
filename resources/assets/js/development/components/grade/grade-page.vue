<template>

    <div id="gradeExamPage" class="container-flexible mainBodyLocator">
        <div class="tile is-ancestor">
            <div class="tile is-parent">

                <!-- Left column holds questions and sliders -->
                <div id="questionAndSliderColumn"
                     class="questionAndSliderColumn tile is-child"
                >
                    <h3> {{ examName}}}</h3>

                    <h4 id="selectPrompt">Select a student to begin grading</h4>

                    <div id="questionArea"
                         v-show="isQuestionAreaVisible"
                    >
                        <!-- Create one Question Tab for each question -->
                        <grading-nav-tabs></grading-nav-tabs>

                        <!-- question panel -->
                        <router-view name="questionPanelArea"></router-view>

                    </div>
                </div>


                <!-- Right column holds Roster and Time info -->
                <div id="rosterAndDashboardColumn"
                     class="tile is-child rosterAndDashboardColumn">

                    <div class="roster-column tile is-parent is-vertical">
                        <div class="tile is-child">
                            <!-- student name and ID -->
                            <active-student-area></active-student-area>

                            <!-- graded / remaining counters -->
                            <dashboard-counts></dashboard-counts>

                            <!-- save & finish button -->
                            <finish-button></finish-button>

                        </div>

                        <div class="tile is-child">

                            <!-- student table shows the student roster -->
                            <grade-roster></grade-roster>

                            <!-- statistics area holds time info -->
                            <dashboard-counts></dashboard-counts>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>


</template>

<style lang="scss">

</style>

<script>

    import GradingNavTabs from "./nav/grading-nav-tabs.vue";
    import ActiveStudentArea from './roster/active-student-area.vue';
    import DashboardCounts from './dashboard/dashboard-counts.vue';
    import DashboardTimer from './dashboard/dashboard-timer.vue';
    import FinishButton from "./inputs/finish-button";

    import { loadExamKumi } from '../../../api/requests/kumiRequests';
    import { loadAllStudents } from '../../../api/requests/studentRequests';


    import * as ngmTypes from '../../../store/modules/newgrading/new-grading-mutation-types';
    import * as ngaTypes from '../../../store/modules/newgrading/new-grading-action-types';
    import * as nggTypes from '../../../store/modules/newgrading/new-grading-getter-types';


    export default {

        props: [],

        components: {
            FinishButton,
            DashboardCounts,
            DashboardTimer,
            GradingNavTabs,
            ActiveStudentArea
        },

        data: function () {
            return {
                isFinishButtonVisible: false,
                isQuestionAreaVisible: true,
                defaults: {}
            }
        },

        asyncComputed: {
            loadStockComments: function () {
            },
            loadElementComments: function () {
            },
            loadElementScores: function () {
            },
            loadQuestionScores: function () {
            },
            loadGradingTimes: function () {
            },
            loadExamGrades: function () {
            },
            loadNumberQuestions: function () {
            },

        },
        computed: {
            examName: function () {

            }
        },


        methods: {


            /**
             * Starts the grading timer
             */
            requestTimerStart: function(){
                window.console.log('gradeVue', 'sending start-timer-request');
this.$store.commit(ngmTypes.startTimer);
               },

            /**
             * Sends an event requesting that the timer stop
             */
            requestTimerStop: function(){

                window.console.log('gradeVue', 'sending stop-timer-request');
                this.$store.commit(ngmTypes.stopTimer);

            },




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
            //
            // /**
            //  * Sends an event requesting that the timer start
            //  */
            // requestTimerStart: function(){
            //     window.console.log('gradeVue', 'sending start-timer-request');
            //     this.$broadcast('start-timer-request');
            // },
            //
            // /**
            //  * Sends an event requesting that the timer stop
            //  */
            // requestTimerStop: function(){
            //     window.console.log('gradeVue', 'sending stop-timer-request');
            //     this.$broadcast('stop-timer-request');
            // },
            //
            // /**
            //  * Handles notification that the timer has started
            //  */
            // handleTimerStart: function () {
            //     window.console.log( 'gradeVue', 'caught timer-start-event' );
            //     this.saveTime();
            //     this.$broadcast('timer-start-event');
            // },
            //
            // /**
            //  * Handles notification that the timer has stopped
            //  */
            // handleTimerStop: function () {
            //     window.console.log( 'gradeVue', 'caught timer-stop-event' );
            //     this.saveTime();
            //     this.$broadcast('timer-stop-event');
            // },


            /* ------------------------------ other ------------------------------ */
        },

        directives: {},

        events: {       /**
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
             * Handles the request to save the time to the db
             */
            'time-save-request': function(){
                window.console.log( 'gradeVue', 'caught time-save-request' );
                this.saveTime();
                this.$broadcast('time-save-request');
            }
        },

        created: function () {
            this.$store.commit( mTypes.loadInitialData );
            let me = this;

            let p = loadExamKumi( this.$store, this.exam );
            p.then( function () {
                //set the first kumi as the one to display
                //this needs to happen before associate exam is called
//                me.$store.commit( 'updateSelectedKumi' );
                loadAllStudents( me.$store, me.exam );
            } );

        }
    }
</script>