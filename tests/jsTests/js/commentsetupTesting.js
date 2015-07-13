/**
 * Created by adam on 4/6/15.
 */

var commentTypes = ['missing', 'poor', 'competent', 'excellent'];

function makePanelPart(qnum, subnum) {
    $.each(commentTypes, function () {
        var subident = 's' + qnum + '_' + subnum + '_' + this;
        $("#qunit-fixture").append(
            '<div><input id="' + subident + '" class="" type="text">'
            + '<input type="hidden" id="' + subident + '_textID" class="" />'
            + '<select id="' + subident + '_select" class="textSettingSelect" data="' + subident + '">'
            + '<option>--Canned preface text--</option>'
            + '</select></div>'
        );
    });
}

/**
 * this makes the fields for assigning elements/comments to questions
 * @param qnum
 * @param numberOfSubtasks
 */
function makeQuestionArea(qnum, numberOfSubtasks){
    var $qid = "#q" + qnum + "_setup_area";
    $("#qunit-fixture").append('<div id="q' + qnum + '_setup_area" class="commentSetupArea" data="' + qnum + '" ></div>');
    for(var i = 1; i < numberOfSubtasks + 1; i++){
        $($qid).append('<div id="q' + qnum + '_sub' + i + '_area" class="subtaskArea" data-questionNumber="' + qnum + '" data-subtask="' + i + '" ></div>');
    }
}

/**
 * Appends a draggable subtask to the specified area
 * @param areaId Format: "q{$qnum}_sub{$subnum}_area"
 * @param elementid The elementid for the subtask
 */
function makeSubtasks(areaId, elementid){
    $("#" + areaId).append('<div class="subtask draggable" data-elementID="' + elementid + '" >'
    + '<div>'
        + '<input type="text" class="displayText" value="element text box" />'
        + '<input type="text" class="elementName" value="element name text" />'
    + '</div>'
    + '<div>'
        + '<input type="text" class="commentID" value="' + elementid + '" />'
        + '<textarea class="commentText">comment text</textarea>'
    + '</div>'
    + '</div>');
}


function makeQuestionSetupArea(qnum, subnum) {
    var subident = 's' + qnum + '_' + subnum;

    $("#qunit-fixture").append('<div id="q' + qnum + '_setup_area" class="commentSetupArea">'
    + '<div id="q' + qnum + '_sub' + subnum + '_area" class="subtaskArea" data="' + subnum + '">'
    + '<div class="taskNum">' + subnum + '</div>'
    + '<div id="' + subident + '" class="subtask draggable" data="">'
    + '<div class="subtaskPart elementInfo">'
    + '<input id="' + subident + '_element" type="text">'
    + '<input id="' + subident + '_elementID" type="hidden">'
    + '<select id="' + subident + '_element_select" class="elementSelect" data="' + subident + '">'
    + '</select>'
    + '</div>'
    + '<div id="' + subident + '_commentArea" class="centralComment subtaskPart">'
    + '<div id="' + subident + '_commentArea" class="centralComment subtaskPart">'
    + '<input id="' + subident + '_commentID" type="hidden">'
    + '<textarea id="' + subident + '" class="centralComment" cols="80" rows="6"></textarea>'
    + '</div>'
    + '<div class="panelControl"></div>'
    + '<div id="' + subident + '_panel" class="commentConfig subtaskPart startHidden">'
    + '</div>');
}

function makeValueFields(qnum, subnum){
    var subident = 's' + qnum + '_' + subnum;
    $("#qunit-fixture").append('<input id="' + subident + '_element" type="text" />'
    + '<input type="text" class="displayText" id="' + subident + '_displayText" />'
    + '<input id="' + subident + '_elementID" type="text" />'
    + '<input id="' + subident + '_commentID" type="text" />'
    + '<textarea id="' + subident + '_comment" ></textarea>');
}

function makeElementSelect(qnum, subnum) {
    var subident = 's' + qnum + '_' + subnum;
    var fix = '<div id="t' + qnum + subnum + '" data-elementID="">'
                +'<div>'
                    + '<select id="' + subident + '_element_select" class="elementSelect" data="' + subident + '" ></select>'
                + '</div>'
                + '</div>'
    $("#qunit-fixture").append(fix);
}

