<template>
    <div id="questionPanel"
         class=" question-panel ">
        <div class="tile is-ancestor">
            <div class="tile is-parent is-vertical ">

                <question-grading-area :item="item" :level="0"></question-grading-area>

                <!-- element area holds all sliders and comments for this question -->
                <question-grading-area
                        v-if="!isElementsEmpty"
                        v-for="e in elements"
                        v-bind:key="e.item.serialNumber"
                        :item="e.item"
                        :level="e.level"
                ></question-grading-area>

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
    #questionPanel {
        .noElementsDiv {
            background-color: #DDDDDD
        }
    }

</style>

<script>
    import * as ngmTypes from '../../../../store/new-grading-mutation-types';
    import * as ngaTypes from '../../../../store/new-grading-action-types';
    import * as nggTypes from '../../../../store/new-grading-getter-types';
    import * as gTypes from '../../../../store/getter-types';

    import ItemInput from '../inputs/item-input.vue';
    import QuestionScore from '../inputs/question-score.vue';
    import CommentText from "../inputs/comment-text.vue";
    import ScoreSlider from "../inputs/score-slider.vue";
    import QuestionGradingArea from "./question-grading-area";

    const getChildren = function ( store, item, level, els = [] ) {
        let js = store.getters.getItemChildren( item );
        //if there are no children, we're done
        if ( _.isUndefined( js ) || js.length === 0 ) return els;

        level += 1;

        _.forEach( js, function ( item ) {
            //push each into the list
            els.push( { item: item, level: level } );
            //call recursively on each child
            getChildren( store, item, level, els );
        } );
    }

    export default {

        components: {
            QuestionGradingArea,
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

            qs: function () {
            },


            //the associated child items
            elements: function () {
                let els = [];
                let me = this;
                if ( !_.isUndefined( this.item ) && !_.isNull( this.item ) ) {
                    let level = 0;
                    getChildren( this.$store, this.item, level, els );
                }
                return els;
                //
                // let els = [];
                // if ( !_.isUndefined( this.item ) && !_.isNull( this.item ) ) {
                //     let level = 0;
                //     // _.forEach( this.$store.getters.getItemChildren( this.item ), function ( item ) {
                //     //     els.push( { level: 1, item: item } );
                //     // } );
                //
                //
                //     return this.$store.getters.getItemChildren( this.item );
                // }
                // return els;
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