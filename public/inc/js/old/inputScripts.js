/**
 * Scripts for the input page
 * @requires securityTools.js
 * 
 */

//================================= Exam
/**
 * 
 * @returns {Exam}
 */
function Exam() {
    var sid;
    this.examTime = 0;
    var examStart;
    var me = this;
}//Exam

/**
 * Setter for examid
 * @param {int} sid
 * @returns {undefined}
 */
Exam.prototype.setID = function(sid) {
    this.sid = sid;
};

function load(exam, record, sid) {
    try {
        //Set the examid
        exam.setID(sid);
        //run callback to load info on exam
        exam.getExamInfo();
        //Set sid for record
        record.setID(sid);
        //initialize question buttons with record
        initializeQuestionSelection(record);
        //set groupnumber
        record.setGroupNumber(getGroupNumber());
        //set total exams
        record.setTotalExams(getTotalExams());
        //make the completion order selector
        setCompletionSelect(record.totalExams);
        //bind listener to exam info fields
        initializeExamInfoSelects();
    } catch (err) {
        window.console.log(err);
    }
}


/**
 * This binds a request handler to the sid field. Entering data in the field will return student id
 * @param {type} exam
 * @param {type} record
 * @returns {undefined}
 */
function setAutocomplete(exam, record) {
    $('#sid').autocomplete({
        source: function(req, add) {
            req.task = 'getAutoSID';
            $.post('api', req, function(response) {
                var suggestions = [];
                $.each(response.data, function(i, val) {
                    suggestions.push(val);
                });
                add(suggestions);
            }, "JSON");
        },
        select: function(event, ui) {//happens when the id is selected
            var sid = ui.item.label;
            load(exam, record, sid);
        }
    });
}



Exam.prototype.examIdCookie = function() {
    if (this.examID === null) {
        $('#eidHere').append('No exam selected');
    }
};

/**
 * Retrieves exam info for the given exam
 * @requires securityTools.js
 * @returns {undefined}
 */
Exam.prototype.getExamInfo = function() {
    var Req = new Object();
    Req.task = 'getExamInfo';
    Req.sid = $("#sid").val();
    $.post('api', Req, function(response) {
        var result = dataResponse(response);
        if(result){
        $.each(result, function(key, value) {
            $('#' + key).val(value);
            $('#' + key + 'Select').val(value);
            $('.' + key).bind('change', function() {
                var vv = $(this).val();
                $('#' + key).val(vv);
                $('#' + key + 'Select').val(vv);
            });//end bind
        });//end each on info
    }
    }, "JSON");//end get exam info json
    $('#examInfo').slideDown();
};//end get exam info


/**
 * Utility to get group number. Separated out to aid in testing
 * @returns {undefined}
 */
function getGroupNumber() {
    var groupnum = $.cookie('groupNumber');
    if (groupnum) {
        return groupnum;
    } else {
        //@todo decide how to handle errors
    }
}

/**
 * Utility to get total exams from cookie
 * @returns {unresolved}
 */
function getTotalExams() {
    var totExams = $.cookie('totalExams');
    if (totExams) {
        return totExams;
    } else {
        //@todo decide how to handle errors
    }
}

//===================== Record	   
/**
 * The object which holds the data for the current student
 * @property sid Student id number as given by user
 * @property groupNumber The current group number
 * @property totalExams Total number of exams to grade
 * @returns {Record}
 */
function Record() {
    this.getID = function() {
        return this.sid;
    };
};

/**
 * Setter for studentid
 * @param {type} sid
 * @returns {undefined}
 */
Record.prototype.setID = function(sid) {
    this.sid = sid;
};

Record.prototype.setGroupNumber = function(groupnumber) {
    this.groupNumber = groupnumber;
};

Record.prototype.setTotalExams = function(totalExams) {
    this.totalExams = totalExams;
};

/**
 * Gets data from server for a given question
 * 
 * @requires securityTools.js securityTools.dataResponse()
 * @param {Record} record
 * @param {Question} question
 * @returns {undefined}
 */
function getRecord(record, question) {
//Record.prototype.getRecord = function(question) {
//    this.q = question;
    var Req = new Object();
    Req.questionNumber = question;
    Req.sid = record.sid;
    Req.task = 'getRecord';
    $.post('api', Req, function(response) {
        //var result = dataResponse(response);
        var result = response.data;
        window.console.log('getRecord', result);
        if (result) {
            //Question details
            questionFieldMaker(result.questions[0]);
            //Elements
            $.each(result.elements, function() {
                record.Element(this);
            });
        }
    }, "JSON");
}

/**
 * Makes a question score box and sets a listener on it
 * @param {type} item
 * @returns {undefined}
 */
