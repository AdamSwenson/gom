<template>
    <div class=" elementPanel box">
        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <!-- question Name -->
                    <p class="elementTitle title is-4">{{ title }}</p>
                </div>
            </div>
        </div>

        <div class="field ">
            <label></label>
            <div class="control">
        <comment-text :item="item" :student="student"></comment-text>
            </div>
            <p class="help"></p>
        </div>

        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <score-slider :item="item" :student="student"></score-slider>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
    import * as ngmTypes from '../../../../store/modules/newgrading/new-grading-mutation-types';
    import * as ngaTypes from '../../../../store/modules/newgrading/new-grading-action-types';
    import * as nggTypes from '../../../../store/modules/newgrading/new-grading-getter-types';
    import * as gTypes from '../../../../store/getter-types';

    import CommentText from './comment-text.vue';
    import ScoreSlider from './score-slider.vue';

    module.exports = {

        components: { CommentText, ScoreSlider },

        props: [
            'item',
            'student'
        ],

        data: function () {
            return {

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
             * Returns the string of the element's description to be displayed on the page
             * @returns {string}
             */
            title: function () {
                return this.item.name;
            },

            /**
             * Shortcut to where the active student is stored
             * @returns {module.exports.computed.activeStudent|null|*}
             */
            activeStudent: function () {
                return this.$store.getters[ nmgTypes.getActiveStudent ];
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
                // cache: false,
                get: function () {
                    if ( !this.isReady() ) return '';

                    let qs = this.$store.getters.getItemScoreObject( this.item.id, this.student.id );
                    if ( qs != null ) {
                        return qs.score;
                    }
                    //     // window.console.log('elementInput', 'elementScore', this.store.getElementScoreForActiveStudent( this.elementIndex ), this.elementIndex );
                    //     return this.store.getElementScoreForActiveStudent( this.elementIndex );
                },
                set: function ( score ) {
                    //     this.store.storeElementScoreForActiveStudent( this.elementIndex, score );
                    //     this.notifyStoreElementScore( score )
                }
            },


            // /**
            //  * Returns the string id of the comment area
            //  * @returns {string}
            //  */
            // commentAreaId: function () {
            //     return "commentQ" + this.questionNumber + "E" + this.elementNumber;
            // },
            //
            // /**
            //  * Returns the jQuery selector for the comment area
            //  * @returns {*|jQuery|HTMLElement}
            //  */
            // commentSelector: function () {
            //     return $( '#' + this.commentAreaId );
            // },

            // /**
            //  * The current value of the text area
            //  */
            // commentText: {
            //     cache: false,
            //     get: function () {
            //         //setting this to just this.elementScore prevents missing from displaying comment.
            //         //when element score was 0.
            //         //Also led to custom comments being deleted when moved to missing
            //         if ( this.elementScore != null )
            //         // window.console.log('elementInput', 'commentText', this.elementScore, this.getValence( this.elementScore ) );
            //             return this.store.getCommentTextForActiveStudent( this.elementIndex, this.getValence( this.elementScore ) );
            //     },
            //     set: function ( text ) {
            //         this.store.storeCommentTextForActiveStudent( this.elementIndex, text );
            //         //send to the db
            //         this.notifyStoreCommentText();
            //     }
            // },


        },

        methods: {
            isReady: function () {
                if ( _.isUndefined( this.item ) || _.isNull( this.item ) || _.isUndefined( this.student ) || _.isNull( this.student ) ) return false;
                return true;
            },

            // /**
            //  * Handles the request to store comment text on the server
            //  * Accompanying object should contain:
            //  *      obj.elementIndex: Index of the element whose score needs updating
            //  */
            // storeCommentTextRequest : function ( commentRequestObj ) {
            //     window.console.log( 'gradeVue', 'store-comment-text-request', commentRequestObj );
            //     let commentText = this.store.getStoredCommentText(commentRequestObj.studentIndex, commentRequestObj.elementIndex)
            //     this.saveCommentWithTime(commentRequestObj.studentIndex, commentRequestObj.elementId, commentText);
            // },
            //
            //
            // /**
            //  * Handles the request to store element score on the server
            //  * Accompanying object should contain:
            //  *      obj.elementIndex: Index of the element whose score needs updating
            //  */
            // storeElementScoreRequest: function ( elementScoreRequestObj ) {
            //     window.console.log( 'gradeVue', 'caught store-element-score-request', elementScoreRequestObj );
            //     let elementId = elementScoreRequestObj.elementId;
            //     let studentIndex = elementScoreRequestObj.studentIndex
            //     //store on server
            //     this.saveElementScoreWithTime(studentIndex, elementId, elementScoreRequestObj.score)
            // },
            //
            //
            //

            /* ------------------ Display manipulation ------------------------------ */
            // /**
            //  * Sets the comment area to empty (user should see the place holder).
            //  * Usually used to clear out any text that might be left from other users
            //  */
            // commentAreaEmpty: function () {
            //     this.commentText = '';
            // },


            // /**
            //  * Updates the displayed comment to match the current slider value.
            //  * TODO Add a test for the potential corner cases making the default null creates
            //  */
            // commentAreaUpdate: function () {
            //     if ( this.elementScore === null ) {
            //         // clear any text that might have been left over from another user
            //         // this.commentAreaEmpty();
            //         // if NULL, disable comment text area until a slider is moved.
            //         // this is so that the user doesn't enter custom text, move the slider,
            //         // and then see their custom text irreversibly wiped out.
            //         this.commentAreaDisable();
            //     } else {
            //         // It has already been scored, so the comment text will be retrieved and set.
            //         //no need for it to remain read only
            //         this.commentAreaEnable();
            //     }
            // },

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
                if ( score === null ) throw new Error( "cannot get valence for null" );
                if ( score < 0 || score > me.settings.valenceCutoffs[ me.settings.valenceCutoffs.length - 1 ] ) throw new Error( "cannot get valence. value out of range" );

                let valence = 0;
                //start at the second largest value in the cutoffs.
                for (let j = me.settings.valenceCutoffs.length - 2; j >= 0; j--) {
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
                // var oldScore = this.store.getElementScoreForActiveStudent( this.elementIndex );
                // //store the new element score in the data object
                // this.elementScore = slideEvt.value;
                //
                // /**
                //  * update comment text and save to DB.
                //  * Only replace text if the score has changed valence regions
                //  */
                // if ( !this.isSameValence( oldScore, this.elementScore ) ) {
                //     //Score is in a new valence region.
                //     //So let's plug in the appropriate comment text and save to DB
                //     //
                //     //Dear Adam, make sure you read the doc for storeCommentText before fucking with
                //     //anything in these lines
                //     this.commentText = this.store.getCommentTextForActiveStudent( this.elementIndex, this.getValence( this.elementScore ) );
                //
                // } else {
                //     // Score is in the same valence region.
                //     // Jump straight to saving without changing the elementComment
                //     // Fear not. Changes directly to the comment text will be handled elsewhere.
                // }
                //
                // // If using bell curve (standardScoring), element score affects
                // the total question score, so update
                // if ( Roster.standardScoring ) {
                //     //  updateStandardScores();
                // }

                // if ( typeof callback != 'undefined' ) {
                //     return callback();
                // }

            },

            setSliderScore: function () {
                // this.sliderSelector.slider( 'setValue', this.elementScore );
//            this.sliderSelector.slider( 'refresh' );
            },


            /**
             * Requests that the grading timer be started, if paused
             */
            notifyStartTimer: function () {
                // this.$dispatch( 'start-timer-request', this.elementIndex );
            },


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
                // me.handleElementSliderStopEvent( slideEvt );
                // me.notifySlideEvent();
            } );

            // window.console.log('input ready', 'elementIndex', this.elementIndex);
        }
    };</script>