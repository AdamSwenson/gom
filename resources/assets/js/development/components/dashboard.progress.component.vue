<template>
    <div id="progress-dashboard"
         class="dashboard"
    >
        <div class="row">
            <div class="panel col-md-3"
                 v-bind:class="{'panel-success' : setupComplete }"
            >
                <div class="panel-heading">
                    <h6><span v-show="setupComplete"><span class="glyphicon glyphicon-ok"></span></span> Setup </h6>
                </div>
                <ul class="list-group">
                    <li class="list-group-item">
                        # Items <span class="badge">{{ numberItems }}</span>
                    </li>

                    <li class="list-group-item">
                        Max total score <span class="badge">{{ perfectScore }}</span>
                    </li>

                    <li class="list-group-item">
                        # Students <span class="badge">{{ numberStudents }}</span>
                    </li>

                </ul>
            </div>
            <div class="panel col-md-3"
                 v-bind:class="{'panel-success' : gradingComplete }"
            >
                <div class="panel-heading">
                    <h6><span v-show="gradingComplete"></span> <span class="glyphicon glyphicon-ok"></span> Grading
                    </h6>
                </div>
                <ul class="list-group">
                    <li class="list-group-item">
                        # Graded <span class="badge">{{ numberGraded }}</span>
                    </li>
                    <li class="list-group-item">
                        Time grading <span class="badge">{{ timeGrading }}</span>
                    </li>
                </ul>

            </div>

            <div class="panel col-md-3">
                <div class="panel-heading">
                    <h6><span v-show="reviewingComplete"> <span class="glyphicon glyphicon-ok"></span></span> Reviewing
                    </h6>
                </div>

                <ul class="list-group">
                    <li class="list-group-item">
                    </li>
                </ul>

            </div>
        </div>
    </div>

</template>
<style>
    ul {

    }

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
                    let v = this.$store.getters[ gTypes.getItemCount ];
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

        methods: {},

        directives: {},

        events: {},

        mounted: function () {
//            console.log('props-dashboard ready', this.$store);
        },
    };
</script>
