(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
/**
 * Created by adam on 10/27/15.
 */

'use strict';

module.exports = function () {
    /**
     * This handles all chart creation. It is agnostic on the number of
     * students on the page.
     * It assumes that there will be a javascript variable named 'studentData'
     * which is an array with accessKeys as keys with json arrays as the value
     */
    function drawAllStudentCharts() {
        $.each(studentData, function ($sid, $data) {

            //Make the chart displaying how they did on each question vs class
            makeOverallChart($sid, $data);

            //Make a chart for the scores on all the elements for a given question
            $.each($data, function ($k, $v) {
                //Don't make a chart for questions which student didn't answer
                if (!$.isEmptyObject($v.elements)) {
                    var chartTarget = 's' + $sid + '_q' + $v.questionNumber;
                    makeElementsChartForQuestion(chartTarget, $v.questionNumber, $v.elements);
                }
            });
        });
    }

    /**
     * Builds the chart comparing performance on all questions
     * @param sid Something to identify the student
     * @param studentData
     */
    function makeOverallChart(sid, studentData) {

        /* Which chart div to stick this in (esp important if there are multiple students on page */
        var chartTarget = 'overall_s' + sid;

        var options = {
            title: "How you did on each question compared to the class average ",
            width: 700,
            height: 300,
            bar: { groupWidth: "65%" },
            legend: { position: "right" }
        };

        //Prepare the data
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'question');
        data.addColumn('number', 'Your Score');
        data.addColumn('number', 'Class Average');

        $.each(studentData, function ($k, $v) {
            //Build up question name for label
            //Since question name is optional, only add it if it is present
            var questionName = 'Q' + $v['questionNumber'] + ' ';
            questionName += $v['questionName'] ? $v['questionName'] : ' ';

            //push row into data table
            data.addRow([questionName, $v['score'], $v['average']]);
        });

        //Draw the chart
        var chart = new google.visualization.ColumnChart(document.getElementById(chartTarget));
        chart.draw(data, options);
    }

    /**
     * Makes a chart of the student's performance vs. average on each element
     * comprising the question
     * @param chartTarget The div id to put the chart in
     * @param questionNumber
     * @param elementsData Object of all element data for that question
     */
    function makeElementsChartForQuestion(chartTarget, questionNumber, elementsData) {

        //push into data table as chart is expecting
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'task');
        data.addColumn('number', 'Your Score');
        data.addColumn('number', 'Class Average');

        //Make a row for each element
        $.each(elementsData, function ($k, $v) {
            data.addRow([$v['elementName'], $v['score'], $v['average']]);
        });

        var options = {
            title: "How you did on tasks for question #" + questionNumber,
            width: 600,
            height: 400,
            bar: { groupWidth: "65%" },
            legend: { position: "bottom" }
        };

        var chart = new google.visualization.ColumnChart(document.getElementById(chartTarget));
        chart.draw(data, options);
    }

    google.load('visualization', '1', { 'packages': ['corechart'] });
    google.setOnLoadCallback(drawAllStudentCharts);
};

},{}]},{},[1]);
