/**
 * The master javascript file for quality_control.blade
 * Created by adam on 2/15/16.
 */

var common = require( '../common.js' );

google.load( "visualization", "1", { packages: [ "corechart" ] } );

var charts = require('./components/qualityCharts.js');

google.setOnLoadCallback( drawCharts );

function drawCharts() {
    charts.drawScoresByOrder();
    charts.drawTimeHistogram();
    charts.drawTimeScoreScatter();
    //drawTimesByOrder();
    //drawScoreAndTimeByOrder();
}


