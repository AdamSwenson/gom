<template>

    <textarea class="comment-text textarea"
              placeholder="No score for this element"
              v-bind:rows="numRows"
              v-model="commentText"
              v-on:focus="maximize"
              v-on:blur="minimize"
    ></textarea>

</template>

<style lang="scss">

</style>

<script>
    import PayloadScore from '../../../../models/PayloadScore';
    import * as ngmTypes from '../../../../store/new-grading-mutation-types';
    import * as ngaTypes from '../../../../store/new-grading-action-types';
    import * as nggTypes from '../../../../store/new-grading-getter-types';

    export default {

        props: [ 'item', 'student' ],

        components: {},

        data: function () {
            return {
                isMinimized: true,
                defaults: {
                    rows: {
                        minimized: 2,
                        maximized: 5
                    }
                }
            }
        },

        computed: {
            /**
             * The exam currently being graded
             */
            exam: function () {
                return this.$store.getters[ nggTypes.getActiveExam ];
            },

            /**
             * The current value of the text area
             */
            commentText: {
                // cache: false,
                get: function () {
                    if ( !this.isReady() ) return '';

                    let so = this.$store.getters[ nggTypes.getItemScoreObject ]( {
                        item: this.item,
                        student: this.student
                    } );

                    if ( !_.isUndefined( so ) ) return so.text;

                    return '';

                },

                set: function ( text ) {

                    let pl = {
                        exam: this.exam,
                        item: this.item,
                        student: this.student,
                        text: text
                    };

                    this.$store.dispatch( ngaTypes.recordCommentText, pl );
                }
            },

            numRows: function () {
                return this.isMinimized ? this.defaults.rows.minimized : this.defaults.rows.maximized;
            }

        },

        methods: {
            isReady: function () {
                if ( _.isUndefined( this.item ) || _.isNull( this.item ) || _.isUndefined( this.student ) || _.isNull( this.student ) ) return false;
                return true;
            },

            /**
             * Prevent user from entering text into comment area
             */
            commentAreaDisable: function () {
                this.el.setAttribute( 'readonly', 'true' );
            },

            /**
             * Allow user to enter text into comment area
             */
            commentAreaEnable: function () {
                this.el.removeAttribute( 'readonly' );
            },

            maximize: function () {
                this.isMinimized = false;
            },

            minimize: function () {
                this.isMinimized = true;
            }

        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>