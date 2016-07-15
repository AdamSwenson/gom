/**
 * Created by adam on 7/11/16.
 */
//
var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

var template = require( "../templates/element-input.template.html" );
var Slider = require( "../../libraries/bootstrap-slider-modified.js" );

module.exports = {

    template: template,

    props: [
        'elementNumber',
        'elementIndex',
        'elementId',
        'elementName',

        'questionNumber'
    ],
//elementId = $elements[$eNumber-1]->getId()
    data: function () {
        return {

            /**
             * The data repository store shared by everyone
             */
            store: store,

            /**
             * Whether the current comment text is customized (as opposed to stock).
             * When this is true, moving the slider should not change the text.
             */
            isCustom: false,

            settings: {
                sliderStep: 0.25,
                valenceCutoffs: [ 0, 3.25, 6.75, 10 ],
                valenceLabels: [ "Missing", "Poor", "Fair", "Excellent" ],
                valenceLabelPositions: [ 0, 33, 67, 100 ]
            }
        };
    },

    computed: {
        /**
         * The current value of the text area
         */
        commentText: {
            cache: false,
            get: function () {
               return this.store.getCommentText( this.activeStudent, this.elementIndex, this.getValence( this.elementScore ) );
            },
            set: function ( text ) {
                this.store.storeCommentText( this.activeStudent, this.elementIndex, text );
                //send to the db
                this.notifyStoreCommentText();
            }
        },

        /**
         * The current value of the slider
         */
        elementScore: {
            cache: false,
            get: function () {
                return this.store.getElementScore( this.store.activeStudent, this.elementIndex )
            },
            set: function ( score ) {
                this.store.storeElementScore( this.store.activeStudent, this.elementIndex, score )
                this.notifyStoreElementScore()
            }
        },

        /**
         * The valence corresponding to the currently set element score
         * @returns {*}
         */
        currentValence: function () {
            //return false if no element score set
            if ( typeof this.elementScore == 'undefined' || this.elementScore == null ) {
                return false;
            }

            return this.getValence( this.elementScore );
        },

        /**
         * Shortcut to where the active student is stored
         * @returns {module.exports.computed.activeStudent|null|*}
         */
        activeStudent: function () {
            return this.store.activeStudent;
        },


        /**
         * Returns the string id of the comment area
         * @returns {string}
         */
        commentAreaId: function () {
            return "commentQ" + this.questionNumber + "E" + this.elementNumber;
        },

        /**
         * Returns the jQuery selector for the comment area
         * @returns {*|jQuery|HTMLElement}
         */
        commentSelector: function () {
            // return document.getElementById(this.commentAreaId);
            return $( '#' + this.commentAreaId );
        },

        /**
         * Returns the string of the element's description to be displayed on the page
         * @returns {string}
         */
        elementTitle: function () {
            return "Element #" + this.elementNumber + ": " + this.elementName;
        },

        /**
         * Returns the string id of the slider element
         * @returns {string}
         */
        sliderId: function () {
            return "sliderQ" + this.questionNumber + "E" + this.elementNumber;
        },

        /**
         * Returns the jQuery selector for the slider element
         * @returns {*|jQuery|HTMLElement}
         */
        sliderSelector: function () {
            // return document.getElementById(this.sliderId);
            return $( '#' + this.sliderId );
        }


    },

    methods: {

        /* ------------------ Display manipulation ------------------------------ */
        /**
         * Sets the comment area to empty (user should see the place holder).
         * Usually used to clear out any text that might be left from other users
         */
        emptyCommentArea: function () {
            this.commentText = '';
            // $( this ).val( '' );
        },

        /**
         * Allow user to enter text into comment area
         */
        enableCommentArea: function () {
            this.commentSelector.removeAttribute( 'readonly' );
            // this.commentSelector.removeAttr( 'readonly' );
            // this.commentSelector.prop( 'readonly', '' );
        },

        /**
         * Prevent user from entering text into comment area
         */
        disableCommentArea: function () {
            this.commentSelector.setAttribute( 'readonly', 'true' );
            // this.commentSelector.prop( 'readonly', 'true' );
        },

        /**
         * Updates the displayed comment to match the current slider value.
         */
        updateComment: function () {
            // set comments

            // var thisComment = data.elementComments[ Roster.activeStudent ][ index ];
            //  var elementScore = this.store.getElementScore( this.store.activeStudent, index );

            //TODO Add a test for the potential corner cases making the default null creates

            if ( this.elementScore === null ) {
                // clear any text that might have been left over from another user
                // this.emptyCommentArea();
                // if NULL, disable comment text area until a slider is moved.
                // this is so that the user doesn't enter custom text, move the slider,
                // and then see their custom text irreversibly wiped out.
                this.disableCommentArea();
                // $( this ).prop( 'readonly', 'true' );
            } else {
                // It has already been scored, so retrieve and set the comment text
                //  this.updateValence( this.elementScore );

                //  this.retrieveStoredCommentText();
                // var thisComment = data.getCommentText( this.activeStudent, index, valence );
                // $( this ).val( thisComment );

                //no need for it to remain read only
                this.enableCommentArea();
                //$( this ).prop( 'readonly', '' );
            }
            // } );
        },

        /* ------------------------------- Valence helpers -------------------------------- */
        /**
         * Sets currentValence to which valence group a [score] belongs to by comparing with valenceCutoffs[]
         * i.e. a score > 0 and <= 2.5 will be in the 'poor' valence (1)
         * @param score
         * @returns {number}
         */
        getValence: function ( score ) {
            var valence = 0;
            var me = this;

            //TODO Decide what should do if this gets null for the score

            for ( var j = me.settings.valenceCutoffs.length - 2; j >= 0; j -- ) {
                if ( score > me.settings.valenceCutoffs[ j ] ) {
                    valence = j + 1;
                    break;
                }

            }
            return valence;
        },

        /**
         * Check whether the old and new scores have the same valence.
         * If they are, return true.
         * If not or if oldScore wasn't set, return false
         * @param oldScore
         * @param newScore
         * @returns {boolean}
         */
        isSameValence: function ( oldScore, newScore ) {
            //if there was no old score, return false
            if ( typeof oldScore == 'undefined' || oldScore == null ) {
                return false;
            }
            if ( this.getValence( newScore ) != this.getValence( oldScore ) ) {
                return false;
            }
            return true;
        },


        /**
         * Called when an element slider stops movement. Updates element
         * score and text (if necessary), then saves score, text and time
         * @param slideEvt
         * @param data
         * @param Roster
         * @param callback
         */
        handleElementSliderStopEvent: function ( slideEvt, callback ) {
            //grab scores
            var oldScore = this.store.getElementScore( this.activeStudent, this.elementIndex );
            //store the new element score in the data object
            this.elementScore = slideEvt.value;

            /**
             * update comment text and save to DB.
             * Only replace text if the score has changed valence regions
             */
            if ( ! this.isSameValence( oldScore, this.elementScore ) ) {
                //Score is in a new valence region.
                //So let's plug in the appropriate comment text and save to DB

                //Store comment text in data object
                //Dear Adam, make sure you read the doc for storeCommentText before fucking with
                //anything in these lines
                //this.commentText = this.commentSelector.val();
                this.commentText = this.store.getCommentText( this.activeStudent, this.elementIndex, this.getValence( this.elementScore ) );

                //update display
                // this.updateDisplayedComment( $elementComment, commentText );


                // AjaxHandler.saveComment( data, Roster, elementId, score, commentText );

            } else {
                // Score is in the same valence region.
                // Jump straight to saving without changing the elementComment
                // Fear not. Changes directly to the comment text will be handled elsewhere.
                // this.notifyStoreElementScore();
//                AjaxHandler.createGradeRequest( data, 'element_id', elementId, score, null, Roster );
            }

            // If using bell curve (standardScoring), element score affects
            // the total question score, so update
            // if ( Roster.standardScoring ) {
            //     //  updateStandardScores();
            // }

            if ( typeof callback != 'undefined' ) {
                return callback();
            }

            // //Update dashboard and roster data displayed
            // updateStudentDashboardAndRosterAreas( data, Dashboard, Roster );
            // //Sigh. The user forgot to restart the timer. Do it for them
            // Timer.resumeTimerIfPaused( data, Roster, Dashboard );
        },

        /* --------------------- Notifications to observers ---------------------- */
        /**
         * Requests that the db be updated with the element score.
         * The element score is already stored in the shared storage object, so
         * we just need to tell the observer which element needs updating.
         */
        notifyStoreElementScore: function () {
            this.$dispatch( 'store-element-score-request', { elementIndex: this.elementIndex } );
        },

        /**
         * Requests that the db be updated with comment text
         */
        notifyStoreCommentText: function () {
            this.$dispatch( 'store-comment-text-request', { elementIndex: this.elementIndex } );
        },

        /**
         * Requests that the grading timer be started, if paused
         */
        notifyStartTimer: function () {
            this.$dispatch( 'start-timer-request', this.elementIndex );

        },

        /**
         * Notifies any listeners that a slide event has occurred
         * @param slideEvent
         */
        notifySlideEvent: function ( slideEvent ) {
            this.$dispatch( 'element-slider-stop-event', this.elementIndex );
        }


    },
    events: {

        /**
         * Listens for a new student being selected. Responds by
         * setting the slider and comment to the stored values (or
         * default values, if not yet graded) for that
         * student.
         * @param elementIndex
         * @param activeStudent
         */
        'student-select-event': function ( elementIndex, activeStudent ) {
            if ( elementIndex == this.elementIndex ) {
                //update the comment text
            }
        }
    },

    ready: function () {
        var me = this;
        // initialize slider
        $( '#' + this.sliderId ).slider( {
            tooltip: 'show',
            value: this.elementScore,
            step: this.settings.sliderStep,
            ticks: this.settings.valenceCutoffs,
            ticks_labels: this.settings.valenceLabels,
            ticks_position: this.settings.valenceLabels
            // id: Counter()
        } );

        /* ----------------- slider listeners --------------- */
        /* When an element slider stops movement,
         update element score and text (if necessary),
         then save score, text and time
         *  */
        this.sliderSelector.on( 'slideStop', function ( slideEvt ) {
            me.handleElementSliderStopEvent( slideEvt );
            me.notifySlideEvent();
            // this.handleElementSliderStopEvent( slideEvt, data, Roster, function () {
            //     //Update dashboard and roster data displayed
            //     updateStudentDashboardAndRosterAreas( data, Dashboard, Roster );
            //Sigh. The user forgot to restart the timer. Do it for them
            //Timer.resumeTimerIfPaused( data, Roster, Dashboard );
        } );
        // window.console.log('store', this.store);
        window.console.log('input ready', 'elementIndex', this.elementIndex);
    }
};