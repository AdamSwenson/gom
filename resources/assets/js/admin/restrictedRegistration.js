/**
 * Created by adam on 6/30/16.
 */

var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;
require( 'bootstrap' );

var common = require( '../common.js' );

(function () {
    $( document ).ready( function () {
        $( '#institutionList li' ).bind( 'click', function () {
            $( '#institutionType' ).val( $( this ).text() );
            var $institution = $( '#institutionSelect' );
            var $icon = $institution.find( 'span' );
            $institution.text( $( this ).text() );
            $institution.append( " " );
            $institution.append( $icon );
        } );
   
    } );
})()