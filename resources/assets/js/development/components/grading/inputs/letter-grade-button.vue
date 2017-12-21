<template>
    <!-- Single button -->

    <p id="letterGradeArea" class="control">
            <span class="select">
                <select class="letterGradeList"
                        v-model="selectedGradeAssignment"
                >
                    <option disabled value="" class="title-option"> - </option>

                    <option
                            v-for="ga in gradeAssignments"
                            :key="ga.displayValue"
                            v-bind:value="ga"
                    >{{ ga.displayValue  }}</option>

                </select>
            </span>
    </p>

</template>
<script>

    // import gTypes from '../../../../store/getter-types';
    import * as nggTypes from '../../../../store/modules/newgrading/new-grading-getter-types';
    import * as ngmTypes from '../../../../store/modules/newgrading/new-grading-mutation-types';
    import * as ngaTypes from '../../../../store/modules/newgrading/new-grading-action-types';


    import {
        calculateGradeAssignmentFromItemScore,
        calculateItemScoreFromLetterGrade
    } from '../../../../store/modules/scores/itemLetterGradeHelpers';
    import GradeAssignment from '../../../../models/GradeAssignment';
    import PayloadScore from '../../../../models/PayloadScore';

    module.exports = {

        props: [
            /**
             * The assigned score for the question.
             *
             * @returns {*}
             */
            'score',
            'item'
        ],

        data: function () {
            return {
                ignoreChange: false,
                selectedGradeAssignment: null,
                defaults: {
                    // displayedGrade: 'Letter grade',
                    gradeValue: null
                }
            };
        },

        watch: {

            //When this is used, the letter grade
            //displayed on the button should track the
            //value of the score
            score: function ( newValue ) {

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
            selectedGradeAssignment: function ( gradeAssignment , oldAssign) {

                if ( this.ignoreChanges ) return true;

                let score = calculateItemScoreFromLetterGrade( gradeAssignment, this.maxScore );
                let pl =  {
                    exam: this.exam,
                    item: this.item,
                    student: this.student,
                    score: score
                };
                this.$store.dispatch( ngaTypes.recordItemScore, pl );
            },


        },
        asyncComputed: {
            exam: function () {
                let e = this.$store.getters[ nggTypes.getActiveExam ];
                return !_.isUndefined( e ) ? e : '';
            },

            student: function () {
                let s = this.$store.getters[ nggTypes.getActiveStudent ];
                return !_.isUndefined( s ) ? s : '';
            },
        },
        computed: {

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
             * The maximum possible score for the question
             * @returns {*}
             */
            maxScore: function () {
                if ( _.isUndefined( this.item ) || _.isNull( this.item ) ) return null;

                return Number( this.item.maxScore );
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

        },

    };


    //
    // /**
    //  * Calculates the question score from the standard grades and max score
    //  * @param gradeValue
    //  * @param maxScore
    //  * @returns {number}
    //  */
    // calcGrade: function ( gradeValue, maxScore ) {
    //     gradeValue = Number( gradeValue );
    //     maxScore = Number( maxScore );
    //     let result = (gradeValue * .01) * maxScore;
    //     return this.roundToTwo( result );
    // },

    // /**
    //  * Reverse calculates the letter grade to display
    //  * based on the total score.
    //  * TODO This needs a flag so that we don't infer grades to people who don't want them or who entered a score manually
    //  * @param totalScore
    //  * @param maxScore
    //  */
    // calcLetter: function ( maxScore, totalScore ) {
    //     totalScore = Number( totalScore );
    //     maxScore = Number( maxScore );
    //
    //     let pctOfTotal = maxScore / totalScore;
    //     //multiple by 100 to more easily compare with grades list
    //     pctOfTotal = Math.round( pctOfTotal * 100 );
    //     let grade = 'Letter grade';
    //
    //     // window.console.log( maxScore, totalScore, pctOfTotal );
    //     for (let i = 0; i < this.gradeAssignments.length; i++) {
    //         let cutOff = Number( this.gradeAssignments[ i ].calcValue );
    //         if ( pctOfTotal >= cutOff ) {
    //             grade = this.gradeAssignments[ i ].displayValue;
    //             break;
    //         }
    //     }
    //     return grade;
    // },
    //
    // /**
    //  * Updates score by clicking on letter grade.
    //  * Also displays tooltip explaining the calculation to the user
    //  *
    //  * Decided not to update the button text at this time because
    //  * would have to store the value both locally and on the server.
    //  *
    //  * @param dthis The this context of the event handler
    //  */
    // handleLetterGradeClick: function ( index ) {
    //     //The numeric value of the letter grade selected
    //     let gradeValue = this.gradeAssignments[ index ].calcValue;
    //     let letterGrade = this.gradeAssignments[ index ].displayValue;
    //     this.score = calcGrade( gradeValue, this.maxScore );
    //     // let letterGrade = this.calcLetter( this.maxScore, this.score );
    //
    //     window.console.log( 'handle', index, gradeValue, letterGrade );
    //     //The letter grade
    //     // this.displayedGrade = this.grades[ index ].displayValue;
    //     // this.notifyLetterGradeSelection();
    //
    //     let pl = PayloadScore.factory( {
    //         exam: this.exam,
    //         item: this.item,
    //         student: this.student,
    //         score: this.score
    //     } )
    //     this.$store.commit( ngmTypes.updateScore, pl );
    //
    //
    //     //todo reenable
    //     //Display tooltip explaining the calculation
    //     //    this.showGradePopOver( this.targetId, letterGrade, gradeValue, this.maxScore );
    // },

</script>
