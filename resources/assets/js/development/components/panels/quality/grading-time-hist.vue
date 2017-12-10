<template>
    <div class="grading-time-hist">
        <div class="quality-description ">
            <p class="subtitle">Grading time histogram</p>

            <p>In many disciplines, there will tend to be a rough positive correlation between exam quality and grading
                time (i.e., better students tend to write more than less good students).</p>

            <p>However, this will not always be the case. It thus may help to look for outliers by grading time alone.
                The following chart is a simple histogram of the amount of time spent grading exams. The number of exams
                taking the amount of time a particular bin is on the vertical axis. You may want to revisit exams in the
                extreme left and right bins.</p>
        </div>

        <div class="chart-area ">
            <div id="gradingTimeHistogram"></div>
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
                    title: 'Grading times distribution',
                    vAxis: { title: 'Number of exams' },
                    hAxis: { title: 'Minutes spent grading' },
                    legend: { position: 'top' },
                },

                defaults: {}
            }
        },

        computed: {
            preparedData: function () {
//todo make sure is actually sorted properly
                var byMinutes = [];

                if ( _.isUndefined( this.qcData ) || _.isNull( this.qcData ) ) return byMinutes;

                let timesGradedOrder = this.qcData;

                for (var i = 0; i < timesGradedOrder.length; i++) {
                    var minutes = timesGradedOrder[ i ].gradingTime / 60;
                    byMinutes.push( [ minutes ] )
                }

                return byMinutes;

            }

        },

        methods: {

            /**
             * Draws a histogram of time spent grading exams
             */
            draw: function () {
                var me = this;
                var data = new GoogleCharts.api.visualization.DataTable();

                // Declare columns
                data.addColumn( 'number', 'time' );
                data.addRows( this.preparedData );

                var chart = new GoogleCharts.api.visualization.Histogram( document.getElementById( 'gradingTimeHistogram' ) );
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