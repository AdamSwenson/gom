/**
 * Created by adam on 4/5/15.
 */


function add_questions(questions) {
    $.each(questions, function () {
        $('.questionSelect').append($("<option></option>")
                .attr("value", this['questionID'])
                .text(this['questionName'])
                .data("questionName", this['questionName'])
                .data("questionText", this['questionText'])
        );
    });
}

/**
 *
 * @property {string} questionName The short identifying name of the question (optional)
 * @property {int} questionID The database id of the question
 * @property {string} string The long question text
 * @property {int} questionNumber The number that this question has on this exam
 * @returns {questionsetup2_L5.Question}
 */
function Question() {
    this.questionName = '';
}


Question.prototype.load = function (qnum) {
    this.questionNumber = qnum;
    this.questionName = $("#q" + qnum + "_name").val();
    this.questionText = $("#q" + qnum + "_text").val();
    this.questionID = $("#q" + qnum + "_questionID").val();
};


function prepareSend(numQuestions) {
    var questions = new Array();
    for (i = 1; i < numQuestions + 1; i++) {
        var q = new Question();
        q.load(i);
        questions.push(q);
    }

    return questions;
}

/**
 * This takes an array of questions and
 * displays them in the appropriate boxes
 * @param {Question} question
 */
function displayQuestion(question) {
    //set the hidden field with the questionID number
    $("#q" + question.questionNumber + "_questionID").val(question.questionID);
    //set the nickname field
    $("#q" + question.questionNumber + "_name").val(question.questionName);
    //set the question text field
    $("#q" + question.questionNumber + "_text").val(question.questionText);
}

function processQuestionJson(questionJson) {
    $.each(questionJson, function () {
        var q = new Question();
        q.questionID = this.questionID;
        q.questionText = this.questionText;
        if(this.questionName){
            q.questionName = this.questionName;
        }
        displayQuestion(q);
    });
}

/**
 * Loads the question into the text upon select change
 * @param dthis The this context from an activated select
 */
function processSelect(dthis) {
    var question = new Question();
    //get the stored questionID for the preexisting question
    question.questionID = $(dthis).val();
    //get the id of the select which fired
    var txt_id = $(dthis).attr("id");
    //get the question number of the selector activated
    question.questionNumber = $("#" + txt_id).attr("data");
    //get the stored question name
    question.questionName = $("#" + txt_id + " :selected").data("questionName");
    //get the stored question text
    question.questionText = $("#" + txt_id + " :selected").data("questionText");
    console.log(question);
    return question;
}

function success(){
    $('#statusArea').empty().removeClass("failure").addClass("success").append("Success");
}

function fail(){
    $('#statusArea').empty().removeClass("success").addClass("failure").append("Failed");
}

function bindQuestionListeners() {
    $(".questionSelect").bind("change", function () {
        var question = processSelect(this);
        displayQuestion(question);
    });


    $("#questionCreate").bind("click", function () {
        var toSend = prepareSend(5);
        $.each(toSend, function () {
            window.console.log(this);
            this.task = 'setUpQuestions';
            sendRequestCallback(this, success, fail);
        });
        //toSend.task = 'setUpQuestions';
        //window.console.log(toSend);
        //sendRequest(toSend,  $('#submitStatus'), '');
    });
}