/**
 * Created by adam on 7/18/16.
 */

var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

require( 'bootstrap' );

module.exports = {

    template: require( '../templates/letter-grade-button.template.html' ),

    props: [
        'questionIndex',
        'questionNumber',
        //json of grades with keys displayValue and calcValue
        'grades'
    ],

    data: function () {
        return {
            /**
             * The data repository store shared by everyone
             */
            store: store,

            defaults: {
                displayedGrade: 'Letter grade',
                gradeValue: null
            },

            // storage: {
            //     currentGradeDisplay: null,
            //     currentGradeValue: null
            // }

        };
    },

    computed: {

        /**
         * The value displayed on the button
         * @returns {*}
         */
        displayedGrade: function () {
            if ( (typeof this.score === "undefined") || (this.score === null) || (this.score == '') ) {
                //display 'Letter grade' if score not set
                return this.defaults.displayedGrade;
            }

            //display the inferred letter grade
            return this.calcLetter( this.maxScore, this.score );
        },


        // //The value of the letter grade used in calculation
        // gradeValue: {
        //     get: function () {
        //         if ( this.storage.currentGradeValue != null ) {
        //             return this.storage.currentGradeValue;
        //         }
        //         return this.defaults.gradeValue;
        //
        //     },
        //     set: function ( val ) {
        //         this.storage.currentGradeValue = val;
        //     }
        // },

        /**
         * The maximum possible score for the question
         * @returns {*}
         */
        maxScore: function () {
            return Number( this.store.getMaxQuestionScore( this.questionIndex ) );
        },

        /**
         * The assigned score for the question.
         * @returns {*}
         */
        score: {
            get: function () {
                return this.store.getQuestionScoreForActiveStudent( this.questionIndex );
            },
            set: function ( score ) {
                this.store.storeQuestionScoreForActiveStudent( this.questionIndex, score );
            }
        },

        /**
         * Converts the question score to a string for display
         * @returns {string}
         */
        scoreString: function () {
            return this.score.toFixed( 2 );
        },

        targetId: function () {
            return "questionScore" + this.questionNumber;
        }

    },

    methods: {

        /**
         * Calculates the question score from the standard grades and max score
         * @param gradeValue
         * @param maxScore
         * @returns {number}
         */
        calcGrade: function ( gradeValue, maxScore ) {
            gradeValue = Number( gradeValue );
            maxScore = Number( maxScore );
            let result =(gradeValue * .01) * maxScore;
            return this.roundToTwo(result);
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
            for ( let i = 0; i < this.grades.length; i ++ ) {
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

            //Display tooltip explaining the calculation
            this.showGradePopOver( this.targetId, letterGrade, gradeValue, this.maxScore );
        },

        /**
         * Handles rounding of the score
         * Cf http://stackoverflow.com/questions/11832914/round-to-at-most-2-decimal-places-in-javascript
         * @param num
         * @returns {number}
         */
        roundToTwo: function ( num ) {
            return + (Math.round( num + "e+2" ) + "e-2");
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
        showGradePopOver: function ( targetId, letterGrade, integerGrade, maxScore ) {
            //What the tooltip will attach to
            var $target = $( '#' + targetId );

            //The decimal to be used in the displayed calculation message
            var floatGrade = Number( integerGrade * 0.01 ).toFixed( 2 );

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

        /* --------------------- Notifications and events ---------------------------- */
        notifyLetterGradeSelection: function () {
            var obj = {};
            obj.questionIndex = this.questionIndex;
            obj.questionNumber = this.questionNumber;
            obj.score = this.score;
            this.$dispatch( 'letter-grade-selected', obj );
        }
    },

    directives: {},
    ready: function () {
        // window.console.log('ready', this.grades);
    }

};