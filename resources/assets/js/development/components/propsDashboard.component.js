/**
 * This handles the display of various statistical features of the exam
 * Such as: the highest possible score, number of items, # students
 * Created by adam on 2/15/17.
 */

module.exports = {

    template: require( '../templates/props-dashboard.template.html' ),

    props: [],

    data: function () {
        return {
            placeHolders: {
                numberItems: 0,
                perfectScore: '-',
                timeGrading: '-'
            },
            defaults: {
                numberStudents: 0,
                numberGraded: 0,

            }
        };
    },

    computed: {
        /**
         * Number of constituent items (questions, elements) on the exam
         */
        numberItems: {
            get: function () {
                //if not set return placeholder
                return this.placeHolders.numberItems;
            }
        },

        /**
         * The maximum possible score, either entered directly
         * or calculated from the items
         */
        perfectScore: {
            get: function () {
                //if not set return placeholder
                return this.placeHolders.perfectScore;
            },
            set: function () {
            }
        },

        /**
         * Number of students associated with this assignment
         */
        numberStudents: {
            get: function () {
                //if not set return placeholder
                return this.defaults.numberStudent;
            }
        },

        /**
         * The number of students' assignments graded
         */
        numberGraded: {
            get: function () {
                //if not set return placeholder
                return this.defaults.numberGraded;
            }

        },

        /**
         * The total amount of time spent grading this assignment
         */
        timeGrading: {
            get: function () {
                //if not set return placeholder
                return this.placeHolders.timeGrading;
            }
        },
    },

    methods: {},

    directives: {},

    events: {},

    ready: function () {
        console.log( 'props-dashboard ready' );
    },
};