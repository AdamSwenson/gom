/**
 * Created by adam on 3/23/16.
 */

var $ = require( 'jquery' );

/**
 * Load the Jira issue collector
 */
module.exports = function() {
// Requires jQuery!
    $.ajax({
        url: "https://merpco.atlassian.net/s/d41d8cd98f00b204e9800998ecf8427e-T/m2bzpb/b/c/0fe61a73be0a039e2366ef5aaa54d24c/_/download/batch/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector-embededjs/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector-embededjs.js?locale=en-US&collectorId=27c8650e",
        type: "get",
        cache: true,
        dataType: "script"
    });



    // $.ajax( {
    //     url: "https://45.79.99.151:8080/s/ef44af2e6d014d37d98d906837ad6da6-T/en_US74vpon/64022/3/1.4.26/_/download/batch/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector-embededjs/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector-embededjs.js?locale=en-US&collectorId=6447b52e",
    //     type: "get",
    //     cache: true,
    //     dataType: "script"
    // } );

}