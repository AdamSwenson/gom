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
var Requests = require('./requests.tools');

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
         * Shortcut to where the active student is stored
         * @returns {module.exports.computed.activeStudent|null|*}
         */
        activeStudent: function () {
            return this.store.getActiveStudentIndex();
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
            return $( '#' + this.commentAreaId );
        },

        /**
         * The current value of the text area
         */
        commentText: {
            cache: false,
            get: function () {
                //setting this to just this.elementScore prevents missing from displaying comment.
                //when element score was 0.
                //Also led to custom comments being deleted when moved to missing
                if ( this.elementScore != null)
                // window.console.log('elementInput', 'commentText', this.elementScore, this.getValence( this.elementScore ) );
                    return this.store.getCommentTextForActiveStudent( this.elementIndex, this.getValenceForScore( this.elementScore ) );
            },
            set: function ( text ) {
                this.store.storeCommentTextForActiveStudent( this.elementIndex, text );
                //send to the db
                this.notifyStoreCommentText();
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

            return this.getValenceForScore( this.elementScore );
        },

        /**
         * The current value of the slider
         */
        elementScore: {
            cache: false,
            get: function () {
                // window.console.log('elementInput', 'elementScore', this.store.getElementScoreForActiveStudent( this.elementIndex ), this.elementIndex );
                return this.store.getElementScoreForActiveStudent( this.elementIndex );
            },
            set: function ( score ) {
                this.store.storeElementScoreForActiveStudent( this.elementIndex, score );
                this.notifyStoreElementScore( score )
            }
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
            return $( '#' + this.sliderId );
        }
    },

    methods: {

        /* ------------------ Display manipulation ------------------------------ */
        /**
         * Sets the comment area to empty (user should see the place holder).
         * Usually used to clear out any text that might be left from other users
         */
        commentAreaEmpty: function () {
            this.commentText = '';
        },

        /**
         * Prevent user from entering text into comment area
         */
        commentAreaDisable: function () {
            this.commentSelector.setAttribute( 'readonly', 'true' );
        },

        /**
         * Allow user to enter text into comment area
         */
        commentAreaEnable: function () {
            this.commentSelector.removeAttribute( 'readonly' );
        },

        /**
         * Updates the displayed comment to match the current slider value.
         * TODO Add a test for the potential corner cases making the default null creates
         */
        commentAreaUpdate: function () {
            if ( this.elementScore === null ) {
                // clear any text that might have been left over from another user
                // this.commentAreaEmpty();
                // if NULL, disable comment text area until a slider is moved.
                // this is so that the user doesn't enter custom text, move the slider,
                // and then see their custom text irreversibly wiped out.
                this.commentAreaDisable();
            } else {
                // It has already been scored, so the comment text will be retrieved and set.
                //no need for it to remain read only
                this.commentAreaEnable();
            }
        },

        /* ------------------------------- Valence helpers -------------------------------- */
        /**
         * Sets currentValence to which valence group a [score] belongs to by comparing with valenceCutoffs[]
         * i.e. a score > 0 and <= 2.5 will be in the 'poor' valence (1)
         *
         * @param score
         * @returns {number}
         */
        getValence: function ( score ) {
            let me = this;
            if ( score === null )throw new Error( "cannot get valence for null" );
            if ( score < 0 || score > me.settings.valenceCutoffs[ me.settings.valenceCutoffs.length - 1 ] )throw new Error( "cannot get valence. value out of range" );

            let valence = 0;
            //start at the second largest value in the cutoffs.
            for ( let j = me.settings.valenceCutoffs.length - 2; j >= 0; j -- ) {
                if ( score > me.settings.valenceCutoffs[ j ] ) {
                    //if the score is greater than the second largest cutoff value, then it belongs
                    //to the highest valence and so on.
                    valence = j + 1;
                    break;
                }
            }
            //return the set valence. If made it all the way to 0, the default will be returned.
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
            //check old and new are the same
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
            //get the existing score
            var oldScore = this.store.getElementScoreForActiveStudent( this.elementIndex );
            //store the new element score in the data object
            this.elementScore = slideEvt.value;

            /**
             * update comment text and save to DB.
             * Only replace text if the score has changed valence regions
             */
            if ( ! this.isSameValence( oldScore, this.elementScore ) ) {
                //Score is in a new valence region.
                //So let's plug in the appropriate comment text and save to DB
                //
                //Dear Adam, make sure you read the doc for storeCommentText before fucking with
                //anything in these lines
                this.commentText = this.store.getCommentTextForActiveStudent( this.elementIndex, this.getValence( this.elementScore ) );

            } else {
                // Score is in the same valence region.
                // Jump straight to saving without changing the elementComment
                // Fear not. Changes directly to the comment text will be handled elsewhere.
            }

            // If using bell curve (standardScoring), element score affects
            // the total question score, so update
            // if ( Roster.standardScoring ) {
            //     //  updateStandardScores();
            // }

            if ( typeof callback != 'undefined' ) {
                return callback();
            }

        },

        setSliderScore: function () {
            this.sliderSelector.slider( 'setValue', this.elementScore );
//            this.sliderSelector.slider( 'refresh' );
        },

        /* --------------------- Notifications to observers ---------------------- */
        /**
         * Requests that the db be updated with the element score.
         * The element score is already stored in the shared storage object, so
         * we just need to tell the observer which element needs updating.
         */
        notifyStoreElementScore: function ( score ) {
            let request = new Requests.ElementScoreRequest(this.activeStudent, this.elementIndex, score, this.elementId);
            this.$dispatch( 'store-element-score-request', request );
        },

        /**
         * Requests that the db be updated with comment text
         */
        notifyStoreCommentText: function () {
            let obj = new Requests.CommentRequest(this.activeStudent, this.elementIndex, this.elementId);
            this.$dispatch( 'store-comment-text-request', obj);
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
        'student-select-event': function ( obj ) {
            window.console.log( 'elementInput', 'caught student-select-event', obj );
            //update the slider value
            this.setSliderScore();
            //return true just in case someone else is listening and
            //needs to hear the event
            return true;
        }
    },

    ready: function () {
        var me = this;

        // initialize slider
        $( '#' + this.sliderId ).slider( {
            tooltip: 'show',
            //value: this.elementScore,
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
        } );

        // window.console.log('input ready', 'elementIndex', this.elementIndex);
    }
};