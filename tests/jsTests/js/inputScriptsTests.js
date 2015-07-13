/* 
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */

//var EXAMID = 1;
//var phpLink = 'dummyapi.php';
var $fixture = $("#qunit-fixture");
//            var $fixture = $("#show");
var examinfo = ['pages', 'notecard', 'completionOrder'];

var questionTestJson = {"questionID":"2","questionName":"NameOfQuestion2","questionScore":"2.2","questionNumber":"2","questionTitle":"Title of Question 2"};
var elementTestJson = {"elementID":"2", "elementAbbr":"testElement1","subtask":"2","elementEnglish":"Text of the element number 2","elementScore":"2.2","questionNumber":"2"};


$.mockjaxSettings.responseTime = 0;

/**
 * Creates the tests for the above questionTestJson
 * @returns {undefined}
 */
function questionJsonTests() {
    equal($('#q2Score').attr('name'), 'q2', "Question score (#q2Score) has correct name ('q2')");
    equal($('#q2Score').val(), 2.2, "Question score text input (#q2Score) field has correct value (2.2)");
    equal($('#q2Score').attr('data'), 2, "Item appended to #question2 has correct data attribute (2)");
    equal($('#q2Score').attr('class'), 'qs', "Question Score text input (#q2Score) has class 'qs'");
    //check the selector
    equal($('#q2Select').attr('name'), 'q2', "Question score selector (#q2Select) has correct name ('q2')");
    equal($('#q2Select').attr('data'), 2, "Question score selector (#q2Select) has correct data attribute (2)");
    //@todo should be looking at selected option; should set which option is selected
    //equal(Number($('#q2Select').val()), 2.2, "Question score selector (#q2Select) has correct value (2.2)");
    equal($('#q2Select').attr('class'), 'qs', "Question score selector (#q2Select) has class 'qs'");
}

/**
 * Utility function for creating a test div in the fixture
 * @param {string} divId The string to be used as the id of the div appeneded to the fixture
 * @returns {undefined}
 */
function appendAndCheckTestDiv(divId) {
    $("#qunit-fixture").empty();
    $("#qunit-fixture").append("<div id='" + divId + "'></div>");
    var $check_setup = $("#qunit-fixture").children();
    var testid = $($check_setup[0]).attr('id');
    equal(testid, divId, "Test div area " + divId + " appended to the fixture and ready for testing");
}
/**
 * Makes the field for the sid and sets its value
 * @param {type} sidValue
 * @returns {undefined}
 */
function makeSidField(sidValue) {
    $("#qunit-fixture").append("<input type='text' id='sid' value='" + sidValue + "' />");
}
/**
 * Utility function to make input fields for examinfo stuff
 * @returns {undefined}
 */
function makeExamInfoFields() {
    $.each(examinfo, function () {
        $("#qunit-fixture").append("<input type='text' id='" + this + "' value='' class='" + this + "' />");
        $("#qunit-fixture").append("<input type='text' id='" + this + "Select' value='' class='" + this + "' />");
    });
}
//============================================================ Tests
module('inputScripts.js Exam object tests', {
    setup: function () {
        makeExamInfoFields();
    }
});
test('Exam() | Test Exam instantiation', function () {
    $fixture.append("<div id='sid'></div>");
    var exam = new Exam();
    equal(exam.examID, EXAMID, 'Exam object has id from constant');
});
test('Exam() | Test studentid initialization', function () {
    var exam = new Exam();
    function fakeAutoComplete(Exam) {
        Exam.setID(123456789);
    }
    notEqual(exam.sid, 123456789);
    fakeAutoComplete(exam);
    equal(exam.sid, 123456789, 'Exam object has test student id number');
});

module('inputScriptsTests.js AJAX calls to getExamInfo', {
    setup: function () {
        makeExamInfoFields();
        makeSidField();
    }
});
/**
 * The autocomplete function will set the sid in the exam object and then make a json post query, this checks the latter
 * @returns {undefined}
 */
