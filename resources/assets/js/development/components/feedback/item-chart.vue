<template>
    <div class="item-chart">
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

    import { getItemScoreSummaryForExam, getItemSummaryStats } from '../../../api/requests/statsRequests';

    import feedbackMixin from './feedback.mixin';
    import { GoogleCharts } from 'google-charts';

    export default {
        mixins: [ feedbackMixin ],

        props: [ 'exam', 'item', 'student' ],

        components: {},

        data: function () {
            return {
                options: {
                    title: "How you did on compared to the rest of the class",
                    // width: 600,
                    // height: 400,
                    bar: { groupWidth: "65%" },
                    legend: { position: "bottom" }
                },
                defaults: {}
            }
        },

        watch: {
            itemStats: function ( newVal ) {
                if ( newVal instanceof ItemStat ) {
                    var me = this;
                    this.$nextTick( function () {
                        //Load the charts library with a callback
                        GoogleCharts.load( (function () {
                            return me.draw
                        })() );
                    } );
                }
            },
            score: function ( newVal ) {
                if ( !_.isUndefined( newVal ) ) {
                    var me = this;
                    this.$nextTick( function () {
                        //Load the charts library with a callback
                        GoogleCharts.load( (function () {
                            return me.draw
                        })() );
                    } );
                }
            },
            historicalStats: function ( newVal ) {
                if ( !_.isUndefined( newVal ) ) {
                    var me = this;
                    this.$nextTick( function () {
                        //Load the charts library with a callback
                        GoogleCharts.load( (function () {
                            return me.draw
                        })() );
                    } );
                }
            }
        },

        asyncComputed: {

            itemStats: function () {
                let me = this;
                let p = this.$store.dispatch( 'loadItemScoreSummaryForExam', { item: this.item, exam: this.exam } );

                return p.then( function () {
                    return me.$store.getters.getItemStatsForExam( { exam: me.exam, item: me.item } );
                } );

            },

            historicalStats: function () {
                let p2 = getItemSummaryStats( this.item );
                p2.then( function ( data ) {
                    let s = ItemStat.factory( data );
                    return s;
                } );
            }
        },

        computed: {
            divId: function () {
                return 'scoreChart' + this.item.id;
            },

            score: function () {
                if ( this.scoreObject ) return this.scoreObject.score;
            },

            preparedData: function () {
                let dt = [];

                if ( _.isUndefined( this.scoreObject ) || _.isNull( this.scoreObject ) ) return dt

                if ( _.isUndefined( this.itemStats ) || _.isNull( this.itemStats ) ) return dt;

                // if ( _.isUndefined( this.historicalStats ) || _.isNull( this.historicalStats ) ) return dt;

                let d = [
                    this.item.name,
                    this.score,
                    this.itemStats.mean,
                    // this.historicalStats.mean
                ];
                //
                // if ( !_.isUndefined( this.historicalStats ) ) {
                //     d.push( this.historicalStats.mean );
                // }
                dt.push( d );

                return dt;
            }

        },

        methods: {
            draw: function () {
                var me = this;
                //push into data table as chart is expecting
                var data = new GoogleCharts.api.visualization.DataTable();
                data.addColumn( 'string', 'task' );
                data.addColumn( 'number', 'Your Score' );
                data.addColumn( 'number', 'Class Average' );
                // data.addColumn( 'number', 'Every Class Average' );

                //Make a row for each element
                data.addRows( this.preparedData );

                var chart = new GoogleCharts.api.visualization.ColumnChart( document.getElementById( this.divId ) );
                chart.draw( data, this.options );
            }
        },

        mounted: function () {
            // var me = this;
            // this.$nextTick( function () {
            //     //Load the charts library with a callback
            //     GoogleCharts.load( (function () {
            //         return me.draw
            //     })() );
            // } );

        }
    }
</script>