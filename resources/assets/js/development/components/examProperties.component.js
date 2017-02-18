/**
 * Created by adam on 2/15/17.
 */

module.exports = {

    template: require( '../templates/exam-properties.template.html' ),

    props: [],

    data: function () {
        return {
            isHidden: true
        };
    },

    computed: {
        /**
         * Name which will be visible to students when they see the exam.
         * Otherwise it will just be referred to as 'Your exam' or
         * 'Your assignment'
         */
        publicName:{get:function(){}, set:function(){}},
        terms: {get:function(){}, set:function(){}},
        term: {get:function(){}, set:function(){}},
        year: {get:function(){}, set:function(){}},
        years: {get:function(){}, set:function(){}},
    },

    methods: {
        openPropsArea: function(){
            //make visible
        },

        closePropsArea: function(){
            //hide
        }
    },

    directives: {},

    events: {
        /**
         * Display exam properties area
         */
        'open-exam-properties' : function(){},
        /**
         * Close exam properties area
         */
        'close-exam-properties' : function(){},
    },

    ready: function () {
        console.log( 'exam-properties ready' );
    },
};