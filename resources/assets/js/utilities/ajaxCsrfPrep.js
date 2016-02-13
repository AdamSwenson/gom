var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

/**
 * Sets the csrf token for ajax requests
 */
module.exports = function() {
    $.ajaxSetup( {
        headers: {
            'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
        }
    } );
}