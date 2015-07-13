/**
 * Created by adam on 4/6/15.
 */

//todo: Validate that one comment per subtask before send

var REQUEST = 'setUpComments';
var NUM_QUESTIONS = 2;
var NUM_SUBTASKS = 3;
//
///**
// * @constructor
// *
// */
//function Comment() {
//}
//
//Comment.prototype.load = function (subtaskId) {
//    var subid = "#" + subtaskId;
//    this.elementEnglish = $(subid + '_element').val();
//    this.elementID = $(subid + '_elementID').val();
//    this.commentID = $(subid + '_commentID').val();
//    this.commentText = $(subid + '_comment').val();
//    this.missing_min = $(subid + '_missing_min_score').val();
//    this.missing_max = $(subid + '_missing_max_score').val();
//    this.poor_min = $(subid + '_poor_min_score').val();
//    this.poor_max = $(subid + '_poor_max_score').val();
//    this.competent_min = $(subid + '_competent_min_score').val();
//    this.competent_max = $(subid + '_competent_max_score').val();
//    this.excellent_min = $(subid + '_excellent_min_score').val();
//    this.excellent_max = $(subid + '_excellent_max_score').val();
//};
//
///**
// * This is deprecated in favor of getElementAssignments
// * @param numQuestions
// * @param numSubtasks
// * @returns {Array}
// */
//function prepareSend(numQuestions, numSubtasks) {
//    var comments = [];
//    for (var q = 1; q < numQuestions + 1; q++) {
//        for (var s = 1; s < numSubtasks + 1; s++) {
//            var c = new Comment();
//            c.load("s" + q + "_" + s);
//            comments.push(c);
//        }
//    }
//window.console.log('prepareSend()', comments);
//    return comments;
//}

/**
 * Load the comments into the page
 * @param comments
 */
function addComments(comments){
    $.each(comments, function () {
        $('.elementSelect').append($("<option></option>")
                .attr("value", this['elementID'])
                .text(this['displayText'])
                .data("elementName", this['elementName'])
                .data("elementID", this['elementID'])
                .data("commentID", this['commentID'])
                .data("displayText", this['displayText'])
                .data("commentText", this['commentText'])
        );
    });
}

/**
 * @property {int} subtask
 * @property {int} questionNumber
 * @property {int} elementID
 * @property {string} elementName
 * @property {string} displayText Corresponds with displayText in php
 * @property {int} commentID Just the elementID
 * @property {string} commentText
 * @constructor
 */
function Element(){};

Element.prototype.load = function(dthis){
    this.subtask = $(dthis).parent().data("subtask");
    this.questionNumber = $(dthis).parent().data("questionnumber");
    this.elementID = $(dthis).find(".commentID").val();
    //this.elementID = $(dthis).data("elementID");
    //this.elementID = $(dthis).data("elementid");
    this.elementName = $(dthis).find(".elementName").val();
    this.displayText = $(dthis).find(".displayText").val();
    this.commentID = $(dthis).find(".commentID").val();
    this.commentText = $(dthis).find(".commentText").val();
}


/**
 * Finds the positions of each question and comment for
 * the commentAssigner
 */
function getElementAssignments(){
    var elements = [];
    $(".subtask").each(function(){
        var element = new Element();
        element.load(this);
console.log('getElementAssign', element);
        if((element.displayText) && (element.displayText.length > 0) && (element.commentText.length > 0)){
            elements.push(element);
        }
        //var Element = new Object();
        //Element.subtask = $(this).parent().data("subtask");
        //Element.questionNumber = $(this).parent().data("questionnumber");
        //Element.elementID = $(this).data("elementid");
        //Element.elementName = $(this).find(".elementName").val();
        //Element.displayText = $(this).find(".displayText").val();
        //Element.commentID = $(this).find(".commentID").val();
        //Element.commentText = $(this).find(".commentText").val();
        //elements.push(element);
    });
    return elements;
}

function displayExisting(Element){
    var ident = "#s" + Element.questionNumber + "_" + Element.subtask;
    $(ident + "_displayText").val(Element.displayText);
    $(ident + "_element").val(Element.elementName);
    $(ident + "_elementID").val(Element.elementID);
    $(ident + "_commentID").val(Element.elementID);
    $(ident + "_comment").val(Element.commentText);
}

