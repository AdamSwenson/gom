var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

//require( 'jquery-ui' );
//require( 'bootstrap' );
//
//var DataTable = require( 'datatables.net-bs' )( window, $ );
//var buttons = require( 'datatables.net-buttons-bs' )( window, $ );
(function(){
var common = require( '../common.js' );

//google.load( "visualization", "1", { packages: [ "corechart" ] } );

var questionScoresBoxPlot = require('./components/questionScoreBoxPlots.js');
var scoreTables = require('./components/scoreTables.js');


function drawCharts() {
    questionScoresBoxPlot.calculateDataSets();
    questionScoresBoxPlot.drawBoxPlots();
    var distributionCharts = require('./examAnalyticsVue.js')();
}
    $("#boxplotHowTo").on('click', function(){
       questionScoresBoxPlot.howToReadBoxPlot();
    });

// function howToReadBoxPlot() {
//     showMessage( '<p style="text-align: justify;">How to Read - Box Plot', 'In this graph, each set of question scores is represented by a box with lines. ' +
//         'The bottom line indicates the lowest quartile (25%) of scores, while the box ' +
//         'displays the second and third quartiles (25%-75%). The top line shows the range of the top ' +
//         '25% of scores. Additional dots show the mean and median score for the question.</p>' );
// }

google.setOnLoadCallback( drawCharts );

})()