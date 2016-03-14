/**
 * Created by adam on 3/3/16.
 */
var $ = require( 'jquery' );
var jQuery = $;
window.jQuery = $;
window.$ = $;

//require( "bootstrap-toggle" );

//var bootstrapToggle = require( "../../../../../node_modules/bootstrap-toggle/js/bootstrap-toggle.js" );

var bootstrapToggle = require( "./../../../../../node_modules/bootstrap-toggle/js/bootstrap-toggle.js" );

module.exports = {

    template: require( '../templates/report-exam-buttons.template.html' ),

    props: [
        'base-url',
        'exam-id',
        'released'
    ],

    data: function () {
        return {};
    },

    computed: {
        //Returns the route for analytics for the exam
        'analyticsTarget': function () {
            return this.baseUrl + '/report/' + this.examId + '/analytics';
        },

        'backupTarget': function () {
            return this.baseUrl + '/backup/' + this.examId
        },
        'studentControlsTarget': function () {
            return this.baseUrl + '/report/' + this.examId + '/students';
        },

        'qualityControlsTarget': function(){
            return this.baseUrl + '/report/' + this.examId + '/qualitycontrol';
        }
    },

    methods: {},

    directives: {
        'toggle': function () {
            $( this.el ).bootstrapToggle(
                {
                    on: "Release",
                    off: "Hide"
                }
            );
        }

    },

    ready: function () {

    }
};