/**
 * Created by adam on 4/6/15.
 */

function makeFieldsForTestValues() {
    $("#qunit-fixture").append("<input type='text' id='year' />");
    $("#qunit-fixture").append("<input type='text' id='term' />");
    $("#qunit-fixture").append("<input type='text' id='examTopic' />");
    $("#qunit-fixture").append("<select id='year_select' class='newExamSelect' data='year'><option value='2012' data='year'></option></select>");
    $("#qunit-fixture").append("<select id='term_select' class='newExamSelect' data='term'><option value='testTerm' data='term'></option></select>");
    $("#qunit-fixture").append("<select id='examTopic_select' class='newExamSelect' data='examTopic'><option value='testtopic' data='examTopic'></option></select>");
    $("#qunit-fixture").append("<input type='button' id='createExam' />");
}

function makeFieldsNoOptions() {
    $("#qunit-fixture").append("<input type='text' id='year' />");
    $("#qunit-fixture").append("<input type='text' id='term' />");
    $("#qunit-fixture").append("<input type='text' id='examTopic' />");
    $("#qunit-fixture").append("<select id='year_select' class='newExamSelect' data='year'></select>");
    $("#qunit-fixture").append("<select id='term_select' class='newExamSelect' data='term'></select>");
    $("#qunit-fixture").append("<select id='examTopic_select' class='newExamSelect' data='examTopic'></select>");
    $("#qunit-fixture").append("<input type='button' id='createExam' />");
}

function resetFieldsForTestValues() {
    $("#year").val('');
    $("#term").val('');
    $("#examTopic").val('');
}

module('examSetup.js select presses', {
    setup: function () {
        makeFieldsForTestValues();
        bindListeners();
        this.year = 2012;
        this.term = 'testTerm';
        this.topic = 'testtopic';
    },
    teardown: function () {
        resetFieldsForTestValues();
    }
});

test('examSetup.js prepare() ', function () {
    expect(3);
    $("#year").val(this.year);
    $("#term").val(this.term);
    $("#examTopic").val(this.topic);
    var result = prepare();
    equal(result.year, this.year);
    equal(result.term, this.term);
    equal(result.examTopic, this.topic);
});

test('newExamSelect yearselect change', function () {
    expect(1);
    $("#year_select").val(this.year).trigger('change');
    equal($("#year").val(), this.year);
});

test('newExamSelect termselect change', function () {
    expect(1);
    $("#term_select").val(this.term).trigger('change');
    equal($("#term").val(), this.term);

});

test('newExamSelect topicselect change', function () {
    expect(1);
    $("#examTopic_select").val(this.topic).trigger('change');
    equal($("#examTopic").val(), this.topic);
});


module('examSetup.js  Fill selectors with values', {
   setup: function(){
       makeFieldsNoOptions();
       this.terms = [{"content": "Term0"}, {"content": "Term1"}];
       this.years = [{"content": "2000"}, {"content": "2001"}];
       this.topics = [{"content": "Topic0"}, {"content": "Topic1"}];
   }
});

test('fillSelects | Term', function(){
    expect(5);
   fillSelects("term_select", 'term', this.terms);
    equal($("#term_select").attr("data"), "term", "term select added to page for testing");
    var options = document.getElementById('term_select').options;
    $("#term_select option").each(function(i){
        equal($(this).attr("data"), 'term', 'correct data attribute loaded');
        equal($(this).val(), "Term"+ i,  "Correct value loaded");
    })
});

test('fillSelects | Year', function(){
    expect(5);
    fillSelects("year_select", 'year', this.years);
    equal($("#year_select").attr("data"), "year", "year select added to page for testing");
    $("#year_select option").each(function(i){
        equal($(this).attr("data"), 'year', 'correct data attribute loaded');
        equal($(this).val(), "200"+ i,  "Correct value loaded");

    })
});

test('fillSelects | topic', function(){
    expect(5);
    fillSelects("examTopic_select", 'examTopic', this.topics);
    equal($("#examTopic_select").attr("data"), "examTopic", "examTopic select added to page for testing");
    $("#examTopic_select option").each(function(i){
        equal($(this).attr("data"), 'examTopic', 'correct data attribute loaded');
        equal($(this).val(), "Topic"+ i,  "Correct value loaded");
    })
});

//module('Status report', {
//    setup: function () {
//        $("#qunit-fixture").append("<div id='submitStatus'></div>");
//    }
//});
//test('examSetup.js displaySuccess()', function () {
//    var pre = $("#submitStatus").text();
//    equal(pre.length, 0);
//    displaySuccess();
//    var post = $("#submitStatus").text();
//    ok(post.length > 0);
//});
//
//test('examSetup.js displayError()', function () {
//    var pre = $("#submitStatus").text();
//    equal(pre.length, 0);
//    displayError();
//    var post = $("#submitStatus").text();
//    ok(post.length > 0);
//});
