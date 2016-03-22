/**
 * Created by adam on 3/16/16.
 */
var $ = require( 'jquery' );
window.$ = $;

var bootbox = require( 'bootbox' );
var bootstrapToggle = require( "./../../../../../node_modules/bootstrap-toggle/js/bootstrap-toggle.js" );

/**
 * Contains the tools for the exam release toggle.
 * This handles the warnings and success/failure messages.
 * It does not do the actual submission to the server. That
 * is taken care of by a parent listening for the exam-release-event
 * and exam-hide-event.
 * In turn, this listens for events to determine what messages to
 * show and which actions to take.
 */
module.exports = {

    template: require( '../templates/exam-release-toggle.template.html' ),

    props: [
        'exam-id',
        'released'
    ],

    data: function () {
        return {
            storage: {
                checked: null
            },
            onStateText: "<span class='glyphicon glyphicon-lock' aria-hidden='true'></span> Hide exam from students",
            offStateText: "<span class='glyphicon glyphicon-envelope' aria-hidden='true'></span> Release exam to students",
            buttonSize: "large",
            buttonWidth: 250,
            onStyle: "warning",
            offStyle: "primary",
            confirmMessages: {
                release: {
                    initial: "<p>Releasing this exam will e-mail all students their grades and personalized feedback.</p> <p>Do you wish to continue?</p>",

                    reRelease: "<p>Re-releasing this exam sends all students an additional message informing them that exam grades or comments may have changed.</p> <p>Do you wish to continue?</p>",
                },
                hide: {
                    initial: "<p>Removing access will prevent students from viewing feedback on the exam. Access can be restored by releasing the exam again.</p>"
                }
            },
            successMessages: {
                release: "<p>All students have been e-mailed!</p>",
                hide: "<p>All student access to the exam has been removed!</p>"
            },
            errorMessages: {
                release: "<p>Sorry, there was a problem releasing this exam!</p><p>Please try again.</p>",
                hide: "<p>Sorry, there was a problem hiding this exam!</p><p>Please try again.</p>"
            }
        };
    },

    computed: {
        checked: function () {
            if ( typeof this.released != 'undefined' ) {
                this.storage.checked = this.released;
                return this.released;
            }
            return false;
        },

        /**
         * Creates the toggle element id
         * @returns {string}
         */
        toggleId: function () {
            return "examReleaseToggle" + this.examId;
        },
    },

    methods: {
        /**
         * Displays confirmation message and handles the user's response
         */
        confirmRelease: function () {
            var me = this;
            var confirmMsg = this.released == 1 ? this.confirmMessages.release.reRelease : this.confirmMessages.release.initial;

            bootbox.confirm( confirmMsg, function ( result ) {
                window.console.log( result );
                if ( result ) {
                    me.sendReleaseExamEvent();
                }
            } );
        },

        confirmHide: function () {
            var me = this;
            bootbox.confirm( this.confirmMessages.hide.initial, function ( result ) {
                if ( result ) {
                    me.sendHideExamEvent()
                }
            } );
        },

        /**
         * Called when the toggle is switched. Determines
         * whether to request the hiding or release of the exam
         * @returns {*}
         */
        handleExamReleaseToggle: function () {
            var isChecked = $( "#" + this.toggleId ).prop( 'checked' );
            if ( isChecked ) {
                //request is to release exam
                return this.confirmRelease();
            }
            //box was checked, now not. So, exam needs to be hidden
            return this.confirmHide();
        },

        /**
         * Notifies someone else to handle releasing the exam
         */
        sendReleaseExamEvent: function () {
            this.$dispatch( 'exam-release-event', this.examId );
        },

        /**
         * Notifies someone else to handle hiding the exam
         */
        sendHideExamEvent: function () {
            this.$dispatch( 'exam-hide-event', this.examId );
        },

        handleSuccessfulRelease: function () {
            bootbox.alert( this.successMessages.release, function () {
            } );
        },

        handleSuccessfulHide: function () {
            bootbox.alert(this.successMessages.hide , function () {
            } );
        },

        handleErrorOnRelease: function () {
            //notify of error
            bootbox.alert( this.errorMessages.release );
            //flop the switch back
            $("#" + this.toggleId ).bootstrapToggle('on');
        },
        handleErrorOnHide: function () {
            //notify of error
            bootbox.alert( this.errorMessages.hide );
            //flop the switch back
            $("#" + this.toggleId ).bootstrapToggle('off');
            //$("#" + this.toggleId ).prop('checked', true ).change();
        },
    },

    events: {
        'exam-release-success': function ( examId ) {
            if(examId == this.examId){
                this.handleSuccessfulRelease();
            }
            return true;
        },
        'exam-release-error': function ( examId ) {
            if(examId == this.examId){
                this.handleErrorOnRelease();
            }
            return true;
        },
        'exam-hide-success': function ( examId ) {
            if(examId == this.examId){
                this.handleSuccessfulHide();
            }
            return true;
        },
        'exam-hide-error': function ( examId ) {
            if(examId == this.examId){
                this.handleErrorOnHide()
            }
            return true;
        },
    },

    directives: {},

    ready: function () {
        var me = this;
        $( "#" + this.toggleId ).change( function () {
            me.handleExamReleaseToggle();
        } );
    }
};