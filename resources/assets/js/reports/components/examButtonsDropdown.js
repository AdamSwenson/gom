/**
 * Created by adam on 3/16/16.
 */
//var $ = require('jquery');
//window.$ = $;

module.exports = {

    template: require( '../templates/exam-buttons-dropdown.template.html' ),
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
        analyticsTarget: function () {
            return this.baseUrl + '/report/' + this.examId + '/analytics';
        },

        backupTarget: function () {
            return this.baseUrl + '/backup/' + this.examId
        },

        studentControlsTarget: function () {
            return this.baseUrl + '/report/' + this.examId + '/students';
        },

        qualityControlsTarget: function () {
            return this.baseUrl + '/report/' + this.examId + '/qualitycontrol';
        }
    }
};