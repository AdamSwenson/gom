<template>
    <div id="questionPanel"
         class=" questionPanel">
        <div class="tile is-ancestor">
            <div class="tile is-parent is-vertical ">
                <div class="tile is-child">

                    <div class="is-pulled-left">
                        <!-- question Name -->
                        <h4 class="">Question #{{ number }}: "{{ name }}"</h4>
                    </div>

                    <!-- question Score -->
                    <div class="is-pulled-right">
                        <question-score></question-score>
                    </div>
                </div>

                <!-- element area holds all sliders and comments for this question -->
                <div class="tile is-child ">
                    <div v-if="!isElementsEmpty">
                        <element-input v-for="item in items"></element-input>
                    </div>

                    <!--add some text if no elements for this question -->
                    <div class=" noElementsDiv "
                         v-if="isElementsEmpty"
                    >
                        <i>No elements for this question</i>
                    </div>

                </div>
            </div>
        </div>
    </div>

</template>

<style lang="scss">

</style>

import ElementInput from '../inputs/element-input.vue';
import QuestionScore from '../inputs/question-score.vue';

<script>
    export default {

        props: ['item'],

        components: { ElementInput, QuestionScore },

        data: function () {
            return {
                serialNumber: _.toInteger( this.$route.params.serialNumber ),

                defaults: {}
            }
        },

        computed: {
            //the associated elements
            items : function (  ) {

            },

            number: function () {

            },

            name: function () {

            }
        },

        methods: {},

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>