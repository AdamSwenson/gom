/**
 * Created by adam on 7/19/16.
 */
//var $ = require('jquery');
//window.$ = $;

module.exports = {

    template: require( '../templates/dashboard.counts.template.html' ),

    props: [
        /** The url that the user should be redirected to
         * when they click the save and finish button*/
        'finishedLink'
    ],

    data: function () {
        return {
            store: store,

            finishButtonHidden: true
        }
    },

    computed: {

        /* --------------- # exams ------------- */
        /**
         * Number of exams already graded
         */
        gradedExams: function(){
            let numGraded = this.store.getNumberGraded();
            if(numGraded){
                return numGraded;
            }
            return '';
//            return this.store.getNumberGraded();
        },

        /**
         * Total number of exams to be graded
         * @returns {number|Number}
         */
        totalExams: function(){
            return this.store.getTotalExams();
        },

        /**
         * Number of exams remaining to be graded
         */
        remainingExams: function(){
            if((typeof this.totalExams == Number) && typeof this.gradedExams == Number){
                var remaining = this.totalExams - this.gradedExams;
                if(remaining === 0){
                    this.showFinishButton();
                }
                return remaining;
            }
            return '';
        },

    },

    methods: {
        showFinishButton: function(){
          this.finishButtonHidden = false;
        },

    },

    directives: {}
};