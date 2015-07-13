/* 
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */


var maxSelectorValue = 10;
var minSelectorValue = 0;
var selectorSteps = 0.25;
var goodvals = [];
for (i = minSelectorValue; i <= maxSelectorValue; i += selectorSteps) {
    goodvals.push(i);
}
/**
 * Makes fields into which the assigner dummy function will write values which can then be checked by the test
 * @returns {undefined}
 */
function makeFieldsForTestValues() {
    $("#qunit-fixture").append("<input type='text' id='itemFromAssigner' />");
    $("#qunit-fixture").append("<input type='text' id='typeFromAssigner' />");
    $("#qunit-fixture").append("<input type='text' id='classFromAssigner' />");
}

function resetFieldsForTestValues() {
    $("#typeFromAssigner").val('');
    $("#classFromAssigner").val('');
    $("#itemFromAssigner").val('');
}

/**
 * Dummy for the assigner defined in commonsetup.js
 * @param {type} item
 * @param {type} type
 * @returns {undefined}
 */
function assigner(item, type) {
    $("#typeFromAssigner").val(type);
    $("#classFromAssigner").val($(item).attr('class'));
}
/**
 * Dummy for edit definied in commonsetup.js
 * @param {type} item
 * @param {type} type
 * @returns {undefined}
 */
var edit = function(item, type) {
        $("#typeFromAssigner").val(type);
        $("#classFromAssigner").val($(item).attr('class'));
        };
/**
 * Dummy ofr makeNew defined in commonsetup.js
 * @param {type} type
 * @returns {undefined}
 */
function makeNew(type){
        $("#typeFromAssigner").val(type);
}



//___________________________________________________________ Tests ______________________________
module('commentsetupScripts.js Score order validation');
test('validateScoreOrder', function () {
    ok([5, 7], 'five is less than seven');
    equal(validateScoreOrder(7, 5), false, 'seven is not less than five');
});


module('commentsetupScripts.js  ScoreSelectMaker', {
    setup: function () {
        $('#qunit-fixture').append("<select id='testSelect' class='target'></select>");
    }
});
test('ScoreSelect.make', function () {
    var S = new ScoreSelectMaker();
    S.make('target');
    equal($('.target').attr('id'), 'testSelect', "Created select");
    var options = $('.target').children();
    $.each(options, function () {
        var optVal = $(this).val();
        var ix = goodvals.indexOf(Number(optVal));
        ok(ix >= 0);
    });
});
test('makeScoreSelects', function () {
    makeScoreSelects();
    equal($('.target').attr('id'), 'testSelect', "Created select");
    var options = $('.target').children();
    $.each(options, function () {
        var optVal = $(this).val();
        var ix = goodvals.indexOf(Number(optVal));
        ok(ix >= 0);
    });
});
test('validateScoreOrder', function () {
    var bigger = 5.5;
    var smaller = 2.2;
    equal(validateScoreOrder(smaller, bigger), true, "returns true when minscore < maxscore");
    equal(validateScoreOrder(bigger, smaller), false, "returns false when minscore > maxscore");
    equal(validateScoreOrder(bigger, bigger), true, "returns true when values are equal");
});



module('commentsetupScripts.js button actions', {
    setup: function () {
        $('#qunit-fixture').append("<div id='newCommentArea' style='display:none;'></div>");
        //   $('#newCommentArea').hide();
        $('#qunit-fixture').append("<input type='text' class='newCommentFields' value='notEmpty' />");
        var buttonids = ['newComment', 'resetNewComment', 'recordNewComment', 'commentUseButton', 'commentAssignButton', 'commentEditButton'];
        $.each(buttonids, function () {
            $("#qunit-fixture").append("<input type='button' id='" + this + "' class='" + this + "' />");
        });
        makeFieldsForTestValues();
        bindListeners();
    },
    teardown: function(){
        resetFieldsForTestValues();
    }
});
test('newComment Click', function () {
    $("#newComment").trigger('click');
    ok($('#newCommentArea').is(":visible"));
});
test('resetNewComment Click', function () {
    $('#resetNewComment').trigger('click');
    equal($('.newCommentFields').val(), '', ".newCommentFields have empty value");
}); 
test('commentUseButton Click', function(){
    expect(2);
    $('.commentUseButton').trigger('click');
    equal($('#typeFromAssigner').val(), 'comment', "correct task given to assigner");
    equal($("#classFromAssigner").val(), 'commentUseButton', "Correct item given to assigner");
});
test('commentAssignButton Click', function(){
    expect(0);
//    $('.commentAssignButton').trigger('click');
    //equal($('#typeFromAssigner').val(), 'comment', "correct task given to assigner");
//    equal($("#classFromAssigner").val(), 'commentAssignButton', "Correct item given to assigner");
});
test('editComment Click', function(){
    expect(2);
    $('.commentEditButton').trigger('click');
    equal($('#typeFromAssigner').val(),'comment', "correct task given to edit");
    equal($("#classFromAssigner").val(), "commentEditButton", "Correct item given to edit");
});
test('recordNewComment Click', function(){
    expect(1);
   $('#recordNewComment').trigger("click");
   equal($('#typeFromAssigner').val(),'comment', "correct task given to makeNew");
});