function questionFieldMaker(item) {
    window.console.log('qfm', item);
    $("#questionScoreSelector").tmpl(item).appendTo("#question" + item.questionNumber);
    var sSelect = new Object();
    sSelect.range = 10;
    sSelect.toAppendTo = 'q' + item.questionNumber + 'Select';
    sSelect.increment = 0.25;
    generateOptions(sSelect);
    $('.qs').bind("change", function() {
        var qnumber = $(this).attr("name");
        var Send = new Object();
        Send.questionID = $(this).attr("data");
        Send.questionScore = $(this).val();
        Send.task = 'recordQuestionScore';
//        Send.sid = me.getID();
        Send.sid = $('#sid').val();
        $('#' + qnumber + 'Score').val(Send.questionScore);
        submitItem(Send, qnumber + 'Score');
    });	//end changer function
};
//
///**
// * Makes a question score box and sets a listener on it
// * @param {type} item
// * @returns {undefined}
// */
//Record.prototype.QuestionField = function(item) {
//    $("#questionScoreSelector").tmpl(item).appendTo("#question" + item.questionNumber);
//    var sSelect = new Object();
//    sSelect.range = 10;
//    sSelect.toAppendTo = 'q' + item.questionNumber + 'Select';
//    sSelect.increment = 0.25;
//    generateOptions(sSelect);
//    $('.qs').bind("change", function() {
//        var qnumber = $(this).attr("name");
//        var Send = new Object();
//        Send.questionID = $(this).attr("data");
//        Send.questionScore = $(this).val();
//        Send.task = 'recordQuestionScore';
////        Send.sid = me.getID();
//        Send.sid = $('#sid').val();
//        $('#' + qnumber + 'Score').val(Send.questionScore);
//        submitItem(Send, qnumber + 'Score');
//    });	//end changer function
//};

/**
 * Makes an element slider and sets a listener on it
 * @param {type} Item
 * @returns {undefined}
 */
Record.prototype.Element = function(Item) {
    if (Item.elementScore === null) {
        Item.sliderScore = 5;
    }
    else {
        Item.sliderScore = Item.elementScore;
    }
    $("#elementSlider").tmpl(Item).appendTo("#question" + Item.questionNumber + " ul");
    $('#' + Item.elementAbbr + 'Slider').slider({
        smooth: true,
        round: 2,
        skin: "blue.round",
        limits: false,
        scale: ['absent', 'weak', 'ok', 'pretty good', 'excellent'],
        from: 0,
        to: 10,
        step: .25,
        callback: function(value) {
            $("#" + Item.elementAbbr).val(value);//makes score change with slider
            var Send = new Object();
            Send.task = 'recordElementScore';
//            Send.sid = this.getID();
            Send.sid = $('#sid').val();
            var sentValue = $('#' + Item.elementAbbr).val();
            Send[Item.elementAbbr] = $('#' + Item.elementAbbr).val();
            Send.elementScore = $('#' + Item.elementAbbr).val();
            Send.elementID = $('#' + Item.elementAbbr).attr('data');
            submitItem(Send, Item.elementAbbr);
        }//end slide event
    });//end slider

    $("#" + Item.elementAbbr).bind('change', function() {
        $("#" + Item.elementAbbr + 'Slider').slider("option", "value", $("#" + Item.elementAbbr).val()); //slider change if text box is edited                
    });//end bind												
    $('#question' + Item.questionNumber).slideDown();
};//end of get record request function

/**
 * Handles submit of elements etc
 * @param {type} Send
 * @param {type} itemname
 * @returns {undefined}
 * @requires securityTools.js securityTools.statusResponse()
 */
function submitItem(Send, itemname) {
    getNonce(Send);
    $.post('api', Send, function(response) {
        var result = statusResponse(response);
        window.console.log(result);
        successCheck(itemname, result);
    }, "JSON");
}

function successCheck(typeSent, result) {
    if (result.status === 'success') {
        $("label[for='" + typeSent + "']").css('color', 'green');
        $('input[name="' + typeSent + '"]').css('color', 'green');//for input boxes and examinfo
    }
    else {
        $("label[for='" + typeSent + "']").css('color', 'yellow');
        $('input[name="' + typeSent + '"]').css('color', 'yellow');
    }
};//successcheck


//____________________________________________________________ generic functions	
function emptyFields() {
    $('#sid').val('');
    $('.changer').css("color", "");
    $('.zeroOut').prop('selectedIndex', 0);
    $('.zeroOut').attr("value", '');
    $('#MainBody li').empty();
    $('#MainBody :text').val('');
    $('#MainBody :slider').val('');
    $('#examInfo :text').val('');
    $('#examTime').val('');
    $('#runningTimer').val('');
    $('.dump').empty();
    $('.startHidden').slideUp();
    $('.qSelect').prop('checked', false);
    $('.dumpOnNewExam').empty(); //Is this necessary? The misspelling suggests so
    $(".optionalQ > .questionScore").empty();
}

/**
 * This adds the appropriate number of options to the completion order selector
 * @param {int} totalExams The number of exams to grade
 * @returns {undefined}
 */
