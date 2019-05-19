<template>
    <div class="comment-setup-panel"
         v-bind:class="styling"
         v-bind:id="panelId"
    >
        <div class="level">
            <!-- Left side -->
            <div class="level-left">
            </div>
            <div class="level-right">
                <div class="level-item">
                    <info-button :help-text="helpText.overall"></info-button>
                </div>
            </div>
        </div>

        <div class="field ">
            <label class="label ">{{ label }}</label>

            <p class="control">
                <textarea
                        class="textarea comment-text"
                        v-bind:rows="numRows"
                        v-bind:placeholder="placeholder"
                        v-model="commentText"
                ></textarea>
            </p>

        </div>

        <valence-buttons
                :displayed-valence="displayedValence"
                :serial-number="serialNumber"
                :is-exam="isExam"
                v-on:please-change-valence="changeDisplayedValence"
        ></valence-buttons>


        <div class="columns">
            <div class="column">
                <prepopulate-comments-button
                        :item="item"
                        :haveCommentsBeenCustomized="haveCommentsBeenCustomized"
                        v-on:please-refresh="refreshDisplay"
                ></prepopulate-comments-button>

            </div>
            <div class="column">
                <update-graded-comments-button
                        :exam="exam"
                        :item="item"
                ></update-graded-comments-button>
            </div>
        </div>


    </div>

</template>
<style>
    .comment-setup-panel {

    }
