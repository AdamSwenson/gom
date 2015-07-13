/* 
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */


module('commentreleaseScripts.js clearDisplayArea', {
   setup: function(){
       $("#qunit-fixture").append("<div id='displayArea'><p>Item</p></div>");
   } 
});
test('clearDisplayArea', function(){
   expect(0); 
});

module('commentreleaseScripts.js button listeners', {
    setup: function(){
        $("#qunit-fixture").append("<input type='button' id='clearMessages' value='clear messages' />");
        $("#qunit-fixture").append("<div id='tobeCleared' class='toClear'><p>item</p></div>");
        $("#qunit-fixture").append("<div id='tobeHidden' class='startHidden'><p>item</p></div>");
    }
});
test('clearMessages', function(){
   ok($(".startHidden").is(":visible"), "test area is visible to start");
   var toBeCleared = $("#tobeCleared").children();
    ok(toBeCleared.length >0);
});