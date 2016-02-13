/**
 * This handles the forward and back nav controls.
 * This file must be included after the file which defines
 * the submitForm function.
 *
 * NOT YET READY
 *
 * TODO Sort out a common submission handler or do this via vue
 */
var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

module.exports = function(){



$("#backNavButton" ).on('click', function(){
    submitForm(backNavTarget);
});

$("#forwardNavButton" ).on('click', function(){
    submitForm(forwardNavTarget);
});
}