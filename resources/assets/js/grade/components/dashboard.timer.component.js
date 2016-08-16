/**
 * Created by adam on 7/19/16.
 */
//var $ = require('jquery');
//window.$ = $;

module.exports = {

    template: require( '../templates/dashboard.timer.template.html' ),

    props: [],

    data: function () {
        return {
            store: store,

            /** Start in paused state */
            paused: true,

            /** Holds the actual timer object once created */
            timer: 0,

            defaults: {
                button: {
                    label: {
                        paused: 'Paused',
                        running: 'Running'
                    },
                    icon: {
                        paused: 'glyphicon glyphicon-pause',
                        running: 'glyphicon glyphicon-play'
                    },
                    styling: {
                        paused: 'btn btn-warning',
                        running: 'btn btn-success'
                    }
                }
            },
        }

    },

    computed: {
        // store: function(){
        //   if(GOM){
        //       return GOM.store;
        //   }
        //   if(window.store){
        //       return window.store;
        //   }
        //
        //   if(store){
        //       return store;
        //   }
        // },
        /* --------------- button ------------- */
        buttonLabel: function () {
            if ( ! this.paused ) {
                return this.defaults.button.label.running;
            }
            return this.defaults.button.label.paused;
        },

        buttonIcon: function () {
            if ( ! this.paused ) {
                return this.defaults.button.icon.running;
            }
            return this.defaults.button.icon.paused;
        },

        buttonStyling: function () {
            if ( ! this.paused ) {
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
        currentExamTime: function () {
            return this.store.getActiveStudentGradingTime( );
        },

        /**
         * The time elapsed for the exam presently being graded.
         * Returns in format HH:MM:SS or MM:SS (if short enough)
         * @returns string
         */
        currentExamTimeDisplay: function () {
            return this.convertSecondsToHHMMSS( this.currentExamTime );
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
            if ( ! this.store.isActive() ) return;

            clearInterval( this.timer );

            //change state
            this.paused = false;

            // set a new timer to fire every second. Update examGradingTimes[]
            this.timer = setInterval( function () {
                me.store.increaseActiveStudentGradingTime( 1 );
            }, 1000 );
        },

        /**
         * Toggle timer between running and paused state.
         * This is bound to the timer button
         */
        toggleTimer: function () {
            if ( ! this.store.isActive() ) return;
            this.paused = ! this.paused;
            if ( this.paused ) {
                this.stopTimer()
                // clearInterval( this.timer );
            } else {
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
            this.$dispatch( 'timer-start-event' )
        },

        /**
         * Lets anyone interested know that the timer has stopped
         */
        notifyTimerStop: function () {
            this.$dispatch( 'timer-stop-event' )
        },

        /**
         * Requests that the parent save the time to the db
         */
        requestTimerSave: function(){
            this.$dispatch('time-save-request');
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