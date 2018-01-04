<template>

    <div id="scoresOrderArea">
        <div class="quality-description ">

            <p class="subtitle">Framing effects</p>
            <p>If you read several very good exams and then one average exam, the average exam may seem worse than it
                is. Or vice-versa.</p>

            <p> Each bar in the following chart represents an exam. The exams are arranged in the order they were
                graded. The first exam you graded is on the left. The last exam is on the right.</p>

            <p>Look for sudden peaks and valleys. That is, exams with scores much higher or lower than their
                predecessors. These may be worth taking a quick look at. </p>

        </div>

        <div class="chart-area ">
            <div id="scoresGradedOrderBar"></div>
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

                 options : {
                    title: "Scores by order graded",
                    height: 600,
                    bar: { groupWidth: "90%" },
                    legend: { position: "top" },
                },
                defaults: {}
            }
        },

        computed: {
            //todo make sure sorting into correct order
            preparedData: function () {
                var scoreTime = [];
                if ( _.isUndefined( this.qcData ) || _.isNull( this.qcData ) ) return scoreTime;

                for (var i = 0; i < this.qcData.length; i++) {
                    scoreTime.push( [
                        'g',
                        this.qcData[ i ].totalScore,
                        this.qcData[ i ].gradingTime
                    ] );
                }
                return scoreTime

            }
        },

        methods: {

            /**
             * Draws a column chart with columns for score and time grading following the order
             * in which exams were graded.
             */
            draw: function () {
                var me = this;

                var data = new GoogleCharts.api.visualization.DataTable();

                // Declare columns
                data.addColumn( 'string', 'Graded' );
                data.addColumn( 'number', 'score' );
                data.addColumn( 'number', 'times' );
                data.addRows( this.preparedData );

                var chart = new GoogleCharts.api.visualization.ColumnChart( document.getElementById( "scoresGradedOrderBar" ) );
                chart.draw( data, this.options );

                function clickHandler() {
                    me.chartClickHandler( chart );
                }

                GoogleCharts.api.visualization.events.addListener( chart, 'select', clickHandler );

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