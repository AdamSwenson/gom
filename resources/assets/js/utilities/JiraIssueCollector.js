/**
 * Created by adam on 3/23/16.
 */

var $ = require( 'jquery' );

/**
 * Load the Jira issue collector
 */
module.exports = function() {
// Requires jQuery!
    jQuery.ajax({
        url: "https://merpco.atlassian.net/s/d41d8cd98f00b204e9800998ecf8427e-T/wd7m1w/b/c/3d70dff4c40bd20e976d5936642e2171/_/download/batch/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector-embededjs/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector-embededjs.js?locale=en-US&collectorId=27c8650e",
        type: "get",
        cache: true,
        dataType: "script"
    });

}