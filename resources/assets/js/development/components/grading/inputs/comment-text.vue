<template>
    <div class="field comment-text-area">
        <label></label>
        <div class="control">
            <textarea class="textarea"
                      rows="4"
                      placeholder="No score for this element"
                      v-model="commentText"
            ></textarea>
        </div>
        <p class="help"></p>
    </div>
</template>

<style lang="scss">

</style>

<script>
    import PayloadScore from '../../../../models/PayloadScore';
    import * as ngmTypes from '../../../../store/modules/newgrading/new-grading-mutation-types';
    import * as ngaTypes from '../../../../store/modules/newgrading/new-grading-action-types';
    import * as nggTypes from '../../../../store/modules/newgrading/new-grading-getter-types';
    import * as gTypes from '../../../../store/getter-types';

    export default {

        props: [ 'item', 'student' ],

        components: {},

        data: function () {
            return {
                defaults: {}
            }
        },

        computed: {
            exam : function (  ) {
              return this.$store.getters[ gTypes.getActiveExamObj ];
            },
            /**
             * The current value of the text area
             */
            commentText: {
                // cache: false,
                get: function () {
                    if(! this.isReady()) return '';

                    let so = this.$store.getters.getItemScoreObject( this.item.id, this.student.id );
                    if ( !_.isUndefined( so ) ) return so.commentText;
                    return '';


                    //
                    // //setting this to just this.elementScore prevents missing from displaying comment.
                    // //when element score was 0.
                    // //Also led to custom comments being deleted when moved to missing
                    // if ( this.elementScore != null )
                    // // window.console.log('elementInput', 'commentText', this.elementScore, this.getValence( this.elementScore ) );
                    //     return this.store.getCommentTextForActiveStudent( this.elementIndex, this.getValence( this.elementScore ) );
                },
                set: function ( text ) {

                    let pl = PayloadScore.factory( {
                        exam: this.exam,
                        item: this.item,
                        student: this.student,
                        text: text
                    } )

                    this.$store.commit( 'updateText', pl );

                }
            },


        },

        methods: {
            isReady: function (  ) {
                if ( _.isUndefined( this.item ) || _.isNull(this.item) || _.isUndefined( this.student ) || _.isNull(this.student) ) return false;
                return true;
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

        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>