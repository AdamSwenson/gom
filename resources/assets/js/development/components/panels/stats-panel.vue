<template>
    <div class="panel-stats-component">

        <h3 class="title is-3">Item score stats</h3>

        <div class="box">
            <div class="tile is-ancestor" v-if="isExamSummaryLoading">
                <loading-indicator :is-loading="isExamSummaryLoading"></loading-indicator>
            </div>

            <!--<div v-else-if="isEmpty">-->
            <!--<p>{{ emptyMessage }}</p>-->
            <!--</div>-->
            <!---->

            <div v-else class="tile is-ancestor">

                <div class="tile is-4 is-vertical is-parent">
                    <div class="tile is-child box">
                        <p class="h4">Item scores on this exam</p>
                        <div class="box">

                            <ul class="stat-list">
                                <li v-for="s in scores"> {{ s.score}} </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="tile is-parent is-vertical">

                    <div class="tile is-child box">
                        <p class="h4">Current exam</p>
                        <stats-summary
                                :is-loading="isExamSummaryLoading"
                                :median="examSummary.median"
                                :mean="examSummary.mean"
                                :sd="examSummary.standardDeviation"
                                :max="examSummary.maxScore"
                                :min="examSummary.minScore"
                                :number="examSummary.numberAnswers"
                                :percentile25="examSummary.percentile25"
                                :percentile75="examSummary.percentile75"
                        ></stats-summary>
                    </div>

                    <div class="tile is-child box">
                        <p class="h4">All exams</p>
                        <stats-summary
                                :is-loading="isItemSummaryLoading"
                                :mean="itemSummary.mean"
                                :median="itemSummary.median"
                                :sd="itemSummary.standardDeviation"
                                :max="itemSummary.maxScore"
                                :min="itemSummary.minScore"
                                :number="itemSummary.numberAnswers"
                                :percentile25="itemSummary.percentile25"
                                :percentile75="itemSummary.percentile75"
                        ></stats-summary>
                    </div>

                    <div class="tile is-child box">
                        <p class="h4">By groups</p>
                        <stats-summary
                                v-for="kumi in kumiSummary"
                                v-bind:key="kumi.kumiId"
                                :name="kumi.kumiName"
                                :id="kumi.kumiId"
                                :mean="kumi.mean"
                                :median="kumi.median"
                                :sd="kumi.standardDeviation"
                                :max="kumi.maxScore"
                                :min="kumi.minScore"
                                :number="kumi.numberAnswers"
                                :percentile25="kumi.percentile25"
                                :percentile75="kumi.percentile75"
                        ></stats-summary>
                    </div>

                </div>
            </div>
        </div>
    </div>

</template>
<style>

</style>
<script>
    import * as aTypes from '../../../store/action-types';
    import * as mTypes from '../../../store/mutation-types';

    import Payload from '../../../models/Payload';

    import statsRequests from '../../../api/requests/statsRequests';
    import loadingIndicator from '../helpers/loading-indicator.vue';

    import statsSummary from './stats/stats-summary.vue'

    export default {
        components: {
            'loading-indicator': loadingIndicator,
            'stats-summary': statsSummary
        },

//        props: ['index'],

        data: function () {
            return {

                /**
                 * Whether there are any stats for this
                 * item. Used to control what message displays
                 */
                isEmpty: true,
                loadingIndicator: " ... ",
                isLoading: false,

                isItemSummaryLoading: false,

                isExamSummaryLoading: false,

                /** Whether the raw scores are currently loading */
                isScoresLoading: false,
                isKumiStatsLoading: false,
                emptyMessage: "No scores have been recorded for this item on this exam.",
                serialNumber: _.toInteger( this.$route.params.serialNumber ),
                active: this.serialNumber,

                mean: '',
                sd: '',
                min: '',
                median: '',
                max: '',
                numberAnswers: '',

                scoreSortOrder: 'desc',

                placeholders: {},
            };
        },

        asyncComputed: {

            /**
             * Retrieves the raw scores without student information
             */
            scores: function () {
                if ( this.isExam ) return [];

                let me = this;

                //display loading indicator
                me.isScoresLoading = true;

                let p = statsRequests.getItemStats( this.$store, this.item );

                return p.then( function () {
                    let stats = me.$store.getters.getStatsForItem( me.item );
                    //done loading
                    me.isScoresLoading = false;
                    return _.sortBy( stats, 'score', me.scoreSortOrder );
                } );
            },

            itemSummary: function () {
                if ( this.isExam ) return [];
                let me = this;
                me.isItemSummaryLoading = true;

                return window.axios
                    .get( 'dev/stats/summary/item/' + this.item.id )
                    .then( ( response ) => {
                        window.console.log( 'itemSummary', 69, response );
                        //done loading
                        me.isItemSummaryLoading = false;
                        return response.data;

//                        me.mean = _.round( response.data.mean, 2 );
//                        me.median = _.round( response.data.median, 2 );
//                        me.min = _.round( response.data.minScore, 2 );
//                        me.max = _.round( response.data.maxScore, 2 );
//                        me.sd = _.round( response.data.standardDeviation, 2 );
//                        me.count = response.data.numberAnswers;

                    } )
                    .catch( function ( error ) {
//                        errorHandling( error );
                    } );

            },

            /**
             * Requests summarized scores for the item on the
             * current exam
             * This will include things like mean, median, sd
             * @param item
             */
            examSummary: function () {
                let me = this;
                me.isExamSummaryLoading = true;

                return window.axios
                    .get( 'dev/stats/summary/exam/' + this.exam.id + '/item/' + this.item.id )
                    .then( ( response ) => {
                        window.console.log( 'examSummary', 173, response );
                        me.isExamSummaryLoading = false;
                        return response.data;
                    } )
                    .catch( function ( error ) {
//                        errorHandling( error );
                    } );
            },

            /**
             * Requests summarized scores for the item on the
             * given kumi
             * This will include things like mean, median, sd
             * @param item
             */
            kumiSummary: function () {
                let me = this;
                me.isKumiStatsLoading = true;
                return window.axios
                    .get( 'dev/stats/summary/kumi/item/' + this.item.id )
                    .then( ( response ) => {
                        window.console.log( 'kumi', 69, response );
                        me.isKumiStatsLoading = false;
                        return response.data;
                    } )
                    .catch( function ( error ) {
//                        errorHandling( error );
                    } );
            },

        },

        watch: {
            scores: function ( v, n ) {
                if ( !_.isUndefined( v ) ) {
                    this.isEmpty = false;
                }
            }

        },

        computed: {
            id: function () {
                return this.item.id;
            },

            //if this is not the panel for the exam
            item: function () {
                return this.$store.getters.getItemBySerialNumber( this.serialNumber );
            },

            exam: function () {
                return this.item.isExam() ? this.item : this.$store.getters.currentExam;
            },

            kumis: function () {
                return this.$store.getters.getK
            },

            isExam: function () {
                return this.item ? this.item.isExam() : false;
            },


        },

        methods: {}
    }
</script>
