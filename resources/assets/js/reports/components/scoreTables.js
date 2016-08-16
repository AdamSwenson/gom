/**
 * Created by ars62917 on 2/16/16.
 */
var $ = require('jquery');
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;
require('bootstrap');
var DataTable = require('datatables.net-bs')(window, $);
//var buttons = require( 'datatables.net-buttons-bs' )( window, $ );

module.exports = (function () {
    var questionData = [];
    $.each(questionStats, function () {
        questionData.push(this);
    });

    $("#questionStatsTable").DataTable({
        data: questionData,
        columns: [
            {data: 'questionNumber'},
            {data: 'questionName'},
            {
                data: 'mean',
                render: $.fn.dataTable.render.number(',', '.', 3)
            },
            {
                data: 'median',
                render: $.fn.dataTable.render.number(',', '.', 3)
            },
            {
                data: 'standardDeviation',
                render: $.fn.dataTable.render.number(',', '.', 3)
            },
            {data: 'maxScore'},
            {data: 'minScore'},
            {data: 'numberAnswers'}
        ],
        //TODO Perhaps check to make sure there aren't a ton of questions and set these accordingly
        paging: false,
        searching: false
    });

    //Create element stats table
    var elementData = [];
    $.each(elementStats, function () {
        this.element = 'Q' + this.questionNumber + 'E' + this.subtask;
        this.action = "<element-chart-buttons element-key='" + this.element + "' element-name='" + this.elementName + "'></element-chart-buttons>";
        elementData.push(this);
    });

    $("#elementStatsTable").DataTable({
        data: elementData,
        columns: [
            {data: 'element'},
            {data: 'elementName'},
            {
                data: 'mean',
                render: $.fn.dataTable.render.number(',', '.', 3)
            },
            {
               data: 'median',
                render: $.fn.dataTable.render.number(',', '.', 3)
            },
            {
                data: 'standardDeviation',
                render: $.fn.dataTable.render.number(',', '.', 3)
            },
            {data: 'maxScore'},
            {data: 'minScore'},
            {data: 'numberAnswers'},
            {data: 'action'}
        ],
        searching: false,
        paging:false,
        scrollY:400
//        lengthMenu: [ 5, 10, 25, 50, 75, 100 ]
    });
})();