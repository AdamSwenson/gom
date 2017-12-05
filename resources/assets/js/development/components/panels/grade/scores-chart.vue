<template>
    <div id="scoreChart"></div>
</template>

<style lang="scss">

</style>

<script>
    import { GoogleCharts } from 'google-charts';
    import * as gTypes from '../../../../store/getter-types';

    export default {

        props: [ 'scores' ],

        components: {},

        data: function () {
            return {
                defaults: {}
            }
        },

        computed: {
            scoreChartData: function () {
                let data = [];
                data.push( [ 'Student', 'Score', { role: 'style' }, { role: 'annotation' } ] );
                let me = this;
                _.forEach( this.scores, function ( score, i ) {

                    let barColor = "00FF00";
                    // let gradeLetter = 'Q';
                    // var barColor = getColorForGrade( score );
                    var gradeLetter = me.getLetterForScore( score );
                    data.push( [ (i + 1).toString(), score, '#' + barColor, gradeLetter ] );
                } );
                return data;
            }
        },

        methods: {
            // returns hex color -- alg is arbitrary, but needs to have enough variation from one grade group to the next
            getColorForGrade: function ( score ) {
                var gradeGroup = 0;
                for (var i = 0; i < gradeCutoffs.length; i++) {
                    if ( score >= parseFloat( gradeCutoffs[ i ] ) ) {
                        gradeGroup = i;
                        break;
                    }
                }
                var c1 = "00FF00"; // base color is pure green
                var colorWidth = 4096;
                var color = (colorWidth * gradeGroup);
                var c2 = color.toString( 16 ); // amount to add to base
                return addHexColor( c1, c2, false ); // subtract 1000 hex for each grade group
            },

            // returns grade letter -- this is shoddy because it does the same loop as getColorForGrade.
            getLetterForScore: function ( score ) {
                let ga = this.$store.getters[ gTypes.getGradeForScore ]( score );
                if ( ! _.isUndefined( ga ) ) return ga.displayValue;
            },
            getLetterForGrade: function ( score ) {
                for (var i = 0; i < gradeCutoffs.length; i++) {
                    if ( score >= parseFloat( gradeCutoffs[ i ] ) ) {
                        return gradeTypes[ i ];
                    }
                }
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

            // displays the bar chart of student scores
            drawChart: function () {
                var data = GoogleCharts.api.visualization.arrayToDataTable( this.scoreChartData );

                var options = {
                    chart: { title: 'Student Grades' },
                    vAxis: { title: 'Score' },
                    hAxis: { title: 'Each bar is 1 student' },
                    chartArea: { 'width': '80%', 'height': '70%' },
                    legend: { position: 'none' },
                    animation: {
                        duration: 600,
                        startup: "true"
                    }
                };

                var chart = new GoogleCharts.api.visualization.ColumnChart( document.getElementById( 'scoreChart' ) );

                chart.draw( data, options );
            },

        },

        directives: {},

        events: {},

        mounted: function () {
            var me = this;
            // this.$nextTick( function () {
                //Load the charts library with a callback
                GoogleCharts.load( me.drawChart );
            // } );
        }
    }


</script>