/* 
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */

$.cookie('jip', '45');
var EXAMID = 1;
var DASHPHP = 'dummyapi.php';
var $fixture = $("#qunit-fixture");
var examinfo = ['pages', 'notecard', 'completionOrder'];
$.mockjaxSettings.responseTime = 0;

module('dashboard_TimerRecord Check buttons fire', {
    teardown: function () {
        $.mockjaxClear();
    }
});

QUnit.asyncTest('Check firing on start buttons', function () {
    // $.mockjaxClear();
    expect(2);
    //stop();
    $.mockjax({
        url: DASHPHP,
        responseText: {"currentTime": 1}
    });
    $.each({'exam': 'startExam', 'group': 'startGroup'}, function (k, v) {
        $("#qunit-fixture").append("<input type='button' id='" + v + "' />");
        var timer = new TimerRecord(k);
        $('#' + timer.startButton).trigger('click');
        ok(timer.startTime, 'Click triggers ' + k);
    });
    QUnit.start();
    timer = '';
    // $.mockjaxClear(mj);
});

QUnit.asyncTest('Check firing on stop buttons', function () {
    expect(2);
    $.mockjax({
        url: DASHPHP,
        responseText: {"currentTime": 1}
    });
    //stop();
    $.each({'exam': 'stopExam', 'group': 'stopGroup'}, function (k, v) {
        $("#qunit-fixture").append("<input type='button' id='" + v + "' />");
        var timer = new TimerRecord(k);
        $('#' + timer.stopButton).trigger('click');
        ok(timer.rightNow, 'Click triggers  ' + k);
        timer = '';
    });
    QUnit.start();
    timer = '';
    // $.mockjaxClear(mj);
});
 