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
                    "elementAbbr": "singer_overview",
                    "subtask": "1",
                    "elementEnglish": "Presentation of a brief overview of Singer's argument",
                    "questionNumber": "2",
                    "eid": "17",
                    "elementScore": "4.5"},
                {"elementID": "13",
                    "elementAbbr": "singer_location_argument",
                    "subtask": "2",
                    "elementEnglish": "Setting out Singer's argument that distance per se can't matter morally",
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
            var elementAverages = [{"elementAverage": "0.823077", "elementID": "62", "elementAbbr": "tocForcedChange", "questionNumber": "1"},
                {"elementAverage": "1.750000", "elementID": "56", "elementAbbr": "tocList", "questionNumber": "1"},
                {"elementAverage": "3.276923", "elementID": "98", "elementAbbr": "tocShortSighted", "questionNumber": "1"},
                {"elementAverage": "3.911538", "elementID": "27", "elementAbbr": "toc_example", "questionNumber": "1"},
                {"elementAverage": "3.096154", "elementID": "19", "elementAbbr": "toc_strategy", "questionNumber": "1"},
                {"elementAverage": "3.326923", "elementID": "12", "elementAbbr": "toc_structure", "questionNumber": "1"},
                {"elementAverage": "8.000000", "elementID": "57", "elementAbbr": "mhList", "questionNumber": "2"},
                {"elementAverage": "5.423077", "elementID": "100", "elementAbbr": "mhUnintConsq", "questionNumber": "2"},
                {"elementAverage": "4.719231", "elementID": "29", "elementAbbr": "mh_definition", "questionNumber": "2"},
                {"elementAverage": "5.557692", "elementID": "30", "elementAbbr": "mh_example", "questionNumber": "2"},
                {"elementAverage": "4.957692", "elementID": "23", "elementAbbr": "mh_risk", "questionNumber": "2"},
                {"elementAverage": "0.828125", "elementID": "46", "elementAbbr": "conseqOverview", "questionNumber": "3"},
                {"elementAverage": "1.453125", "elementID": "49", "elementAbbr": "demandingDepth", "questionNumber": "3"},
                {"elementAverage": "3.031250", "elementID": "47", "elementAbbr": "demandingExample", "questionNumber": "3"},
                {"elementAverage": "2.265625", "elementID": "48", "elementAbbr": "demandingImp", "questionNumber": "3"},
                {"elementAverage": "0.156250", "elementID": "50", "elementAbbr": "demandingOIC", "questionNumber": "3"},
                {"elementAverage": "1.171875", "elementID": "51", "elementAbbr": "demandingReply", "questionNumber": "3"},
                {"elementAverage": "9.636364", "elementID": "99", "elementAbbr": "ldsNotForced", "questionNumber": "4"}, {"elementAverage": "3.941176", "elementID": "63", "elementAbbr": "ldsProbSinger", "questionNumber": "4"}, {"elementAverage": "3.639706", "elementID": "34", "elementAbbr": "lds_cms", "questionNumber": "4"}, {"elementAverage": "4.838235", "elementID": "33", "elementAbbr": "lds_dmu", "questionNumber": "4"}, {"elementAverage": "4.095588", "elementID": "32", "elementAbbr": "lds_ideal", "questionNumber": "4"}, {"elementAverage": "5.000000", "elementID": "24", "elementAbbr": "lds_objectionable", "questionNumber": "4"}, {"elementAverage": "2.833333", "elementID": "101", "elementAbbr": "num_rescuers_matter", "questionNumber": "5"}, {"elementAverage": "1.650000", "elementID": "13", "elementAbbr": "singer_location_argument", "questionNumber": "5"}, {"elementAverage": "3.900000", "elementID": "14", "elementAbbr": "singer_location_can_matter", "questionNumber": "5"}, {"elementAverage": "1.183333", "elementID": "17", "elementAbbr": "singer_overview", "questionNumber": "5"}, {"elementAverage": "1.500000", "elementID": "16", "elementAbbr": "singer_rescuers_argu", "questionNumber": "5"}];
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
//___________________________________________________________________________ Tests____________
module('outputScripts.js Grade display')
test('Test fillGrade', function () {
    $('#qunit-fixture').append("<input type='text' class='grade' />");
    // $('#test').append("<div class='grade'> </div>");
    gradejson = [{'gradeLetter': 'A'}];
    fillGrade(gradejson);
    equal($('.grade').val(), 'A', 'Grade set');
});

module('outputScripts.js Questions and comments content', {
    setup: function(){
        $('#qunit-fixture').append("<div id='questionResultsHere'></div>");
        $.each(QUESTION_NUMBERS, function () {
            $('#qunit-fixture').append("<div id='q" + this + "Comments'></div>");
        });
    }
});
test('makeQuestionNames', function () { 
    fillQuestionNames(QUESTION_PROPS);
    $.each(QUESTION_PROPS, function(){
        var div = "#q" + this.questionNumber;
        var len = $(div).children().length;
        ok(len > 0);
    });
});

test('fillComments', function () {
   expect(0); 
});