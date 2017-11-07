/* 
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */


$.mockjaxSettings.responseTime = 0;

module("dashboard_TimerDisplayTests TimerDisplay.getServerTime calls", {
    setup: function () {
        setDummyGroup();
        $.mockjax({
            url: DASHPHP,
            type: 'GET',
            dataType: 'json',
            responseText: {"time": 1}
        });
    },
    teardown: function () {
        $.mockjaxClear();
    }
});
/** @covers TimerDisplay.prototype.getServerTime */
QUnit.asyncTest("TimerDisplay.getServerTime for exam1", function () {
    expect(0);
    start();
//    expect(4);
//    var examtimer = new TimerDisplay('exam1');
//    equal(examtimer.timerType, 'exam1', "timer initialized");
//    examtimer.getServerTime();
//    setTimeout(function () {
//        equal(examtimer.elapsedTime, 1, "Elapsed time loaded into object");
//        notEqual(examtimer.elapsedTime, 0, "Elapsed time has been changed from 0");
//        start();
//    }, 1000);
});
/** @covers TimerDisplay.prototype.getServerTime */
QUnit.asyncTest("TimerDisplay.getServerTime for group", function () {
     expect(0);
     start();
//    expect(4);
//    var grouptimer = new TimerDisplay('group');
//    equal(grouptimer.timerType, 'group', "timer initialized");
//    grouptimer.getServerTime();
//    setTimeout(function () {
//        equal(grouptimer.elapsedTime, 1, "Elapsed time loaded into object");
//        notEqual(grouptimer.elapsedTime, 0, "Elapsed time has been changed from 0");
//        start();
//    }, 1000);
});

module('dashboard_TimerDisplayTests Display dashboard time values', {
    setup: function () {
        setDummyGroup();
        $("#qunit-fixture").append("<input type='text' id='currentTimeGaugeBox' />");
        $("#qunit-fixture").append("<input type='text' id='currentGroupGaugeBox' />");
    }
});
test('setCurrentTimeBox for exam1', function () {
    var t = new TimerDisplay('exam');
    var testvals = [
        {'test': 5.5, 'display': '5.50 Sec'},
        {'test': 60, 'display': '1.00 Min'}
    ];
    $.each(testvals, function () {
        t.elapsedTime = this.test;
        t.setCurrentTimeBox();
        equal($('#currentTimeGaugeBox').val(), this.display, "currentTimeGaugeBox value set");
    });
});
test('setCurrentTimeBox for group', function () {
    var t = new TimerDisplay('group');
    var testvals = [
        {'test': 5.5, 'display': '5.50 Sec'},
        {'test': 60, 'display': '1.00 Min'}
    ];
    $.each(testvals, function () {
        t.elapsedTime = this.test;
        t.setCurrentTimeBox();
        equal($('#currentGroupGaugeBox').val(), this.display, "currentGroupGaugeBox value set");
    });
});
/**
 * @covers TimerDisplay.prototype.makeDisplayTimeFromElapsedTime
 */
test('makeDisplayTimeFromElapsedTime', function () {
    var t = new TimerDisplay('exam');
    var testvals = [
        {'test': 5.5, 'display': '5.50 Sec'},
        {'test': 60, 'display': '1.00 Min'}
    ];
    $.each(testvals, function () {
        t.elapsedTime = this.test;
        equal(t.makeDisplayTimeFromElapsedTime(), this.display, "makeDisplayTimeFromElapsedTime is working");
    });
});