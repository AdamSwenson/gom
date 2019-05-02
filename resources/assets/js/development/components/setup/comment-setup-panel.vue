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
                        v-model="commentText"></textarea>
            </p>

            <!--<p class="help">{{numCharacters}}</p>-->

            <p v-if=" isOverwriteHelpMessageVisible "
               class="help is-danger"></p>
<!--            >Changes to the stock text will be used to create rough drafts of the text for the other comments. If you-->
<!--                have already customized any of these, these changes will replace any customizations you've made. If you-->
<!--                don't want either of these things to happen, un-check the box below.</p>-->
        </div>

        <valence-buttons
                :displayed-valence="displayedValence"
                :serial-number="serialNumber"
                :is-exam="isExam"
                v-on:please-change-valence="changeDisplayedValence"
        ></valence-buttons>

        <div class="level">
            <!-- Left side -->
            <div class="level-left">
                <div class="level-item">
                    <div class="field">
                        <label class="label">{{ syncControlLabel }} </label>
                        <p class="control">
                            <a id="prepopulationControl"
                               class="button is-outlined is-primary"
                               v-on:click="handlePopulateClick"
                            >Create comments from stock</a>
                        </p>
                    </div>
                </div>

                <div class="level-item">
                    <info-button :help-text="helpText.prePopulation"></info-button>
                </div>

                <div class="level-right">
