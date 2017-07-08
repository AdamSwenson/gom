<template>
    <div v-bind:class="styling"
         v-bind:id="panelId"
    >
        <div class="field ">
            <label class="label ">{{ label }}</label>
            <p class="control">
                <textarea
                        class="textarea comment-text"
                        rows="3"
                        v-bind:placeholder="placeholder"
                        v-model="commentText"></textarea>
            </p>
        </div>

        <valence-buttons :serial-number="serialNumber" :is-exam="isExam"></valence-buttons>

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

        props: [],

        data: function () {
            return {

                serialNumber: _.toInteger( this.$route.params.serialNumber ),

//                active: this.serialNumber,

                identifier: 'comment-setup-panel',

                labels: {
                    exam: "Set up student feedback for the exam as a whole",
                    item: "Set up student feedback for this item"
                },

                //Which valence is currently displayed
                displayed: 'stock',

                placeholders: {
                    exam: "Set up a global comment on the exam as a whole",
                    item: "Explain in detail what needed to be done in order to fully complete this task. This will form the basis for the response seen by the student.",
                },

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
        watch: {
            '$route' ( to, from ) {
                // react to route changes...
            }
        },
        computed: {
            panelId: function () {
                return this.identifier + '-' + this.serialNumber;
            },

            styling: function () {
                return this.identifier;
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
                return false;
            },

            label: function () {
                if ( this.isExam ) return this.labels.exam;
                return this.labels.item;
            },

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


            valences: function () {
                return Comment.valences;
            }

        },

        methods: {
            getComment: function(valence){
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


            prePopulateComments: function ( stock ) {
                var me = this;
                for(let [comment] of this.item.getEmptyComments()) {
                    if ( comment.valence === 'stock' ) return true;
                    let text = Comment.makePrePopulatedContent(comment.valence, stock);
                            let pl = Payload.factory( {
                                obj: this.item,
                                updateValence: valence,
                                updateVal: text
                            } );

                }

  }
        },


        directives: {},

        events: {
            'please-change-valence': function ( evt ) {
                console.log( 'caught please-change-valence', evt );
                this.displayedValence = evt;
            }
        },

        mounted: function () {
//            window.console.log('panel.comment-setup.component', 'mounted', 166, this.index);
        },
    };
</script>
