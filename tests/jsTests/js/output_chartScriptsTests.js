/* 
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */

//These are constants etc for output_outputScriptsTests.js
var QUESTION_NUMBERS = [1, 2, 3];
var QUESTION_PROPS = [{'questionTitle': 'Question 1 Title', 'questionNumber': 1},
    {'questionTitle': 'Question 2 Title', 'questionNumber': 2},
    {'questionTitle': 'Question 3 Title', 'questionNumber': 3}];
//These are constants for chart scripts tests
var elementScores = [
    {"elementID": "17",
        "elementName": "singer_overview",
        "subtask": "1",
        "displayText": "Presentation of a brief overview of Singer's argument",
        "questionNumber": "2",
        "eid": "17",
        "elementScore": "4.5"},
    {"elementID": "13",
        "elementName": "singer_location_argument",
        "subtask": "2",
        "displayText": "Setting out Singer's argument that distance per se can't matter morally",
        "questionNumber": "5",
        "eid": "13",
        "elementScore": "3.3"}
];
var questionScores = [
    {"questionID": "73", "questionNumber": "1", "questionTitle": "Tragedy of the Commons", "qid": "73", "questionScore": "6.00"},
    {"questionID": "74", "questionNumber": "2", "questionTitle": "Moral Hazard", "qid": "74", "questionScore": "7.50"},
    {"questionID": "25", "questionNumber": "3", "questionTitle": "Too demandingness objection", "qid": "25", "questionScore": null},
    {"questionID": "24", "questionNumber": "4", "questionTitle": "Leveling down argument and response", "qid": "24", "questionScore": "8.00"},
    {"questionID": "15", "questionNumber": "5", "questionTitle": "Distance and location don't matter", "qid": "15", "questionScore": null}];
var elementAverages = [{"elementAverage": "0.823077", "elementID": "62", "elementName": "tocForcedChange", "questionNumber": "1"},
    {"elementAverage": "1.750000", "elementID": "56", "elementName": "tocList", "questionNumber": "1"},
    {"elementAverage": "3.276923", "elementID": "98", "elementName": "tocShortSighted", "questionNumber": "1"},
    {"elementAverage": "3.911538", "elementID": "27", "elementName": "toc_example", "questionNumber": "1"},
    {"elementAverage": "3.096154", "elementID": "19", "elementName": "toc_strategy", "questionNumber": "1"},
    {"elementAverage": "3.326923", "elementID": "12", "elementName": "toc_structure", "questionNumber": "1"},
    {"elementAverage": "8.000000", "elementID": "57", "elementName": "mhList", "questionNumber": "2"},
    {"elementAverage": "5.423077", "elementID": "100", "elementName": "mhUnintConsq", "questionNumber": "2"},
    {"elementAverage": "4.719231", "elementID": "29", "elementName": "mh_definition", "questionNumber": "2"},
    {"elementAverage": "5.557692", "elementID": "30", "elementName": "mh_example", "questionNumber": "2"},
    {"elementAverage": "4.957692", "elementID": "23", "elementName": "mh_risk", "questionNumber": "2"},
    {"elementAverage": "0.828125", "elementID": "46", "elementName": "conseqOverview", "questionNumber": "3"},
    {"elementAverage": "1.453125", "elementID": "49", "elementName": "demandingDepth", "questionNumber": "3"},
    {"elementAverage": "3.031250", "elementID": "47", "elementName": "demandingExample", "questionNumber": "3"},
    {"elementAverage": "2.265625", "elementID": "48", "elementName": "demandingImp", "questionNumber": "3"},
    {"elementAverage": "0.156250", "elementID": "50", "elementName": "demandingOIC", "questionNumber": "3"},
    {"elementAverage": "1.171875", "elementID": "51", "elementName": "demandingReply", "questionNumber": "3"},
    {"elementAverage": "9.636364", "elementID": "99", "elementName": "ldsNotForced", "questionNumber": "4"}, {"elementAverage": "3.941176", "elementID": "63", "elementName": "ldsProbSinger", "questionNumber": "4"}, {"elementAverage": "3.639706", "elementID": "34", "elementName": "lds_cms", "questionNumber": "4"}, {"elementAverage": "4.838235", "elementID": "33", "elementName": "lds_dmu", "questionNumber": "4"}, {"elementAverage": "4.095588", "elementID": "32", "elementName": "lds_ideal", "questionNumber": "4"}, {"elementAverage": "5.000000", "elementID": "24", "elementName": "lds_objectionable", "questionNumber": "4"}, {"elementAverage": "2.833333", "elementID": "101", "elementName": "num_rescuers_matter", "questionNumber": "5"}, {"elementAverage": "1.650000", "elementID": "13", "elementName": "singer_location_argument", "questionNumber": "5"}, {"elementAverage": "3.900000", "elementID": "14", "elementName": "singer_location_can_matter", "questionNumber": "5"}, {"elementAverage": "1.183333", "elementID": "17", "elementName": "singer_overview", "questionNumber": "5"}, {"elementAverage": "1.500000", "elementID": "16", "elementName": "singer_rescuers_argu", "questionNumber": "5"}];
