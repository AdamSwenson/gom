/**
 * Created by adam on 6/2/15.
 */

/**
 * Sets up the fixture
 * #8released  Released button for unreleased exam1
 * #9released  Released button for released exam1
 * #6locked    Locked button for unlocked exam1
 * #7locked    Locked button for locked exam1
 *
 * #totalExams Text field for total exams
 */
function makeFields(){
    $("#qunit-fixture").empty();
    var items = ['<input data="8" class="releasedChecks ui-helper-hidden-accessible" id="8released" name="8released[]" value="released" type="checkbox">',
    '<input data="9" class="releasedChecks ui-helper-hidden-accessible" id="9released" name="9released[]" value="released" checked="checked" type="checkbox">',
    '<input data="6" class="lockedChecks ui-helper-hidden-accessible" id="6locked" name="6locked[]" value="locked" type="checkbox">',
    '<input data="7" class="lockedChecks ui-helper-hidden-accessible" id="7locked" name="7locked[]" value="locked" checked="checked" type="checkbox">',
    '<input role="button" id="setTotalExams" class="prettyButton ui-button ui-widget ui-state-default ui-corner-all" value="Set number of exams to grade" type="button">',
    '<input id="totalExams" type="text">',
    '<select id="existingExams"><option value="2" data="2">2015 testTerm testTopic</option></select>'
    ];

    $.each(items, function(){
//        $("#show").append(this);
        $("#qunit-fixture").append(this);
    });
}

var results = [];

function sendRequestCallback(Request, successCallback, failureCallback){
    console.log('h');
    results.push(Request);
    console.log(Request);
    $.post("_api.php", Request, function(){
       successCallback();
    },"JSON");
}

$.mockjaxSettings.responseTime = 0;

module('managerScripts.js processing functions', {
    setup: function () {
        makeFields();
    }
});

test('managerScripts.js | processClick released button in unreleased state', function(){
   expect(1);
   var result = processClick($("#8released"), 'release');
    equal('unreleaseExam', result.task);

});

test('managerScripts.js | processClick released button in released (checked) state', function(){
    expect(1);
    var result = processClick($("#9released"), 'release');
    equal('grantExamAccess', result.task);
});

test('managerScripts.js | processClick locked button in locked (checked) state', function(){
    expect(1);
    var result = processClick($("#7locked"), 'lock');
    equal('lockExam', result.task);
});

test('managerScripts.js | processClick locked button in unlocked state', function(){
    expect(1);
    var result = processClick($("#6locked"), 'lock');
    equal('unlockExam', result.task);
});


test('managerScripts.js | processSetTotal', function(){
   expect(2);
    var totExams = 43;
    $("#totalExams").val(totExams);
    var result = processSettotal($("#totalExams"));
    equal(result.task, 'setTotalExams');
    equal(result.totalExams, totExams)
});

/**
 * TODO Fix processSetexam test
 */
test('managerScripts.js | processSetexam', function(){
    expect(1);
    var result = processSetexam($("#examSelect option"));
    equal(result.task, 'setExamID');
    //equal(result.examID, 2);
});
//
//module('managerScripts.js release button', {
//    setup: function () {
//        makeFields();
//        $.mockjax({
//            url: "api.php",
//            type: 'POST',
//            dataType: 'json',
//            responseText: {"status": "success"}
//        });
//    },
//    teardown: function () {
//        $.mockjaxClear();
//    }
//});
//
//QUnit.asyncTest('managerScripts.js released click (unreleased to released)', function () {
//    expect(0);
//    $("#8released").trigger("click");
//    start();
//});
//
//
//test('managerScripts.js released click (released to unreleased)', function () {
//    expect(0);
//    $("#9released").trigger("click");
//});
//
//module('managerScripts.js locked button', {
//    setup: function () {
//        makeFields();
//        this.v = '';
//    },
//    teardown: function () {
//    }
//});
//
//test('managerScripts.js locked click (unlocked to locked)', function () {
//    expect(0);
//    $("#6locked").trigger("click");
//    //ok(results.length > 0);
//});
//
//
//test('managerScripts.js locked click (locked to unlocked)', function () {
//    expect(0);
//    $("#7released").trigger("click");
//});
