
<!-- This displays the score for the item -->

<template>

    <div class="question-score questionScoreForm field has-addons">
        <label class="label questionScoreLabel"></label>

        <p class="control">
            <input v-model="score" lazy
                   class="input has-text-right questionScore"
                   type="number"
                   v-bind:min="minScore"
                   v-bind:max="maxScore"
            />
        </p>

        <p class="control">
            <a class="button is-static">/ {{ maxScore }}</a>
        </p>

    </div>
</template>
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
                if ( newVal === oldVal ) return false;

                //
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
                    jQuery( 'body' ).on( 'click.tt', function () {
                        $target.tooltip( 'destroy' );
                        //Then remove the event handler so other tooltips will fire
                        jQuery( 'body' ).off( 'click.tt' );
                    } );
                }, 10 );

            },
        },


    }
    ;</script>