<template>

    <div id="gradeExamPage" class="container-flexible mainBodyLocator">
        <p class="title">{{examName}}</p>
        <div class="tile is-ancestor">
            <div class="tile is-parent">

                <!-- Left column holds questions and sliders -->
                <div id="questionAndSliderColumn"
                     class="questionAndSliderColumn tile is-child"
                >
                    <h3> {{ examName}}</h3>

                    <h4 id="selectPrompt">Select a student to begin grading</h4>

                    <div id="questionArea"
                         v-show="isQuestionAreaVisible"
                    >
                        <!-- Create one Question Tab for each question -->
                        <!--<grading-nav-tabs></grading-nav-tabs>-->

                        <!-- question panel -->
                        <router-view name="questionPanelArea"></router-view>

                    </div>
                </div>


                <!-- Right column holds Roster and Time info -->
                <div id="rosterAndDashboardColumn"
                     class="tile is-child rosterAndDashboardColumn">

                    <div class="roster-column tile is-parent is-vertical">
                        <div class="tile is-child">
                            <!-- graded / remaining counters -->
                            <dashboard-counts></dashboard-counts>
                            <dashboard-timer></dashboard-timer>

                        </div>

                        <div class="tile is-child">
                            <!-- student table shows the student roster -->
                            <grading-roster></grading-roster>
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
    import GradingRoster from './roster/grading-roster.vue';

    import { loadExam } from '../../../api/requests/examRequests';
    import { loadExamKumi } from '../../../api/requests/kumiRequests';
    import { loadAllStudents } from '../../../api/requests/studentRequests';

    import Payload from '../../../models/Payload';
    import Exam from '../../../models/Exam';

    import * as ngmTypes from '../../../store/modules/newgrading/new-grading-mutation-types';
    import * as ngaTypes from '../../../store/modules/newgrading/new-grading-action-types';
    import * as nggTypes from '../../../store/modules/newgrading/new-grading-getter-types';
    import * as gTypes from '../../../store/getter-types';


    export default {

        props: [],

        components: {
            ActiveStudentArea,
            DashboardCounts,
            DashboardTimer,
            // FinishButton,
            // GradingNavTabs,
            GradingRoster,

        },

        data: function () {
            return {
                //temporary while developing as separate page
                examId: window.examId,

                isFinishButtonVisible: false,
                isQuestionAreaVisible: true,
                defaults: {}
            }
        },

        asyncComputed: {
            exam: function () {
                return this.$store.getters[ nggTypes.getActiveExam ];
            },

            students: function () {
                return this.$store.getters[ gTypes.getStudentsFromRoster ];
            },


            examName: function () {
                return this.exam ? this.exam.examName : '';
            }
        },
        computed: {},


        methods: {


            /**
             * Sets the grading timer to running
             */
            requestTimerStart: function () {
                window.console.log( 'gradeVue', 'sending start-timer-request' );
                this.$store.commit( ngmTypes.startTimer );
            },

            /**
             * Sends an event requesting that the timer stop
             */
            requestTimerStop: function () {

                window.console.log( 'gradeVue', 'sending stop-timer-request' );
                this.$store.commit( ngmTypes.stopTimer );

            },


            /* ------------------------------ Display ------------------------------ */

            showQuestionPanel: function () {
            },


            /* ------------------------------ Server ------------------------------ */

            // /**
            //  * Saves a comment (and score if present) to the database
            //  * @param elementId Database id of the element
            //  * @param commentText Text of the comment to save
            //  * @param score Associated score to save (can be left null)
            //  * @returns boolean
            //  */
            // saveCommentWithTime: function ( studentIndex, elementId, commentText ) {
            //     var me = this;
            //
            //     let student = this.store.getStudent( studentIndex );
            //     let examId = this.store.getExamId();
            //     let time = this.store.getStudentGradingTime( studentIndex );
            //     let score = false;
            //
            //     let request = new this.ajaxTools.requests.commentRequest( student.studentId, elementId, commentText, score, time );
            //
            //     window.console.log( 'saveCommentWTime', request );
            //     return this.ajaxTools.sendRequest( examId, request );
            // },
            //
            // /**
            //  * Records grading time to the db
            //  */
            // saveTime: function () {
            //     let studentId = this.store.getActiveStudentId();
            //     let examId = this.store.getExamId();
            //     let time = this.store.getActiveStudentGradingTime();
            //
            //     let request = new this.ajaxTools.requests.timeRequest( studentId, time );
            //     window.console.log( 'saveTime', request );
            //     return this.ajaxTools.sendRequest( examId, request );
            // },
            //
            // /**
            //  * Save a question or element score (along with grading time) to the server
            //  *
            //  * NB, To avoid race conditions, don't use the active student shortcuts in store to get the values.
            //  *
            //  * @param elementId
            //  * @param score
            //  */
            // saveElementScoreWithTime: function ( studentIndex, elementId, score ) {
            //     let student = this.store.getStudent( studentIndex );
            //     let examId = this.store.getExamId();
            //     let time = this.store.getStudentGradingTime( studentIndex );
            //
            //     let request = new this.ajaxTools.requests.elementScoreRequest( student.studentId, elementId, score, time );
            //     window.console.log( 'saveElementScoreWTime', request );
            //     return this.ajaxTools.sendRequest( examId, request );
            // },
            //
            // /**
            //  * Save a question or element score (along with grading time) to the server
            //  *
            //  * NB, To avoid race conditions, don't use the active student shortcuts in store to get the values.
            //  *
            //  * @param studentIndex
            //  * @param questionIndex
            //  * @param questionAssignmentId
            //  */
            // saveQuestionScoreWithTime: function ( studentIndex, questionIndex, questionAssignmentId ) {
            //     let student = this.store.getStudent( studentIndex );
            //     let examId = this.store.getExamId();
            //     let time = this.store.getStudentGradingTime( studentIndex );
            //     let score = this.store.getQuestionScore( studentIndex, questionIndex );
            //     let request = new this.ajaxTools.requests.questionScoreRequest( student.studentId, questionAssignmentId, score, time );
            //     window.console.log( 'saveQuestionScoreWTime', request );
            //     return this.ajaxTools.sendRequest( examId, request );
            // },
            //
            // /**
            //  * Sends a request to delete a score from the database
            //  * @param studentIndex
            //  * @param questionAssignmentId
            //  * @returns boolean
            //  */
            // deleteScore: function ( studentIndex, questionAssignmentId ) {
            //     let student = this.store.getStudent( studentIndex );
            //     let examId = this.store.getExamId();
            //     // window.console.log('deleteQuestionScore', );
            //     return this.ajaxTools.deleteScoreRequest( examId, student.studentId, questionAssignmentId );
            // },

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

        events: {

            //
            // /**
            //  * Catches the event fired upon student selection.
            //  * The object accompanying the event should have the properties:
            //  * obj.studentName
            //  * obj.studentIdentifier
            //  *
            //  * @param obj
            //  */
            // handleStudentSelectEvent: function ( obj ) {
            //     window.console.log( 'gradeVue', 'caught student-select-event', obj );
            //     this.showQuestionPanel();
            //     this.requestTimerStart();
            //     this.$broadcast( 'student-select-event', obj );
            // },
            //
            //
            // // ------------------------------ Timers
            // /**
            //  * Handles request to start the grading timer
            //  */
            // handleStartTimerRequest: function () {
            //     window.console.log( 'gradeVue', 'caught start-timer-request' );
            //     this.requestTimerStart();
            // },
            //
            // /**
            //  * Handles the request to stop the grading timer by
            //  * retransmitting it back down the chain
            //  */
            // handleStopTimerRequest: function () {
            //     window.console.log( 'gradeVue', 'stop-timer-request' );
            //     this.requestTimerStop();
            //     // this.$broadcast('stop-timer-request');
            // },
            //
            // /**
            //  * Handles the request to save the time to the db
            //  */
            // timeSaveRequest: function () {
            //     window.console.log( 'gradeVue', 'caught time-save-request' );
            //     this.saveTime();
            //     this.$broadcast( 'time-save-request' );
            // }
        },

        created: function () {
            let me = this;

            return new Promise( function ( resolve, reject ) {
                //load the exam object and store it
                loadExam( me.examId )
                    .then( function ( data ) {
                        let exam = Exam.factory( data );
                        me.$store.commit( ngmTypes.setActiveExam, Payload.factory( {
                            obj: exam,
                            mutateSilently: true
                        } ) );
                        return exam;
                    } )
                    .then( function ( exam ) {
                        window.console.log( 'grading-page', 'exam', 400, exam );
                        loadExamKumi( me.$store, exam )
                            .then( function () {
                                loadAllStudents( me.$store, exam )
                                    .then( function () {
                                        resolve();
                                    } );
                            } );

                    } );

            } );


            // let me = this;
            // let p1 = new Promise( function ( resolve, reject ) {
            //     //load the exam object and store it
            //     let exam = loadExam( me.examId );
            //     me.$store.commit( ngmTypes.setActiveExam, exam );
            //     resolve();
            // } );

//             p1.then( function ( data ) {
//                 let p = loadExamKumi( me.$store, me.exam );
//                 p.then( function () {
//                     //set the first kumi as the one to display
//                     //this needs to happen before associate exam is called
// //                me.$store.commit( 'updateSelectedKumi' );
//                     loadAllStudents( me.$store, me.exam );
//                 } );
//
//             } );
//
//             this.$store.commit( mTypes.loadInitialData );
//             let me = this;
//
//             let p = loadExamKumi( this.$store, this.exam );
//             p.then( function () {
//                 //set the first kumi as the one to display
//                 //this needs to happen before associate exam is called
// //                me.$store.commit( 'updateSelectedKumi' );
//                 loadAllStudents( me.$store, me.exam );
//             } );

        }
    }
</script>