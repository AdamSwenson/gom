/**
 * Created by adam on 2/15/16.
 */

//TODO Refactor to use prototype to make cleaner (e.g., so don't need a click handler and event in every method)
//TODO Make the bars change color after they are clicked.

var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

require( 'bootstrap' );

module.exports = {

    /**
     * Draws a histogram of time spent grading exams
     */
    drawTimeHistogram: function () {
        var me = this;
        var byMinutes = [];
        for ( var i = 0; i < timesGradedOrder.length; i ++ ) {
            var minutes = timesGradedOrder[ i ][ 1 ] / 60;
            byMinutes.push( [ minutes ] )
        }
        var data = new google.visualization.DataTable();

        // Declare columns
        data.addColumn( 'number', 'time' );
        data.addRows( byMinutes );

        var options = {
            title: 'Grading times distribution',
            vAxis: { title: 'Number of exams' },
            hAxis: { title: 'Minutes spent grading' },
            legend: { position: 'top' },
        };

        var chart = new google.visualization.Histogram( document.getElementById( 'gradingTimeHistogram' ) );
        chart.draw( data, options );

        function clickHandler() {
            me.chartClickHandler( chart );
        }

        google.visualization.events.addListener( chart, 'select', clickHandler );
    },

    /**
     * Draws a scatterplot of time grading vs. score with R squared value
     */
    drawTimeScoreScatter: function () {
        var me = this;
        var scoreTime = [];
        for ( var i = 0; i < scoresAndTimes.length; i ++ ) {
            scoreTime.push( [ scoresAndTimes[ i ][ 1 ], scoresAndTimes[ i ][ 2 ] ] );
        }

        var data = new google.visualization.DataTable();

        // Declare columns
        data.addColumn( 'number', 'score' );
        data.addColumn( 'number', 'Grading time' );

        data.addRows( scoreTime );

        var options = {
            title: "Scores vs. Grading time",
            width: 600,
            height: 400,
            vAxis: { title: 'Total Score' },
            hAxis: { title: 'Grading Time (seconds)' },
            trendlines: {
                0: {
                    type: 'linear',
                    color: 'green',
                    lineWidth: 3,
                    opacity: 0.3,
                    showR2: true,
                    visibleInLegend: true
                }
            },
        };
        var chart = new google.visualization.ScatterChart( document.getElementById( "timeScoreScatter" ) );
        chart.draw( data, options );

        function clickHandler() {
            me.chartClickHandler( chart );
        }

        google.visualization.events.addListener( chart, 'select', clickHandler );
    },

    /**
     * Draws a column chart with columns for score and time grading following the order
     * in which exams were graded.
     */
    drawScoreAndTimeByOrder: function () {
        var me = this;
        var data = new google.visualization.DataTable();

        // Declare columns
        data.addColumn( 'string', 'Graded' );
        data.addColumn( 'number', 'score' );
        data.addColumn( 'number', 'times' );
        data.addRows( scoresAndTimes );

        var options = {
            title: "Scores by graded order",
            height: 600,
            bar: { groupWidth: "90%" },
            legend: { position: "top" },
        };
        var chart = new google.visualization.ColumnChart( document.getElementById( "combinedTimeAndScore" ) );
        chart.draw( data, options );

        function clickHandler() {
            me.chartClickHandler( chart );
        }

        google.visualization.events.addListener( chart, 'select', clickHandler );

    },

    /**
     * Makes column chart of total scores in the order in which the exams were graded
     */
    drawScoresByOrder: function () {
        var me = this;
        var data = new google.visualization.DataTable();

        // Declare columns
        data.addColumn( 'string', 'Graded' );
        data.addColumn( 'number', 'score' );
        data.addRows( scoresGradedOrder );

        var options = {
            title: "Scores by graded order",
            width: 1000,
            height: 400,
            bar: { groupWidth: "85%" },
            vAxis: { title: 'Total Score' },
            legend: { position: "none" },
        };
        var chart = new google.visualization.ColumnChart( document.getElementById( "scoresGradedOrderBar" ) );
        chart.draw( data, options );

        function clickHandler() {
            me.chartClickHandler( chart );
        }

        google.visualization.events.addListener( chart, 'select', clickHandler );
    },

    /**
     * Draws a column chart of grading times in the order in which they were graded.
     */
    drawTimesByOrder: function () {
        var me = this;
        var data = new google.visualization.DataTable();

        // Declare columns
        data.addColumn( 'string', 'Graded' );
        data.addColumn( 'number', 'seconds' );
        data.addRows( timesGradedOrder );

        var options = {
            title: "Grading times by graded order",
            width: 600,
            height: 400,
            bar: { groupWidth: "95%" },
            vAxis: { title: 'Time Grading' },
            legend: { position: "none" },
        };
        var chart = new google.visualization.ColumnChart( document.getElementById( "timesGradedOrderBar" ) );
        chart.draw( data, options );

        function clickHandler() {
            me.chartClickHandler( chart );
        }

        google.visualization.events.addListener( chart, 'select', clickHandler );
    },


    /**
     * Adds the clicked on student to the list of students whose exams should
     * be revisited.
     * TODO Make bar change color when clicked.
     * @param chart
     */
    chartClickHandler: function ( chart ) {
        var me = this;
        var selection = chart.getSelection();
        for ( var i = 0; i < selection.length; i ++ ) {
            var item = selection[ i ];
            if ( item.row != null && item.column != null ) {
                var selectedData = scoresAndTimesAll[ item.row ];
                me.addStudentToList( selectedData[ 4 ], selectedData[ 3 ] );
                //item.row.color = 'red';
                window.console.log( 'click happened', selectedData );
            }
        }
    },

    /**
     * Appends student info to the list of students whose exams should be revisited
     * @param studentName
     * @param studentIdentifier
     */
    addStudentToList: function ( studentName, studentIdentifier ) {
        var listItem = "<li class='list-group-item'>" + studentName + " (id: " + studentIdentifier + ") [Link to comments] [Link to grading] <span class='text-right'><span class='toRemove glyphicon glyphicon-remove'></span></span></li>";
        $( "#revisitList" ).append( listItem );
        $( ".toRemove" ).on( 'click', function () {
            $( this ).parent().remove();
        } );
    },

}