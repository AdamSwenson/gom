/**
 * Created by adam on 7/11/16.
 */

var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

var Slider = require( "../libraries/bootstrap-slider-modified.js" );

module.exports = {

    template: require( '../templates/element-input.template.html' ),

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
             * The data repository store by everyone
             */
            store: store,

            // /**
            //  * The current value of the text area
            //  */
            // commentText: '',
            //
            // /**
            //  * The current valence of the slider position
            //  */
            // currentValence: false,

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

        //grab the info related to elements
//         var $element = $( slideEvt.target ).closest( '[id^="element"]' );
// var $parent = $element.parents( '[id^="element"]' );
// var commentAreaId = $element.attr( 'data-comment-area-id' );
// var $elementComment = $( '#' + commentAreaId );
// var elementIndex = $element.attr( 'data-element-index' ); //the subtask number of the element
// var elementId = $element.attr( 'data-element-id' ); //the DB's id for the element

        /**
         * The current value of the text area
         */
        commentText: {
            get: function () {
                this.store.getCommentText( this.activeStudent, this.elementIndex, this.currentValence );
            },
            set: function ( text ) {
                this.store.storeCommentText( this.activeStudent, this.elementIndex, text );
            }
        },

        /**
         * The current value of the slider
         */
        elementScore: {
            get: function () {
                this.store.getElementScore( this.store.activeStudent, index )
            },
            set: function () {

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
        }
        ,

        /**
         * Returns the jQuery selector for the slider element
         * @returns {*|jQuery|HTMLElement}
         */
        sliderSelector: function () {
            return $( '#' + this.sliderId );
        }


    },

    methods: {

        // /* ------------------ store data manipulation -------------------------- */
        // updateStoredCommentText: function () {
        //     this.store.storeCommentText( this.activeStudent, this.elementIndex, this.commentText );
        // },
        //
        // retrieveStoredCommentText: function () {
        //     this.commentText = this.store.getCommentText( this.activeStudent, this.elementIndex, this.currentValence );
        // },
        //
        // updateStoredElementScore: function () {
        // },
        //
        // retrieveStoredElementScore: function () {
        //     var elementScore = this.store.getElementScore( this.store.activeStudent, index );
        // }
        //


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
            this.commentSelector.removeAttr( 'readonly' );
            this.commentSelector.prop( 'readonly', '' );
        },

        /**
         * Prevent user from entering text into comment area
         */
        disableCommentArea: function () {
            this.commentSelector.prop( 'readonly', 'true' );
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
                this.emptyCommentArea();
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


        // /**
        //  * Changes the text of the displayed comment
        //  * @param $comment
        //  * @param commentText
        //  */
        // updateDisplayedComment: function ( $comment, commentText ) {
        //     //make writable
        //     $comment.removeAttr( 'readonly' );
        //
        //     //set text
        //     $comment.val( commentText );
        // },

        /**
         * Called when an element slider stops movement. Updates element
         * score and text (if necessary), then saves score, text and time
         * @param slideEvt
         * @param data
         * @param Roster
         * @param callback
         */
        handleElementSliderStopEvent: function ( slideEvt, data, Roster, callback ) {


            //on slide
            // this.storeData();
            // this.updateContent();
            this.notifyChange();

            //
            // //grab scores
            // var oldScore = data.getElementScore( Roster.activeStudent, elementIndex );
            // var score = slideEvt.value;
            //
            // /* ---------- update the element's score visually and in data.elementScores[] --------- */
            //
            // //store the new element score in the data object
            // data.storeElementScore( Roster.activeStudent, elementIndex, score );
            //
            //
            // /**
            //  * update comment text and save to DB.
            //  * Only replace text if the score has changed valence regions
            //  */
            // if ( ! this.isSameValence( oldScore, score ) ) {
            //     //Score is in a new valence region.
            //     //So let's plug in the appropriate comment text and save to DB
            //
            //     //Store comment text in data object
            //     //Dear Adam, make sure you read the doc for storeCommentText before fucking with
            //     //anything in these lines
            //     data.storeCommentText( Roster.activeStudent, elementIndex, $elementComment.val() );
            //     var commentText = data.getCommentText( Roster.activeStudent, elementIndex, this.updateValence( score ) );
            //
            //     //update display
            //     this.updateDisplayedComment( $elementComment, commentText );
            //
            //     //send to the db
            //     AjaxHandler.saveComment( data, Roster, elementId, score, commentText );
            //
            // } else {
            //     // Score is in the same valence region.
            //     // Jump straight to saving without changing the elementComment
            //     // Fear not. Changes directly to the comment text will be handled elsewhere.
            //     AjaxHandler.createGradeRequest( data, 'element_id', elementId, score, null, Roster );
            // }
            //
            // // If using bell curve (standardScoring), element score affects
            // // the total question score, so update
            // if ( Roster.standardScoring ) {
            //     //  updateStandardScores();
            // }
            //
            // callback();
            // // //Update dashboard and roster data displayed
            // // updateStudentDashboardAndRosterAreas( data, Dashboard, Roster );
            // // //Sigh. The user forgot to restart the timer. Do it for them
            // // Timer.resumeTimerIfPaused( data, Roster, Dashboard );
        },

        /* --------------------- Notifications to observers ---------------------- */
        /**
         * Requests that the db be updated with the element score.
         * The element score is already stored in the shared storage object, so
         * we just need to tell the observer which element needs updating.
         */
        notifyStoreElementScore: function () {
            this.$dispatch('store-element-score-request', this.elementIndex );
        },

        /**
         * Requests that the db be updated with comment text
         */
        notifyStoreCommentText: function () {
            this.$dispatch( 'store-comment-text-request', this.elementIndex);
        },

        /**
         * Requests that the grading timer be started, if paused
         */
        notifyStartTimer: function () {
            this.$dispatch('start-timer-request', this.elementIndex);
        
        },

        /**
         * Notifies any listeners that a slide event has occurred
         * @param slideEvent
         */
        notifySlideEvent: function ( slideEvent ) {
            this.$dispatch('element-slider-stop-event', this.elementIndex);
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
    }
    ,

    directives: {}
    ,

    ready: function () {
        //initialize slider
        $( this.el ).slider( {
            tooltip: 'show',
            value: this.elementScore,
            step: this.settings.sliderStep,
            ticks: this.settings.valenceCutoffs,
            ticks_labels: this.settings.valenceLabels,
            ticks_position: this.settings.valenceLabels,
            // id: Counter()
        } );

        /* ----------------- slider listeners --------------- */
        /* When an element slider stops movement,
         update element score and text (if necessary),
         then save score, text and time
         *  */
        this.sliderSelector.on( 'slideStop', function ( slideEvt ) {
            this.notifySlideEvent();
            // this.handleElementSliderStopEvent( slideEvt, data, Roster, function () {
            //     //Update dashboard and roster data displayed
            //     updateStudentDashboardAndRosterAreas( data, Dashboard, Roster );
                //Sigh. The user forgot to restart the timer. Do it for them
                //Timer.resumeTimerIfPaused( data, Roster, Dashboard );
            } );

        }
    }
;