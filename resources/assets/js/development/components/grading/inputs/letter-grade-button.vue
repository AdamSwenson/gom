<template>
    <!-- Single button -->
    <!--<div class="field letter-grade-button">-->
        <p class="letter-grade-button control">
            <span class="select" title="The grade for this item">
                <select class="letterGradeList"
                        v-model="selectedGradeAssignment"
                >
                    <option disabled value="" class="title-option"> {{ defaultDisplay }}</option>

                    <option
                            v-for="ga in gradeAssignments"
                            :key="ga.displayValue"
                            v-bind:value="ga"
                            v-bind:data="ga.calcValue"
                    >{{ ga.displayValue }}
                    </option>

                </select>
            </span>
        </p>
    <!--</div>-->
</template>
<script>

    // import gTypes from '../../../../store/getter-types';
    import * as ngaTypes from '../../../../store/new-grading-action-types';


    import {
        calculateGradeAssignmentFromItemScore,
        calculateItemScoreFromLetterGrade
    } from '../../../../store/modules/scores/itemLetterGradeHelpers';
    import GradeAssignment from '../../../../models/GradeAssignment';

    import scoreInputMixin from './scoreInputMixin';

    module.exports = {
        mixins: [
            scoreInputMixin
        ],

        props: [
            'item',
            'student'
        ],

        data: function () {
            return {
                defaultDisplay: '', //Select letter grade',
                ignoreChange: false,
                selectedGradeAssignment: null,
                defaults: {
                    // displayedGrade: 'Letter grade',
                    gradeValue: null
                }
            };
        },

        watch: {
            /**
             * If the item changes, the button should go to default or
             * the current score
             */
            item: function () {
                this.resetDisplayedGrade();
            },

            /**
             * If the student changes, the button should go
             * either to default or reflect the current score
             */
            student: function () {
                this.resetDisplayedGrade();
            },

            //When this is used, the letter grade
            //displayed on the button should track the
            //value of the score
            score: function ( newValue ) {
                this.resetDisplayedGrade(newValue);

                //we don't want the change in score to trigger the
                //update score since that would be both duplicative and
                //potentially override a more fine-grained score.
                //So we set a flag
                // this.ignoreChanges = true;
                //
                // //     //update the inferred letter grade
                // this.selectedGradeAssignment = calculateGradeAssignmentFromItemScore( newValue, this.maxScore );
                //
                // //Don't forget to reset the flag
                // this.ignoreChanges = false;
            },

            //This is the value that clicking the button will change
            //so we watch it in order to call mutations on the score
            selectedGradeAssignment: function ( gradeAssignment, oldAssign ) {

                if ( this.ignoreChanges ) return true;

                if(_.isNull(gradeAssignment) || _.isUndefined(gradeAssignment)) return true;

                let score = calculateItemScoreFromLetterGrade( gradeAssignment, this.maxScore );
                let pl = {
                    exam: this.exam,
                    item: this.item,
                    student: this.student,
                    score: score
                };
                this.$store.dispatch( ngaTypes.recordItemScore, pl );
            },


        },
        asyncComputed: {},
        computed: {
            //maxScore , score, and exam are defined in the mixin

            /**
             * The value displayed on the button
             * @returns {*}
             */
            displayedLetterGrade: function () {
                // if ( !_.isNull( this.displayedGradeAssignment ) && this.displayedGradeAssignment !== '-' )
                return this.displayedGradeAssignment.displayValue;
            },

            displayedGradeValue: function () {
                // if ( !_.isNull( this.displayedGradeAssignment ) && this.displayedGradeAssignment !== '-' )
                return this.displayedGradeAssignment.calcValue;
            },

            displayedGradeAssignment: function () {
                if ( _.isUndefined( this.score ) || _.isNull( this.score ) ) return null;
                return calculateGradeAssignmentFromItemScore( this.score, this.maxScore );
            },

            /**
             * Json of grades with keys displayValue and calcValue
             * @returns {{}}
             */
            gradeAssignments: function () {
                return GradeAssignment.defaults;
                //this should be reenabled if we allow this component
                //to be used for entire exams
                // return this.$store.getters.getGradeAssignmentsInSortedList;
            },


            /**
             * Converts the question score to a string for display
             * @returns {string}
             */
            scoreString: function () {
                if ( _.isUndefined( this.score ) || _.isNull( this.score ) ) return ''
                return this.score ? this.score.toFixed( 2 ) : '';
            },

        },

        methods: {

            /**
             * Safely resets the displayed grade without triggering
             * an update of the score
             */
            resetDisplayedGrade: function ( newScore = null ) {
                //we don't want the change in score to trigger the
                //update score since that would be both duplicative and
                //potentially override a more fine-grained score.
                //So we set a flag
                this.ignoreChanges = true;

                if ( !_.isNull( newScore ) ) {
                    this.selectedGradeAssignment = calculateGradeAssignmentFromItemScore( newScore, this.maxScore );
                } else {
                    this.selectedGradeAssignment = null;
                }

                this.ignoreChanges = false;
            }
        },

    };

    // /**
    //  * Reverse calculates the letter grade to display
    //  * based on the total score.
    //  * TODO This needs a flag so that we don't infer grades to people who don't want them or who entered a score manually
    //  * @param totalScore

</script>
