/**
 * Created by adam on 10/4/15.
 */


var $ = require( 'jquery' );

/**
 * Automatically hide non-important flash message
 */
module.exports = function() {
//Automatically hide non-important flash message
    $( 'div.alert' ).not( 'alert-important' ).delay( 3000 ).slideUp( 300 );
}
//# sourceMappingURL=commonScripts.js.map
