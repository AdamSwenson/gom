<template>
    <div id="dashboardCounts" class="">
        <!-- graded / remaining counters -->
        <p>Graded: <span id="graded">{{ gradedExams }}</span> | Remaining: <span
                id="remaining">{{ remainingExams }}</span>
        </p>

    </div>
</template>

<script>
    import * as gTypes from '../../../../store/getter-types';


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
                return this.$store.getters[ gTypes.getNumberGraded ];
            },

            /**
             * Total number of exams to be graded
             * @returns {number|Number}
             */
            totalExams: function () {
                return this.$store.getters[ gTypes.getTotalNumberOfExamsToGrade ];
            },

            /**
             * Number of exams remaining to be graded
             */
            remainingExams: function () {
                if ( ! _.isUndefined(this.totalExams) && _.isUndefined( this.gradedExams) ) {
                    let remaining = this.totalExams - this.gradedExams;
                    return remaining;
                }
                return '';
            },

        },

        methods: {},

        directives: {}
    };
</script>