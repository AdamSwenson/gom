/**
 * Created by adam on 2/12/16.
 */

//This is the js for create_exam.blade
//var $ = require( 'jquery' );
//window.$ = $;
//var jQuery = $;
//window.jQuery = jQuery;
//require( 'bootstrap' );

var common = require( '../common.js' );

/*
 Functions used by create_exam and edit_exam pages to perform validation,
 submit the form and set the navigation buttons (prev / next) to their proper targets
 */
var examForm = require('./examForm.js');