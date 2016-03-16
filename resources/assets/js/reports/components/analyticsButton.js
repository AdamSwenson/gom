/**
 * Created this while toying with the idea of having a separate
 * control for each button. That way may be easier to swap things
 * around for different devices et cetera.
 */
//var $ = require('jquery');
//window.$ = $;

module.exports = {

    template: require( '../templates/analytics-button.template.html' ),

    props: [
        'exam-id'
    ],

    data: function () {
        return {};
    },

    computed: {
        //Returns the route for analytics for the exam
        'analyticsTarget': function () {
            return this.$parent.baseUrl + '/report/' + this.examId + '/analytics';
        },
    },

    methods: {},

    directives: {}
};