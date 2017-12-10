<template>
    <div id="dashboard-timer">
        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <span class="icon" aria-hidden="true">
                        <i class="fa fa-tachometer">Statistics</i>
                    </span>
                </div>
            </div>

            <div class="level-right">
                <div class="level-item">
                    <a id="time-button"
                       class="button is-fullwidth"
                       title="Toggle timer"
                       v-bind:class="buttonStyling"
                       v-on:click="toggleTimer"
                    >
                        <span class="icon">{{ buttonIcon }}</span> {{buttonLabel}}
                    </a>
                </div>

            </div>
        </div>

        <table class="table is-narrow">
            <tr>
                <th>Time This Exam</th>
                <td>{{ currentExamTimeDisplay }}</td>
            </tr>

            <tr>
                <th>Average Time</th>
                <td>{{ averageTimeDisplay }}</td>
            </tr>

            <tr>
                <th>Total Time</th>
                <td>{{ totalTimeDisplay }}</td>
            </tr>

            <tr>
                <th>Time Remaining</th>
                <td>{{ remainingTimeDisplay }}</td>
            </tr>

        </table>
    </div>

</template>
<style>

</style>
<script>

    import * as mTypes from '../../../../store/modules/newgrading/new-grading-mutation-types';
    import * as aTypes from '../../../../store/modules/newgrading/new-grading-action-types';
    import * as gTypes from '../../../../store/modules/newgrading/new-grading-getter-types';
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
                return this.$store.getters[ gTypes.getActiveStudent ];
            },

            isRunning : function (  ) {
                    return this.$store.getters[ gTypes.isTimerRunning ];
            },

            /**
             * This is the value everything originally used
             */
            paused: function () {
                return ! this.isRunning;
            },

            /* --------------- button ------------- */
            buttonLabel: function () {
                if ( !this.paused ) {
                    return this.defaults.button.label.running;
                }
                return this.defaults.button.label.paused;
            },

            buttonIcon: function () {
                if ( !this.paused ) {
                    return this.defaults.button.icon.running;
                }
                return this.defaults.button.icon.paused;
            },

            buttonStyling: function () {
                if ( !this.paused ) {
                    return this.defaults.button.styling.running;
                }
                return this.defaults.button.styling.paused;
            },


            /* --------------- time ------------- */
            /**
             * The average time spent grading.
             * Returns in seconds
             * @returns Number
             */
            averageTime: function () {
                //avoid dividing by 0
                let storedNum = this.store.getNumberGraded();
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

            /**
             * The time elapsed for the exam presently being graded.
             * Returns in seconds
             * @returns Number
             */
            seconds: {
                get: function () {
                    return this.activeStudent.gradingTime;
                }, set: function ( v ) {
                    this.updateTime( v );
                }
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
             * The total time spent grading
             * Returns in seconds
             * @returns Number
             */
            totalTime: function () {
                return this.store.getTotalGradingTime();
                // var totalTime = 0;
                // $.each( this.store.examGradingTimes, function ( index, value ) {
                //     totalTime += value;
                // } );
                // return totalTime;
            },

            /**
             * The total time spent grading
             * Returns in format: HH:MM:SS
             * @returns string
             */
            totalTimeDisplay: function () {
                return this.convertSecondsToHHMMSS( this.totalTime );
            },

            /**
             * Returns estimated time remaining in seconds
             * TODO Strip outliers to make more accurate
             * @returns Number
             */
            remainingTime: function () {
                let numberExams = this.store.getTotalExams();
                let estTime = this.averageTime * numberExams;
                let timeRemaining = estTime - this.totalTime;
                return timeRemaining;
            },

            /**
             * Returns estimated time remaining formatted for display
             * Returns in format: HH:MM:SS
             * @returns string
             */
            remainingTimeDisplay: function () {
                return this.convertSecondsToHHMMSS( this.remainingTime );
            },

        },

        watch:{
          isRunning: function ( newVal ) {
              if (newVal) this.startTimer();

              //stop if the new value is false;
              if (! newVal) this.stopTimer();
          }
        },

        methods: {

            /**
             * Handles everything that needs to be done
             * on timer start
             */
            startTimer: function () {
                this.loadTimer();
                //we don't need to request that the time be saved
                //the parent will do that automatically on being
                //notified that the timer has started.
                this.notifyTimerStart();
            },

            /**
             * Handles everything that needs to be done
             * on timer stop
             */
            stopTimer: function () {
                clearInterval( this.timer );
                this.paused = true;
                //we don't need to request that the time be saved
                //the parent will do that automatically on being
                //notified that the timer has stopped.
                this.notifyTimerStop();
            },

            /**
             * Load timer for the active student and sets state to running
             * @param data
             * @param Roster
             */
            loadTimer: function () {
                var me = this;

                //if no student is active, don't start
                if ( !this.store.isActive() ) return;

                clearInterval( this.timer );

                //change state
                // this.paused = false;

                // set a new timer to fire every second.
                this.timer = setInterval( function () {
                    //increment the time
                    let newTime = me.seconds += 1;
                    //tell store to record it
                    me.updateTime( newTime );
                }, 1000 );
            },

            /**
             * Toggle timer between running and paused state.
             * This is bound to the timer button
             */
            toggleTimer: function () {
                //if no student is selected, do nothing
                if ( !this.store.isActive() ) return;

                //otherwise, update the local stored state
                this.paused = !this.paused;

                if ( this.paused ) {
                    //stop the timer if now not running
                    this.stopTimer()
                } else {
                    //start the timer if now is running
                    this.startTimer();
                }
            },

            convertSecondsToHHMMSS: function ( seconds ) {
                if ( isNaN( seconds ) ) return "00:00:00";
                var date = new Date( null );
                date.setSeconds( seconds );
                if ( seconds < 3600 ) return date.toISOString().substr( 14, 5 );
                else return date.toISOString().substr( 11, 8 );
            },

            /* ---------------------- Events and notifications ---------------- */
            /**
             * Lets anyone interested know that the timer has started
             */
            notifyTimerStart: function () {
                this.$emit( 'timer-start' )
            },

            /**
             * Lets anyone interested know that the timer has stopped
             */
            notifyTimerStop: function () {
                this.$emit( 'timer-stop' )
            },

            /**
             * Sends update request to store
             * which will be intercepted and
             * save the time to the db
             */
            updateTime: function ( newTotalTime ) {
                let pl = PayloadTime.factory( { exam: this.exam, student: this.student, time: newTotalTime } );
                this.$store.dispatch( aTypes.setTime, pl );
            }
        },

        events: {
            /**
             * Handles request to start the timer
             */
            'start-timer-request': function () {
                window.console.log( 'dashboard.timer', 'caught start-timer-request' );
                this.startTimer();
            },

            /**
             * Handles request to start the timer
             */
            'stop-timer-request': function () {
                window.console.log( 'dashboard.timer', 'caught stop-timer-request' );
                this.stopTimer();
            }
        },

    };
</script>