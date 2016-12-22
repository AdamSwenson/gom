/**
 * Created by adam on 3/2/16.
 */

var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

require( 'bootstrap' );

var common = require( '../common.js' );

//set active set of links as scroll
$('body').scrollspy({
    target: '.docs-sidebar',
    offset: 40
});

$(document).ready(function () {
    $('figure').on('click', function () {
        var src = $("img", this).attr('src');
        var img = '<images src="' + src + '" class="images-responsive"/>';
        $('#myModal').modal();
        $('#myModal').on('shown.bs.modal', function () {
            $('#myModal .modal-body').html(img);
        });
        $('#myModal').on('hidden.bs.modal', function () {
            $('#myModal .modal-body').html('');
        });
    });
})