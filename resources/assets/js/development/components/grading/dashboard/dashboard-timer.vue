<template>
    <div id="dashboard-timer">

        <table class="table is-narrow">
            <tr>
                <th>Time This Exam</th>
                <td class="current-exam-time">{{ currentExamTimeDisplay }}</td>
            </tr>

            <tr>
                <th>Average Time</th>
                <td class="average-exam-time">{{ averageTimeDisplay }}</td>
            </tr>

            <tr>
                <th>Total Time</th>
                <td class="total-grading-time">{{ totalTimeDisplay }}</td>
            </tr>

            <tr>
                <th>Time Remaining</th>
                <td class="remaining-grading-time">{{ remainingTimeDisplay }}</td>
            </tr>

        </table>

        <p class="field">
            <a id="time-button"
               class="button is-fullwidth"
               title="Toggle timer"
               v-bind:class="buttonStyling"
               v-on:click="toggleTimer"
            >
                        <span class="icon is-small">
                            <i v-if="! isRunning" class="fa fa-play" aria-hidden="true"></i>

                            <i v-if="isRunning" class="fa fa-pause" aria-hidden="true"></i>
                       </span>
                <span> {{buttonLabel}} </span>
            </a>

        </p>

    </div>

</template>
<style>

</style>
<script>

    import * as ngmTypes from '../../../../store/modules/newgrading/new-grading-mutation-types';
    import * as aTypes from '../../../../store/modules/newgrading/new-grading-action-types';
    import * as nggTypes from '../../../../store/modules/newgrading/new-grading-getter-types';

    import * as gTypes from '../../../../store/getter-types';


    import Student from '../../../../models/Student';
    import PayloadTime from '../../../../models/PayloadTime';

    module.exports = {

        props: [ 'exam' ],

        data: function () {
            return {

                /** Start in paused state */
                // paused: true,

                /** Holds the actual timer object once created */
                timer: 0,

                defaults: {
                    unsetTime: ' -- : -- ',
                    button: {
                        label: {
                            paused: 'Paused',
                            running: 'Running'
                        },
                        icon: {
                            paused: '<i class="fa play" aria-hidden="true">',
                            running: '<i class="fa pause" aria-hidden="true">'
                        },
                        styling: {
                            paused: 'is-warning',
                            running: 'is-success'
                        }
                    }
                },
            }

        },

        computed: {

            activeStudent: function () {
                return this.$store.getters[ nggTypes.getActiveStudent ];
            },

            /**
             * The average time spent grading.
             * Returns in seconds
             * @returns Number
             */
            averageTime: function () {
                //avoid dividing by 0
                let storedNum = this.numberGraded;
                let numGraded = storedNum == 0 ? 1 : storedNum;
                var avgTime = this.totalTime / numGraded;
                return avgTime;
            },

            /**
             * The average time spent grading.
             * Returns in format HH:MM:SS or MM:SS (if short enough)
             * @returns string
             */
            averageTimeDisplay: function () {
                return this.convertSecondsToHHMMSS( this.averageTime );
            },


            /* --------------- button ------------- */
            buttonLabel: function () {
                if ( this.isRunning ) {
                    return this.defaults.button.label.running;
                }
                return this.defaults.button.label.paused;
            },

            buttonStyling: function () {
                if ( this.isRunning ) {
                    return this.defaults.button.styling.running;
                }
                return this.defaults.button.styling.paused;
            },

            /**
             * The time elapsed for the exam presently being graded.
             * Returns in format HH:MM:SS or MM:SS (if short enough)
             * @returns string
             */
            currentExamTimeDisplay: function () {
                if ( _.isUndefined( this.seconds ) ) return this.defaults.unsetTime;
                return this.convertSecondsToHHMMSS( this.seconds );
            },

            /**
             * Number of exams already graded
             */
            numberGraded: function () {
                return this.$store.getters[ gTypes.getNumberGraded ];
            },

            /**
             * Whether the timer is presently running
             */
            isRunning: function () {
                return this.$store.getters[ nggTypes.isTimerRunning ];
            },

            /**
             * Whether a student has been selected for
             * grading. This is primarily used to ensure that
             * we don't call for the timer to start unless a student
             * is selected.
             */
            isStudentSelected: function () {
                let s = this.$store.getters[ nggTypes.getActiveStudent ];
                if ( !_.isUndefined( s ) && !_.isNull( s ) ) return true;
                return false;
            },


            /**
             * Returns estimated time remaining in seconds
             * TODO Strip outliers to make more accurate
             * @returns Number
             */
            remainingTime: function () {
                let remainingExams = this.$store.getters[ gTypes.getNumberUngraded ];
                let estTime = this.averageTime * remainingExams;
                // let timeRemaining = estTime - this.totalTime;
                return estTime;
            },

            /**
             * Returns estimated time remaining formatted for display
             * Returns in format: HH:MM:SS
             * @returns string
             */
            remainingTimeDisplay: function () {
                return this.convertSecondsToHHMMSS( this.remainingTime );
            },

            /**
             * The time elapsed for the exam presently being graded.
             * Returns in seconds
             * @returns Number
             */
            seconds: {
                get: function () {
                    if ( this.activeStudent ) return this.activeStudent.gradingTime;
                },
                set: function ( v ) {
                    this.updateTime( v );
                }
            },


            /**
             * The total time spent grading
             * Returns in seconds
             * @returns Number
             */
            totalTime: function () {
                return this.$store.getters.getTotalGradingTime;
            },

            /**
             * The total time spent grading
             * Returns in format: HH:MM:SS
             * @returns string
             */
            totalTimeDisplay: function () {
                return this.convertSecondsToHHMMSS( this.totalTime );
            },

        },

        watch: {
            /**
             * We need other page components to be
             * able to start and stop the timer.
             * Thus its state is stored centrally and
             * we need to react to changes by loading the actual
             * timer.
             */
            isRunning: function ( newVal ) {
                if ( newVal ) this.startTimer();

                //stop if the new value is false;
                if ( !newVal ) this.stopTimer();
            }
        },

        methods: {

            convertSecondsToHHMMSS: function ( seconds ) {
                if ( isNaN( seconds ) ) return "00:00:00";
                var date = new Date( null );
                date.setSeconds( seconds );
                if ( seconds < 3600 ) return date.toISOString().substr( 14, 5 );
                else return date.toISOString().substr( 11, 8 );
            },

            /**
             * Handles everything that needs to be done
             * on timer start
             */
            startTimer: function () {
                this.$store.dispatch( aTypes.startExamTimer );
            },

            /**
             * Handles everything that needs to be done
             * on timer stop
             */
            stopTimer: function () {
                this.$store.dispatch( aTypes.stopExamTimer );
            },

            /**
             * Toggle timer between running and paused state.
             * This is bound to the timer button
             */
            toggleTimer: function () {
                if ( !this.isStudentSelected ) return false;
                if ( this.isRunning ) {
                    //stop the timer if now is running
                    this.stopTimer();
                } else {
                    //start the timer if now not running
                    this.startTimer();
                }
            },

        },


    };
</script>