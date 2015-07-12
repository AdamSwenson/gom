/**
 * Created by adam on 4/9/15.
 *
 * This holds scripts that are shared by multiple pages
 */

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
    }
    return sendObject;
}


/**
 * Response handler for post calls
 *
 * @todo Add accordion
 * @todo Add different response based on response returned

 * @param {type} response
 * @returns {undefined}
 */
function responseHandler(response, jquerySelectorToChange, message) {
    if (response.status) {
        if (response.status.status === 'success') {
            try {
//                setAccordionCookie(COOKIE_PAGENAME);
                successHandler(jquerySelectorToChange, message);
            } catch (e) {
                window.console.log(e);
            }
//            location.reload(true);
        } else {
            failureHandler(jquerySelectorToChange, message);
        }
    }
}

function successHandler(jquerySelectorToChange, message) {
    jquerySelectorToChange.empty();
    if (jquerySelectorToChange) {
        jquerySelectorToChange.addClass('success');
    }
    if (message) {
        jquerySelectorToChange.append(message + " succeeded");
    }
}

function failureHandler(jquerySelectorToChange, message) {
    jquerySelectorToChange.empty();
    if (message) {
        jquerySelectorToChange.append(message + " failed");
//        alert("There was a problem handling your request. " + message);
    }
    if (jquerySelectorToChange) {
        jquerySelectorToChange.addClass('failure');
    }
}

function sendRequest(Request, jquerySelectorToChange, message) {
    $.post("api.php", Request, function (response) {
        responseHandler(response, jquerySelectorToChange, message);
    }, "JSON");
}

function sendRequestCallback(Request, successCallback, failureCallback) {
    $.post("api.php", Request, function (response) {
        if ((response.status && (response.status.status === 'success')) || (response.data.status && response.data.status === 'success')) {
                try {
                    successCallback();
                } catch (e) {
                    window.console.log(e);
                }
            } else {
                failureCallback();
            }
    }, "JSON");
}