<template>

    <div class="questionScoreForm ">
        <letter-grade-button
                :item="item"
                v-on:selected="handleLetterGradeSelect"
        ></letter-grade-button>


        <div class="field">
            <label class="label questionScoreLabel">Score:</label>

            <div class="control">
                <input v-model="questionScore" lazy
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

    module.exports = {

        components: { letterGradeButton },
        props: [
            'exam',
            'item',
            'student',
            'questionNumber'
        ],

        data: function () {
            return {
                /**
                 * The string id of the question score field for this question.
                 * Does not contain '#'
                 * @returns {string}
                 */
                scoreFieldIdString: "questionScore" + this.questionNumber,

                /**
                 * The string id of the max score field for
                 * this question.
                 * Does not contain '#'
                 * @returns {string}
                 */
                maxScoreFieldIdString: "maxScore" + this.questionNumber,


                maxScore: this.item.maxScore,
                minScore: 0,
            };
        },

        computed: {


            /**
             * The student's score for this question
             */
            score: {
                get: function () {
                    let qs = this.$store.getQuestionScoreForActiveStudent( this.questionIndex );
                    if ( qs != null ) {
                        return qs;
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
                    this.$store.storeQuestionScoreForActiveStudent( this.questionIndex, score );
                    this.notifyRecordScore();
                }
            }
        },

        methods: {

            /**
             * Handles the request to store question score on the server
             * Accompanying object should contain:
             *      obj.questionAssignmentId: Db id of the question assignment
             *      obj.questionIndex: Index of the question whose score needs updating
             *      obj.studentIndex: Index of the student to record grades for.
             *          This is here to avoid a race condition
             * @param questionScoreRequestObj
             */
            'store-question-score-request': function ( questionScoreRequestObj ) {
                window.console.log( 'gradeVue', 'caught store-question-score-request', questionScoreRequestObj );
                let score = this.store.getQuestionScoreForActiveStudent(questionScoreRequestObj.questionIndex);
                if( score == '' || score == null){
                    this.deleteScore(questionScoreRequestObj.studentIndex, questionScoreRequestObj.questionAssignmentId);
                }else{
                    this.saveQuestionScoreWithTime(questionScoreRequestObj.studentIndex, questionScoreRequestObj.questionIndex, questionScoreRequestObj.questionAssignmentId )
                }
            },

            handleLetterGradeSelect: function ( gradeAssignment ) {
                //set score
                this.score = gradeAssignment.calcValue;

        },


        /**
         * Tells someone else that the score has changed and should be
         * recorded in the db
         */
        notifyRecordScore: function () {
            let studentIndex = this.store.getActiveStudentIndex();
            let questionAssignmentId = this.questionAssignmentId;
            let questionIndex = this.questionIndex;

            let obj = new Requests.QuestionScoreRequest( studentIndex, questionIndex, questionAssignmentId );

            this.$dispatch( 'store-question-score-request', obj );
        }
    },

        events
    :
    {
    }
    ,

    }
    ;</script>