<template>
    <div class="item-summary-stats"
         v-bind:class="styling"
    >
        <p class="h4">{{ title }}</p>

        <div class="box">
            <div v-if="isLoading"
            >
                <loading-indicator
                        :is-loading="isLoading"
                ></loading-indicator>
            </div>

            <div v-if=" ! isLoading ">
                <div v-if="scope === 'kumi'">
                    <div v-for="kumi in summary"
                         v-bind:key="kumi.kumiId"
                    >
                        <p class="h4">{{ kumi.kumiName }}</p>

                        <div class="box">
                            <stats-summary
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

                <div v-else>
                    <stats-summary
                            :median="summary.median"
                            :mean="summary.mean"
                            :sd="summary.standardDeviation"
                            :max="summary.maxScore"
                            :min="summary.minScore"
                            :number="summary.numberAnswers"
                            :percentile25="summary.percentile25"
                            :percentile75="summary.percentile75"
                    ></stats-summary>
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

    import statsSummary from './summary-stats-display.vue'

    export default {
        components: {
            'loading-indicator': loadingIndicator,
            'stats-summary': statsSummary
        },

        props: [
            'exam', //the exam object we are to get stats for
            'item', //the item object
            'scope' //One of:  'exam', 'all', 'kumi
        ],

        data: function () {
            return {

                emptyStatsObject: {
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

                /** The name, id, or class which identifies the component.
                 * Keys are potential values of scope
                 */
                identifier: {
                    'all': 'all-exam-summary',
                    'exam': 'current-exam-summary'
                },

                /** Controls whether the loading indicator or content displays */
                isLoading: false,

                /** Display text for title. Keys are potential values of scope */
                titles: {
                    'all': "All exams",
                    'exam': "Current exam",
                    'kumi': "By groups"
                },

            };
        },

        asyncComputed: {

            /**
             * Requests summarized scores for the item on the
             * current exam
             * This will include things like mean, median, sd
             * @param item
             */
            summaryAjax: function () {
                let me = this;
                me.isLoading = true;

                let p;

                switch ( this.scope ) {
                    case 'all':
                        p = this.getItemSummaryStats( this.item );
                        break;
                    case 'exam':
                        p = this.getItemScoreSummaryForExam( this.exam, this.item );
                        break;
                    case 'kumi':
                        p = this.getItemScoreSummariesByKumis( this.item );
                        break;
                }

                return p.then( function ( data ) {
                    me.isLoading = false;
                    return data;
                } );

            },

        },

        computed: {
            title: function () {
                return this.titles[ this.scope ];
            },

            name: function () {
                return this.identifier[ this.scope ];
            },

            styling: function () {
                return this.identifier[ this.scope ];
            },


            /**
             * The summary statistics as an object
             */
            summary: function () {
                if ( _.isUndefined( this.summaryAjax ) || this.isLoading ) {
                    return this.emptyStatsObject;
                }
                return this.summaryAjax;
            },


        },

        methods: {
            /**
             * This exposes requests for score summary statistics.
             * The returned data will include things like mean, median, sd
             *
             * The methods this exposes include:
             *      getItemSummaryStats
             *      getItemScoreSummaryForExam
             *      getItemScoreSummariesByKumis
             */
            ...statsRequests

        },

        directives: {},

        events: {},

    };
</script>