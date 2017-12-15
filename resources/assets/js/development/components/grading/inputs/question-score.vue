<template>

    <div class="questionScoreForm ">
        <letter-grade-button
                :item="item"
                v-on:selected="handleLetterGradeSelect"
        ></letter-grade-button>


        <div class="field">
            <label class="label questionScoreLabel">Score:</label>

            <div class="control">
                <input v-model="score" lazy
                       class="input has-text-right questionScore"
                       type="number"
                       v-bind:min="minScore"
                       v-bind:max="maxScore"
                /> / {{ maxScore }}
            </div>

        </div>
    </div>

</template>
<script>
    import letterGradeButton from './letter-grade-button';
    import PayloadScore from '../../../../models/PayloadScore';
    import * as ngmTypes from '../../../../store/modules/newgrading/new-grading-mutation-types';
    import * as ngaTypes from '../../../../store/modules/newgrading/new-grading-action-types';
    import * as nggTypes from '../../../../store/modules/newgrading/new-grading-getter-types';
    import * as gTypes from '../../../../store/getter-types';


    module.exports = {

        components: { letterGradeButton },

        props: [
            'item',
            'student',
        ],

        data: function () {
            return {
                // /**
                //  * The string id of the question score field for this question.
                //  * Does not contain '#'
                //  * @returns {string}
                //  */
                // scoreFieldIdString: "questionScore" + this.questionNumber,
                //
                // /**
                //  * The string id of the max score field for
                //  * this question.
                //  * Does not contain '#'
                //  * @returns {string}
                //  */
                // maxScoreFieldIdString: "maxScore" + this.questionNumber,

            };
        },

        asyncComputed: {},

        computed: {
            exam : function (  ) {
                return this.$store.getters[ gTypes.getActiveExamObj ];
            },

            maxScore: function () {
                if ( _.isUndefined( this.item ) ) return '';
                return this.item.maxScore;
            },

            minScore: function () {
                return 0;
            },

            /**
             * The student's score for this question
             */
            score: {
                get: function () {
                    if ( _.isUndefined( this.item ) || _.isUndefined( this.student ) ) return '';
                    let qs = this.$store.getters.getItemScoreObject( this.item.id, this.student.id );
                    if ( qs != null ) {
                        return qs.score;
                    }
                },

                /**
                 * Update the score in the shared data object and send
                 * a request for someone else to record it to the server.
                 *
                 * Note that we use the 'lazy' parameter in the template so that
                 * this only syncs once the change event has fired. That prevents
                 * us from sending two different requests for a two digit score.
                 *
                 * @param score
                 */
                set: function ( score ) {

                    let pl = PayloadScore.factory( {
                        exam: this.exam,
                        item: this.item,
                        student: this.student,
                        score: score
                    } )
                    this.$store.commit( ngmTypes.updateScore, pl );
                }
            }
        },

        methods: {


            handleLetterGradeSelect: function ( gradeAssignment ) {
                //set score
                this.score = gradeAssignment.calcValue;

            },
        },


    }
    ;</script>