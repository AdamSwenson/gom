<template>

    <div id="gradeExamPage" class="container-flexible mainBodyLocator">
        <p class="title">{{examName}}</p>
        <div class="tile is-ancestor">
            <div class="tile is-parent">

                <!-- Left column holds questions and sliders -->
                <div id="questionAndSliderColumn"
                     class="questionAndSliderColumn tile is-child"
                >

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
                            <span class="icon" aria-hidden="true">
                        <i class="fa fa-tachometer"></i> <span>Statistics</span>
                    </span>

                            <!-- graded / remaining counters -->
                            <dashboard-counts></dashboard-counts>
                            <dashboard-timer></dashboard-timer>

                        </div>

                        <div class="tile is-child">
                            <!-- student table shows the student roster -->
                            <grading-roster></grading-roster>
                            <a class="button">Hide graded</a>
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
    import { getItemsForExam, getItemOrderForExam } from '../../../api/requests/itemRequests';
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
            GradingNavTabs,
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


        },
        computed: {
            examName: function () {
                return this.exam ? this.exam.name : '';
            }

        },


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
                        loadExamKumi( me.$store, exam )
                            .then( function () {
                                loadAllStudents( me.$store, exam )
                                    .then( function () {
                                        let p = me.$store.dispatch( 'loadItemsFromServer', exam );
                                        p.then( function () {
                                            resolve();
                                        } );
                                    } );
                            } );
                    } );

            } );
        }
    };

</script>