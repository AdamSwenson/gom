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

                            <a class="button is-pulled-right"
                               v-on:click="toggleDashVisibility"
                            ><span class="icon"><i v-bind:class="dashControlIcon"></i></span>
                            </a>

                        <p class="subtitle"
                           v-if="! isQuestionAreaVisible"
                           id="selectPrompt"
                        >Select a student to begin grading</p>

                        <div id="questionArea"
                             v-show="isQuestionAreaVisible"
                        >
                            <!-- Create one Question Tab for each question -->
                            <grading-nav-tabs
                                    v-on:set-default-question-tab-route="setDefaultQuestionTabRoute"
                            ></grading-nav-tabs>

                            <!-- question panel -->
                            <router-view name="questionPanelArea"></router-view>

                        </div>
                    </div>


                    <!-- Right column holds Roster and Time info -->
                    <div id="rosterAndDashboardColumn"
                         class="tile is-child rosterAndDashboardColumn box"
                         v-show="isDashColumnVisible"
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

        <!--<bottom-navbar></bottom-navbar>-->

    </div>


</template>

<style lang="scss">
    /*Custom font imports
    Font override variables are defined in this file, so it
    needs to be loaded before bootswatch or anything else brings in bootstrap
    */
    @import '../../../../sass/common/remote_font_includes';
    /*Load bulma as customized*/
    @import '../../../../sass/development/custom-bulma';
    /*Customize certain stuff in bootstrap*/
    @import '../../../../sass/common/bootstrap_overrides';
    /*Super common styling for every page*/
    @import '../../../../sass/common/universal-styles';

    #grade-main-page {

        background-color: $main-background-color-gradient-limit;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .8), 0 3px 9px rgba(0, 0, 0, .2);

        /*height: 100vh;*/
        height: -moz-available;
        height: -webkit-fill-available;
        height: fill-available;
        /*!*height:auto !important;*!*/

        #questionAndSliderColumn {
            width-max: 700px;
        }

        #rosterAndDashboardColumn {
            max-width: 550px;
            min-width: 340px;
        }

        #grade-main-body {

            height: -moz-available;
            height: -webkit-fill-available;
            height: fill-available;
            /*height: 100vh;*/
            /*<!--background-image: linear-gradient(bottom left, $main-background-color, $main-background-color-gradient-limit);-->*/
            /*padding-left: 1em;*/
            /*padding-right: 1em;*/

        }

        /*.startHidden {*/
        /*display: none;*/
        /*}*/

        .input-group.full-width .input-group-btn:last-child > .btn {
            margin-left: 5px;
        }

        .input-group.full-width .input-group-btn:last-child > .btn {
            border-bottom-left-radius: 4px;
            border-top-left-radius: 4px;
        }

        .input-group.full-width .form-control:first-child {
            border-bottom-right-radius: 4px;
            border-top-right-radius: 4px;
        }
    }
</style>

<script>

    import * as ngmTypes from '../../../store/new-grading-mutation-types';
    import * as ngaTypes from '../../../store/new-grading-action-types';
    import * as nggTypes from '../../../store/new-grading-getter-types';
    import * as gTypes from '../../../store/getter-types';
    import * as mTypes from '../../../store/mutation-types';

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
                isReadyToRock: false,

                //temporary while developing as separate page
                examId: window.examId,

                isFinishButtonVisible: false,

                isDashColumnVisible: true,

                /**
                 * Which tab should be open by default
                 * when a new user is selected.
                 * It will be set from an event emitted by
                 * the grading-nav-tabs component after it has
                 * finished asynchronously creating the routes
                 */
                defaultQuestionTabRoute: '',

                defaults: {}
            }
        },

        asyncComputed: {
            exam: function () {
                return this.$store.getters[ nggTypes.getActiveExam ];
            },

            /**
             * The student whose exam is presently being graded
             */
            selectedStudent: {
                get: function () {
                    return this.$store.getters[ nggTypes.getActiveStudent ];
                },
                watch: function () {
                    this.setQuestionTabToDefault();
                }
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
            },


            dashControlIcon: function () {
                if ( this.isDashColumnVisible ) {
                    return 'fa fa-angle-double-right';
                }
                return 'fa fa-angle-double-left';
            }

        },

        watch: {
          isQuestionAreaVisible: function(newVal){
              this.isDashColumnVisible = ! newVal;

          }
        },


        methods: {

            /**
             * Handles the set-default-route event
             * emitted by grading-nav-tabs when it is
             * done asynchronously creating the routes for
             * the question selection tabs.
             */
            setDefaultQuestionTabRoute: function ( route ) {
                this.defaultQuestionTabRoute = route;
                //and since this will only be caught the first time the page
                //loads, we set the question to default
                this.setQuestionTabToDefault();
            },


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

            /**
             * Makes the default question active
             */
            setQuestionTabToDefault: function () {
                if ( this.defaultQuestionTabRoute !== '' ) {
                    this.$router.push( this.defaultQuestionTabRoute );
                }

            },


            /* ------------------------------ Display ------------------------------ */

            showQuestionPanel: function () {
            },

            toggleDashVisibility: function () {
                this.isDashColumnVisible = ! this.isDashColumnVisible;
            }


        },

        created: function () {
            let me = this;

            //this is loaded async. We call it first since we don't want the student names
            //to display if they are supposed to be hidden. However, it's not that important
            //so we're not letting it block the other requests until it loads...
            this.$store.dispatch( ngaTypes.loadGradePreferencesFromServer );

            this.$store.dispatch( 'loadExamFromServer', this.examId ).then( function () {
                me.$store.dispatch( 'loadItemsFromServer', me.examId ).then( function () {
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
                                //we now have all the basic items we need, so we can
                                //let other processes know
                                me.$store.commit( 'notifyReady' );
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