function setCompletionSelect(totalExams) {
    for (i = 1; i <= totalExams; i++) {
        $('#completionOrderSelect').append(
                $("<option></option>")
                //.attr("id", )
                .attr("value", i)
                .text(i)
                );//append
    }
}

function generateOptions(selectProperties) {
    var i = 0;
    while (i <= selectProperties.range) {
        $("#" + selectProperties.toAppendTo).append(
                $("<option></option>")
                //	.attr("id", selectProperties.id )
                .attr("data", selectProperties.data)
                .attr("value", i)
                .text(i)
                );//append
        i += selectProperties.increment;
    }
}

//_____________________________________________________________ page layout and components	
//pages
/**
 * Makes pages selctor
 * @returns {undefined}
 */
function makePageSelect() {
    var PagesSel = new Object();
    PagesSel.selectTextID = 'pages';
    PagesSel.selectLabel = 'Pages';
    PagesSel.selectTextData = 'pages';
    PagesSel.selectTextName = 'pages'; //the success function will identify this by name
    PagesSel.selectTextClasses = 'Input examInfo pages changer zeroOut';
    PagesSel.selectID = 'pagesSelect';
    PagesSel.selectClasses = 'pages changer zeroOut';
    PagesSel.selectData = 'pages';
    PagesSel.selectName = 'pagesSelect';

    $("#selectTemplate").tmpl(PagesSel).appendTo("#pagesHere");
    var pSelect = new Object();
    pSelect.range = 16;
    pSelect.toAppendTo = 'pagesSelect';
    pSelect.data = 'pages';
    pSelect.increment = 0.25;
    generateOptions(pSelect);
};

/**
 * Creates the selector for the completion order field
 * NB., the items in the select will be set by other function setCompletionOrderSelect()
 * 
 * @returns {undefined}
 */
function makeCompletionSelect() {
    var Completion = new Object();
    Completion.selectTextID = 'completionOrder';
    Completion.selectLabel = 'Order Handed In';
    Completion.selectTextData = 'completionOrder';
    Completion.selectTextName = 'completionOrder';
    Completion.selectTextClasses = 'Input examInfo completionOrder changer zeroOut';
    Completion.selectID = 'completionOrderSelect';
    Completion.selectClasses = 'completionOrder changer zeroOut';
    Completion.selectData = 'completionOrder';
    Completion.selectName = 'completionOrderSelect';
    $("#selectTemplate").tmpl(Completion).appendTo("#completionOrderHere");
    var cSelect = new Object();
    cSelect.range = 20;
    cSelect.toAppendTo = 'completionOrderSelect';
    cSelect.data = 'completionOrder';
    cSelect.increment = 1;
    generateOptions(cSelect);
}

/**
 * Creates the notecard selector
 * @returns {undefined}
 */
function makeNotecardSelect() {
    var Notecard = new Object();
//Notecard.selectTitle = 'Notecard';
    Notecard.selectTextID = 'notecard';
    Notecard.selectLabel = 'Notecard';
    Notecard.selectTextData = 'notecard';
    Notecard.selectTextName = 'notecard';
    Notecard.selectTextClasses = 'Input examInfo notecard changer zeroOut';
    Notecard.selectID = 'notecardSelect';
    Notecard.selectClasses = 'notecard changer zeroOut';
    Notecard.selectData = 'notecard';
    Notecard.selectName = 'notecard';
    $("#selectTemplate").tmpl(Notecard).appendTo("#notecardHere");
    var nSelect = new Object();
    nSelect.range = 2;
    nSelect.toAppendTo = 'notecardSelect';
    nSelect.data = 'notecard';
    nSelect.increment = 0.25;
    generateOptions(nSelect);
}


//____________________________________________________ Initialize listeners
/**
 * Sets handlers for newRecord button click. This function should be called on page load
 * @returns {undefined}
 */
function bindHandlersToNewRecordButton(){
    $('#newRecord').bind("click", function() {
        emptyFields();
        location.reload();
    });
}

/**
 * This passes a record object to the question selector and binds listener to the selector 
 * @param {Record} record
 * @returns {undefined}
 */
function initializeQuestionSelection(record) {
    $('.qSelect').change(function() {
        $(".optionalQ > .questionScore").slideUp().empty();
        $('.dump').empty();
        var questionid = $('input[name="qSelect"]:checked').val();
        getRecord(record, questionid);
        $('#q' + questionid + 'grade').slideDown();
    });
}

/**
 * Binds listener to the exam info selectors to submit upon change
 * @returns {undefined}
 */
function initializeExamInfoSelects() {
    $('.changer').bind("change", function() {
        var Send = new Object();
        Send.task = 'recordExamInfo';
        Send.sid = $('#sid').prop("value");
        Send.type = $(this).attr("data");
        Send.score = $(this).val();
        $('#' + Send.type).val(Send.score); //set the score in textbox
        $('#' + Send.type + 'Select').val(Send.score); //Set the select to the right score (presumably if entered in textbox)
        submitItem(Send, Send.type);
    });
}