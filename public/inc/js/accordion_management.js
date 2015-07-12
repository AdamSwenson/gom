/* 
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */

/**
 * This contains scripts for storing which panel is open in a cookie and then reopening the page to the appropriate accordion tab.
 *  Should be called in Call this in a callback
 * @requires Requires j cookie to be loaded
 * @requires Requires that the accordion be in a div with the class 'accordion'
 */


/**
 *  This detects which which panel is open and stores it in a  cookie. Should be used as a callback in a response handler before page reloads.
 *  Should be called in Call this in a callback
 * @param {string} pageName The name of the page to add to the cookie
 * @returns {undefined}
 */
function setAccordionCookie(pageName) {
    var activepanel = parseInt($(".accordion").accordion("option", "active"));
    $.cookie(pageName + '_activePanel', activepanel);
};

/**
 * This checks the cookie for which panel should be open, and opens it. Should be called on page load
 * @param {string} pageName The name of the page to look for in the cookie
 * @returns {undefined}
 */
function openPanel(pageName) {
    try {
        var storedpanel = parseInt($.cookie(pageName + '_activePanel'));
        if (storedpanel >= 0) {
            //open the stored panel
            $('.accordion').accordion({
                collapsible: true,
                heightStyle: 'content',
                active: storedpanel
            });
        }
        else {
            $('.accordion').accordion({
                collapsible: true,
                heightStyle: 'content',
                active: 0
            });

        }
    } catch (err) {
        //Default to just setting the accordion
        $('.accordion').accordion({
            collapsible: true,
            heightStyle: 'content'
        });
    }
};