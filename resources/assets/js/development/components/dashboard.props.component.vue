<template>
    <div id="props-dashboard" class="dashboard">
        <dl class="dl-horizontal">

            <dt># items</dt>
            <dd>{{ numberItems }}</dd>

            <dt>Max total score</dt>
            <dd>{{ perfectScore }}</dd>
            <!--<dd><input type="number" v-model="perfectScore" /></dd>-->

            <dt># Students</dt>
            <dd>{{ numberStudents}}</dd>

            <dt># Graded</dt>
            <dd>{{ numberGraded }}</dd>

            <dt>Time grading</dt>
            <dd>{{ timeGrading }}</dd>

        </dl>

    </div>
</template>
<style>

</style>
<script>
    /**
     * This handles the display of various statistical features of the exam
     * Such as: the highest possible score, number of items, # students
     * Created by adam on 2/15/17.
     */

    export default {
        props: [],

        data: function () {
            return {
                placeHolders: {
                    numberItems: '-',
                    perfectScore: '-',
                    timeGrading: '-'
                },
                defaults: {
                    numberStudents: 0,
                    numberGraded: 0,

                }
            };
        },

        computed: {
            /**
             * Number of constituent items (questions, elements) on the exam
             */
            numberItems: function () {
                let v = this.$store.getters.getItemCount;
                //if not set return placeholder
                return typeof v != 'undefined' ? v : this.placeHolders.numberItems;

            },

            /**
             * The maximum possible score, either entered directly
             * or calculated from the items
             */
            perfectScore: {
                get: function () {
                    //if not set return placeholder
                    return this.placeHolders.perfectScore;
                },
                set: function () {
                }
            },

            /**
             * Number of students associated with this assignment
             */
            numberStudents: {
                get: function () {
                    //if not set return placeholder
                    return this.defaults.numberStudent;
                }
            },

            /**
             * The number of students' assignments graded
             */
            numberGraded: {
                get: function () {
                    //if not set return placeholder
                    return this.defaults.numberGraded;
                }

            },

            /**
             * The total amount of time spent grading this assignment
             */
            timeGrading: {
                get: function () {
                    //if not set return placeholder
                    return this.placeHolders.timeGrading;
                }
            },
        },

        methods: {},

        directives: {},

        events: {},

        mounted: function () {
            console.log( 'props-dashboard ready' );
        },
    };
</script>
