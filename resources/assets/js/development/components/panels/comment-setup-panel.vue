<template>
    <div v-bind:class="styling"
         v-bind:id="panelId"
    >
        <div class="level">
            <!-- Left side -->
            <div class="level-left">
            </div>
            <div class="level-right">
                <div class="level-item">
                    <info-button :help-text="helpText"></info-button>
                </div>
            </div>
        </div>

        <div class="field ">
            <label class="label ">{{ label }}</label>
            <p class="control">
                <textarea
                        class="textarea comment-text"
                        rows="4"
                        v-bind:placeholder="placeholder"
                        v-model="commentText"></textarea>
            </p>
        </div>

        <valence-buttons
                :serial-number="serialNumber"
                :is-exam="isExam"
        ></valence-buttons>
        <div class="level">
            <!-- Left side -->
            <div class="level-left">
                <div class="level-item">
                    <label class="checkbox">
                        <input type="checkbox" v-model="shouldPrePopulate">
                        {{ syncControlLabel }}
                    </label>
                </div>
                <div class="level-item">
                    <info-button :help-text="prePopulationHelpText"></info-button>
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
    import * as aTypes from '../../../store/action-types';
    import * as gTypes from '../../../store/getter-types';
    import valenceButtons from '../input/buttons.valence.component.vue'

    /**
     * The comment details setup area
     * Created by adam on 2/19/17.
     */
    export default {
        components: {
            valenceButtons, // 'valence-buttons': valenceButtons,
        },

        props: [ 'forExam' ],

        data: function () {
            return {

                identifier: 'comment-setup-panel',

                labels: {
                    exam: "Set up student feedback for the exam as a whole",
                    item: "Set up student feedback for this item"
                },

                /** Which valence is currently displayed */
                displayed: 'stock',

                /** The instructional help text for the overall panel */
                helpText: `<div class="help">
                    <p>In this area, you create the feedback your students will receive for this item. </p>
                    <p>[Explanation of score levels nd valences here]</p>
                    </div>`,


                placeholders: {
                    //These are for the text entry textarea
                    exam: "Set up a global comment on the exam as a whole",
                    item: "Explain in detail what needed to be done in order to fully complete this task. This will form the basis for the response seen by the student.",
                },

                /** The help text to be displayed for the sync checkbox */
                prePopulationHelpText: `<div class="help">
                    <p>If this box is checked, when you enter text into the Stock valence
                    comments will be generated for the other valences.</p>
                    <p>You will probably still want to further customize the text for each.</p>
                    </div> `,

                //Whether to pre-populate the comments
                shouldPrePopulate: true,


                defaults: {
                    commentText: ''
                },

            };
        },


        /*
         One thing to note when using routes with params is that when the user navigates from /user/foo to /user/bar,
         the same component instance will be reused. Since both routes render the same component, this is more efficient
         than destroying the old instance and then creating a new one. However, this also means that the lifecycle
         hooks of the component will not be called.
         To react to params changes in the same component, you can simply watch the $route object:
         */
//        watch: {
//            '$route'( to, from ) {
//                // react to route changes...
//            }
//        },
        computed: {

            panelId: function () {
                return this.identifier + '-' + this.serialNumber;
            },

            styling: function () {
                return this.identifier;
            },

            serialNumber: function () {
                return this.$parent.serialNumber;
            },

            item: function () {
                return this.$store.getters.getItemBySerialNumber( this.serialNumber );
            },

            comments: function () {
                return this.item.comments;
            },

            //Doing this via computed property so don't have to pass in on route
            isExam: function () {
                if ( this.item instanceof Exam ) return true;
                if ( this.forExam ) return true;
                return false;
            },

            label: function () {
                if ( this.isExam ) return this.labels.exam;
                return this.labels.item;
            },

            /**
             * Gets the appropriate placeholder text depending
             * on the type of item involved
             */
            placeholder: function () {
                if ( this.isExam ) return this.placeholders.exam;
                return this.placeholders.item;
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
                        if ( typeof comment !== 'undefined' ) {
                            return comment.text;
                        }
                    }
                },

                set: function ( v ) {
//                    window.console.log( 'comment-setup-panel', 'set', 97, this.serialNumber, this.item, v );
                    let pl = Payload.factory( {
                        obj: this.item,
                        updateValence: this.displayed,
                        updateVal: v
                    } );

                    this.$store.commit( mTypes.updateComment, pl );

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
             * The text displayed for the control which
             * governs whether changes to stock overwrite
             * existing comments.
             */
            syncControlLabel :function (  ) {
                let noChanges = 'Prepopulate comments from stock';
                let changes = 'Overwrite existing comment with changes to stock';
                return this.item.haveCommentsBeenCustomized() ? changes : noChanges;
            },


            valences: function () {
                return Comment.valences;
            }

        },

        methods: {
            getComment: function ( valence ) {
                return this.comments
            },

            /**
             * Alters which valence is displayed.
             * Called by child components
             */
            changeDisplayedValence: function ( newValence ) {
                window.console.log( 'changeDisplayedValence', 130, newValence );
                if ( newValence ) {
                    this.displayedValence = newValence;
                }
            },


            /**
             * Takes the stock comment and creates the valenced comments
             */
            prePopulateComments: function ( stock ) {
                var me = this;

                _.forEach( this.valences, function ( v ) {
                    if ( v !== 'stock' ) {
                        let comment = me.item.getComment( v );

                        //skip if it's the stock comment
                        if ( comment.valence === 'stock' ) return true;

                        // Skip if the comment text is already set
                        // We don't want to overwrite existing comments if stock is altered.
                        if ( comment.text.length > 0 ) return true;

                        //create the new text.
                        //nb, any enhancements to prepopulation should be done in Comment
                        let text = Comment.makePrePopulatedContent( comment.valence, stock );

                        //save the new comment text for the valence
                        let pl = Payload.factory( {
                            obj: me.item,
                            updateValence: comment.valence,
                            updateVal: text
                        } );
                        me.$store.commit( mTypes.updateComment, pl );
                    }
                } );
            }

        },

        events: {
            'please-change-valence':

                function ( evt ) {
                    console.log( 'caught please-change-valence', evt );
                    this.displayedValence = evt;
                }
        }
        ,


    };
</script>
