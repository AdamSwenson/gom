/* 
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */


module('securityTools.js processResponse()');


test('processResponse() | Happy path', function () {
    expect(1);
    var incoming = '{"data":[{"datakey1":"data item number 1","datakey2":"data item number 2"},{"datakey1":"data item number 21","datakey2":"data item number 22"}]}';
    var expected = {"data": [{"datakey1": "data item number 1", "datakey2": "data item number 2"}, {"datakey1": "data item number 21", "datakey2": "data item number 22"}]};
    var result = processResponse(incoming);
    deepEqual(result, expected, "data json properly processed");
});

module('securityTools.js statusresponse() processing functions', {
    setup: function () {
    }
});

test('statusResponse() | Happy path', function () {
    expect(1);
    var incoming = '{"status":[{"status":"success","message":"success"}]}';
    var expected = [{"status": "success", "message": "success"}];
    var result = statusResponse(JSON.parse(incoming));
    deepEqual(result, expected, "status json properly processed");
});

test('statusResponse() | Non-json object incoming', function () {
    expect(1);
    var incoming = 'cat made the json again. why?';
    var result = dataResponse(incoming);
    strictEqual(result, false, "status returns false on non-json incoming");
});

test('statusResponse() | Wrong key incoming', function () {
    expect(1);
    var testdata = '{"data":[{"datakey1":"data item number 1","datakey2":"data item number 2"},{"datakey21":"data item number 21","datakey22":"data item number 22"}]}';
    var result = statusResponse(this.testdata);
    strictEqual(result, false, "status returns false on wrong key incoming");
});

module('securityTools.js dataResponse() processing functions',
        {
            setup: function () {
                this.testdata = '{"data":[{"datakey1":"data item number 1","datakey2":"data item number 2"},{"datakey21":"data item number 21","datakey22":"data item number 22"}]}';

            }
        });
test('dataResponse() | Happy path', function () {
    expect(1);
    var expected = [{"datakey1": "data item number 1", "datakey2": "data item number 2"}, {"datakey21": "data item number 21", "datakey22": "data item number 22"}];
    var result = dataResponse(JSON.parse(this.testdata));
    deepEqual(result, expected, "data json properly processed");
});

test('dataResponse() | Non-json object incoming', function () {
    expect(1);
    var testdata = 'cat wrote program. oops';
    var result = dataResponse(testdata);
    strictEqual(false, result, "Returns false on non json");

});

test('dataResponse() | Wrong key incoming', function () {
    expect(1);
    var testdata = '{"badkey":[{"datakey1":"data item number 1","datakey2":"data item number 2"}]}';
    var result = dataResponse(testdata);
    strictEqual(false, result, "Returns false on bad key");
});


module('securityTools.js | ResponseHandler', 
{
    setup: function(){
        this.custom_message = 'custom error message';
        this.status_good = JSON.parse('{"status":[{"status":"success","message":"success"}]}');
        this.status_bad_default = JSON.parse('{"status":[{"status":"fail","message":"fail"}]}');
        this.status_bad_custom = JSON.parse('{"status":[{"status":"fail","message":"' + this.custom_message + '"}]}');
        this.testdata = JSON.parse('{"data":[{"datakey1":"data item number 1","datakey2":"data item number 2"},{"datakey21":"data item number 21","datakey22":"data item number 22"}]}');
    }
});

test('ResponseHandler.determineType() Good responses', function(){
    expect(4);
    var handler = new ResponseHandler();
    equal(handler.determineType(this.status_good), 'status');
    equal(handler.determineType(this.status_bad_default), 'status');
    equal(handler.determineType(this.status_bad_custom), 'status');
    equal(handler.determineType(this.testdata), 'data');
});


test('ResponseHandler.determineType() exception', function(){
    expect(2);
    var handler = new ResponseHandler();
    equal(handler.determineType(''),'error');
    equal(handler.determineType('{"cat":["cat":"raow"]}'), 'error');    
});

test('ResponseHandler.process() status success default', function(){
    expect(2);
    var handler = new ResponseHandler();
    handler.process(this.status_good);
    equal(handler.status, 'success');
    equal(handler.message, 'success');
    });
    
test('ResponseHandler.process() status fail default', function(){
    expect(2);
    var handler = new ResponseHandler();
    handler.process(this.status_bad_default);
    equal(handler.status, 'fail');
    equal(handler.message, 'fail');
});
    
test('ResponseHandler.process() status fail custom', function(){
    expect(2);
    var handler = new ResponseHandler();
    handler.process(this.status_bad_custom);
    equal(handler.status, 'fail');
    equal(handler.message, this.custom_message);
});