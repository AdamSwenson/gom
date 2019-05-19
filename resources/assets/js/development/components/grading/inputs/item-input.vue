<template>
    <div class="item-input  questionPanel box">

        <div class="input-container-top">
            <div class="item-name">
                <p v-bind:class="labelStyling">{{ name }}</p>
            </div>
            <div class="item-score">
                <question-score
                        :item="item"
                        :student="student"
                >
<!--                    <letter-grade-button slot="input-button"-->
<!--                                         :item="item"-->
<!--                                         :student="student"-->
<!--                    ></letter-grade-button>-->
                </question-score>
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
            <!--<div class="level-left ">-->
            <div class="level-item has-text-centered is-fullwidth">
                <score-slider
                        :item="item"
                        :student="student"
                ></score-slider>
            </div>
            <!--</div>-->
            <!--<div class="level-right">-->
            <div class="level-item">
                <clear-score-button :item="item" :student="student"></clear-score-button>
                <!--</div>-->
            </div>
        </div>

        <!--<div class="input-container-bottom">-->
        <!--<div class="slider-item">-->
        <!--<score-slider-->
        <!--:item="item"-->
        <!--:student="student"-->
        <!--&gt;</score-slider>-->
        <!--</div>-->
        <!--<div class="clear-button-item">-->
        <!--<clear-score-button :item="item" :student="student"></clear-score-button>-->
        <!--</div>-->
        <!--</div>-->


    </div>

</template>

<style lang="scss">

    .input-container-top {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;

        .item-name {

        }
        .item-score {

        }
    }

    .input-container-bottom {
        display: flex;
        /*justify-content: space-between;*/
        flex-wrap: wrap;
        .slider-item {
            width: 90%
        }
        .clear-button-item {

        }

    }

</style>

<script>
    import * as nggTypes from '../../../../store/new-grading-getter-types';

    import QuestionScore from '../inputs/question-score.vue';
    import CommentText from "../inputs/comment-text.vue";
    import ScoreSlider from "../inputs/score-slider.vue";
    import LetterGradeButton from "../inputs/letter-grade-button.vue";
    import ClearScoreButton from "../inputs/clear-score-button.vue";


    export default {
        props: [ 'item', 'level' ],

        components: {
            ClearScoreButton,
            CommentText,
            ScoreSlider,
            CommentText,
            LetterGradeButton,
            QuestionScore,
        },

        data: function () {
            return {
                defaults: {}
            }
        },


        computed: {

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
                let heading = _.isUndefined( this.level ) ? 3 : this.level + 3;
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