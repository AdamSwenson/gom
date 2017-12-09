<template xmlns="http://www.w3.org/1999/html">

    <div id="timeScoreScatterArea">
        <div class="quality-description ">
            <p class="h3">Grading time</p>
            <p>To help keep you motivated, the gradeomatic recorded how long you spent grading each exam1. You
                can
                use this data to help with quality control.</p>
            <p>For example, you might have spent twice as long on one B- exam1 than on other B- exams because you
                were tired or losing focus on the task. Similarly, spending a lot less time on an exam1 might be
                a
                sign that you were rushing.</p>
            <p>The following chart plots the time spent grading each exam1 against it's total score. You might
                want
                to pay particular attention to outliers in the upper left quadrent (high score; graded fast) and
                lower right quadrent (low score; graded slow).</p>

        </div>

        <div class="chart-area level">
            <div class="level-item">
                <div id="timeScoreScatter"></div>
            </div>
        </div>

    </div>


</template>

<style lang="scss">

</style>

<script>
    import { GoogleCharts } from 'google-charts';

    export default {

        props: [ 'qcData' ],

        components: {},

        data: function () {
            return {
                defaults: {}
            }
        },

        computed: {
            preparedData: function () {
                let scoreTime = [];

                if ( _.isUndefined( this.qcData ) ) return scoreTime;

                let scoresAndTimes = this.qcData;

                for (let i = 0; i < scoresAndTimes.length; i++) {
                    scoreTime.push( [
                        scoresAndTimes[ i ].totalScore,
                        scoresAndTimes[ i ].gradingTime
                    ] );
                }
                return scoreTime;

            }
        },

        methods: {

            /**
             * Draws a scatterplot of time grading vs. score with R squared value
             */
            draw: function () {
                let scoresAndTimes = this.qcData;
                var me = this;
                var scoreTime = [];
                for (var i = 0; i < scoresAndTimes.length; i++) {
                    scoreTime.push( [
                        scoresAndTimes[ i ].totalScore,
                        scoresAndTimes[ i ].gradingTime
                    ] );
                }

                var data = new GoogleCharts.api.visualization.DataTable();

                // Declare columns
                data.addColumn( 'number', 'score' );
                data.addColumn( 'number', 'Grading time' );

                data.addRows( this.preparedData );

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
                var chart = new GoogleCharts.api.visualization.ScatterChart( document.getElementById( "timeScoreScatter" ) );
                chart.draw( data, options );

                function clickHandler() {
                    me.chartClickHandler( chart );
                }

                GoogleCharts.api.visualization.events.addListener( chart, 'select', clickHandler );
            },

        },

        directives: {},

        events: {},

        mounted: function () {
            var me = this;
            this.$nextTick( function () {
                //Load the charts library with a callback
                GoogleCharts.load( (function () {
                    return me.draw
                })() );
            } );

        }
    }
</script>