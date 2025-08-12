<template>
    <div class="overall-chart">
        <div class="box">
            <div class="chart-area"
                 v-bind:id="divId"
            ></div>
        </div>
    </div>
</template>

<style lang="scss">

</style>

<script>
    import * as nggTypes from '../../../store/new-grading-getter-types';
    import * as gTypes from '../../../store/getter-types';
    import { getTotalScoreSummaryStats } from '../../../api/requests/statsRequests';
    // import feedbackMixin from './feedback.mixin';
    import { GoogleCharts } from 'google-charts';

    // import ItemStat from '../../../models/ItemStat';

    export default {
        // mixins: [ feedbackMixin ],

        props: [ 'exam', 'student' ],

        components: {},

        data: function () {
            return {
                divId: 'overall-chart',

                defaults: {
                    max: 200
                }
            }
        },

        watch: {
            preparedData: function ( newVal, oldVal ) {
                if ( newVal.length > 0 ) this.load();
            },
        },

        asyncComputed: {
            totalScoreStats: function () {
                //check if we don't need to do this (i.e., if we're on the static student
                //feedback page)
                if ( _.isUndefined( this.staticClassAverage ) ) {
                    if ( !_.isUndefined( this.exam ) && !_.isNull( this.exam ) ) {
                        window.console.log( 'overall-chart', 'totalScoreStats', 56, );
                        let p = getTotalScoreSummaryStats( this.exam );
                        return p.then( function ( data ) {
                            return data;
                        } );
                    }
                }
            }
        },

        computed: {
            options: function () {
                return {
                    title: "Total score ",

                    // width: 600,
                    // height: 400,
                    bar: { groupWidth: "65%" },
                    legend: { position: "bottom" },
                    vAxis: {
                        minValue: 0,
                        maxValue: this.maxPossible
                    },
                    enableInteractivity: this.showScore,
                }
            },

            classAverage: function () {
                // return 130;
                if ( !_.isUndefined( this.staticClassAverage ) ) return Math.round( Number( this.staticClassAverage ) );

                return this.totalScoreStats ? this.totalScoreStats.mean : null;
            },


            totalScore: function () {
                if ( _.isUndefined( this.student ) || _.isNull( this.student ) ) return null;
                return this.$store.getters[ nggTypes.getTotalScoreForStudent ]( this.student );
            },


            maxPossible: function () {
                let s = this.$store.getters[ gTypes.getMaxPossibleScore ];
                return !_.isUndefined( s ) ? s : this.defaults.max;

            },


            preparedData: function () {
                let dt = [];

                if ( _.isUndefined( this.totalScore ) || _.isNull( this.totalScore ) ) return dt

                if ( _.isUndefined( this.classAverage ) || _.isNull( this.classAverage ) ) return dt;

                let d = [
                    'Total score',
                    this.totalScore,
                    this.classAverage,
                ];

                dt.push( d );

                return dt;
            },

            /**
             * Whether to show the field with the xxx / yyy points.
             * If you are using a wide grade range (e.g., 400 points), students
             * can get fixated on points when what matters is the letter grade
             */
            showScore: function(){
                return false;
            },


            staticClassAverage: function () {
                let el = document.getElementById( 'averageTotalScore' );
                if ( !_.isUndefined( el ) && !_.isNull( el ) ) return el.getAttribute( 'data' );
            }

            // title: function(){}
        },

        methods: {
            load: function () {
                let me = this;
                this.$nextTick( function () {
                    //todo dev this was disabled for hotfixf18e2

                    //Load the charts library with a callback
                    GoogleCharts.load( (function () {
                        return me.draw
                    })() );
                } );
            },

            draw: function () {
                var me = this;
                //push into data table as chart is expecting
                var data = new GoogleCharts.api.visualization.DataTable();
                data.addColumn( 'string', 'type' );
                data.addColumn( 'number', 'Your Score' );
                data.addColumn( 'number', 'Class Average' );
                // data.addColumn( 'number', 'Every Class Average' );

                //Make a row for each element
                data.addRows( this.preparedData );

                var chart = new GoogleCharts.api.visualization.ColumnChart( document.getElementById( this.divId ) );
                chart.draw( data, this.options );
            }
        },


        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>