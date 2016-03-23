/**
 * Created by adam on 2/12/16.
 */

var $ = require( 'jquery' );

var aj = require('./utilities/ajaxCsrfPrep.js')();
var navBar = require( './utilities/navbar.js' )();
var flash = require( './utilities/flashMessageHandling.js' )();
var jira = require('./utilities/JiraIssueCollector.js')();