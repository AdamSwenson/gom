/**
 * Created by adam on 5/15/16.
 */
var $ = require('jquery');
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

/**
 * Controls the exam timer
 * @type {{me: *, timer: null, timerPaused: boolean, saveTimer: Timer.saveTimer, loadTimer: Timer.loadTimer, resumeTimerIfPaused: Timer.resumeTimerIfPaused, toggleTimer: Timer.toggleTimer, updateTimer: Timer.updateTimer, convertSecondsToHHMMSS: Timer.convertSecondsToHHMMSS}}
 */
module.exports = {
        /** Holds the actual timer object once created */
        timer: null,
        /** Start in paused state */
        timerPaused: true,

        /**
         * Save timer for the active student and update the displays
         * for avg time, total time, and time remaining.
         * @param data
         * @param Roster
         * @param AjaxHandler
         */
        saveTimer: function ( data, Roster, AjaxHandler, Dashboard ) {
            if ( Roster.activeStudent === null ) return;
            data.examGradingTimes[ Roster.activeStudent ] = Roster.activeStudentTime;
            AjaxHandler.saveDataWithTime( null, data, Roster );
            this.updateTimer( data, Roster, Dashboard );
        },

        /**
         * Load timer for the active student and sets state to running
         * @param data
         * @param Roster
         */
        loadTimer: function ( data, Roster, Dashboard ) {
            if ( Roster.activeStudent === null ) return;
            clearInterval( this.timer );
            $( '#btnTimerLabel' ).text( 'Running' );
            $( '#btnTimer' ).attr( 'class', 'btn btn-success' );
            $( '#btnTimerIcon' ).attr( 'class', 'glyphicon glyphicon-play' );
            this.timerPaused = false;
            var me = this;

            // set a new timer to fire every second. Update examGradingTimes[]
            Roster.activeStudentTime = data.examGradingTimes[ Roster.activeStudent ];
            this.timer = setInterval( function () {
                data.examGradingTimes[ Roster.activeStudent ] = ++ Roster.activeStudentTime;
                me.updateTimer( data, Roster, Dashboard );
            }, 1000 );
        },

        /**
         * if the timer is paused, enable it
         */
        resumeTimerIfPaused: function ( data, Roster, Dashboard ) {
            if ( this.timerPaused ) this.toggleTimer( data, Roster, Dashboard );
        },

        /**
         * Toggle timer between running and paused state
         * @param data
         * @param Roster
         */
        toggleTimer: function ( data, Roster, Dashboard ) {
            if ( Roster.activeStudent === null ) return;
            this.timerPaused = ! this.timerPaused;
            if ( this.timerPaused ) {
                $( '#btnTimerLabel' ).text( 'Paused' );
                $( '#btnTimer' ).attr( 'class', 'btn btn-warning' );
                $( '#btnTimerIcon' ).attr( 'class', 'glyphicon glyphicon-pause' );
                clearInterval( this.timer );
            } else {
                this.loadTimer( data, Roster, Dashboard );
            }
        },

        /**
         * Updates the statistics area. Called once per second by the timer.
         * @param data
         * @param Roster
         * @param Dashboard
         */
        updateTimer: function ( data, Roster, Dashboard ) {
            var totalTime = 0;
            $.each( data.examGradingTimes, function ( index, value ) {
                totalTime += value;
            } );
            var avgTime = totalTime / ( (Dashboard.examsGraded( data ) == 0) ? 1 : Dashboard.examsGraded( data ) );
            var estTime = avgTime * data.numStudents;
            var timeRemaining = estTime - totalTime;

            if ( Roster.activeStudent ) {
                $( '#thisExamTime' ).text( this.convertSecondsToHHMMSS( data.examGradingTimes[ Roster.activeStudent ] ) );
            }
            $( '#avgTime' ).text( this.convertSecondsToHHMMSS( avgTime ) );
            $( '#totalTime' ).text( this.convertSecondsToHHMMSS( totalTime ) );
            $( '#timeRemaining' ).text( this.convertSecondsToHHMMSS( timeRemaining ) );
        },

        convertSecondsToHHMMSS: function ( seconds ) {
            if ( isNaN( seconds ) ) return "00:00:00";
            var date = new Date( null );
            date.setSeconds( seconds );
            if ( seconds < 3600 ) return date.toISOString().substr( 14, 5 );
            else return date.toISOString().substr( 11, 8 );
        }
    };