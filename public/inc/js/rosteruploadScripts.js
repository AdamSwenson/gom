/* 
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */

/**
 * This is the script file for rosterupload.php
 */


/**
 * @param {type} objectType
 * @param {type} getCommand
 * @returns {undefined}
 */
function genericGetAll(objectType, getCommand) {
    var Req = new Object();
    Req.task = getCommand;
    $.getJSON(SETUPLINK, Req, function(json) {
        $.each(json.data, function(){
            window.console.log('jip');
        if (objectType === 'Kumi') {
            $("#ExamKumiOptionTemplate").tmpl(this).appendTo(".classSelect");
            $("#ExamKumiListTemplate").tmpl(this).appendTo(".classList");
        }
        else if (objectType === 'Exam') {
            $("#ExamKumiOptionTemplate").tmpl(this).appendTo(".examSelect");
            $("#ExamKumiListTemplate").tmpl(this).appendTo(".examList");
        }
    });
    }, "JSON");
 
}