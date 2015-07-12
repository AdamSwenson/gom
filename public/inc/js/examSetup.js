/**
 * Created by adam on 4/5/15.
 */

/**
 * Set the input boxes from the selects
 * @param dthis
 */
function setTargets(dthis) {
    var target = $(dthis).attr('data');
    var toSet = $(dthis).val();
    $('#' + target).val(toSet);
   // window.console.log('setTargets', target, toSet);
}

/**
 * Creates an object to be sent to the server
 */
function prepare() {
    var Send = new Object;
    Send.term = $("#term").val();
    Send.year = $("#year").val();
    Send.examTopic = $("#examTopic").val();
  //  window.console.log('prepare() Send', Send);
    return Send;
}

/**
 *
 * @param selectId String id of the select to fill with options
 * @param target The value box id that will be filled
 * @param data The items with a property 'content'
 */
function fillSelects(selectId, target, data){
    $.each(data, function () {
        console.log(this.content);
        $("#" + selectId).append($("<option></option>")
                .attr("value", this.content)
                .text(this.content)
                .attr("data", target)
        );
    });
}

function bindListeners() {
    $(".newExamSelect").bind("change", function () {
        setTargets(this);
    });

    $("#createExam").bind("click", function () {
        var send = prepare();
        send.task = 'createExam';
 //       window.console.log(send);
        sendRequest(send,  $("#submitStatus"), "Exam creation");
    });
}