/****************************************** TESTS **************************************************/

module('commentSetup.js | commentPanel', {
    setup: function () {
        this.testtextid = 32;
        this.testtext = "standard text to use";
        makePanelPart(1,1);
        $(".textSettingSelect").append($("<option></option>")
            .attr("value", this.testtextid)
            .text(this.testtext)
            .attr('selected', 'true'));
    }
});
test('updatePanelValues() ', function(){
    expect(2);
    var selid = '#s1_1_missing';
    var $sel = $(selid + '_select');
    console.log($sel);
    updatePanelValues($sel);
    //set hidden field with id
    equal($(selid + "_textID").val(), this.testtextid, "id set");
    equal($(selid).val(), this.testtext, "text set");
});



module('commentSetup.js | commentPanel display ', {
    setup: function(){
        $("#qunit-fixture").append('<div id="s1_1_panel" style="display:none"/>');
        $("#qunit-fixture").append('<input type="button" id="testbutton" data="s1_1" />');
    }
});
test('changePanelVisibility() ', function(){
    ok(!$("#s1_1_panel").is(":visible", "panel hidden at start"));
    changePanelVisibility($("#testbutton"));
    ok($("#s1_1_panel").is(":visible"), "panel shows");
});



module('commentSetup.js |  Select controls for main page items', {
    setup: function () {
        makeElementSelect(1, 1);
        makeValueFields(1, 1);
        this.comments = [{
            "questionID": 1,
            "subtask": 1,
            "elementID": 1,
            "commentID": 101,
            "displayText": "Element 1 text",
            "elementName": "Element1name",
            "commentText": "Text of the comment 1 area"
        },
            {
                "questionID": 1,
                "subtask": 2,
                "elementID": 2,
                "commentID": 102,
                "displayText": "Element 2 text",
                "elementName": "Element2name",
                "commentText": "Text of the comment 2 area"
            },
            {
                "questionID": 2,
                "subtask": 1,
                "elementID": 3,
                "commentID": 103,
                "displayText": "Element 3 text",
                "elementName": "Element4name",
                "commentText": "Text of the comment 3 area"
            },
            {
                "questionID": 2,
                "subtask": 2,
                "elementID": 4,
                "commentID": 104,
                "displayText": "Element 4 text",
                "elementName": "Element4name",
                "commentText": "Text of the comment 4 area"
            }];
    }
});
test('addComments() Add comments to selectors', function () {
    expect(6);
    addComments(this.comments);
    var expected = this.comments[0];
    var $sel = $("#s1_1_element_select").find('option:eq(0)');
    equal($sel.attr("value"), expected['elementID'], "value has elementid");
    equal($sel.text(), expected['displayText'], "text contains displayText");
    equal($sel.data("commentID"), expected['commentID'], "data contains commentid");
    equal($sel.data("elementID"), expected['elementID'], "data contains elementid");
    equal($sel.data("displayText"), expected['displayText'], "data contains displayText");
    equal($sel.data("commentText"), expected['commentText'], "data contains commentText");
});
test('updateElementValues() Updating fields upon select change', function(){
    expect(5);
    addComments(this.comments);

    var expected = this.comments[0];
    var elid = '#s1_1';
    var $sel = $(elid + "_element_select");
    updateElementValues($sel);
    //console.log($(elid + "_elementID").val(), 'right here');
    //equal($("#t11").data("elementID"), expected['elementID'], "elementid set on parent");
    equal($(elid + "_elementID").val(), expected['elementID'], "elementid field set");
    equal($(elid + "_element").val(), expected['elementName'], "elementName field set");
    equal($(elid + "_displayText").val(), expected['displayText'], "element english field set");
    equal($(elid + "_commentID").val(), expected['commentID'], "comment id field set");
    equal($(elid + "_comment").val(), expected['commentText'], " commentText field set");
});



