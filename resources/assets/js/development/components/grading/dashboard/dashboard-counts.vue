<template>
    <!-- graded / remaining counters -->
    <p id="dashboardCounts"
       class="dashboard-counts"
    >
        <span class="progress-label">Graded:</span> <span id="graded">{{ gradedExams }}</span> | <span class="progress-label">Remaining:</span>
        <span id="remaining">{{ remainingExams }}</span>
    </p>
</template>

<style lang="scss">
    #dashboardCounts {
        .progress-label {
            font-weight: bold;
        }
    }
</style>

<script>
    import * as gTypes from '../../../../store/getter-types';
    import * as nggTypes from '../../../../store/new-grading-getter-types';

    module.exports = {

        components: {},

        props: [
            /** The url that the user should be redirected to
             * when they click the save and finish button*/
            'finishedLink'
        ],

        data: function () {
            return {}
        },

        computed: {

            /* --------------- # exams ------------- */
            /**
             * Number of exams already graded
             */
            gradedExams: function () {
                let n = this.$store.getters[ nggTypes.getNumberGraded ];
                return !_.isUndefined( n ) ? n : '';
            },

            /**
             * Total number of exams to be graded
             * @returns {number|Number}
             */
            totalExams: function () {
                let n = this.$store.getters[ nggTypes.getTotalExams ];
                return !_.isUndefined( n ) ? n : '';
            },

            /**
             * Number of exams remaining to be graded
             */
            remainingExams: function () {
                let n = this.$store.getters[ nggTypes.getNumberExamsRemaining ];
                return !_.isUndefined( n ) ? n : '';

            },

        },

        methods: {},

        directives: {}
    };
</script>