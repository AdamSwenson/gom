/* 
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */

/**
 * This contains various tools for securing the application.
 * There are two formats for the json object returned by the server.
 * A status result will have the key status and contain an array with keys 'status' and 'message'.
 * A data result will have the key data and contain an arbitrary array 
 */


/**
 * This safely creates new javascript object from incoming data from php server. This
 * safely parses returned JSON data so that there is no accidental execution of received HTML code.
 * 
 * [Building secure apps, pp 330ff]
 * OWASP AJAX security guidelines reference: 
 *  * Always return JSON with an object on the outside
 *  * Always have the outside primitive be an object for JSON strings
 *  
 *  OWASP JSON object examples:
 *  * Exploitable: [{"object": "inside an array"}]
 *  * Not exploitable: {"object": "not inside an array"}
 *  * Also not exploitable: {"toplevel": [{"object": "inside an array"}]}
 *  Note: A toplevel JSON object can contain an embedded array with array syntax, but a JSON object cannot begin with array syntax.
 * 
 * @param {json} jsonObject The incoming json object to process
 * @returns {undefined}
 */
function processResponse(jsonObject) {
    try {
//    var obj = $.parseJSON(jsonObject); //parse() prevents code execution
        var obj = JSON.parse(jsonObject);
        return obj;
    } catch (e) {
        window.console.log(e);
        return false;
    }
    //second is HTML context
    //getObjectbyID().innerText() = obj.quote;//quote is html encoded and safe for html
}

/**
 * This escapes and otherwise sanitizes a html string from the server for displaying in the page
 * @param {type} htmlToInsert
 * @returns {undefined}
 */
//function makeSafeForDisplay(htmlToInsert) {
//    return htmlToInsert;
//}
//;


/**
 * If there's a nonce on the page, this takes an object that is ready to be sent to the sever
 * and adds the nonce to it
 * @param {Object} sendObject
 * @returns {unresolved}
 */
function getNonce(sendObject) {
    var nonce = $("#formToken").val();
    if (nonce) {
        sendObject.nonce = nonce;
        var pageName = $("#formToken").attr("data");
        sendObject.pageName = pageName;
        return sendObject;
    }
    else {
        return sendObject;
    }
}

function clearErrorMessage() {
    $('#ErrorMessage').empty();
}

/**
 * This parses json objects where the server should be returning a status report
 * 
 * processResponse not necessary because jquery get has been set to parse the json already
 * 
 * @param {type} incomingJSON
 * @returns {array|false} 
 */
function statusResponse(incomingJSON) {
    try {
        var incoming = incomingJSON;
        if (incoming) {
            if (incoming['status']) {
                return incoming['status'];
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    } catch (e) {
        window.console.log(e);
        return false;
    }
}

/**
 * This parses json objects where the server should be returning data
 * 
 * processResponse not necessary because jquery get has been set to parse the json already
 * 
 * @param {JSON} incomingJSON
 */
function dataResponse(incomingJSON)
{
    try {
        var incoming = incomingJSON;
//        var incoming = processResponse(incomingJSON);

        if (incoming) {
            if (incoming.hasOwnProperty('data')) {
                return incoming['data'];
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    } catch (e) {
        window.console.log(e);
        return false;
    }
}


function ResponseHandler() {
    window.console.log('rh exists');
    this.errorClass = 'errorText';
    this.defaultErrorMessage = "<p class='" + this.errorClass + "'>There was a problem with the request. Please try again. </p>";
}

/**
 * Checks what type of request came in. Returns string indicating type
 * @param {JSON} incoming
 * @returns {String}
 */
ResponseHandler.prototype.determineType = function (incoming) {
//    window.console.log('rh determineType');
    var type = 'error';
    try {
        window.console.log('determingin');
        if (incoming) {
            if (incoming['data']) {
                window.console.log('dt');
                type = 'data';
            }
            else if (incoming['status']) {
                window.console.log('st');
                type = 'status';
            }
        }
        return type;

    } catch (e) {
        errorHandler(e);
        return type;
    }
};

//ResponseHandler.prototype.process = function (incoming) {
//    window.console.log('j');
//};

ResponseHandler.prototype.process = function (incoming) {
    try {
        var incoming = incoming;
        if (incoming) {
            var t = this.determineType(incoming);
            window.console.log('determinetype', t);
            switch (t) {
                case 'data':
                    this.data = dataResponse(incoming);
                    break;
                case 'status':
                    var result = statusResponse(incoming);
                    this.status = result[0]['status'];
                    window.console.log('ResponseHandler.process', this.status);
                    this.message = result[0]['message'];
                    break;
                case 'error':
                    this.displayErrorMessage();
                    break;
                default:
                    this.displayErrorMessage();
                    break;
            }
        }

    } catch (e) {
//        errorHandler(e);
        window.console.log(e);
        return false;
    }
};

//ResponseHandler.prototype.process = function(){
//    window.console.log('jip jip jip');
//};

ResponseHandler.prototype.displayErrorMessage = function () {
    $("#errorMessage").append(this.defaultErrorMessage);
};

ResponseHandler.prototype.displayCustomErrorMessage = function (customMessage) {
    $("#errorMessage").append("<p class='" + this.errorClass + "'>" + customMessage + "</p>");
};


function errorHandler(error) {
    //this.error = error;
    window.console.log(error);

    //$.post("js_error_log.php", { 'message': error, 'window': window.location.href }, function(response){}, "JSON");

}
