/**
 * Created by  adam on 7/11/16.
 */

var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

require( 'bootstrap' );

var Vue = require( 'vue' );

//dev
Vue.config.debug = true;


new Vue( {
    el: '#gradeExamPage',

    components: {
        'element-input': require('./components/elementInput.js'),
        'current-student-area': require('./components/currentStudentArea.js'),
        'student-list-item': require('./components/studentListItem')
    },


    data: {},

    computed: {},

    methods: {
        
    //     saveElementComment: function(){
    //
    //         //grab scores
    //         var oldScore = data.getElementScore( Roster.activeStudent, elementIndex );
    //         var score = slideEvt.value;
    //
    //         /* ---------- update the element's score visually and in data.elementScores[] --------- */
    //
    //         //store the new element score in the data object
    //         data.storeElementScore( Roster.activeStudent, elementIndex, score );
    //
    //
    //         /**
    //          * update comment text and save to DB.
    //          * Only replace text if the score has changed valence regions
    //          */
    //         if ( ! this.isSameValence( oldScore, score ) ) {
    //             //Score is in a new valence region.
    //             //So let's plug in the appropriate comment text and save to DB
    //
    //             //Store comment text in data object
    //             //Dear Adam, make sure you read the doc for storeCommentText before fucking with
    //             //anything in these lines
    //             data.storeCommentText( Roster.activeStudent, elementIndex, $elementComment.val() );
    //             var commentText = data.getCommentText( Roster.activeStudent, elementIndex, this.updateValence( score ) );
    //
    //             //update display
    //             this.updateDisplayedComment( $elementComment, commentText );
    //
    //             //send to the db
    //             AjaxHandler.saveComment( data, Roster, elementId, score, commentText );
    //
    //         } else {
    //             // Score is in the same valence region.
    //             // Jump straight to saving without changing the elementComment
    //             // Fear not. Changes directly to the comment text will be handled elsewhere.
    //             AjaxHandler.createGradeRequest( data, 'element_id', elementId, score, null, Roster );
    //         }
    //
    //         // If using bell curve (standardScoring), element score affects
    //         // the total question score, so update
    //         if ( Roster.standardScoring ) {
    //             //  updateStandardScores();
    //         }
    //
    //         callback();
    //         // //Update dashboard and roster data displayed
    //         // updateStudentDashboardAndRosterAreas( data, Dashboard, Roster );
    //         // //Sigh. The user forgot to restart the timer. Do it for them
    //         // Timer.resumeTime
    //     }
    },

    events: {
        'student-select-event': function(obj){
            window.console.log('gradeVue', 'student-select-event');
        this.$broadcast('student-select-event', obj);
        },

        /**
         * Handles the request to store comment text on the server
         */
        'store-comment-text-request': function(obj){
            window.console.log('gradeVue', 'store-comment-text-request', obj.elementIndex);
        },

        /**
         * Handles the request to store element score on the server
         */
        'store-element-score-request' : function(obj){
            window.console.log('gradeVue', 'store-element-score-request', obj.elementIndex);
        },

        /**
         * Handles request to start the grading timer
         */
        'start-timer-request': function(){
            window.console.log('gradeVue', 'caught start-timer-request');
        },

        /**
         * Handles the request to stop the grading timer
         */
        'stop-timer-request': function(){
            window.console.log('gradeVue', 'stop-timer-request');
        },

        /**
         * Handles anything not done by the elementInput when a slider stops moving
         */
        'element-slider-stop-event': function(){
            window.console.log('gradeVue', 'element-slider-stop-event');
            // this.handleElementSliderStopEvent( slideEvt, data, Roster, function () {
            //     //Update dashboard and roster data displayed
            //     updateStudentDashboardAndRosterAreas( data, Dashboard, Roster );
            //Sigh. The user forgot to restart the timer. Do it for them
            //Timer.resumeTimerIfPaused( data, Roster, Dashboard );
        }
    },


    directives: {},

    ready: function () {
        $.ajaxSetup( {
            headers: {
                'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
            }
        } );
        window.console.log( 'gradeVue.js ready' );

    }
} );

