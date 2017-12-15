<template>
    <!-- Single button -->
    <div id="letterGradeArea"
         class="field">

        <div class="control">
            <span class="select">
                <select class="letterGradeList"
                        v-model="displayedGrade"
                >
                    <option disabled value="" class="title-option"> - </option>

                    <option
                            v-for="ga in gradeAssignments"
                            :key="ga.serialNumber"
                            v-bind:value="ga"
                    >{{ ga.displayValue }}</option>

                </select>
            </span>
        </div>
    </div>

</template>
<script>

    import gTypes from '../../../../store/getter-types';

    module.exports = {

        props: [
            /**
             * The assigned score for the question.
             *
             * @returns {*}
             */
            'score',
            'grades'
        ],

        data: function () {
            return {
                displayedGrade: '-',
                defaults: {
                    displayedGrade: 'Letter grade',
                    gradeValue: null
                }
            };
        },

        watch: {
            displayedGrade: function ( gradeAssignment ) {

                // //The letter grade
                // this.$emit( 'selected', gradeAssignment );

                //Display tooltip explaining the calculation
                //  this.showGradePopOver( this.$el, this.displayedGrade.displayValue, this.displayedGrade.calcValue,  this.maxScore );

            },


            score: function ( newScore ) {
                this.displayedGrade = this.$store.getters[ gTypes.getGradeAssignmentForScore ];
            }
        },
        asyncComputed: {
            /**
             * Json of grades with keys displayValue and calcValue
             * @returns {{}}
             */
            gradeAssignments: function () {
                return this.$store.getters.getGradeAssignmentsInSortedList;
                // return this.store.getGrades();
            },

        },
        computed: {
            //
            // /**
            //  * The value displayed on the button
            //  * @returns {*}
            //  */
            // displayedGrade: function () {
            //     if ( (typeof this.score === "undefined") || (this.score === null) || (this.score == '') ) {
            //         //display 'Letter grade' if score not set
            //         return this.defaults.displayedGrade;
            //     }
            //
            //     //display the inferred letter grade
            //     return this.calcLetter( this.maxScore, this.score );
            // },


            /**
             * The maximum possible score for the question
             * @returns {*}
             */
            maxScore: function () {
                return Number( this.item.maxScore );
            },


            /**
             * Converts the question score to a string for display
             * @returns {string}
             */
            scoreString: function () {
                return this.score ? this.score.toFixed( 2 ) : '';
            },


        },

        methods: {
            // /**
            //  * Save the question score
            //  * obj.questionIndex
            //  * obj.questionNumber
            //  * obj.score
            //  * @param obj
            //  */
            // 'letter-grade-selected': function ( obj ) {
            //     window.console.log( 'gradeVue', 'letter-grade-selected', obj );
            //     this.store.storeQuestionScoreForActiveStudent( obj.questionIndex, obj.score );
            //     //save to server
            //
            //     this.$broadcast( 'letter-grade-selected', obj );
            // },


            /**
             * Calculates the question score from the standard grades and max score
             * @param gradeValue
             * @param maxScore
             * @returns {number}
             */
            calcGrade: function ( gradeValue, maxScore ) {
                gradeValue = Number( gradeValue );
                maxScore = Number( maxScore );
                let result = (gradeValue * .01) * maxScore;
                return this.roundToTwo( result );
            },

            /**
             * Reverse calculates the letter grade to display
             * based on the total score.
             * TODO This needs a flag so that we don't infer grades to people who don't want them or who entered a score manually
             * @param totalScore
             * @param maxScore
             */
            calcLetter: function ( maxScore, totalScore ) {
                totalScore = Number( totalScore );
                maxScore = Number( maxScore );

                let pctOfTotal = maxScore / totalScore;
                //multiple by 100 to more easily compare with grades list
                pctOfTotal = Math.round( pctOfTotal * 100 );
                let grade = 'Letter grade';

                // window.console.log( maxScore, totalScore, pctOfTotal );
                for (let i = 0; i < this.grades.length; i++) {
                    let cutOff = Number( this.grades[ i ].calcValue );
                    if ( pctOfTotal >= cutOff ) {
                        grade = this.grades[ i ].displayValue;
                        break;
                    }
                }
                return grade;
            },

            /**
             * Updates score by clicking on letter grade.
             * Also displays tooltip explaining the calculation to the user
             *
             * Decided not to update the button text at this time because
             * would have to store the value both locally and on the server.
             *
             * @param dthis The this context of the event handler
             */
            handleLetterGradeClick: function ( index ) {
                //The numeric value of the letter grade selected
                let gradeValue = this.grades[ index ].calcValue;
                let letterGrade = this.grades[ index ].displayValue;
                this.score = this.calcGrade( gradeValue, this.maxScore );
//            let letterGrade = this.calcLetter( this.maxScore, this.score );

                window.console.log( 'handle', index, gradeValue, letterGrade );
                //The letter grade
                // this.displayedGrade = this.grades[ index ].displayValue;
                this.notifyLetterGradeSelection();

                //todo reenable
                //Display tooltip explaining the calculation
                //    this.showGradePopOver( this.targetId, letterGrade, gradeValue, this.maxScore );
            },

            /**
             * Handles rounding of the score
             * Cf http://stackoverflow.com/questions/11832914/round-to-at-most-2-decimal-places-in-javascript
             * @param num
             * @returns {number}
             */
            roundToTwo: function ( num ) {
                return +(Math.round( num + "e+2" ) + "e-2");
            },

            /**
             * Creates a tooltip over the score box explaining the calculation done
             * by selecting the letter grade for the question. The tooltip should
             * automatically disappear upon clicking elsewhere on the page.
             * @param targetId String id of the score div to attach to
             * @param letterGrade String representation of the grade (e.g., 'A')
             * @param integerGrade Integer Value of the grade as an integer between 0 and 100
             * @param maxScore Integer Maximum score possible on the question
             */
            showGradePopOver: function ( gradeAssignment ) {
                //What the tooltip will attach to
                var $target = this.$el;

                //The decimal to be used in the displayed calculation message
                var floatGrade = Number( gradeAssignment.calcValue * 0.01 ).toFixed( 2 );

                //The resulting total to be displayed in the calculation message
                var total = this.scoreString; //Number( floatGrade * maxScore ).toFixed( 2 );

                //The message to display
                var message = "<p class='gradeToolTip'>" + letterGrade + " = " + integerGrade + "%<br/>" +
                    maxScore + " * " + floatGrade + " = " + total + "</p>";

                //Make sure any previously attached tooltip is gone
                $target.tooltip( 'destroy' );

                //Add a tooltip to the body and show it
                //Note: attached to body so won't float away on screen resize
                $target.tooltip( {
                    animation: true,
                    container: 'body',
                    html: true,
                    trigger: 'manual',
                    title: message
                } ).tooltip( 'show' );

                //Wait briefly for the tooltip to initialize and display
                setTimeout( function () {
                    //Attach a handler to the body to destroy the tooltip when the user clicks elsewhere.
                    $( 'body' ).on( 'click.tt', function () {
                        $target.tooltip( 'destroy' );
                        //Then remove the event handler so other tooltips will fire
                        $( 'body' ).off( 'click.tt' );
                    } );
                }, 10 );

            },

        },

    };
</script>
