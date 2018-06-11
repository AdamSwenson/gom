<template>
    <div class="exam-stats-panel">

        <h3 class="title is-3">Exam stats</h3>

        <div class="box">
            <div class="tile is-ancestor">

                <div class="tile is-vertical is-parent">

                    <div class="tile is-child box">
                        <exam-properties :exam="exam"></exam-properties>
                    </div>

                    <div class="countBox tile is-child box">
                        <exam-counts :exam="exam"></exam-counts>
                    </div>

                </div>

                <div class="tile is-parent is-vertical">

                    <div class="timeBox tile is-child box">
                        <time-stats :exam="item"></time-stats>
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

    import * as gTypes from '../../../store/getter-types';

    import Payload from '../../../models/Payload';

    import timeRequests from '../../../api/requests/timeRequests';
    import loadingIndicator from '../helpers/loading-indicator.vue';
    import timeStats from '../stats/time-stats.vue'
    import statsSummary from '../stats/summary-stats-display.vue'
    import examCounts from '../stats/number-graded.vue'
    import examProperties from '../stats/exam-properties.vue'

    export default {
        components: {
            'exam-counts' : examCounts,
            'exam-properties': examProperties,
            'loading-indicator': loadingIndicator,
            'stats-summary': statsSummary,
            'time-stats': timeStats
        },


        data: function () {
            return {
                placeholders: {
                    numberItems: ''
                },
            };
        },

        asyncComputed: {},

        watch: {},

        computed: {
            id: function () {
                return this.item.id;
            },

            //if this is not the panel for the exam
            item: function () {
                return this.$store.getters.rootItem;

//                return this.$store.getters.getItemBySerialNumber( this.serialNumber );
            },

            exam: function () {
                return this.item.isExam() ? this.item : this.$store.getters.rootItem;
            },

            isExam: function () {
                return this.item ? this.item.isExam() : false;
            },


        },

        methods: {}
    }
</script>
