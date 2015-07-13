/**
 * Created by adam on 4/6/15.
 */

function makeFields(qnum, qid, qname, qtext) {
    $("#qunit-fixture").append("<textarea id='q" + qnum + "_text' class='questionTextArea' rows='5' cols='50'>" + qtext + "</textarea>");
    $("#qunit-fixture").append("<input id='q" + qnum + "_name' class='questionName' value='" + qname + "' type='text'>");
    $("#qunit-fixture").append("<input id='q" + qnum + "_questionID' type='hidden' value='" + qid + "' data='" + qnum + "'>");
    $("#qunit-fixture").append("<select id='q" + qnum + "_select' class='questionSelect' data='" + qnum + "'>");
}


module('questionSetup.js Question', {
    setup: function () {
        this.questionNumber = 3;
        this.questionID = 3;
        this.questionName = 'test name';
        this.questionText = "test text";
        makeFields(this.questionNumber, this.questionID, this.questionName, this.questionText);
    }
});

test('Question() ', function () {
    expect(4);
    var question = new Question();
    question.load(3);
    equal(this.questionNumber, question.questionNumber, 'question number');
    equal(this.questionText, question.questionText, 'question title');
    equal(this.questionName, question.questionName, 'question name');
    equal(this.questionID, question.questionID, 'questionid');
//            equal(qnum, $("#q" + qnum + "_name").val());
//            equal(qnum, $("#q" + qnum + "_questionID").val());
//            equal(qnum, $("#q" + qnum + "_select").val());

//            $("#q" + qnum + "_name").val();
});