<!--                    <update-graded-comments-toggle-->
<!--                            v-on:toggled="handleOverwriteGradedClick"-->
<!--                            :is-active="overwriteDefaults"-->
<!--                    ></update-graded-comments-toggle>-->

                    <update-graded-comments-button :exam="exam"
                                                   :item="item"
                    ></update-graded-comments-button>
                </div>

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
    import * as mTypes from '../../../store/mutation-types';
    import * as gTypes from '../../../store/getter-types';
    import valenceButtons from './comment/valence-buttons.vue'
    import UpdateGradedCommentsButton from "./comment/update-graded-comments-button";
    import UpdateGradedCommentsToggle from "./comment/update-graded-comments-toggle";

    /**
     * The comment details setup area
     * Created by adam on 2/19/17.
     */
    export default {
        name: 'comment-setup-panel',

        components: {
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
                    syncControl: {
                        noChanges: 'Use stock to create rough drafts of other comments',
                        changes: 'Overwrite existing comments with rough drafts from stock'
                    },
                    // updateGraded: "Update graded exam comments"
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

                    /** The help text to be displayed for the sync checkbox */
                    prePopulation: `<div class="help"><p>Changes to the stock text will be used to create rough drafts of the text for the other comments. If you have already customized any of these, these changes will replace any customizations you've made.</p><p> If you don't want either of these things to happen, do not click this!</p></div>`

                    //     `<div class="help">
                    // <p>If this box is checked, when you enter text into the Stock valence
                    // comments will be generated for the other valences.</p>
                    // <p>You will probably still want to further customize the text for each.</p>
                    // </div> `
                },

                /** Whether to replace the default text in graded student comments with
                 * the new default text
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

                /** Whether to pre-populate the comments */
                shouldPrePopulate: false,

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
//                    window.console.log( 'comment-setup-panel', 'set', 97, this.serialNumber, this.item, v );

                    this.updateComment( this.displayed, v );
                    // let pl = Payload.factory( {
                    //     obj: this.item,
                    //     updateValence: this.displayed,
                    //     updateVal: v,
                    //     options: {overwriteDefaults: true}
                    // } );
                    //
                    // this.$store.commit( mTypes.updateComment, pl );

                    //If the user indicated that they want to prepopulate
                    //the other comments from stock and if the valence was stock
                    //we now set the other comments
                    if ( this.displayed === 'stock' && this.shouldPrePopulate === true ) {
                        this.prePopulateComments( v );
                    }
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
                let stock = this.item.getComment( 'stock' );

                let v = false;
                _.forEach( this.valencesExcludingStock, function ( valence ) {
                    let currentComment = me.item.getComment( valence );
                    if ( currentComment.isTextBasedOnStock( stock.text ) ) v = true;
                } );
                return v;
            },

            //Doing this via computed property so don't have to pass in on route
            isExam: function () {
                if ( this.item instanceof Exam ) return true;
                if ( this.forExam ) return true;
                return false;
            },

            isOverwriteHelpMessageVisible: function () {
                //This only displays when we are working on stock
                if ( this.displayed !== 'stock' ) return false;
                //if nothing has been set, the info dialog is assumed to be enough
                if ( this.isEveryCommentEmpty ) return false;

                if ( this.shouldPrePopulate ) return true;


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

            styling: function () {
            },

            /**
             * The text displayed for the control which
             * governs whether changes to stock overwrite
             * existing comments.
             */
            syncControlLabel: function () {
                return this.haveCommentsBeenCustomized ? this.labels.syncControl.changes : this.labels.syncControl.noChanges;
            },

            valences: function () {
                return Comment.valences;
            },

            valencesExcludingStock: function () {
                return _.drop( Comment.valences );
            }
        },

        // watch: {
        //   commentText: function(v){
        //       window.console.log( 'comment-setup-panel', 'commentText', 349, v);
        //   }
        // },


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
             * When the user clicks the button, this fires the prepopulate command.
             * It has a bunch of extra stuff because this used to default to doing it
             * automatically. But that created the danger of wiping out the user's work,
             * This was changed from a checkbox with GOM-380
             */
            handlePopulateClick: function () {
                //change the prepopulate control value
                this.shouldPrePopulate = true;

                //we need to briefly switch back and forth between
                //the stock and the current displayed valence so that
                //the currently displayed valence will have its text updated.
                //Hopefully the user won't notice the change, but vue doesn't seem
                //to let us update live.
                //So we grab the current valence in order to change back to it
                //once we've done the population.
                let d = this.displayed;
                this.changeDisplayedValence( 'stock' );

                //grab the stock comment
                if ( typeof this.item !== 'undefined' ) {
                    let comment = this.item.getComment( 'stock' );
                    if ( typeof comment !== 'undefined' ) {
                        //fire the method which handles the population
                        //using the stock comment text
                        this.prePopulateComments( comment.text );
                    }
                }

                //Change back to the valence that we were looking at
                this.changeDisplayedValence( d );

                //reset the control value, so won't continue doing it
                this.shouldPrePopulate = false;
            },

            handleOverwriteGradedClick: function () {
                this.overwriteDefaults = !this.overwriteDefaults;
            },

            /**
             * Takes the stock comment and creates rough drafts
             * of the valenced comments for the user to work from.
             */
            prePopulateComments: function ( stock ) {
                if ( !this.shouldPrePopulate ) return false;

                var me = this;

                _.forEach( this.valencesExcludingStock, function ( v ) {
                    let comment = me.item.getComment( v );

//                        todo This logic could probably be improved
                    // Skip if the comment text is already set.
                    // We don't want to overwrite existing comments if stock is altered.
                    // We can't judge when to overwrite the saved text with
                    // changes from stock by checking that comment.text.length > 0
                    // since that will stop after the first letter of stock.
                    // Thus we instead check that it isn't longer than the current stock we
                    // are trying to insert.
                    if ( !_.isUndefined( comment.text ) && !_.isNull( comment.text ) && comment.text.length > stock ) return true;

                    //create the new text.
                    //nb, any enhancements to prepopulation should be done in Comment
                    let text = Comment.makePrePopulatedContent( comment.valence, stock );

                    //save the new comment text for the valence
                    me.updateComment( comment.valence, text );
                } );
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

                if ( this.overwriteDefaults ) {
                    pl.options = { overwriteDefaults: true, examId: this.exam.id }
                }

                this.$store.commit( mTypes.updateComment, pl );
            }

        },

    };
</script>
