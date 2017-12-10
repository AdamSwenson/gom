<template>
    <div id="dashboardCounts" class="">

        <!-- graded / remaining counters -->
        <p>Graded: <span id="graded">{{ gradedExams }}</span> | Remaining: <span
                id="remaining">{{ remainingExams }}</span>
        </p>


    </div>
</template>

<script>


    module.exports = {


        components: {
            FinishButton
        },

        props: [
            /** The url that the user should be redirected to
             * when they click the save and finish button*/
            'finishedLink'
        ],

        data: function () {
            return {
                store: store
            }
        },

        computed: {
            /**
             * Button will not display unless remaining is 0
             * @returns {string}
             */
            buttonStyle: function () {
                if ( this.remainingExams != 0 ) {

                    return "display:none";
                } else if ( this.remainingExams == 0 ) {
                    return '';
                }
            },
            /* --------------- # exams ------------- */
            /**
             * Number of exams already graded
             */
            gradedExams: function () {
                return this.store.getNumberGraded();
            },

            /**
             * Total number of exams to be graded
             * @returns {number|Number}
             */
            totalExams: function () {
                return this.store.getTotalExams();
            },

            /**
             * Number of exams remaining to be graded
             */
            remainingExams: function () {
                if ( (typeof this.totalExams != 'undefined') && typeof this.gradedExams != 'undefined' ) {
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