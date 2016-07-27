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
            store: store
        }
    },

    computed: {
        /**
         * Button will not display unless remaining is 0
         * @returns {string}
         */
        buttonStyle: function () {
            window.console.log(this.remainingExams);
            if ( this.remainingExams != 0 ) {

                return "display:none";
            }else if(this.remainingExams == 0){
                return '';
            }
        },
        /* --------------- # exams ------------- */
        /**
         * Number of exams already graded
         */
        gradedExams: function () {
           return this.store.getNumberGraded();
        },

        /**
         * Total number of exams to be graded
         * @returns {number|Number}
         */
        totalExams: function () {
            return this.store.getTotalExams();
        },

        /**
         * Number of exams remaining to be graded
         */
        remainingExams: function () {
            if ( (typeof this.totalExams != 'undefined') && typeof this.gradedExams != 'undefined' ) {
                let remaining = this.totalExams - this.gradedExams;
                return remaining;
            }
            return '';
        },

    },

    methods: {
    },

    directives: {}
};