<template>
    <div id="grade-main-page"
         class=" mainBodyLocator"
    >
        <div class="grade-main-body container box">
            <top-navbar
                    :exam="exam"
                    page-type="grade"
            >
                <p slot="level-left"
                   class="title">{{examName}}
                </p>

            </top-navbar>
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
                         class="tile is-child rosterAndDashboardColumn box"
                    >

                        <div class="roster-column tile is-parent is-vertical">

                            <div class="tile is-child">
                                <!-- graded / remaining counters -->
                                <div class="has-text-centered">
                                    <dashboard-counts></dashboard-counts>
                                </div>

                                <dashboard-timer></dashboard-timer>

                                <!-- save & finish button -->
                                <finish-button></finish-button>

                            </div>

                            <div class="tile is-child">
                                <!-- student table shows the student roster -->
                                <grading-roster></grading-roster>

                                <div class="buttons">
                                    <student-name-visibility></student-name-visibility>
                                    <hide-graded-rows></hide-graded-rows>
                                    <auto-start-timer-button></auto-start-timer-button>
                                    <feedback-preview-button></feedback-preview-button>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <bottom-navbar></bottom-navbar>

    </div>


</template>

<style lang="scss">
    @import '../../../../sass/development/newGom';

    #grade-main-page {
        background-color: $main-background-color-gradient-limit;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .8), 0 3px 9px rgba(0, 0, 0, .2);

        #grade-main-body {
            /*<!--background-image: linear-gradient(bottom left, $main-background-color, $main-background-color-gradient-limit);-->*/
            /*padding-left: 1em;*/
            /*padding-right: 1em;*/

        }
    }
</style>

<script>

    import GradingNavTabs from "./nav/grading-nav-tabs.vue";
    import ActiveStudentArea from './roster/active-student-area.vue';
    import DashboardCounts from './dashboard/dashboard-counts.vue';
    import DashboardTimer from './dashboard/dashboard-timer.vue';
    import GradingRoster from './roster/grading-roster.vue';
    //navs
    import TopNavbar from '../top-nav/top-navbar.vue';
    import BottomNavbar from "../bottom-nav/bottom-navbar";
    //buttons
    import FeedbackPreviewButton from "../feedback/feedback-preview-button";


    import { loadExam } from '../../../api/requests/examRequests';
    import { loadKumiForExam } from '../../../api/requests/kumiRequests';
    import { loadAllStudents } from '../../../api/requests/studentRequests';
    // import { getItemsForExam, getItemOrderForExam } from '../../../api/requests/itemRequests';
    import Payload from '../../../models/Payload';
    import Exam from '../../../models/Exam';

    import * as ngmTypes from '../../../store/new-grading-mutation-types';
    import * as ngaTypes from '../../../store/new-grading-action-types';
    import * as nggTypes from '../../../store/new-grading-getter-types';
    import * as gTypes from '../../../store/getter-types';
    import * as mTypes from '../../../store/mutation-types';

    import StudentNameVisibility from "./controls/student-name-visibility";
    import HideGradedRows from "./controls/hide-graded-rows";
    import FinishButton from "./inputs/finish-button";
    import StudentSearchBar from "./roster/student-search-bar";
    import AutoStartTimerButton from "./controls/auto-start-timer-button";


    export default {

        props: [],

        components: {
            AutoStartTimerButton,
            StudentSearchBar,
            FinishButton,
            HideGradedRows,
            StudentNameVisibility,
            FeedbackPreviewButton,
            BottomNavbar,
            ActiveStudentArea,
            DashboardCounts,
            DashboardTimer,
            TopNavbar,
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

            //this is loaded async. We call it first since we don't want the student names
            //to display if they are supposed to be hidden. However, it's not that important
            //so we're not letting it block the other requests until it loads...
            this.$store.dispatch( ngaTypes.loadGradePreferencesFromServer );

            this.$store.dispatch( 'loadExamFromServer', this.examId ).then( function () {
                me.$store.dispatch( 'loadItemsFromServer', me.exam ).then( function () {
                    //get any groups associated with the exam
                    //this will include the central group which
                    //constitutes the roster
                    me.$store.dispatch( 'loadKumisForExamFromServer', me.exam ).then( function () {
                        //and then get the students to go in those
                        //groups
                        me.$store.dispatch( 'loadStudentsFromServer', me.exam ).then( function () {
                            //and any existing scores
                            //as well as comments
                            me.$store.dispatch( 'loadScoresFromServer', me.exam ).then( function () {
                                //finally we get grading times
                                me.$store.dispatch( ngaTypes.loadTimesFromServer, me.exam )
                                //and are done.
                            } );
                        } );
                    } );
                } );
            } );

        }
    };

</script>