</style>
<script>

    import Comment from '../../../models/Comment'
    import Payload from '../../../models/Payload'
    import Exam from '../../../models/Exam'
    import * as gTypes from '../../../store/getter-types';
    import * as aTypes from '../../../store/action-types';
    import valenceButtons from './comment/valence-buttons.vue'
    import UpdateGradedCommentsButton from "./comment/update-graded-comments-button";
    import UpdateGradedCommentsToggle from "./comment/update-graded-comments-toggle";
    import PrepopulateCommentsButton from "./comment/prepopulate-comments-button";

    /**
     * The comment details setup area
     * Created by adam on 2/19/17.
     */
    export default {
        name: 'comment-setup-panel',

        components: {
            PrepopulateCommentsButton,
            UpdateGradedCommentsToggle,
            UpdateGradedCommentsButton,
            valenceButtons, // 'valence-buttons': valenceButtons,
        },

        props: [ 'forExam', 'dataSerialNumber' ],

        data: function () {
            return {

                serialNumber: _.toInteger( this.$route.params.serialNumber ),

                active: this.serialNumber,

                identifier: 'comment-setup-panel',

                labels: {
                    exam: "Set up student feedback for the exam as a whole",
                    item: "Set up student feedback for this item",
                },

                /** Which valence is currently displayed */
                displayed: 'stock',

                /** The instructional help text for the overall panel */
                helpText: {
                    overall:
                        `<div class="help">
                    <p>In this area, you create the feedback your students will receive for this item. </p>
                    <p>[Explanation of score levels nd valences here]</p>
                    </div>`,
                },

                /** Whether to replace the default text in graded student comments with
                 * the new default text
                 * NOT CURRENTLY USED
                 * */
                overwriteDefaults: false,

                placeholders:
                    {
                        //These are for the text entry textarea
                        exam: "Set up a global comment on the exam as a whole",
                        item:
                            "Explain in detail what needed to be done in order to fully complete this task. This will form the basis for the response seen by the student.",
                    },

                rows: {
                    // isMaximized : false,
                    maximizeAtChars: 200,
                    minimized: 4,
                    maximized: 8
                },

                styling: ''

                /** Whether to pre-populate the comments */
                // shouldPrePopulate: false,

            };
        },

        computed: {
            exam: function () {
                return this.$store.getters[ gTypes.getActiveExam ];
            },

            /**
             * Whether all comments for the item lack
             * values for their text property
             */
            isEveryCommentEmpty: function () {
                if ( _.isUndefined( this.item ) ) return true;

                return this.item.isEveryCommentEmpty;
            },

            /**
             * Returns an iterator [[key, value]]
             * from map object of the comments
             */
            comments: function () {
                return this.item.comments.entries();
            },


            /**
             * This is the presently visible comment text
             */
            commentText: {
                get: function () {
                    if ( typeof this.item !== 'undefined' ) {
                        //displayed holds the valence as a string
                        //so we get the comment by passing in the valence to
                        //the item object
                        let comment = this.item.getComment( this.displayed );
//                        window.console.log( 'comment-setup-panel', 'get', 190, comment);
                        if ( typeof comment !== 'undefined' ) {
                            return comment.text;
                        }
                    }
                },

                set: function ( v ) {

                    this.updateComment( this.displayed, v );

                }
            },

            displayedValence: {
                get: function () {
                    return this.displayed;
                },

                set: function ( newValence ) {
                    if ( newValence ) {
                        let idx = Comment.valences.indexOf( newValence );
                        if ( idx >= 0 ) {
                            this.displayed = Comment.valences[ idx ];
                        }
                    }
                }
            },


            /**
             * This returns an object with each of the
             * valences as keys and the prepopulated comments
             */
            commentsCreatedFromStock: function () {
                let stock = this.item.getComment( 'stock' );
                let out = {};
                _.forEach( this.valencesExcludingStock, function ( valence ) {
                    out[ valence ] = Comment.makePrePopulatedContent( valence, stock.text );
                } );
                return out;
            },

            /**
             * This determines whether any of the comments have been
             * customized by the user. This is important to know so that
             * we do not allow her to accidentally overwrite something she
             * customized on accident, while at the same time allowing her to
             * start anew from stock if that's what she wants.
             */
            haveCommentsBeenCustomized: function () {
                let me = this;
                let v = false;

                if( !_.isUndefined(this.item)) {
                    let stock = this.item.getComment( 'stock' );
                    _.forEach( this.valencesExcludingStock, function ( valence ) {
                        let currentComment = me.item.getComment( valence );
                        if ( currentComment.isTextBasedOnStock( stock.text ) ) v = true;
                    } );
                }
                return v;
            },

            //Doing this via computed property so don't have to pass in on route
            isExam: function () {
                if ( this.item instanceof Exam ) return true;
                if ( this.forExam ) return true;
                return false;
            },

            item: function () {
                return this.$store.getters.getItemBySerialNumber( this.serialNumber );
            },

            label: function () {
                if ( this.isExam ) return this.labels.exam;
                return this.labels.item;
            },

            numCharacters: function () {
                if ( !_.isUndefined( this.commentText ) && !_.isNull( this.commentText ) ) {
                    return this.commentText.length;
                }
                return 0;
            },

            /**
             * How many rows of the text area to display
             */
            numRows: function () {
                // return this.rows.isMaximized ? this.rows.maximized : this.rows.minimized;
                if ( this.numCharacters < this.rows.maximizeAtChars ) {
                    return this.rows.minimized;
                }
                return this.rows.maximized;
            },

            panelId: function () {
                return this.identifier + '-' + this.serialNumber;
            },

            parentSerialNumber: function () {
                return this.$parent.serialNumber;
            },

            /**
             * Gets the appropriate placeholder text depending
             * on the type of item involved
             */
            placeholder: function () {
                if ( this.isExam ) return this.placeholders.exam;
                return this.placeholders.item;
            },


            valences: function () {
                return Comment.valences;
            },

            valencesExcludingStock: function () {
                return Comment.valencesExcludingStock;
            }
        },


        methods: {

            /**
             * Alters which valence is displayed.
             * Called by child components or by bound listener
             */
            changeDisplayedValence: function ( newValence ) {
//                window.console.log( 'changeDisplayedValence', 130, newValence , this.item);
                if ( newValence ) {
                    this.displayedValence = newValence;
                }
            },

            /**
             * After we prepopulate the comments from stock,
             * we need to briefly switch back and forth between
             * the stock and the current displayed valence so that
             * the currently displayed valence will have its text updated.
             * Hopefully the user won't notice the change, but vue doesn't seem
             * to let us update live.
             */
            refreshDisplay: function () {

                //So we grab the current valence in order to change back to it
                //once we've done the population.
                let d = this.displayed;
                this.changeDisplayedValence( 'stock' );

                //Change back to the valence that we were looking at
                this.changeDisplayedValence( d );

            },


            /**
             * Utility function to centralize calling
             * the mutation to update the comment text since
             * two methods call it.
             *
             * @param valence
             * @param val
             */
            updateComment: function ( valence, val ) {
                let pl = Payload.factory( {
                    obj: this.item,
                    updateValence: valence,
                    updateVal: val,
                } );

                // re-enable if we decide to use the update-graded-comments-toggle
                // as created in GOM-391
                // if ( this.overwriteDefaults ) {
                //     pl.options = { overwriteDefaults: true, examId: this.exam.id }
                // }
                this.$store.dispatch( aTypes.updateComment, pl );
                // this.$store.commit( mTypes.updateComment, pl );
            }

        },

    };
</script>
