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
        'released',
        'graded',
        'previously-released'
    ],

    data: function () {
        return {
            storage: {
                checked: null,
                /**
                 * This will be initially set from the prop. It
                 * will also be altered after successful ajax calls.
                 * The reason for separating this from checked is that
                 * the checked state changes when the toggle is clicked
                 * regardless of whether the release operation is actually
                 * carried out.
                 * Thus this state only changes upon confirmation from the
                 * server.
                 */
                isReleased: null,
                previouslyReleased: null,
                ignoreToggle: false
            },
            onStateText: "<span class='glyphicon glyphicon-lock' aria-hidden='true'></span> Hide exam from students",
            offStateText: "<span class='glyphicon glyphicon-envelope' aria-hidden='true'></span> Release exam to students",
            buttonSize: "large",
            buttonWidth: 250,
            onStyle: "warning",
            offStyle: "primary",
            confirmMessages: {
                release: {
                    initial: "<p class='confirmText releaseConfirmText'>Releasing this exam will e-mail all students their grades and personalized feedback.</p> <p class='confirmText releaseConfirmText'>Do you wish to continue?</p>",

                    reRelease: "<p class='confirmText reReleaseConfirmText'>Re-releasing this exam sends all students an additional message informing them that exam grades or comments may have changed.</p><p class='confirmText reReleaseConfirmText'> Do you wish to continue?</p>",
                },
                hide: {
                    initial: "<p class='confirmText hideConfirmText'>Removing access will prevent students from viewing feedback on the exam.</p> <p class='confirmText hideConfirmText'> Access can be restored by releasing the exam again.</p>"
                }
            },
            successMessages: {
                release: "<p class='successText releaseSuccess'>All students have been e-mailed!</p>",
                hide: "<p class='successText hideSuccess'>All student access to the exam has been removed!</p>"
            },
            errorMessages: {
                release: "<p class='errorText releaseError'>Sorry, there was a problem releasing this exam!</p><p class='errorText releaseError'>Please try again.</p>",
                hide: "<p class='errorText hideError'>Sorry, there was a problem hiding this exam!</p><p class='errorText hideError'> Please try again.</p>"
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
         * Whether the exam has been released before. This
         * matters to which confirmation message the user
         * receives on release requests.
         * @returns {*}
         */
        priorRelease: function () {
            if ( this.storage.previouslyReleased != null ) {
                //if the value has been set, return it.
                //this should trump the original server value in case
                //the exam has been released and hidden in the current
                //session
                return this.storage.previouslyReleased;
            }
            else if ( typeof this.previouslyReleased != 'undefined' ) {
                //if the value isn't stored, then set the server's value
                //in storage before returning it
                if ( this.previouslyReleased == "1" ) {
                    this.storage.previouslyReleased = true;
                }
                return this.storage.previouslyReleased;
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
            var confirmMsg = this.priorRelease == true ? this.confirmMessages.release.reRelease : this.confirmMessages.release.initial;

            // bootbox.confirm( confirmMsg, function ( result ) {
            //     window.console.log( 'confirmRelease', result );
            //     if ( result ) {
            //         me.sendReleaseExamEvent();
            //     } else {
            //         me.handleCanceledRelease();
            //     }
            // } );

            bootbox.dialog( {
                className: "confirmationModal",
                message: confirmMsg,
                title: "Confirm releasing exam",
                buttons: {
                    success: {
                        label: 'Cancel',
                        className: "btn-sm cancelRelease",
                        callback: function () {
                            me.handleCanceledRelease();
                        }
                    },
                    danger: {
                        label: '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span> Confirm',
                        className: "btn-sm btn-danger confirmRelease",
                        callback: function () {
                            me.sendReleaseExamEvent();
                        }

                    }
                }
            } );
            // }
        },

        confirmHide: function () {
            var me = this;

            bootbox.dialog( {
                className: "confirmationModal",
                message: this.confirmMessages.hide.initial,
                title: "Confirm hiding exam",
                buttons: {
                    success: {
                        label: 'Cancel',
                        className: "btn-sm cancelHide",
                        callback: function () {
                            me.handleCanceledHide();
                        }
                    },
                    danger: {
                        label: '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span> Confirm',
                        className: "btn-danger btn-sm confirmHide",
                        callback: function () {
                            me.sendHideExamEvent();
                        }
                    }
                }
            } );
            //
            // bootbox.confirm( this.confirmMessages.hide.initial, function ( result ) {
            //     window.console.log( 'confirmHide', result );
            //     if ( result ) {
            //         me.sendHideExamEvent();
            //     } else {
            //         me.handleCanceledHide();
            //     }
            // } );
        },

        /**
         * Called when the toggle is switched. Determines
         * whether to request the hiding or release of the exam
         * @returns {*}
         */
        handleExamReleaseToggle: function () {
            if (this.storage.ignoreToggle){
                return true;
            }

            var isChecked = $( "#" + this.toggleId ).prop( 'checked' );
            if ( isChecked ) {
                //request is to release exam
                return this.confirmRelease();
            }
            //the box was checked, now it is not.
            //Things now get a bit tricky....
            switch ( this.storage.isReleased ) {
                case true:
                    /*
                     isReleased only gets set to true in two cases:
                     (1) if the exam was released when the page was loaded; or
                     (2) if the ajax request to release was successful.
                     In either case, the exam is marked released in the database.
                     So, we know that the request is to hide the exam.
                     */
                    return this.confirmHide();
                    break;

                case false:
                    /*
                     We're here because of a toggle event. Toggle events occur when
                     a user clicks, or when the state is programmatically changed.
                     The programmatic changes can occur in several ways:
                     (B1) The user canceled the release request; or
                     (B2) The release request failed on the server's side.
                     (B3) The user canceled the hide request; or
                     (B4) The hide request failed on the server side.
                     isReleased is false only if
                     (A1) it was set onload because the prop released was undefined.
                     (A2) a successful hide request happened.
                     Thus neither B1 nor B2 requires any confirmation action.
                     */
                    return false;
                    break;
                default:
                    //includes original state (null)
                    return false;

            }

        },

        /**
         * Called when the user cancels the release request
         */
        handleCanceledRelease: function () {
            //The operation was canceled. But the toggle
            //is still in the checked state. If we don't
            //reset it, it will think that the exam has
            //already been released. So, let's reset it
            this.storage.ignoreToggle = true;
            $( "#" + this.toggleId ).bootstrapToggle( 'off' );
            this.storage.ignoreToggle = false;
        },

        handleCanceledHide: function () {
            //The operation was canceled. But the toggle
            //is still in the unchecked state. If we don't
            //reset it, it will think that the exam has
            //been released. So, let's reset it
            this.storage.ignoreToggle = true;
            $( "#" + this.toggleId ).bootstrapToggle( 'on' );
            this.storage.ignoreToggle = false;
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
            //only now should this guy think he's released
            this.storage.isReleased = true;
            this.storage.previouslyReleased = true;
            bootbox.alert( this.successMessages.release, function () {
            } );
        },

        handleSuccessfulHide: function () {
            //only now should this guy be sure he's not released
            this.storage.isReleased = false;
            bootbox.alert( this.successMessages.hide, function () {
            } );
        },

        handleErrorOnRelease: function () {
            //notify of error
            bootbox.alert( this.errorMessages.release );
            //flop the switch back
            $( "#" + this.toggleId ).bootstrapToggle( 'on' );
        },

        handleErrorOnHide: function () {
            //notify of error
            bootbox.alert( this.errorMessages.hide );
            //flop the switch back
            $( "#" + this.toggleId ).bootstrapToggle( 'off' );
        },

        /**
         * Check whether the exam has been graded. If not,
         * disable the toggle.
         */
        checkIfGraded: function () {
            if ( typeof this.graded != 'undefined' && this.graded == "1" ) {
                window.console.log( this.graded );
                return false;
            }
            window.console.log( 'out', this.graded );
            $( "#" + this.toggleId ).bootstrapToggle( 'disable' );

            //or do here? should disabled be the default?
        }
    },

    events: {
        'exam-release-success': function ( examId ) {
            if ( examId == this.examId ) {
                this.handleSuccessfulRelease();
            }
            return true;
        },

        'exam-release-error': function ( examId ) {
            if ( examId == this.examId ) {
                this.handleErrorOnRelease();
            }
            return true;
        },

        'exam-hide-success': function ( examId ) {
            if ( examId == this.examId ) {
                this.handleSuccessfulHide();
            }
            return true;
        },

        'exam-hide-error': function ( examId ) {
            if ( examId == this.examId ) {
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

        //set isReleased state
        if ( typeof this.released != 'undefined' && this.released != '' ) {
            if ( this.released == "1" ) {
                this.storage.isReleased = true;
            } else {
                //just in case...
                this.storage.isReleased = this.released;
            }
        } else {
            this.storage.isReleased = false;
        }

        this.checkIfGraded();
    }
}
;