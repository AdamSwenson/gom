<template>
    <div class="exam-stats-panel">

        <h3 class="title is-3">Exam stats</h3>

        <div class="box">
            <div class="tile is-ancestor">

                <div class="tile is-vertical is-parent">

                    <div class="tile is-child box">
                        <p class="h4">Exam properties</p>
                        <div class="box">
                            <ul>
                                <li># items : {{ numberItems }}</li>
                                <li># students : {{numberStudents}} </li>
                            </ul>
                        </div>
                    </div>

                    <div class="tile is-child box">
                        <p class="h4">Counts</p>
                        <div class="box">
                            <ul>
                                <li># Graded : {{ examsGraded }}</li>
                                <li># Remaining : {{ examsRemaining }}</li>
                            </ul>
                        </div>
                    </div>

                </div>

                <div class="tile is-parent is-vertical">

                    <div class="tile is-child box">
                        <p class="h4">Total Time</p>
                        <div class="box">
                            <ul>
                                <li>Elapsed : {{ timeElapsedAjax }} seconds</li>
                                <li>Remaining : {{ timeRemaining}}</li>
                                <li>Average grading time : {{ averageGradingTime }}</li>
                            </ul>
                        </div>
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

    import timeRequests from '../../../api/requests/timeRequests';
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

                isTimeLoading : true,

                placeholders: {},
            };
        },

        asyncComputed: {

            timeElapsedAjax: function () {
                let me = this;
                me.isTimeLoading = true;

                let p = timeRequests.getTotalGradingTime(this.item);

                return p.then(function(data){
                    me.isTimeLoading = false;
                    return data.elapsedSeconds;
                });
            },

        },

        watch: {},

        computed: {
            id: function () {
                return this.item.id;
            },

            //if this is not the panel for the exam
            item: function () {
                return this.$store.getters.currentExam;

//                return this.$store.getters.getItemBySerialNumber( this.serialNumber );
            },
            averageGradingTime: function () {

            },

            timeElapsed: function () {

            },

            timeRemaining: function () {

            },

            numberItems: function () {

            },

            numberStudents: function () {

            },

            examsGraded: function () {

            },

            examsRemaining: function () {

            },

            exam: function () {
                return this.item.isExam() ? this.item : this.$store.getters.currentExam;
            },

            isExam: function () {
                return this.item ? this.item.isExam() : false;
            },


        },

        methods: {}
    }
</script>
