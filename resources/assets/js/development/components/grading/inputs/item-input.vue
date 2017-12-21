<template>
    <div id="element-input"
         class=" questionPanel box">

        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <!-- question Name -->
                    <p v-bind:class="labelStyling">{{ name }}</p>
                </div>
            </div>

            <div class="level-right">
                <div class="level-item">
                    <!-- question Score -->
                    <question-score
                            :item="item"
                            :student="student"
                    ></question-score>

                </div>
            </div>
        </div>

        <div class="field ">
            <label></label>
            <div class="control">
                <comment-text
                        :item="item"
                        :student="student"
                ></comment-text>
            </div>
            <p class="help"></p>
        </div>

        <div class="level">
            <div class="level-item has-text-centered is-fullwidth">
                <score-slider
                        :item="item"
                        :student="student"
                ></score-slider>
            </div>

        </div>

    </div>

</template>

<style lang="scss">

</style>

<script>
    import * as ngmTypes from '../../../../store/modules/newgrading/new-grading-mutation-types';
    import * as ngaTypes from '../../../../store/modules/newgrading/new-grading-action-types';
    import * as nggTypes from '../../../../store/modules/newgrading/new-grading-getter-types';
    import * as gTypes from '../../../../store/getter-types';

    import QuestionScore from '../inputs/question-score.vue';
    import CommentText from "../inputs/comment-text.vue";
    import ScoreSlider from "../inputs/score-slider.vue";


    export default {
        props: [ 'item', 'level' ],
        components: {
            CommentText,
            ScoreSlider,
            CommentText,
            QuestionScore,
        },

        data: function () {
            return {
                defaults: {}
            }
        },


        computed: {
            // serialNumber: function () {
            //     return _.toInteger( this.$route.params.serialNumber );
            // },
            //
            // number: function () {
            //     return this.serialNumber;
            //     // window.console.log( 'question-panel', 'number', 86, this.item);
            //     // return !_.isNull( this.item ) ? this.item.serialNumber : '';
            // },

            name: function () {
                // return this.item.name;
                if ( !_.isUndefined( this.item ) && !_.isNull( this.item ) ) {
                    return this.item.name
                }
                return '';
            },
            student: function () {
                let s = this.$store.getters[ nggTypes.getActiveStudent ];
                return !_.isUndefined( s ) ? s : ''
            },


            /**
             * Returns the styling for the heading, which
             * is used to distinguish between parent and child
             * items
             * @returns {string}
             */
            labelStyling: function () {
                let base = 'title is-';
                let heading = _.isUndefined(this.level) ? 3 :  this.level + 3;
                return base + heading;
            },

        },

        methods: {},

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>