/**
 * Created by adam on 7/18/16.
 */
//var $ = require('jquery');
//window.$ = $;

module.exports = {

    template: require( '../templates/question-score.template.html' ),

    props: [
        'questionIndex',
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
            return this.store.maxQuestionScores[ this.questionIndex ];
        },

        /**
         * The student's score for this question
         *
         */
        questionScore: {
            get: function () {
                return this.store.getQuestionScore( this.store.activeStudent, this.questionIndex );
            },
            /**
             * Update the score in the shared data object and send
             * a request for someone else to record it to the server.
             * @param score
             */
            set: function ( score ) {
                this.store.storeQuestionScore( this.store.activeStudent, this.questionIndex, score );
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
            var obj = {};
            obj.questionIndex = this.questionIndex;
            this.$dispatch( 'store-question-score-request', obj );
        }
    },

    events: {
        'letter-grade-selected': function ( obj ) {
            window.console.log('questionScore', 'caught letter-grade-selected', obj);
            if ( (typeof obj.questionIndex != 'undefined') && (obj.questionIndex == this.questionIndex)){
                if ( typeof obj.score != 'undefined' ) {
                    this.questionScore = obj.score;
                }
            }
            //in case anyone else is listening
            return true;
        }
    },

};