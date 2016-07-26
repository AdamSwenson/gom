/**
 * Created by adam on 7/18/16.
 */
//var $ = require('jquery');
//window.$ = $;

var Requests = require('./requests.tools');

module.exports = {

    template: require( '../templates/question-score.template.html' ),

    props: [
        /**
         * The db id of the assignment of the question to the exam
         * @type integer
         */
        'questionAssignmentId',
        /**
         * The index identifying the question in the data json objects
         * @type integer
         */
        'questionIndex',
        /**
         * The number of the question on the exam
         * @type string
         */
        'questionNumber',
    ],

    data: function () {
        return {
            /**
             * The data repository store shared by everyone
             */
            store: store
        };
    },

    computed: {

        //TODO convert question number and qa id into computed properties

        /**
         * The string id of the question score field for this question.
         * Does not contain '#'
         * @returns {string}
         */
        scoreFieldIdString: function () {
            return "questionScore" + this.questionNumber;
        },

        /**
         * The string id of the max score field for
         * this question.
         * Does not contain '#'
         * @returns {string}
         */
        maxScoreFieldIdString: function () {
            return "maxScore" + this.questionNumber;
        },

        /**
         * The maximum possible score for this question
         * @returns {*}
         */
        maxScore: function () {
            return this.store.getMaxQuestionScore( this.questionIndex );
        },

        /**
         * The student's score for this question
         *
         */
        questionScore: {
            get: function () {
                let qs = this.store.getQuestionScoreForActiveStudent( this.questionIndex );
                if ( qs != null ) {
                    return qs;
                }
                // return '';
            },
            /**
             * Update the score in the shared data object and send
             * a request for someone else to record it to the server.
             * @param score
             */
            set: function ( score ) {
                this.store.storeQuestionScoreForActiveStudent( this.questionIndex, score );
                this.notifyRecordScore();
            }
        }
    },

    methods: {
        /**
         * Tells someone else that the score has changed and should be
         * recorded in the db
         */
        notifyRecordScore: function () {
            let studentIndex = this.store.getActiveStudentIndex();
            let questionAssignmentId = this.questionAssignmentId;
            let questionIndex = this.questionIndex;

            let obj = new Requests.QuestionScoreRequest(studentIndex, questionIndex, questionAssignmentId);

            this.$dispatch( 'store-question-score-request', obj );
        }
    },

    events: {
        'letter-grade-selected': function ( obj ) {
            window.console.log( 'questionScore', 'caught letter-grade-selected', obj );
            if ( (typeof obj.questionIndex != 'undefined') && (obj.questionIndex == this.questionIndex) ) {
                if ( typeof obj.score != 'undefined' ) {
                    this.questionScore = obj.score;
                }
            }
            //in case anyone else is listening
            return true;
        }
    },

};