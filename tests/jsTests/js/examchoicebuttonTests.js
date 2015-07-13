/* 
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */

function makeFieldsForTestValues() {
    $("#qunit-fixture").append("<input type='text' id='taskRequest' />");
    $("#qunit-fixture").append("<input type='text' id='setupRequest' />");
    $("#qunit-fixture").append("<input type='text' id='completeRequest' />");
}

function makeDocElements(){
    $("#qunit-fixture").append("<input type='checkbox' class='taskComplete' />");
    $("#qunit-fixture").append("<div class='hideOnComplete'></div>");
    $("#qunit-fixture").append("<div class='completedMessage'></div>");
}

var sendStatusChange = function(request){
        $('#taskRequest').val(request.please);
        $('#setupRequest').val(request.setupTask);
        $('#completeRequest').val(request.complete);
    };
module('submit presses', {
    setup: function () {
        makeFieldsForTestValues();
        //makebuttons();
        //bindListeners();
     },
    teardown: function () {
        $("#qunit-fixture").empty();
        //resetFieldsForTestValues();
    }
});

test('submitStatusChange task closed', function () {
    expect(3);

    var task = 'testtask';
    var state = [true, false];
    submitStatusChange(task, true);
    equal($('#taskRequest').val(), 'taskComplete');
    equal($('#setupRequest').val(), task);
    equal($('#completeRequest').val(), 'closed');
});
   
test('submitStatusChange task open', function () {
    expect(3);
    var task = 'testtask';
    submitStatusChange(task, false);
    equal($('#taskRequest').val(), 'taskComplete');
    equal($('#setupRequest').val(), task);
    equal($('#completeRequest').val(), 'open');
});

module('examchoicebutton.js setTaskStatusButton', {
    setup: function(){
        makeDocElements();
    },
    teardown: function () {
        ;
    }
});
test('setTaskStatusButton open', function(){
    expect(3);
    setTaskStatusButton('open');
    ok(!$('.taskComplete').prop('checked'));
    ok($('.hideOnComplete').is(':visible'));
    ok($('.completedMessage').is(":empty"));
});

test('setTaskStatusButton closed', function(){
    expect(3);
    setTaskStatusButton('closed');
    ok($('.taskComplete').prop('checked'));
    ok(!$('.hideOnComplete').is(':visible'));
    equal($('.completedMessage').html(), "To use this page, mark this task incomplete with the button to the right. ");
});

//CheckExamStatus---------------------------------------
module('examchoicebutton.js checkExamStatus', {
    setup: function(){
        $('#qunit-fixture').append("<input type='text' id='statusDummy' />");
        $('#qunit-fixture').append("<input type='text' id='examStatus' />");
    }
});
    
test('checkExamStatus where value set', function(){
    expect(1);
    $("#examStatus").val('test');
    ok(checkExamStatus());
});

test('checkExamStatus where value not set', function(){
    expect(1);
    ok(!checkExamStatus());
});

//Cookie tests-------------------------------
module('examchoicebutton.js Cookie setting and retrieving', {
    setup: function(){
        $('#qunit-fixture').append("<input type='text' id='currentExamID' />");
        $.cookie('examid', null);
    }, 
    teardown: function(){
        $.cookie('examid', null);
    }
});

//test('setExamCookie', function(){
//    expect(1);
//    var testExamId = Math.floor((Math.random() * 1000));
//    window.console.log(testExamId);
//    $('#currentExamID').val(testExamId);
//    setExamCookie();
//    equal($.cookie('examid'), testExamId);
//});

test('readExamCookie', function(){
    expect(1);
    var testExamId = Math.floor((Math.random() * 1000));
    window.console.log(testExamId);
    $.cookie('examid', testExamId);
    readExamCookie();
    equal($('#currentExamID').val(), testExamId);
});


