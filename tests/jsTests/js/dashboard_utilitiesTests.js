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

function setDummyGroup() {
    $("#qunit-fixture").append("<input type='text' id='groupNumber' value='0' />");
}
module('dashboard_utilities Dashboard initialize');
test('Check exam timer intializes properly', function () {
    expect(3);
    var timer = new TimerRecord('exam');
    ok(timer, 'Exam timer initialized');
    equal(timer.startButton, 'startExam', 'Start button properly named');
    equal(timer.stopButton, 'stopExam', 'Stop button properly named');
});

test('Check group timer intializes properly', function () {
    expect(3);
    var timer = new TimerRecord('group');
    ok(timer, 'Group timer initialized');
    equal(timer.startButton, 'startGroup', 'Start button properly named');
    equal(timer.stopButton, 'stopGroup', 'Stop button properly named');
    timer = '';
});

module('dashboard_utilities checkCurrentGroup', {
    setup: function(){
        $("#qunit-fixture").append("<input type='text' id='groupNumber' />");
        $.cookie('groupNumber', '');
    },
    teardown: function () {
        $.cookie('groupNumber', '');
    }
});
/**
 * Utility for making sure that group number cookie and field were cleared
 * Adds two tests to the expected count
 * @returns {undefined}
 */
function emptyGroupTests() {
    ok(!$('#groupNumber').val(), "Fixture groupNumber is empty");
    ok(!$.cookie('groupNumber'), "Cookie groupNumber is empty");
}

test('checkCurrentGroup returns false if nothing set', function () {
    expect(3);
    emptyGroupTests();
    var groupNumber = checkCurrentGroup();
    equal(groupNumber, false, "No groupnumber set");
});
test('checkCurrentGroup returns number if box is set', function () {
    expect(4);
    emptyGroupTests();
    var testval = 22;
    $('#groupNumber').val(testval);
    var groupNumber = checkCurrentGroup();
    equal(groupNumber, testval, "Returned testvalue set in box");
    equal($.cookie('groupNumber'), testval, "Set cookie after finding value in box");
});
test('checkCurrentGroup returns number if cookie is set', function () {
    expect(4);
    emptyGroupTests();
    var testval = 28;
    $.cookie('groupNumber', testval);
    var groupNumber = checkCurrentGroup();
    equal(groupNumber, testval, "Returned testvalue set in cookie");
    equal($('#groupNumber').val(), testval, "Box value set after cookie checked");
});
test('checkCurrentGroup ignores cookie if box is set and sets cookie to new value', function () {
    expect(4);
    //emptyGroupTests();
    var badvalue = 20;
    var goodvalue = 33;
    $.cookie('groupNumber', badvalue);
    equal($.cookie('groupNumber'), badvalue, "Cookie initialized with value to be ignored");
    $('#groupNumber').val(goodvalue);
    equal(checkCurrentGroup(), goodvalue, "Ignores cookie and returns value from box");
    notEqual($.cookie('groupNumber'), badvalue, "Cookie no longer has the initial value");
    equal($.cookie('groupNumber'), goodvalue, "Cookie now has value from box");
});

module('dashboard_utilities Check calculation and formatting utilities');
test('unitChooser', function () {
    expect(5);
    QUnit.equal(unitChooser(0), 'Sec', 'Returns Sec for 0');
    QUnit.equal(unitChooser(0.11), 'Sec', 'Returns Sec for 0.11');
    QUnit.equal(unitChooser(1), 'Sec', 'Returns Sec for 1');
    QUnit.equal(unitChooser(60), 'Min', 'Returns Min for 60');
    QUnit.equal(unitChooser(100), 'Min', 'Returns Min for 100');
});
test('secondsToMinutes', function () {
    expect(6);
    equal(secondsToMinutes(0), 0, "Returns 0 for 0");
    equal(secondsToMinutes(0.1), 0.1, "Returns 0.1 for 0.1");
    equal(secondsToMinutes(0.1111111), 0.111, "Returns 0.111 for 0.1111111");
    equal(secondsToMinutes(60), 1, "Returns 1 for 60");
    equal(secondsToMinutes(65), 1.08, "Returns 1.08 for 65");
    equal(secondsToMinutes(120), 2, "Returns 2 for 120");
});
test('secondsToHours', function () {
    expect(4);
    equal(secondsToHours(0), 0, "Returns 0 for 0");
    equal(secondsToHours(3600), 1, "Returns 1 for 3600");
    equal(secondsToHours(1800), 0.5, "Returns 0.5 for 1800");
    equal(secondsToHours(5400), 1.5, "Returns 1.5 for 5400");
});
test('addLeadingZero', function () {
    equal(addLeadingZero(0), "00", "Returns 00 for 0");
    equal(addLeadingZero(5), "05", "Returns 05 for 5");
    equal(addLeadingZero(10), "10", "Returns 10 for 10");
    equal(addLeadingZero(15), "15", "Returns 15 for 15");
});
test('timeFormat', function () {
    equal(timeFormat(0), "00:00", "Returns 0:0 for 0 ");
    equal(timeFormat(60), "00:01", "Returns 00:01 for 60 ");
    equal(timeFormat(120), "00:02", "Returns 00:02 for 120 ");
    equal(timeFormat(600), "00:10", "Returns 00:10 for 600 ");
    equal(timeFormat(3600), "01:00", "Returns 01:00 for 3600 ");
    equal(timeFormat(5400), "01:30", "Returns 01:30 for 5400 ");
});
