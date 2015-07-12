/* 
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */
/**
 * This handles the selector which chooses the exam on multiple pages. Also handles completion button
 * @requires $.cookie
 * @requires Global variable COOKIE_PAGENAME
 * 
 * @todo Setup callback to check for success
 * @todo Have task button marked as complete if done
 * @todo Setup to mark as incomplete
 */

//******************************************************************** EXAM CHOOSER
//Onload check if exam id is set, if not prompt to set it
function checkExamSet() {
    if (EXAMID !== '') {
        $('#currentExamID').val(EXAMID);
    } else {
        alert('Please set which exam to setup');
    }
}

//function setExamCookie(pagename) {
//    var examid = $('#currentExamID').val();
//    //$.cookie('examid', examid);
//}
//;

/**
 * Checks whether examid is set, if so sets the display field
 * @param {type} pagename
 * @returns {undefined}
 */
function readExamCookie(pagename) {
    var eid = parseInt($.cookie('examid'));
    $('#currentExamID').val(eid);
}
;

/**
 * Sets the listeners for examid setting events
 * @returns {undefined}
 */
function bindExamEventListeners() {
    $("#examTarget").bind("change", function () {
        console.log('examtarget changed');
        var currExamID = $("#examTarget :selected").attr("value");
        setExamId(currExamID);
    });

// Change the status of an exam setup task
    $('.taskComplete').bind('change', function () {
        var task = $(this).attr("id");
        var state = $(this).prop('checked');
//    setExamStatusCookie()
        submitStatusChange(task, state);
    });
}

/**
 * Called by the listener to set an exam id as the current exam
 * @param {type} examID
 * @returns {undefined}
 */
function setExamId(examID) {
    console.log(examID);
    var Send = new Object();
    Send.examID = examID;
    Send.task = 'setExamID';
    sendSetExamId(Send);
}

/**
 * Sends the new examid to the server. sets cookie on success and reloads page
 * @param {object} Send
 * @returns {undefined}
 */
function sendSetExamId(Send) {
    $.post('api.php', Send, function (response) {
        //responseHandler(response);
        if(response){
            location.reload(true);
        }

    }, "JSON");
}

//************************************************************************ TASK STATUS 
/**
 * Prepares the message to send when exam status changes
 * @param {type} task
 * @param {type} state
 * @returns {undefined}
 */
function submitStatusChange(task, state) {
    var status = '';
    (state === true ? status = 'closed' : status = 'open');
    if ((status === 'closed') || (status === 'open')) {
        var Req = {'please': 'taskComplete',
            'setupTask': task,
            'complete': status};
        sendStatusChange(Req);
    }
}

/**
 * Handles the post operation when the status changes
 * @param {type} request
 * @returns {undefined}
 */
function sendStatusChange(request) {
    $.post('api.php', request, function (response) {
        responseHandler(response);
    }, "JSON");
}

/**
 * Hides page parts and displays task complete message
 * @returns {undefined}
 */
function displayComplete(){
    $('.taskComplete').prop('checked', true);
    $('.hideOnComplete').hide();
    $('.completedMessage').append("To use this page, mark this task incomplete with the button to the right. ");
}

/**
 * Removes the stuff displayed when the page task is complete
 * @returns {undefined}
 */
function displayOpen(){
    $('.completedMessage').empty();
    $('.taskComplete').prop('checked', '');
    $('.hideOnComplete').show();
}

/**
 * Checks or unchecks the exam status button along with other display changes
 * @param {string} status
 * @returns {undefined}
 */
function setTaskStatusButton(status) {
    switch (status) {
        case 'open':
            displayOpen();
            break;
        case 'closed':
            displayComplete();
            break;
        default:
            break;
    }
}

/**
 * Checks for a value in the hidden examstatus field and acts accordingly
 * @returns boolean
 */
function checkExamStatus() {
    var examstatus = $('#examStatus').val();
    if (examstatus) {
        setTaskStatusButton(examstatus);
        return true;
    }else{
        return false;
    }
}

/**
 * Sets a cookie named 'exam_' + current examid with open or closed
 * @param {string} status String of 'open' or 'closed'
 * @param {int} examid The exam id
 * @returns {undefined}
 */
//function setExamStatusCookie(status, examid){
//    switch (status){
//        case 'open':
//            $.cookie('exam_' + examid, 'open');
//            break;
//        case 'closed':
//            $.cookie('exam_' + examid, 'closed');
//            break;
//        default:
//            break;
//    }
//}

/**
 * Reads status cookie and returns string of 'open' or 'closed'
 * @param {type} examid
 * @returns {String}
 */
//function readExamStatusCookie(examid){
//    if(examid >= 1){
//        var status = $.cookie('exam_' + examid);
//        switch(status){
//            case 'open':
//                return 'open';
//                break;
//            case 'closed':
//                return 'closed';
//                break;
//            default:
//                break;
//        }
//    }
//}