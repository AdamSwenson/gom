<template>
    <!--v-show="show"-->
    <div

         class="item-chart">
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
                show: false,

                defaults: {
                    options: {
                        // width: 600,
                        // height: 400,
                        bar: { groupWidth: "65%" },
                        legend: { position: "bottom" },
                        title: "How you did"
                    },
                }
            }
        },

        watch: {
            // itemStats: function ( newVal ) {
            //     if ( newVal instanceof ItemStat ) {
            //         var me = this;
            //         this.$nextTick( function () {
            //             //Load the charts library with a callback
            //             GoogleCharts.load( (function () {
            //                 return me.draw
            //             })() );
            //         } );
            //     }
            // },
            preparedData: function ( newVal ) {
                if ( !_.isUndefined( newVal ) && newVal.length > 0 ) {
                    var me = this;
                    this.$nextTick( function () {
                        //Load the charts library with a callback
                        GoogleCharts.load( (function () {
                            return me.draw
                        })() );
                    } );
                    me.show = true;
                    me.$emit('show-area')
                }
            },

            // historicalStats: function ( newVal ) {
            //     if ( !_.isUndefined( newVal ) ) {
            //         var me = this;
            //         this.$nextTick( function () {
            //             //Load the charts library with a callback
            //             GoogleCharts.load( (function () {
            //                 return me.draw
            //             })() );
            //         } );
            //     }
            // }
        },

        asyncComputed: {
            // todo renable once figure out loop
            childItemStatsObjects: function () {
                let me = this;
                let s = [];
// //
                //check if we don't need to do this (i.e., if we're on the static student
                //feedback page)
                // if ( _.isUndefined( this.childItemStatsObjects )) {

                    let itemChildren = this.$store.getters.getItemChildren( this.item );
                    if ( _.isUndefined( itemChildren ) || _.isNull( itemChildren ) || itemChildren.length === 0 ) return s;
                    // let p = me.$store.dispatch( 'loadItemScoreSummaryForExamFromPageJson', { exam: me.exam } );
                    // p.then( function () {
// //     _.forEach(this.itemChildren, function(item){
// //         s.push( me.$store.getters.getItemStatsForExam( { exam: me.exam, item: item } ) );
// //
// //     });
//
// // });
                    _.forEach( itemChildren, function ( item ) {
//                     window.console.log( 'item-chart', 'jjj', 95, item.id);
//                 //     me.$store.dispatch( 'loadItemScoreSummaryForExam', { item: item, exam: me.exam } )
//                 //         .then( function () {
                        s.push( me.$store.getters.getItemStatsForExam( { exam: me.exam, item: item } ) );
                    } );
//                 //
//                 } );
//
                    return s;
                // }
            },

            childItemScoreObjects: function () {
                let me = this;
                let s = [];

                if ( _.isUndefined( this.itemChildren ) || _.isNull( this.itemChildren ) || this.itemChildren.length === 0 ) return s;
                if ( !this.isReady() ) return s;

                _.forEach( this.itemChildren, function ( item ) {

                    let childScoreObject = me.$store.getters[ nggTypes.getItemScoreObject ]( {
                        item: item,
                        student: me.student
                    } );
                    s.push( childScoreObject );
                } );
                return s;
            },


            preparedData: function () {
                let dt = [];

                if ( _.isUndefined( this.itemChildren ) || _.isNull( this.itemChildren ) || this.itemChildren.length === 0 ) return dt
                if ( _.isUndefined( this.childItemStatsObjects ) || _.isNull( this.childItemStatsObjects ) || this.childItemStatsObjects.length === 0 ) return dt

                if ( !this.isReady() ) return dt;

                //Add the parent item
                dt.push( this.makeChartRow( this.item, this.scoreObject, this.itemStats ) );

                let me = this;
                //add all the children
                for (let i = 0; i < this.itemChildren.length; i++) {
                    let childItem = this.itemChildren[ i ];
                    let childScore = this.childItemScoreObjects[ i ];
                    let childStats = this.childItemStatsObjects[ i ];

                    dt.push( me.makeChartRow( childItem, childScore, childStats ) );
                }

                return dt;

            },

            itemStats: function () {
                let me = this;

                // let p = this.$store.dispatch( 'loadItemScoreSummaryForExamFromPageJson');
                // let p = this.$store.dispatch( 'loadItemScoreSummaryForExam', { item: this.item, exam: this.exam } );

                // return p.then( function () {
                    let d = me.$store.getters.getItemStatsForExam( { exam: me.exam, item: me.item } );
                // return _.isUndefined(d) ? d : [];
                    // } );
                return d;

            },

            historicalStats: function () {
                //don't query the server if we're on the static student feedback page
                if(! _.isUndefined(window.isStatic) && window.isStatic) return [];

                let p2 = getItemSummaryStats( this.item );
                p2.then( function ( data ) {
                    let s = ItemStat.factory( data );
                    return s;
                } );
            },


            // show: function(){
            //     return this.preparedData.length > 0 ; //! _.isUndefined(this.score);
            // }

        },

        computed: {

            divId: function () {
                if ( this.item ) return 'scoreChart' + this.item.id;
            },

            score: function () {
                if ( this.scoreObject ) return this.scoreObject.score;
            },

            options: function () {
                let opts = this.defaults.options;
                opts.title = this.itemName;
                return opts;
            },

        },

        methods: {
            makeChartRow: function ( item, scoreObject, statsObject ) {
                return [
                    item.name,
                    (!_.isUndefined( scoreObject ) && !_.isNull( scoreObject )) ? scoreObject.score : null,
                    (!_.isUndefined( statsObject ) && !_.isNull( statsObject )) ? statsObject.mean : null
                    // this.historicalStats.mean
                ];
            },


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

            // }
            //     //Load the charts library with a callback
            //     GoogleCharts.load( (function () {
            //         return me.draw
            //     })() );
            // } );

        }
    }
</script>