asyncTest('getExamInfo() | Test call to getExamInfo', function () {
    makeSidField(123456789);
    makeExamInfoFields();
    expect(5);
    var exam = new Exam();
    function test() {
        $.each(examinfo, function () {
            var k = '#' + this;
            var v = $("#" + this).val();
            equal(v, 10, 'Value set for ' + this);
        });
    };
    $.mockjax({
        url: "dummy.php",
        responseText: {"data": {"pages": "10", "notecard": "10", "completionOrder": "10"}}
    });
    function fakeAutoComplete(Exam) {
        Exam.setID(123456789);
        equal(exam.sid, 123456789, "Exam sid set");
        Exam.getExamInfo();
    }
    notEqual(exam.sid, 123456789, "Exam sid not yet set");
    fakeAutoComplete(exam);
    setTimeout(function () {
        test();
        start();
    }, 1000);
    $.mockjaxClear();
});

module('inputScripts.js QuestionFieldMaker tests (without ajax)');
test('questionFieldMaker Test that question field maker works properly', function () {
    expect(8);
    appendAndCheckTestDiv('question2');
    questionFieldMaker(questionTestJson);
    questionJsonTests();
});

module('inputScripts.js | Record()');
test('Record() | Test Record initialization and variable sets', function () {
    expect(2);
    var record = new Record();
    var groupnumber = 5;
    var totalExams = 10;
    record.setGroupNumber(groupnumber);
    record.setTotalExams(totalExams);
    equal(groupnumber, record.groupNumber, 'Groupnumber set');
    equal(totalExams, record.totalExams, 'Total Exams set');
});
test("Record() | Test that record is storing variables correctly within its various scopes", function () {
    var record = new Record();
    record.setID(10);
    equal(10, record.sid, "id set in record.sid");
    equal(10, record.getID(), "id set in record.get()");
});

module('inputScripts | getRecord()', {
    setup: function () {
        $("#qunit-fixture").append('<div id="question2"></div>');
    }
});
asyncTest('getRecord() | Test record load with AJAX', function () {
    var mmj = $.mockjax({
        url: phpLink,
        responseText: {"data":[{"elements":elementTestJson},{"question":questionTestJson}]}
    });
    expect(7);
    var record = new Record();
    var result = getRecord(record, 2);
    setTimeout(function () {
        questionJsonTests();
        QUnit.start();
    }, 1000);
    $.mockjaxClear(mmj);
});

module("inputScripts | ExamInfo selectors creation functions");
test("setCompletionSelect()", function(){
    $("#qunit-fixture").append("<select id='completionOrderSelect' />");
    var numExams = 3;
    var validNums = [1, 2, 3];
    var invalidNums = [0, 4];
    setCompletionSelect(numExams);
    $('#completionOrderSelect option').each(function(){
       ok(validNums.indexOf(Number($(this).val())) !== -1, "value in list of good numbers");
       ok(invalidNums.indexOf(Number($(this).val())) === -1, "value not in list of bad numbers");
    });  
});

test("generateOptions()", function(){
   $("#qunit-fixture").append("<select id='testSelect' />");
   var selectProps = new Object();
   selectProps.range = 3;
   selectProps.toAppendTo = 'testSelect';
   selectProps.data = 'testData';
   selectProps.increment = 1;
    var validNums = [0, 1, 2, 3];
    var invalidNums = [4];
    expect(12);
    generateOptions(selectProps);
    $("#testSelect option").each(function(){
        ok(validNums.indexOf(Number($(this).val())) !== -1, "value in list of good numbers");
        ok(invalidNums.indexOf(Number($(this).val())) === -1, "value not in list of bad numbers");
        equal($(this).attr('data'), selectProps.data, "Data set properly");
    });
});

test("makePageSelect()", function(){
   $("#qunit-fixture").append("<div id='pagesHere' ></div>");
   makePageSelect();
   //check the text input field properties
   var tid = '#pages';
   equal($(tid).attr("name"), "pages", "Name set correctly for text input field");
   equal($(tid).attr("data"), "pages", "data set correctly for text input field");
   equal($(tid).attr("class"), "Input examInfo pages changer zeroOut", "classes set correctly for text input field");
    //check properties of the selector
    var id = "#pagesSelect";
    equal($(id).attr("data"), "pages", "Data set correctly selector");
    equal($(id).attr("class"), 'pages changer zeroOut', "classes set correctly for selector");
    var invalidNums = [16.25, 18];
    var validNums = [];
    for($i=0; $i <= 16; $i += 0.25){
        validNums.push($i);
    }
    $(id + " option").each(function(){
       ok(validNums.indexOf(Number($(this).val())) !== -1, "Option value is okay"); 
       ok(invalidNums.indexOf(Number($(this).val())) === -1, "Option value not in list of bad numbers");
       equal($(this).attr("data"), "pages", "Option data set correctly");
    });

});

