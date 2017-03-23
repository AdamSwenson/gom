/**
 * Created by adam on 2/15/17.
 */
//var $ = require('jquery');
//window.$ = $;

module.exports = {

    template: require( '../../templates/exam-name.template.html' ),

    props: [
        'exam-id'
        //ability to set type which gets displayed
    ],

    components: {},

    data: function () {
        return {

            placeHolders : {
                privateName: "Enter a descriptive name for this assignment (e.g., English 101 Exam #1)",
                publicName: ""
            },

            types: ['Assignment', 'Essay', 'Exam'],

            defaults: {
                type: 'Assignment'
            },
        };
    },

    computed: {
        /**
         * The name which only the user can see
         */
        privateName: {
            get: function(){
                //if not set return placeholder
                // return this.placeHolders.privateName;
            },
            set: function(){

            },
        },

        /**
         * The kind of thing being graded. This is the
         * name that display at the top before the word 'Name'
         */
        displayType: function(){
            //todo check prop and then use the following as default
            return this.defaults.type;
        }
    },

    methods: {
        /**
         * Requests that the exam properties area display
         */
        openExamProperties:function(){
            //Todo add event broadcast
            console.log( 'openExamProperties clicked' );
        }
    },

    directives: {},

    events: {},

    mounted: function () {
        console.log( 'exam-name ready' );
    },
};