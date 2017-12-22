<template>
    <div id="questionPanel"
         class=" questionPanel box">
        <div class="tile is-ancestor">
            <div class="tile is-parent is-vertical ">

                <div class="tile is-child">
                    <item-input :item="item"
                                :level="0"
                    ></item-input>
                </div>

                <!-- element area holds all sliders and comments for this question -->
                <div class="tile is-child "
                     v-if="!isElementsEmpty"
                     v-for="item in elements">
                    <item-input
                            v-bind:key="item.serialNumber"
                            :item="item"
                            :level="1"
                    ></item-input>
                </div>

                <!--add some text if no elements for this question -->
                <div class=" noElementsDiv tile is-child "
                     v-if="isElementsEmpty"
                >
                    <i>No elements for this question</i>
                </div>
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

    import ItemInput from '../inputs/item-input.vue';
    import QuestionScore from '../inputs/question-score.vue';
    import CommentText from "../inputs/comment-text.vue";
    import ScoreSlider from "../inputs/score-slider.vue";


    export default {

        components: {
            ItemInput,
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

        asyncComputed: {},

        computed: {
            /**
             * The item's serial number, fetched from the route
             * @returns {number | _.LoDashImplicitWrapper<number> | _.LoDashExplicitWrapper<number>}
             */
            serialNumber: function () {
                return _.toInteger( this.$route.params.serialNumber );
            },

            /**
             * Returns the item
             * @returns {*}
             */
            item: function () {
                return this.$store.getters.getItemBySerialNumber( this.serialNumber );
            },

            student: function () {
                let s = this.$store.getters[ nggTypes.getActiveStudent ];
                return !_.isUndefined( s ) ? s : ''
            },


            //the associated child items
            elements: function () {
                let els = [];
                if ( !_.isUndefined( this.item ) && !_.isNull( this.item ) ) {
                    let level = 0;
                    // _.forEach( this.$store.getters.getItemChildren( this.item ), function ( item ) {
                    //     els.push( { level: 1, item: item } );
                    // } );


                    return this.$store.getters.getItemChildren( this.item );
                }
                return els;
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