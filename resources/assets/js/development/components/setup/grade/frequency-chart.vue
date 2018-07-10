<template>

    <div id="gradeFreqChart" class="frequency-chart"></div>

</template>

<style lang="scss">
    #gradeFreqChart {
        width: 450px;
        height: 220px;
    }
</style>

<script>
    import { GoogleCharts } from 'google-charts';


    export default {

        props: [ 'gradeFrequencies' ],

        components: {},

        data: function () {
            return {
                chartDivId: 'gradeFreqChart',

                chartOptions : {
                    chart: { title: 'Grade Distribution' },
                    vAxis: { title: 'Count', format: '#' },
                    hAxis: { title: 'Grade' },
                    chartArea: { 'width': '80%', 'height': '70%' },
                    legend: { position: 'none' },
                    animation: {
                        duration: 600,
                        startup: "true"
                    }
                },

                defaults: {}
            }
        },

        watch: {
          'freqChartData':function (  ) {
              this.drawChart();
          }
        },

        computed: {
            gradeAssignments: function () {
                return this.$store.getters.getGradeAssignments;
            },

            freqChartData: function () {
                if(_.isUndefined(this.gradeFrequencies)) return [];

                let me = this;
                let data = _.toPairs( this.gradeFrequencies );
                _.forEach( data, (function ( d, i ) {
                    // let barColor = "00FF00";
                    var barColor = me.getColorForGrade( d[ 0 ] );
                    d.push( barColor );
                }) );

                data.push( [ 'Grade', 'Frequency', { role: 'style' } ] );

                // now reverse the chart data so that "F" is the first column and A+ the furthest right
                data.reverse();

                return data;
            }

        },

        methods: {

// returns hex color -- alg is arbitrary, but needs to have enough variation from one grade group to the next
            getColorForGrade: function ( letterGrade ) {
                var gradeGroup = 0;
                for (var i = 0; i < this.gradeAssignments.length; i++) {
                    if ( letterGrade === this.gradeAssignments[ i ].displayValue ) {
                        gradeGroup = i;
                        break;
                    }
                }
                var c1 = "00FF00"; // base color is pure green
                var colorWidth = 4096;
                var color = (colorWidth * gradeGroup);
                var c2 = color.toString( 16 ); // amount to add to base
                return this.addHexColor( c1, c2, false ); // subtract 1000 hex for each grade group
            },

            // adds c1 to c2. if 'add' is false, values are subtracted
            addHexColor: function ( c1, c2, add ) {
                if ( add ) {
                    var hexStr = (parseInt( c1, 16 ) + parseInt( c2, 16 )).toString( 16 );
                } else {
                    var hexStr = (parseInt( c1, 16 ) - parseInt( c2, 16 )).toString( 16 );
                }
                while (hexStr.length < 6) {
                    hexStr = '0' + hexStr;
                }
                return hexStr;
            },


            // displays the grade frequency chart
            drawChart: function () {
                if(_.isUndefined(GoogleCharts.api)) return false;

                var data = GoogleCharts.api.visualization.arrayToDataTable( this.freqChartData );

                /**
                 * The chart drawing object
                 *
                 * For some reason, probably related to how this.el and this.$el work,
                 * instantiating it like this:
                 *      var chart = new GoogleCharts.api.visualization.ColumnChart( this.$el )
                 * seemed to cause harmless but console cluttering error messages. However,
                 * the problem briefly reappeared and disappeared while this was changed. So may
                 * not have been the cause
                 *
                 * @type {google.visualization.ColumnChart}
                 */
                var chart = new GoogleCharts.api.visualization.ColumnChart( document.getElementById( 'gradeFreqChart' ) );

                chart.draw( data, this.chartOptions );
            },

        },

        directives: {},

        events: {},

        mounted: function () {
            var me = this;
            this.$nextTick( function () {
                //Load the charts library with a callback
                GoogleCharts.load( (function(){return me.drawChart})() );
            } );

        }
    }
</script>