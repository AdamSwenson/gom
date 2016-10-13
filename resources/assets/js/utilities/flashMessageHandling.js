/**
 * Created by adam on 10/4/15.
 */


var $ = require( 'jquery' );
var delayTime = 5000;
/**
 * Automatically hide non-important flash message
 */
module.exports = function() {
//Automatically hide non-important flash message
    $( 'div.alert' ).not( '.alert-important' ).delay( delayTime).slideUp( 300 );
}