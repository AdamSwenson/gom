/**
 * Created by adam on 3/3/16.
 */
var $ = require( 'jquery' );
var jQuery = $;
window.jQuery = $;
window.$ = $;

module.exports = {

    template: require( '../templates/report-exam-buttons.template.html' ),

    props: [
        'base-url',
        'exam-id',
    ],

    data: function () {
        return {
            storage: {
            },
        };
    },

    computed: {
        'analyticsTarget': function () {
            return this.baseUrl + '/report/' + this.examId + '/analytics';
        },

        'backupTarget': function () {
            return this.baseUrl + '/backup/' + this.examId
        },
        'studentControlsTarget': function () {
            return this.baseUrl + '/report/' + this.examId + '/students';
        },

        'qualityControlsTarget': function () {
            return this.baseUrl + '/report/' + this.examId + '/qualitycontrol';
        }
    },

    methods: {},
    events: {},
    directives: {},
    ready: function () {}
};