test("makeCompletionSelect()", function(){
   $("#qunit-fixture").append("<div id='completionOrderHere' ></div>");
   makeCompletionSelect();
   //check the text input field properties
   var tid = '#completionOrder';
   equal($(tid).attr("name"), "completionOrder", "Name set correctly for text input field");
   equal($(tid).attr("data"), "completionOrder", "data set correctly for text input field");
   equal($(tid).attr("class"), "Input examInfo completionOrder changer zeroOut", "classes set correctly for text input field");
    //check properties of the selector
    var id = "#completionOrderSelect";
    equal($(id).attr("data"), "completionOrder", "Data set correctly selector");
    equal($(id).attr("class"), 'completionOrder changer zeroOut', "classes set correctly for selector");
    var invalidNums = [21, 20.25];
    var validNums = [];
    for($i=0; $i <= 20; $i += 1){
        validNums.push($i);
    }
    $(id + " option").each(function(){
       ok(validNums.indexOf(Number($(this).val())) !== -1, "Option value is okay"); 
       ok(invalidNums.indexOf(Number($(this).val())) === -1, "Option value not in list of bad numbers");
       equal($(this).attr("data"), "completionOrder", "Option data set correctly");
    });
});

test("makeNotecardSelect()", function(){
   $("#qunit-fixture").append("<div id='notecardHere' ></div>");
   makeNotecardSelect();
   //check the text input field properties
   var tid = '#notecard';
   equal($(tid).attr("name"), "notecard", "Name set correctly for text input field");
   equal($(tid).attr("data"), "notecard", "data set correctly for text input field");
   equal($(tid).attr("class"), "Input examInfo notecard changer zeroOut", "classes set correctly for text input field");
    //check properties of the selector
    var id = "#notecardSelect";
    equal($(id).attr("data"), "notecard", "Data set correctly selector");
    equal($(id).attr("class"), 'notecard changer zeroOut', "classes set correctly for selector");
    var invalidNums = [2.25, 3];
    var validNums = [];
    for($i=0; $i <= 2; $i += 0.25){
        validNums.push($i);
    }
    $(id + " option").each(function(){
       ok(validNums.indexOf(Number($(this).val())) !== -1, "Option value is okay"); 
       ok(invalidNums.indexOf(Number($(this).val())) === -1, "Option value not in list of bad numbers");
       equal($(this).attr("data"), "notecard", "Option data set correctly");
    });
});

module("inputScripts | start and stop listeners");

test("initializeQuestionSelection", function(){
    //@todo Setup tests for intialize questionselector
    $.mockjaxClear();
   $("#qunit-fixture").append("<input id='testTarget' type='checkbox' class='.qSelect' value='2' name='qSelect' />");
   $("#qunit-fixture").append("<div id='optionalQ' class='optionalQ'><div id='questionScore' class='questionScore'></div></div> ");
   $("#qunit-fixture").append("<div id='q2grade'></div>");
   $("#qunit-fixture").append("<input type='text' class='dump' value='non 0 value' />");
   $("#q2grade").hide();
   //trigger
   initializeQuestionSelection();
   $("#testTarget").trigger("change");
   var calls = $.mockjax.mockedAjaxCalls();
    window.console.log(calls);
    //test if .dump cleared out
    var dumpfield = $(".dump").val();
    //equal(dumpfield.length, 0, ".dump emptied out");
    //test if q2grade is visible
//    ok($("#q3grade").is(":visible"), "grade area slid down");
    expect(0);
});
test("initializeExamInfoSelects", function(){
   //@todo setup tests for intializeExamInfoSelects
    expect(0); 
});