/**
 * Created by adam on 7/18/16.
 */

var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

require('bootstrap');

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

            defaults:{
                displayedGrade: 'Letter grade',
                gradeValue: null
            },

            storage:{
                currentGradeDisplay: null,
                currentGradeValue: null
            }

        };
    },

    computed: {

        /**
         * The value displayed on the button
         * @returns {*}
         */
        displayedGrade: {
            get: function () {
                if ( this.storage.currentGradeDisplay ) {
                    return this.storage.currentGradeDisplay
                }
                return this.defaults.displayedGrade;
            },
            set: function (val) {
                this.storage.currentGradeDisplay = val;
            }
        },

        //The value of the letter grade used in calculation
        gradeValue: {
            get: function(){
                if(this.storage.currentGradeValue != null){
                    return this.storage.currentGradeValue;
                }
                return this.defaults.gradeValue;

            },
            set: function(val) {
                this.storage.currentGradeValue = val;
            }
        },

        maxScore: function(){
            return this.store.maxQuestionScores[this.questionIndex];
          // return Number(this.store.maxQuestionScores[this.questionIndex]);
        },

        score: function(){
            // window.console.log('score', this.gradeValue, this.maxScore);
            return this.calcGrade(this.gradeValue, this.maxScore);
        },

        scoreString: function(){
            return this.score.toFixed(2);
        },
        targetId: function(){
            return "questionScore" + this.questionNumber;
        }

    },

    methods: {

        calcGrade: function(gradeValue, maxScore){
            gradeValue = Number(gradeValue);
            maxScore = Number(maxScore);
            return (gradeValue * .01) * maxScore;
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
            window.console.log('letter grade clicked', index);


            //The value of the letter grade selected
            this.gradeValue = this.grades[index].calcValue;

            //The letter grade
            this.displayedGrade = this.grades[index].displayValue;

            this.notifyLetterGradeSelection();

            //Display tooltip explaining the calculation
           this.showGradePopOver( this.targetId, this.displayedGrade, this.gradeValue, this.maxScore );
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
        notifyLetterGradeSelection: function(){
            var obj = {};
            obj.questionIndex = this.questionIndex;
            obj.questionNumber = this.questionNumber;
            obj.score = this.score;
            this.$dispatch('letter-grade-selected', obj);
        }
    },

    directives: {},
    ready: function(){
        // window.console.log('ready', this.grades);
    }

};