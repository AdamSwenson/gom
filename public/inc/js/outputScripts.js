/*  25 Aug 12 */

//$(document).ready(function(){


function fillQuestionNames(questionNameJSON) {
    $.each(questionNameJSON, function () {
        var Display = new Object();
        Display.questionNumber = this.questionNumber;
        Display.questionTitle = this.questionTitle;
        $('#questionResult').tmpl(Display).appendTo('#questionResultsHere');
    });
};

function fillGrade(gradeJSON) {
    $.each(gradeJSON, function () {
        var grade = this.gradeLetter;
        $('.grade').val(grade);
    });
}

function makeComments(commentsJSON) {
    var Display = new Object();
    Display.stockText = 'stockText';
    //fill with comments
    $.each(commentsJSON, function () {
        $('#commentTemplate').tmpl(this).appendTo('#q' + this.questionNumber + 'Comments');
    });
}


//___________________________________________________ on load
//getGrade();
//getRecord();
//getComments();
//});//end doc ready function

//------------------------------------------------------------ OLD ---------------------------------
//function getGrade() {
//    $.getJSON(OUTPUTLINK, {'task': 'getGrade'}, function (response) {
//        fillGrade(response);
////		$.each(response, function(){
////			$('.grade').append(this.gradeLetter);
////		});
//    }, "JSON");
//}//get grade
//
////**************************************************RETRIEVE RECORD
//function getRecord() {
//    $.getJSON(OUTPUTLINK, {'task': 'getQuestions'}, function (response) {
//        var data = response.data;
//        fillQuestionNames(data);
////            
////		$.each(response.data, function(){
////			var Display = new Object();
////			Display.questionNumber = this.questionNumber;
////			Display.questionTitle = this.questionTitle;
////			$('#questionResult').tmpl(Display).appendTo('#questionResultsHere');
////		});
//        // console.log('jip');
//        getComments();
//
//    }, "JSON");
//
//
//}
//;//end of get record request function
//
//var getComments = function () {
//    $.getJSON(OUTPUTLINK, {'task': 'getComments'}, function (response) {
//        //make divs for each question
//        $.each(response.comments, function () {
//            var Display = new Object();
//            Display.stockText = 'stockText';
//        });
//        //fill with comments
//        $.each(response.comments, function () {
//            $('#commentTemplate').tmpl(this).appendTo('#q' + this.questionNumber + 'Comments');
//        });
//
//    }, "JSON");
//};
