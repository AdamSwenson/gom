<template>
    <div class="overall-chart">
        <div class="box">
            <!--{{score}}-->
            <!--mean : {{ itemStats ? itemStats.mean : '-' }}-->
            <!--median : {{itemStats ? itemStats.median : '-' }}-->
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
    import ItemStat from '../../../models/ItemStat';

    import {
        getItemScoreSummaryForExam,
        getItemSummaryStats,
        getTotalScoreSummaryStats
    } from '../../../api/requests/statsRequests';

    import feedbackMixin from './feedback.mixin';
    import { GoogleCharts } from 'google-charts';

    export default {
        mixins: [ feedbackMixin ],

        props: [ 'exam', 'student' ],

        components: {},

        data: function () {
            return {
                divId: 'overall-chart',
                options: {
                    title: "Total score ",

                    // width: 600,
                    // height: 400,
                    bar: { groupWidth: "65%" },
                    legend: { position: "bottom" }
                },

                defaults: {}
            }
        },

        watch: {
            preparedData: function ( newVal, oldVal ) {
                if ( newVal.length >0 ) this.load();
            },
        },

        asyncComputed: {
            totalScoreStats: function () {
                if ( ! _.isUndefined( this.exam ) && ! _.isNull( this.exam ) ){
                    let p = getTotalScoreSummaryStats( this.exam );
                    return p.then( function ( data ) {
                        return data;
                    } );
                }
            }
        },
        computed: {
            classAverage: function () {
                return this.totalScoreStats ? this.totalScoreStats.mean : null;
            },


            totalScore: function () {
                if ( _.isUndefined( this.student ) || _.isNull( this.student ) ) return null;
                return this.$store.getters[ nggTypes.getTotalScoreForStudent ]( this.student );
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

            // title: function(){}
        },

        methods: {
            load: function (  ) {
                let me = this;
                this.$nextTick( function () {
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