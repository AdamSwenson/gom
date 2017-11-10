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

                emptyStatsObject :  {
                    kumiName: "-",
                    kumiId: "-",
                    mean: "-",
                    median: "-",
                    standardDeviation: "-",
                    maxScore: "-",
                    minScore: "-",
                    numberAnswers: "-",
                    percentile25: "-",
                    percentile75: "-",
                },

                /**
                 * Whether there are any stats for this
                 * item. Used to control what message displays
                 */
                isEmpty: true,
                loadingIndicator: " ... ",
                isLoading: false,

                isItemSummaryLoading: true,

                isExamSummaryLoading: true,

                /** Whether the raw scores are currently loading */
                isScoresLoading: false,
                isKumiStatsLoading: true,

                emptyMessage: "No scores have been recorded for this item on this exam.",
                serialNumber: _.toInteger( this.$route.params.serialNumber ),
                active: this.serialNumber,

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

                //this loads the scores into store
               //and returns a promise
                let p = statsRequests.getItemScoresForStats( this.$store, this.item );

                //thus when it is complete, we get them from the store
                return p.then( function () {
                    let stats = me.$store.getters.getStatsForItem( me.item );
                    //done loading
                    me.isScoresLoading = false;
                    return _.sortBy( stats, 'score', me.scoreSortOrder );
                } );
            },


            /**
             * Requests summarized scores for the item
             * This will include things like mean, median, sd
             */
            itemSummaryAjax: function () {
                if ( this.isExam ) return [];
                let me = this;
                me.isItemSummaryLoading = true;

                let p = statsRequests.getItemSummaryStats(this.item);

                return p.then(function(data){
                    me.isItemSummaryLoading = false;
                    return data;
                });

            },

            /**
             * Requests summarized scores for the item on the
             * current exam
             * This will include things like mean, median, sd
             * @param item
             */
            examSummaryAjax: function () {
                let me = this;
                me.isExamSummaryLoading = true;

                let p = statsRequests.getItemScoreSummaryForExam(this.exam, this.item);

                return p.then(function(data){
                    me.isExamSummaryLoading = false;
                    return data;
                });

            },

            /**
             * Requests summarized scores for the item for each
             * kumi it is associated with
             * This will include things like mean, median, sd
             * along with the kumi id and name
              * @param item
             */
            kumiSummaryAjax: function () {
                let me = this;
                me.isKumiStatsLoading = true;

                let p = statsRequests.getItemScoreSummariesByKumis(this.item);

                return p.then(function(data){
                    me.isKumiStatsLoading = false;
                    return data;
                });
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

            itemSummary: function (  ) {
                if(_.isUndefined(this.itemSummaryAjax) || this.isItemSummaryLoading)
                {
                    return this.emptyStatsObject;
                }
                return this.itemSummaryAjax;
            },

            exam: function () {
                return this.item.isExam() ? this.item : this.$store.getters.currentExam;
            },

            examSummary: function (  ) {
                if(_.isUndefined(this.examSummaryAjax)|| this.isExamSummaryLoading)
                {
                    return this.emptyStatsObject;
                }
                return this.examSummaryAjax;
            },

            kumis: function () {
                return this.$store.getters.getK
            },


            kumiSummary: function (  ) {
                if(_.isUndefined(this.kumiSummaryAjax)|| this.isKumiSummaryLoading)
                {
                    return this.emptyStatsObject;
                }
                return this.kumiSummaryAjax;
            },


            isExam: function () {
                return this.item ? this.item.isExam() : false;
            },


        },

        methods: {}
    }
</script>
