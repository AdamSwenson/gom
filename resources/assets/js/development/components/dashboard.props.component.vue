<template>
    <div id="props-dashboard" class="dashboard">
        <dl class="dl-horizontal">

            <dt><span v-show="itemsComplete" class="text-success glyphicon glyphicon-ok"></span> # items</dt>
            <dd>{{ numberItems }}</dd>

            <dt>Max total score</dt>
            <dd>{{ perfectScore }}</dd>
            <!--<dd><input type="number" v-model="perfectScore" /></dd>-->

            <dt><span v-show="studentsComplete" class="glyphicon glyphicon-ok"></span> # Students</dt>
            <dd>{{ numberStudents}}</dd>

            <dt> # Graded</dt>
            <dd>{{ numberGraded }}</dd>

            <dt>Time grading</dt>
            <dd>{{ timeGrading }}</dd>

            <dt v-show="gradingComplete"><span class="glyphicon glyphicon-ok"></span></dt>
            <dd v-show="gradingComplete">Grading Complete</dd>
            <dt v-show="reviewingComplete"><span class="glyphicon glyphicon-ok"></span></dt>
            <dd v-show="reviewingComplete">Reviewing Complete </dd>

        </dl>

    </div>
</template>
<style>

</style>
<script>

    import * as aTypes from '../../store/action-types';
    import * as mTypes from '../../store/mutation-types';
    import * as gTypes from '../../store/getter-types';

    /**
     * This handles the display of various statistical features of the exam
     * Such as: the highest possible score, number of items, # students
     * TODO: This should probably be made slicker and more informative
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
                },
                //for steps which are complete
                //when a certain number of things are done
                //e.g., add one student or one question
                //these are the thresholds the current amount
                //is compared to
                thresholds: {
                    questions: 1,
                    students: 1
                }
            };
        },

        computed: {
            /**
             * Number of constituent items (questions, elements) on the exam
             */
            numberItems: {
                get: function () {
                    let v = this.$store.getters[gTypes.getItemCount];
                    //if not set return placeholder
                    return typeof v != 'undefined' ? v : this.placeHolders.numberItems;
                }
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

        methods: {
            //checks on whether stage is complete
            //returns boolean

            itemsComplete: function () {
                //if (numItemsWithIds > this.thresholds.items) return true;
                return false;
            },
            studentsComplete: function () {
                //if (numStudents > this.thresholds.students) return true;
                return false;
            },
            setupComplete: function () {
                return false;
            },
            gradingComplete: function () {
                //if (numGraded > this.thresholds.graded) return true;
                return false
            },
            reviewingComplete: function () {
                return false;
            }
        },

        directives: {},

        events: {},

        mounted: function () {
            console.log('props-dashboard ready', this.$store);
        },
    };
</script>
