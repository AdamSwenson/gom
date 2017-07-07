/**
 * Created by  adam on 2/17/16.
 */

var $ = require( 'jquery' );
window.$ = $;
require( 'bootstrap' );

var Vue = require( 'vue' );
var bootbox = require( 'bootbox' );

//Item
Vue.config.debug = true;

module.exports = function () {
    new Vue( {
            el: '#app',

            components: {
                'element-chart-buttons': require( './components/elementDistributionChartsButtons.js' )
                //'score-dist-chart': require( './components/scoreDistributionChart.js' )
            },


            data: {
                chartErrorMessage: "<p>We were unable to create a chart for this item. There probably wasn't enough data.</p> <p>If that's not the case, please report it as a possible bug.</p>",
                storage: {
                    elementScoreTables: [],
                    questionScores: []
                }
            },

            computed: {

                /**
                 * Returns Google DateTable
                 * @returns {*}
                 */
                questionScoresTable: function () {
                    return questionScoresTable;
                },

                questionScores: function () {

                    return questionScoresByQNumber
                },

                elementScoresByQENumber: function () {
                    return elementScoresByQENumber;
                },

                elementScoreTables: function () {
                    //Don't build the tables if they already exist
                    //if(this.storage.elementScoreTables.length > 0)
                    //{
                    //    return this.storage.elementScoreTables;
                    //}
//TODO Number of questions and elements should be either dynamically determined or loaded from server
                    var numQuestions = 5;
                    var numElements = 5;

                    //var questionScoresTable = google.visualization.arrayToDataTable(questionScores);
                    for ( var i = 1; numQuestions >= i; i ++ ) {
                        for ( var j = 1; numElements >= j; j ++ ) {
                            var elementScoresTable = new google.visualization.DataTable();
                            //elementScoresTable.addColumn( 'string', 'element' );
                            elementScoresTable.addColumn( 'number', 'score' );

                            var key = 'Q' + i + 'E' + j
                            if ( typeof elementScoresByQENumber[ key ] != 'undefined' ) {
                                for ( var k = 0; elementScoresByQENumber[ key ].length > k; k ++ ) {
                                    elementScoresTable.addRow( [ elementScoresByQENumber[ key ][ k ] ] );
                                }
                            } else {
                                //there are no scores defined for the element
                               // elementScoresTable.addRow( [ elementScoresByQENumber[ key ][ 0 ] ] );

                            }


                            this.storage.elementScoreTables[ key ] = elementScoresTable;
                        }
                    }
                    return this.storage.elementScoreTables;
                }
            },

            methods: {
                drawElementHistogram: function ( key, elementName ) {
                    try {
                        var options = {
                            title: key + ' ' + elementName,
                            vAxis: { title: '# students with score' },
                            hAxis: { title: 'Score' },
                            legend: { position: 'top' },
                        };

                        //push div onto page
                        var targetDiv = "<div id='elementHistWrapper" + key + "' class='elementChartWrapperDiv  col-lg-4 col-md-6 col-sm-12'>" +
                            "<p class='text-right'>" +
                            "<span class='glyphicon glyphicon-remove chartRemove'></span><span class='sr-only'>Remove</span>" +
                            "</p>" +
                            "<div id='elementHist" + key + "'></div>" +
                            "</div>";

                        //add div and chart if doesn't already exist
                        if ( ! $( "#elementHistWrapper" + key ).length ) {
                            $( "#elementChartArea" ).append( targetDiv );
                            var chart = new google.visualization.Histogram( document.getElementById( "elementHist" + key ) );
                            chart.draw( this.elementScoreTables[ key ], options );
                        }

                        //bind a listener to remove it
                        $( '.chartRemove' ).on( 'click', function () {
                            $( this ).parent().parent().remove();
                        } );
                    } catch ( e ) {
                        bootbox.alert( this.chartErrorMessage );
                    }


                },

                /**
                 * Calculates the data for the boxplot
                 * @param key
                 * @returns {DataSet}
                 */
                calculateBoxplotData: function ( key ) {
                    var me = this;
                    //questionDataSets = [];
                    var DataSet = function () {
                        this.min = 0;
                        this.max = 30;
                        this.second = 0;
                        this.third = 0;
                        this.median = 0;
                        this.mean = 0;
                    };

                    var scores = elementScoresByQENumber[ key ];

                    if ( scores.length > 0 ) {
                        scores.sort( function ( a, b ) {
                            return a - b
                        } );
                        var num = scores.length;
                        var sum = 0;

                        scores.forEach( function ( score ) {
                            sum += score;
                        } );

                        var dataSet = new DataSet();
                        dataSet.min = scores[ 0 ];
                        dataSet.max = scores[ num - 1 ];
                        dataSet.second = scores[ parseInt( num / 4 ) ];
                        dataSet.third = scores[ parseInt( num * 3 / 4 ) ];
                        var mid = parseInt( num / 2 ) - 1;
                        dataSet.median = scores[ mid ];
                        if ( num % 2 ) {
                            dataSet.median = (scores[ parseInt( mid ) ] + scores[ mid + 1 ]) / 2;
                        }
                        dataSet.mean = parseFloat( (sum / num).toFixed( 2 ) );

                        return dataSet;
                    }
                },

                /**
                 * Draws a boxplot for the given element
                 * @param key String in the format Q*E* which is the key for an element
                 * @param elementName
                 */
                drawElementBoxplot: function ( key, elementName ) {
                    try {
                        var dataSet = this.calculateBoxplotData( key );

                        //Put into expected format
                        var boxPlotData = [];
                        boxPlotData.push( [
                            elementName,
                            dataSet.min,
                            dataSet.second,
                            dataSet.third,
                            dataSet.max,
                            dataSet.median,
                            dataSet.mean
                        ] );

                        var data = google.visualization.arrayToDataTable( boxPlotData, true );

                        //push div onto page
                        var targetDiv = "<div id='elementBoxWrapper" + key + "' class='elementChartWrapperDiv col-lg-3 col-md-6 col-sm-12'>" +
                            "<p class='chartClose text-right'>" +
                            "<span class='glyphicon glyphicon-remove chartRemove'></span><span class='sr-only'>Remove</span>" +
                            "</p>" +
                            "<div id='elementBox" + key + "'></div>" +
                            "</div>";

                        //add div and chart if doesn't already exist
                        if ( ! $( "#elementBoxWrapper" + key ).length ) {
                            $( "#elementChartArea" ).append( targetDiv );

                            // Create and draw the visualization.
                            var chart = new google.visualization.ComboChart( document.getElementById( "elementBox" + key ) );
                            chart.draw( data, {
                                title: key + ' ' + elementName,
                                vAxis: { title: "Score" },
                                //hAxis: {title: elementName},
                                legend: {
                                    position: 'top'
                                    //textStyle: {
                                    //    color: 'black',
                                    //    fontSize: 14
                                    //}
                                },
                                series: {
                                    0: { type: "candlesticks", labelInLegend: 'Q2-Q3' },
                                    1: { type: "line", labelInLegend: 'median', pointSize: 10, lineWidth: 0 },
                                    2: { type: "line", labelInLegend: 'mean', pointSize: 10, lineWidth: 0, color: 'black' }
                                }
                            } );
                        }
                        //bind a listener to remove it
                        $( '.chartRemove' ).on( 'click', function () {
                            $( this ).parent().parent().remove();
                        } );
                    } catch ( e ) {
                        bootbox.alert( this.chartErrorMessage );
                    }

                }
            },

            events: {
                'element-histogram-draw': function ( sent ) {
                    console.log( 'parent element-histogram-draw', sent.elementKey );
                    this.drawElementHistogram( sent.elementKey, sent.elementName );
                },
                'element-boxplot-draw': function ( sent ) {
                    console.log( 'parent element-boxplot-draw', sent.elementKey );
                    this.drawElementBoxplot( sent.elementKey, sent.elementName );
                },
            },


            directives: {
                'chart': function () {
                    //this.storage.questionScores = new google.visualization.DataTable();
                    //this.storage.questionScores.addColumn( 'score' );
                    //this.storage.questionScores.addRows( this.parent.questionScores[ "1" ] );

                    //window.console.log('eavjs', this.storage.questionScores);
                }
            }
            ,

            ready: function () {
                $.ajaxSetup( {
                    headers: {
                        'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
                    }
                } );
                window.console.log( 'examAnalyticsVue ready' );
            }
        }
    )
    ;

}
