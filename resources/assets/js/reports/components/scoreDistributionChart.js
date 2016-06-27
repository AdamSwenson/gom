/**
 * Created by adam on 2/17/16.
 */
//var $ = require('jquery');
//window.$ = $;
//google.load( "visualization", "1", { packages: [ "corechart" ] } );

module.exports = {

    template: require( '../templates/score-distribution-chart.template.html' ),

    props: [
        'data-key',
        'item-type',
        'score-data',
        'chart-title'
    ],

    data: function () {
        return {
            storage: {
                data: null
            }
        };
    },

    computed: {
        data: {
            get: function () {
                return this.$parent.questionScoreTable;
                //if ( this.storage.data === null ) {
                //    this.prepareData();
                //}
                //window.console.log('get data', this.storage.data);
                //return this.storage.data;
            }
        },

        //google: function(){
        //    return google.load( "visualization", "1", { packages: [ "corechart" ] } );
        //}

    },

    methods: {
        prepareData: function () {
            this.storage.data = new google.visualization.DataTable();
            // Declare columns
            this.storage.data.addColumn( 'score' );

            switch ( this.itemType ) {
                case 'question' :
                    //fill w data from parent
                    this.storage.data.addRows( this.$parent.questionScores[ this.dataKey ] );
                    break;
                case 'element':
                    this.storage.data.addRows( this.$parent.questionScores[ this.dataKey ] );
                    break;
                default:
                    window.console.log( 'error loading data' );
            }
        },

        plotChart: function () {
            var options = {
                title: this.chartTitle,
                vAxis: { title: 'Number with score' },
                hAxis: { title: 'Score' },
//                legend: { position: 'top' },
            };
            return this.data;
//            var chart = new google.visualization.Histogram( document.getElementById( this.el ) );
//            chart.draw( this.data, options );

        }
    },

    directives: {
        chart: function () {
            var options = {
                //title: this.chartTitle,
                vAxis: { title: 'Number with score' },
                hAxis: { title: 'Score' },
//                legend: { position: 'top' },
            };
            var chart = new google.visualization.Histogram( document.getElementById( this.el ) );
            chart.draw( this.data, options );

            window.console.log( 'dir' );
        }
    },

    ready: function () {
//this.prepareData();

        //this.plotChart();
    }
};