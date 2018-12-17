
<!-- This displays the score for the item -->

<template>

    <div class="question-score questionScoreForm field has-addons">
        <label class="label questionScoreLabel"></label>

        <p class="control">
            <input v-model="score"
                   class="input has-text-right questionScore"
                   type="number"
                   v-bind:min="minScore"
                   v-bind:max="maxScore"
                   title="The score for this item"
            />
        </p>

        <p class="control">
            <a class="button is-static" title="The max possible score">/ {{ maxScore }}</a>
        </p>

    </div>
</template>


<style lang="scss">
.question-score {
    input{
        width: 6em
    }
}
</style>

<script>

    var jQuery = require( 'jquery' );
    window.jQuery = jQuery;
    require( 'bootstrap' );

    import letterGradeButton from './letter-grade-button.vue';
    import PayloadScore from '../../../../models/PayloadScore';
    import GradeAssignment from '../../../../models/GradeAssignment';

    import * as ngmTypes from '../../../../store/new-grading-mutation-types';
    import * as ngaTypes from '../../../../store/new-grading-action-types';
    import * as nggTypes from '../../../../store/new-grading-getter-types';
    import * as gTypes from '../../../../store/getter-types';


    import {
        calculateGradeAssignmentFromItemScore,
        calculateItemScoreFromLetterGrade
    } from '../../../../store/modules/scores/itemLetterGradeHelpers';

    import scoreInputMixin from './scoreInputMixin';

    export default {
        mixins: [
            scoreInputMixin
        ],

        components: { letterGradeButton },

        props: [
            'item',
            'student',
        ],

        data: function () {
            return {
            };
        },

        watch: {
            score: function ( newVal, oldVal ) {
                if ( _.isUndefined( newVal ) || _.isUndefined( oldVal ) ) return false;
                //no change
                if ( newVal === oldVal ) return false;
                //value not yet loaded
                if(newVal instanceof Promise) return false;
                //we need a grade assignment if we are going to show it
                if(_.isNull(this.displayedGradeAssignment)) return false

                // window.console.log( 'question-score', 'score', 79, this.displayedGradeAssignment, this.maxScore, newVal);

                //todo To renable the grade popover, this is where you do it.
                //Note that the problem is with this https://github.com/twbs/bootstrap/issues/21830
                //it requires editing the bootstrap.js file or updating to 4.0
                // this.showGradePopOver( this.displayedGradeAssignment, this.maxScore, newVal );
            }
        },

        asyncComputed: {},

        computed: {
            //maxScore , score, and exam are defined in the mixin

            displayedGradeAssignment: function () {
                if ( _.isUndefined( this.score ) || _.isNull( this.score ) ) return null;
                return calculateGradeAssignmentFromItemScore( this.score, this.maxScore );
            },

            minScore: function () {
                return 0;
            },

            scoreObject: function () {
                return this.$store.getters.getItemScoreObject( this.item.id, this.student.id );
            },

        },

        methods: {

            // isReady defined in mixin

            handleLetterGradeSelect: function ( gradeAssignment ) {
                //set score
                this.score = gradeAssignment.calcValue;
            },

            /**
             * Creates a tooltip over the score box explaining the calculation done
             * by selecting the letter grade for the question. The tooltip should
             * automatically disappear upon clicking elsewhere on the page.
             *
             * NB, if tooltip stops working after an npm update, that's probably
             * because need to re-add a check for null in bootstrap.js.
             * See https://github.com/twbs/bootstrap/issues/21830
             *
             * @param targetId String id of the score div to attach to
             * @param letterGrade String representation of the grade (e.g., 'A')
             * @param integerGrade Integer Value of the grade as an integer between 0 and 100
             * @param maxScore Integer Maximum score possible on the question
             */
            showGradePopOver: function ( gradeAssignment, maxScore, score ) {

                let $target = jQuery( this.$el );
                let integerGrade = gradeAssignment.calcValue;
                let letterGrade = gradeAssignment.displayValue;
                //The decimal to be used in the displayed calculation message
                let floatGrade = Number( gradeAssignment.calcValue * 0.01 ).toFixed( 2 );
                //The resulting total to be displayed in the calculation message
                var total = Number( score ).toFixed( 2 ); //Number( floatGrade * maxScore ).toFixed( 2 );

                if(_.isUndefined(integerGrade) || _.isUndefined(letterGrade) || _.isNaN(floatGrade) || _.isNaN(total)) return false;

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

                    // window.console.log( 'question-score', 'ttt', 158, $target);
                    //Attach a handler to the body to destroy the tooltip when the user clicks elsewhere.
                    jQuery( 'body' ).on( 'click.tt', function () {
                        if(!_.isNull($target.tooltip)){
                            $target.tooltip( 'destroy' );
                            //Then remove the event handler so other tooltips will fire
                            jQuery( 'body' ).off( 'click.tt' );
                        }

                    } );
                }, 10 );

            },

            // waitAndSetTimeout: function(){
            //     let limit = 10;
            //     if(_.isUndefined(tries)) let tries = 0
            //     tries += 1;
            //
            //
            // }
        },


    };
</script>