var questionAverages = [
    {"questionAverage": "3.373077", "questionID": "73", "questionNumber": "1"},
    {"questionAverage": "5.317686", "questionID": "74", "questionNumber": "2"},
    {"questionAverage": "2.546875", "questionID": "25", "questionNumber": "3"},
    {"questionAverage": "5.485294", "questionID": "24", "questionNumber": "4"},
    {"questionAverage": "3.350000", "questionID": "15", "questionNumber": "5"}];
var expectedQuestionNumbers = [1, 2, 3, 4, 5];
var expectedQuestionTitles = ["Tragedy of the Commons", "Moral Hazard", "Too demandingness objection", "Leveling down argument and response", "Distance and location don't matter"];
var expectedQuestionScores = [6.00, 7.5, 0, 8, 0];
var expectedQuestionAverages = [3.373077, 5.317686, 2.546875, 5.485294, 3.350000];

//______________________________________________________________________________ Tests
module('chartScripts.js QuestionData and QuestionAverages');
test('QuestionData', function () {
    var qd = new QuestionDataObject();
    qd.load(questionScores);
    deepEqual(qd.questionNumbers, expectedQuestionNumbers, "Loads question numbers and converts to number");
    deepEqual(qd.questionNames, expectedQuestionTitles, "Loads question titles");
    deepEqual(qd.questionScores, expectedQuestionScores, "Loads question scores");
});

test('QuestionAverages', function () {
    var qa = new QuestionAverages();
    qa.load(questionAverages);
    deepEqual(qa.questionAverages, expectedQuestionAverages, "Loads question averages");
});

