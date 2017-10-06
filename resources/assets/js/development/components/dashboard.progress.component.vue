<template>
    <nav id="progress-dashboard"
         class="level"
    >

            <!--<div class="level-item has-text-centered">-->
                <!--<div><p class="heading">-->
            <!--<span v-show="setupComplete">-->
            <!--<span class="glyphicon glyphicon-ok"></span>-->
            <!--</span> Setup-->
                <!--</p>-->
                <!--</div>-->
            <!--</div>-->

            <div class="level-item has-text-centered">
                <div>
                    <p class="heading"># Items</p>
                    <p class="title">
                        <span class="badge">{{ numberItems }}</span>
                    </p>
                </div>
            </div>

            <div class="level-item has-text-centered">
                <div>
                    <p class="heading">Max total score</p>
                    <p class="title"><span class="badge">{{ perfectScore }}</span></p>
                </div>
            </div>


            <div class="level-item  has-text-centered">
                <div>
                    <p class="heading"># Students</p>
                    <p class="title">
                        <span class="badge">{{ numberStudents }}</span>
                    </p>
                </div>
            </div>

            <!--<div class="level-item has-text-centered"-->
                 <!--id="progressGrading"-->
                 <!--v-bind:class="{'bg-success' : gradingComplete }"-->
            <!--&gt;-->
                <!--<div>-->
                    <!--<p class="heading">-->
                        <!--<span v-show="gradingComplete">-->
                            <!--<span class="glyphicon glyphicon-ok"></span>-->
                        <!--</span>-->
                        <!--Grading-->
                    <!--</p>-->
                <!--</div>-->
            <!--</div>-->

            <div class="level-item has-text-centered">
                <div>
                    <p class="heading"># Graded </p>
                    <p class="title">
                        <span class="badge">{{ numberGraded }}</span>
                    </p>
                </div>
            </div>

            <div class="level-item has-text-centered">
                <div>
                    <p class="heading">Time grading</p>
                    <p class="title"><span class="badge">{{ timeGrading }}</span></p>
                </div>
            </div>

            <!--<div class="level-item has-text-centered"-->
                 <!--id="progressReviewing"-->
            <!--&gt;-->
                <!--<div>-->
                    <!--<p class="heading">-->
                        <!--<span v-show="reviewingComplete">-->
                            <!--<span class="glyphicon glyphicon-ok"></span>-->
                        <!--</span>-->
                        <!--Reviewing-->
                    <!--</p>-->
                <!--</div>-->
            <!--</div>-->

        <!--</div>-->

    </nav>

</template>
<style lang="scss">
    #progress-dashboard {
        h5 {
            text-align: right;
            vertical-align: top;
            /*text-shadow : 0 2px 3px rgba(0,0,0,.8);*/
        }
        li {
            .group-cell {
            }
        }
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
                    return this.defaults.numberStudents;
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
