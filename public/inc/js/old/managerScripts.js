/**
 * Requires common.js
 */

function bindListeners() {
    $("#existingExams").bind("change", function () {
        var toSend = processSetexam(this);
        var success = function(){document.location.reload(true);};
        var failure = function(){alert("Set exam failed")};
        sendRequestCallback(toSend, success, failure);
    });

    $("#setTotalExams").bind("click", function () {
        var toSend = processSettotal(this);
        var success = function(){document.location.reload(true);};
        var failure = function(){alert("Set total exams failed")};
        sendRequestCallback(toSend, success, failure);
    });

    $(".releasedChecks").bind("click", function(){
        var toSend = processClick(this, 'release');
        if(toSend.task){
            var success = function(){
                $("#" + toSend.examID + "released").effect("shake");
            };
            var failure = function(){alert('release exam failed');};
            sendRequestCallback(toSend, success, failure);
        }
    });

    $(".lockedChecks").bind("click", function(){
        var toSend = processClick(this, 'lock');
        if(toSend.task){
            var success = function(){
                $("#" + toSend.examID + "locked").effect("shake");
            }
            var failure = function(){alert('lock exam failed');};
            sendRequestCallback(toSend, success, failure);
        }
    });
}

/**
 * Handles setting the current exam
 * @param dthis
 */
function processSetexam(dthis){
    var toSend = new Object();
    toSend.task = 'setExamID';
    toSend.examID = $("#existingExams :selected").attr("value");
    return toSend;
}

/**
 * Handles setting the total number of exams to grade
 * @param dthis
 */
function processSettotal(dthis){
    var toSend = new Object();
    toSend.totalExams = $("#totalExams").val();
    toSend.task = 'setTotalExams';
    return toSend;
}

/**
 * Handles clicks of lock and release buttons
 * @param dthis The this context from the bound event handler
 * @param type string Either 'lock' or 'release'
 */
function processClick(dthis, type){
    var toSend = new Object();
    toSend.examID = $(dthis).attr('data');
    var checked = $(dthis).prop('checked');
    switch(type){
        case 'lock':
            if(checked === true){
                toSend.task = 'lockExam';
            }else{
                toSend.task = 'unlockExam'
            }
            break;
        case 'release':
            if(checked === true){
                toSend.task = 'releaseExam';
            }else{
                toSend.task = 'unreleaseExam'
            }
            break;
    }
    return toSend;
}

/* ---------------- callbacks ------------------------ */
/**
 * Callback to run on success
 * @param toSend
 */
function setExamOnSuccess(toSend){
    $.cookie('examID', toSend.examID, {expires: 7});
    document.location.reload(true);
}

/**
 * Callback to run on failure
 * @param toSend
 */
function setExamOnFail(toSend){
    console.log("setExamOnFail", toSend);
}

function clickOnSuccess(toSend){
    console.log('success');
}

function clickOnFail(toSend){
    console.log('fail');
}

/**
 * Runs after a successful response from server for setting the
 * total number of exams for grading.
 */
function setTotalOnSuccess(toSend){
    $.cookie('totalExams', toSend.totalExams, {expires: 5});
    document.location.reload(true);
}

function setTotalOnFail(toSend){
    console.log('fail');
}