module('chartScripts.js QuestionHolder');
test('LoadData', function () {
    var questionHolder = new QuestionHolder();
    questionHolder.loadScores(questionScores);
    $.each(questionHolder.questions, function () {
        var question = this;
        $.each(questionScores, function () {
            if (this.questionID === question.questionID) {
                equal(question.questionNumber, this.questionNumber, "questionNumber is equal");
                equal(question.title, 'Q' + this.questionNumber + ' ' + this.title, "Title is correct");
                if (this.questionScore === null) {
                    equal(question.score, null, "question score is equal in null case");
                } else {
                    equal(question.score, Number(this.questionScore), "question score is equal");
                }
            }
        });
    });

});
test('LoadAverages', function () {
    var questionHolder = new QuestionHolder();
    questionHolder.loadScores(questionScores);
    questionHolder.loadAverages(questionAverages);
    $.each(questionHolder.questions, function () {
        var question = this;
        $.each(questionAverages, function () {
            if (this.questionID === question.questionID) {
                equal(question.average, Number(this.questionAverage), "question average is equal")
            }
        });
    });
});
test('getByID', function () {
    var questionHolder = new QuestionHolder();
    questionHolder.loadScores(questionScores);
    $.each(questionScores, function () {
        var q = questionHolder.getByID(this.questionID);
        equal(q.questionNumber, this.questionNumber, "Get by id returns object w correct questionNumber");
    });
});
test('getByQuestionNumber', function () {
    var questionHolder = new QuestionHolder();
    questionHolder.loadScores(questionScores);
    $.each(questionScores, function () {
        var q = questionHolder.getByNumber(this.questionNumber);
        equal(q.questionID, this.questionID, "Get by number returns object w correct questionID");
    });
});
test('setAnsweredQuestions', function () {
    var unanswered = new Question(1);
    unanswered.score = null;
    unanswered.setQuestionNumber(1);
    var answered1 = new Question(2);
    answered1.score = 0;
    answered1.setQuestionNumber(2);
    var answered2 = new Question(3);
    answered2.score = 5.5;
    answered2.setQuestionNumber(3);
    var qh = new QuestionHolder();
    qh.questions = [unanswered, answered1, answered2];
    qh.setAnsweredQuestions();
    window.console.log(qh);
    ok(qh.answeredQuestions.indexOf(2) >= 0, "Score 0 gets put in answered questions");
    ok(qh.answeredQuestions.indexOf(3) >= 0, "Score 5.5 gets put in answered questions");
    ok(qh.answeredQuestions.indexOf(1) < 0, "Score null not put in answered questions");
});

module('chartScripts.js ElementHolder');
test('LoadScores', function () {
    var elementHolder = new ElementHolder();
    elementHolder.loadScores(elementScores);
    $.each(elementHolder.elements, function () {
        var element = this;
        $.each(elementScores, function () {
            if (this.elementID === element.elementID) {
                equal(element.questionNumber, this.questionNumber, "elementNumber is equal");
                equal(element.elementAbbr, this.elementName, "elementAbbr is equal");
                equal(element.elementEnglish, this.displayText, "elementEnglish is equal");
                equal(element.subtask, Number(this.subtask), "subtask is equal");
                equal(element.score, Number(this.elementScore), "element score is equal");
            }
        });
    });
});
test('LoadElementAverage', function () {
    var elementHolder = new ElementHolder();
    elementHolder.loadScores(elementScores);
    elementHolder.loadAverages(elementAverages);
    $.each(elementHolder.elements, function () {
        var element = this;
        $.each(elementAverages, function () {
            if (this.elementID === element.elementID) {
                equal(element.average, Number(this.elementAverage), "element average is equal");
            }
        });
    });
});
//TODO: Check for case where element assigned to multiple questions
test('getByQuestionNumber', function () {
    var elHolder = new ElementHolder();
    elHolder.loadScores(elementScores);
    $.each(elementScores, function () {
        var e = elHolder.getByQuestionNumber(this.questionNumber);
        ok(e.length > 0);
    });
});
test('consolidateElementScores', function () {
    var incoming = [[{"a": "1", "b": "1"}], [{"a": "2", "b": "2"}]];
    var result = consolidateElementScores(incoming);
    deepEqual(result, [{"a": "1", "b": "1"}, {"a": "2", "b": "2"}]);
    deepEqual(result[0], {"a": "1", "b": "1"});
    deepEqual(result[1], {"a": "2", "b": "2"});
});

module('chartScripts.js Page setup functions', {
    setup: function () {
        $('#qunit-fixture').append("<div id='elementCharts'></div>");
    },
    teardown: function () {
    }
});
test('divMaker', function () {
    var qh = new QuestionHolder();
    var answeredQuestionNumbers = [1, 4, 5];
    qh.answeredQuestions = answeredQuestionNumbers;
    divMaker(qh);
    //var $divparts = $('#elementCharts').children();
    $.each(answeredQuestionNumbers, function () {
        var div = '#Q' + this + 'Chart';
        equal($(div).attr('class'), 'elementChartDiv', "elementChartDiv added");
    });
});