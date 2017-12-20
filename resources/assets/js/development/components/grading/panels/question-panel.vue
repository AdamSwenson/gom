<template>
    <div id="questionPanel"
         class=" questionPanel box">
        <div class="tile is-ancestor">
            <div class="tile is-parent is-vertical ">
                <div class="tile is-child">
                    <div class="level">
                        <div class="level-left">
                            <div class="level-item">
                                <!-- question Name -->
                                <h4 class="">#{{ number }}: "{{ name }}"</h4>
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

                    <comment-text :item="item" :student="student"></comment-text>
                    <div class="level">
                        <div class="level-left">
                            <div class="level-item">
                                <score-slider :item="item" :student="student"></score-slider>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- element area holds all sliders and comments for this question -->
        <div class="tile is-child ">
            <div v-if="!isElementsEmpty">
                <element-input v-for="item in elements"
                               v-bind:key="item.serialNumber"
                               :item="item"
                               :student="student"></element-input>
            </div>

            <!--add some text if no elements for this question -->
            <div class=" noElementsDiv "
                 v-if="isElementsEmpty"
            >
                <i>No elements for this question</i>
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

    import ElementInput from '../inputs/element-input.vue';
    import QuestionScore from '../inputs/question-score.vue';
    import CommentText from "../inputs/comment-text.vue";
    import ScoreSlider from "../inputs/score-slider.vue";


    export default {
        // name: 'qp',

        components: {
            ElementInput,
            CommentText,
            ScoreSlider,
            CommentText,
            QuestionScore,

        },

        data: function () {
            return {
                // serialNumber: _.toInteger( this.$route.params.serialNumber ),

                defaults: {}
            }
        },

        asyncComputed: {},

        computed: {
            serialNumber: function () {
                return _.toInteger( this.$route.params.serialNumber );
            },

            item: function () {
                return this.$store.getters.getItemBySerialNumber( this.serialNumber );
            },


            number: function () {
                return this.serialNumber;
                // window.console.log( 'question-panel', 'number', 86, this.item);
                // return !_.isNull( this.item ) ? this.item.serialNumber : '';
            },

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


            //the associated elements
            elements: function () {
                if ( !_.isUndefined( this.item ) && !_.isNull( this.item ) ) {
                    return this.$store.getters.getItemChildren( this.item );
                }
                return [];
            },

            isElementsEmpty: function () {
                return this.elements.length === 0;
            },


        },

        methods: {},

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>