module('preparation for submission', {
    setup: function(){
        this.numberQuestions = 2;
        this.numberSubtasks = 3;
        makeQuestionArea(1, this.numberSubtasks);
        makeQuestionArea(2, this.numberSubtasks);
    }
});
test('getElementAssignments() Everything in original place', function(){
    makeSubtasks("q1_sub1_area", 1);
    makeSubtasks("q1_sub2_area", 2);
    makeSubtasks("q1_sub3_area", "");
    makeSubtasks("q2_sub1_area", 4);
    makeSubtasks("q2_sub2_area", 5);
    makeSubtasks("q2_sub3_area", "");
    var result = getElementAssignments();

    ok(result.length === 6, "correct number of results returned");
    equal(result[0].questionNumber, "1", "questionNumber for subtask 1-1");
    equal(result[0].subtask, "1", "subtask for subtask 1-1");
    equal(result[0].elementID, "1", "elementid for subtask 1-1")
    equal(result[1].questionNumber, "1", "questionNumber for subtask 1-2");
    equal(result[1].subtask, "2", "subtask for subtask 1-2");
    equal(result[1].elementID, "2", "elementid for subtask 1-2")
    equal(result[2].questionNumber, "1", "questionNumber for subtask 1-3");
    equal(result[2].subtask, "3", "subtask for subtask 1-3");
    equal(result[2].elementID, "", "elementid for subtask 1-3")
    equal(result[3].questionNumber, "2", "questionNumber for subtask 2-1");
    equal(result[3].subtask, "1", "subtask for subtask 2-1");
    equal(result[3].elementID, "4", "elementid for subtask 2-1")
    equal(result[4].questionNumber, "2", "questionNumber for subtask 2-2");
    equal(result[4].subtask, "2", "subtask for subtask 2-2");
    equal(result[4].elementID, "5", "elementid for subtask 2-2")
    equal(result[5].questionNumber, "2", "questionNumber for subtask 2-3");
    equal(result[5].subtask, "3", "subtask for subtask 2-3");
    equal(result[5].elementID, "", "elementid for subtask 2-3");

    $.each(result, function(){
       equal(this.displayText, "element text box", "this.displayText okay");
        equal(this.elementName, "element name text", "this.elementName okay");
        //equal(this.commentID, "99", "this.commentID okay");
        equal(this.commentText, "comment text", "this.commentText okay");
    });

});
test('getElementAssignments() Some items moved', function(){
    makeSubtasks("q1_sub1_area", 1);
    makeSubtasks("q1_sub2_area", 5);
    makeSubtasks("q1_sub3_area", "");
    makeSubtasks("q2_sub1_area", 4);
    makeSubtasks("q2_sub2_area", 2);
    makeSubtasks("q2_sub3_area", 3);
    var result = getElementAssignments();
    //console.log('getelassign', result);
    ok(result.length === 6, "correct number of results returned");
    equal(result[0].questionNumber, "1", "questionNumber for subtask 1-1");
    equal(result[0].subtask, "1", "subtask for subtask 1-1");
    equal(result[0].elementID, "1", "elementid for subtask 1-1")

    equal(result[1].questionNumber, "1", "questionNumber for subtask 1-2");
    equal(result[1].subtask, "2", "subtask for subtask 1-2");
    equal(result[1].elementID, "5", "elementid for subtask 1-2")

    equal(result[2].questionNumber, "1", "questionNumber for subtask 1-3");
    equal(result[2].subtask, "3", "subtask for subtask 1-3");
    equal(result[2].elementID, "", "elementid for subtask 1-3")

    equal(result[3].questionNumber, "2", "questionNumber for subtask 2-1");
    equal(result[3].subtask, "1", "subtask for subtask 2-1");
    equal(result[3].elementID, "4", "elementid for subtask 2-1")

    equal(result[4].questionNumber, "2", "questionNumber for subtask 2-2");
    equal(result[4].subtask, "2", "subtask for subtask 2-2");
    equal(result[4].elementID, "2", "elementid for subtask 2-2")

    equal(result[5].questionNumber, "2", "questionNumber for subtask 2-3");
    equal(result[5].subtask, "3", "subtask for subtask 2-3");
    equal(result[5].elementID, 3, "elementid for subtask 2-3");

    $.each(result, function(){
        equal(this.displayText, "element text box");
        equal(this.elementName, "element name text");
        //equal(this.commentID, "99");
        equal(this.commentText, "comment text");
    });


});