function processElementJson(elementJson){
    var elements = [];
    $.each(elementJson,  function(){
       var el = new Element();
        el.questionNumber = this.questionNumber;
        el.subtask = this.subtask;
        el.elementID = this.elementID;
        el.commentID = this.elementID;
        el.elementName = this.elementName;
        el.displayText = this.displayText;
        el.commentText = this.commentText;
        elements.push(el);
        console.log(el);
    });
    return elements;
}

/**
 * Updates the value boxes in the settings panel from the selectors
 * @param dthis
 */
function updatePanelValues(dthis){
    //get the id of the select which fired
    var sel_id = $(dthis).attr("id");
    //get the id of the subtask
    var my_id = $("#" + sel_id).attr("data");

    var newVal = $("#" + sel_id + " :selected").val();
    var newTxt = $("#" + sel_id + " :selected").text();
    //set hidden field with id
    $("#" + my_id + "_textID").val(newVal);
    //set text box with text
    $("#" + my_id).val(newTxt);
}


/**
 * Called when an element select is changed. Updates the value
 * boxes from the selects
 * @param dthis The this context of the bound listener
 */
function updateElementValues(dthis) {
    //get the id of the select which fired
    var sel_id = $(dthis).attr("id");
    //get the id of the subtask
    var my_id = $("#" + sel_id).attr("data");

    //get the question number of the selector activated
    //var elementID = $("#" + sel_id + " :selected").val();
    var elementID = $("#" + sel_id + " :selected").data("elementID");
    var commentID = $("#" + sel_id + " :selected").data("commentID");
    var displayText = $("#" + sel_id + " :selected").data("displayText");
    var commentText = $("#" + sel_id + " :selected").data("commentText");
    var elementName = $("#" + sel_id + " :selected").data("elementName");
 //    window.console.log(my_id, elementID, commentID, displayText, commentText);

    //set textboxes
    //$(dthis).parent().parent().data('elementID', elementID);
    $("#" + my_id + "_elementID").val(elementID);
    //$("#" + my_id).data("elementID", elementID);
    $("#" + my_id + "_element").val(elementName);
    $("#" + my_id + "_displayText").val(displayText);
    $("#" + my_id + "_commentID").val(commentID);
    $("#" + my_id + "_comment").val(commentText);
}

/**
 * Shows or hides a settings panel
 * @param dthis The this context of the bound listener
 */
function changePanelVisibility(dthis) {
    var panelID = $(dthis).attr("data");
    window.console.log('changePanelVisibility()', panelID);
    $("#" + panelID + "_panel").toggle();
}

/**
 * Gets the new select values from server after
 * something has been added
 */
function updateExisting(){
    var Request = new Object();
    Request.task = 'get'
    $.post("api", Request, function (response) {
        responseHandler(response, jquerySelectorToChange, message);
    }, "JSON");
}

function bindListeners() {
//binds elementSelectors to value boxes
    $(".elementSelect").bind("change", function () {
        updateElementValues(this);
    });

    $(".panelControlButton").bind("click", function () {
        changePanelVisibility(this);
    });

    $("#commentsCreate").bind("click", function () {
        var toSend = getElementAssignments();
        console.log('commentsCreate click', toSend);
        $.each(toSend, function () {
            window.console.log('sending', this);
            this.task = 'setUpComments';
            var statusArea = '#s' + this.questionNumber + '_' + this.subtask + '_status';
            console.log(statusArea);
            var success = function(){
                console.log('success');
                $(statusArea).empty();
                $(statusArea).append('<span class="ui-icon ui-icon-check"></span>');
            };
            var failure = function(){
                console.log('fail');
                $(statusArea).empty();
                $(statusArea).append('<span class="ui-icon ui-icon-close"></span>');
            }

            sendRequestCallback(this, success,  failure);
            //sendRequest(this, $(statusArea), '<span class="ui-icon ui-icon-check"></span>');
        });
    });
}
