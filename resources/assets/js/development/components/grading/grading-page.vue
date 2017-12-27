<template>

    <div id="gradeExamPage" class="container-flexible mainBodyLocator">
        <div class="grading-main box">

            <exam-selection-bar
                    :exam="exam"
                    page-type="grade"
            >
                <p slot="level-left"
                   class="title">{{examName}}
                </p>
            </exam-selection-bar>


            <div class="tile is-ancestor">
                <div class="tile is-parent">

                    <!-- Left column holds questions and sliders -->
                    <div id="questionAndSliderColumn"
                         class="questionAndSliderColumn tile is-child box"
                    >

                        <h4 v-if="! isQuestionAreaVisible"
                            id="selectPrompt">Select a student to begin grading</h4>

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
                         class="tile is-child rosterAndDashboardColumn box">


                        <div class="roster-column tile is-parent is-vertical">
                            <div class="tile is-child">
                            <span class="icon" aria-hidden="true">
                        <!--<i class="fa fa-tachometer"></i> <span>Statistics</span>-->
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

    </div>


</template>

<style lang="scss">
    @import '../../../../sass/development/newSetup';

    #gradeExamPage {
    }

    .grading-main {
        /*<!--background-image: linear-gradient(bottom left, $main-background-color, $main-background-color-gradient-limit);-->*/
        padding-left: 2px;
        padding-right: 2px;
        background-color: $main-background-color-gradient-limit;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .8), 0 3px 9px rgba(0, 0, 0, .2);

    }
</style>

<script>

    import GradingNavTabs from "./nav/grading-nav-tabs.vue";
    import ActiveStudentArea from './roster/active-student-area.vue';
    import DashboardCounts from './dashboard/dashboard-counts.vue';
    import DashboardTimer from './dashboard/dashboard-timer.vue';
    import GradingRoster from './roster/grading-roster.vue';
    import ExamSelectionBar from '../exams/exam-selection-bar.vue';

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
            ExamSelectionBar,
            // FinishButton,
            GradingNavTabs,
            GradingRoster,

        },

        data: function () {
            return {
                //temporary while developing as separate page
                examId: window.examId,

                isFinishButtonVisible: false,

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
            },

            isQuestionAreaVisible: function () {
                let s = this.$store.getters[ nggTypes.getActiveStudent ];
                return !_.isUndefined( s ) && !_.isNull( s );
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
                                            let p2 = me.$store.dispatch( 'loadScoresFromServer', exam );
                                            p2.then( function () {
                                                let p3 = me.$store.dispatch(ngaTypes.loadTimesFromServer, exam);
                                                p3.then(function(){
                                                    resolve();
                                                });

                                            } );
                                        } );
                                    } );
                            } );
                    } );

            } );
        }
    };

</script>