<template xmlns="http://www.w3.org/1999/html">

    <div id="timeScoreScatterArea" class="time-score-scatter">
        <div class="quality-description ">
            <p class="subtitle">Time - score scatterplot</p>
            <p>To help keep you motivated, the gradeomatic recorded how long you spent grading each exam. You can use
                this data to help with quality control.</p>
            <p>For example, you might have spent twice as long on one B- exam than on other B- exams because you were
                tired or losing focus on the task. Similarly, spending a lot less time on an exam might be a sign that
                you were rushing.</p>
            <p>The following chart plots the time spent grading each exam against it's total score. You might want to
                pay particular attention to outliers in the upper left quadrant (high score; graded fast) and lower
                right quadrant (low score; graded slow).</p>
        </div>

        <div class="chart-area ">
            <div id="timeScoreScatter"></div>
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
                options: {
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
                },
                defaults: {}
            }
        },

        computed: {
            preparedData: function () {
                let scoreTime = [];

                if ( _.isUndefined( this.qcData ) || _.isNull( this.qcData ) ) return scoreTime;

                for (let i = 0; i < this.qcData.length; i++) {
                    scoreTime.push( [
                        this.qcData[ i ].totalScore,
                        this.qcData[ i ].gradingTime
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
                var me = this;

                var data = new GoogleCharts.api.visualization.DataTable();

                // Declare columns
                data.addColumn( 'number', 'score' );
                data.addColumn( 'number', 'Grading time' );

                data.addRows( this.preparedData );

                var chart = new GoogleCharts.api.visualization.ScatterChart( document.getElementById( "timeScoreScatter" ) );
                chart.draw( data, this.options );

                function clickHandler() {
                    me.chartClickHandler( chart );
                }

                GoogleCharts.api.visualization.events.addListener( chart, 'select', clickHandler );
            },

            chartClickHandler: function ( chart ) {
                let selection = chart.getSelection();
                let rowNum = selection[ 0 ].row;
                if ( !_.isUndefined( this.qcData ) ) {
                    let selectedData = this.qcData[ rowNum ];
                    // window.console.log( 'time-score-scatter', 'chartClickHandler', 128, selectedData);
                    return this.$emit( 'chart-clicked', selectedData );
                }
            }
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