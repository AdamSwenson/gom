<template>
    <div class="timeBox ">
        <p class="h4">Grading Time</p>
        <div class="box">
            <div v-if="isLoading"
            >
                <loading-indicator
                        :is-loading="isLoading"
                ></loading-indicator>
            </div>

            <div class="time-list"
                 v-if="! isLoading"
            >

                <stat-display>
                    <div slot="label">Elapsed</div>
                    <div slot="value">{{timeElapsed}}</div>
                </stat-display>

                <stat-display>
                    <div slot="label">Average</div>
                    <div slot="value">{{averageGradingTime}}</div>
                </stat-display>


                <stat-display>
                    <div slot="label">Remaining</div>
                    <div slot="value">{{timeRemaining}}</div>
                </stat-display>


            </div>
        </div>
    </div>

</template>

<style lang="scss">

</style>

<script>
    import * as aTypes from '../../../../store/action-types';
    import * as mTypes from '../../../../store/mutation-types';
    import Payload from '../../../../models/Payload';


    import timeRequests from '../../../../api/requests/timeRequests';
    import loadingIndicator from '../../helpers/loading-indicator.vue';
    import statDisplay from './stat-display.vue';

    export default {

        props: [
            'exam', //the exam object we are to get stats for
        ],

        components: {
            'loading-indicator': loadingIndicator,
            'stat-display': statDisplay
        },

        data: function () {
            return {
                isLoading: false,

                defaults: {}
            }
        },

        asyncComputed: {

            timeElapsedAjax: function () {
                let me = this;

                me.isLoading = true;

                let p = timeRequests.getTotalGradingTime( this.exam );

                return p.then( function ( data ) {
                    let pl = Payload.factory( {
                        mutateSilently: true,
                        obj: me.exam,
                        updateProp: 'totalGradingSeconds',
                        updateVal: data.elapsedSeconds
                    } );

                    //store the total time on the exam
                    me.$store.commit( mTypes.updateItem, pl );

                    //store the average time on the exam
                    pl.updateProp = 'averageGradingSeconds';
                    pl.updateVal = data.averageSeconds;
                    me.$store.commit( mTypes.updateItem, pl );

                    me.isLoading = false;

                } );
            },

        },


        computed: {
            item: function () {
                return this.$store.getters.currentExam;
//                return this.$store.getters.getItemBySerialNumber( this.serialNumber );
            },

            /**
             * The average number of seconds spent grading a
             * student's exam
             */
            averageGradingTime: function () {
                return this.exam ? this.formatForDisplay( this.exam.averageGradingSeconds ) : '';
            },

            /**
             * The total number of seconds spent grading
             * the exam
             */
            timeElapsed: function () {
                return this.exam ? this.formatForDisplay( this.exam.totalGradingSeconds ) : '';
            },

            /**
             * The estimated amount of seconds required to
             * finish grading all student exams
             */
            timeRemaining: function () {
                return this.exam ? this.formatForDisplay( this.exam.estimatedGradingTimeRemaining ) : '';
            },


            isExam: function () {
                return this.item ? this.item.isExam() : false;
            },

        },

        methods: {

            /**
             * Applies any formatting necessary to the value
             * so that it can be displayed
             * @param value
             * @returns {*}
             */
            formatForDisplay: function ( value ) {
                return this.convertSecondsToHHMMSS( value );
            },


            convertSecondsToHHMMSS: function ( seconds ) {
                if ( isNaN( seconds ) ) return "00:00:00";
                var date = new Date( null );
                date.setSeconds( seconds );
                if ( seconds < 3600 ) return date.toISOString().substr( 14, 5 );
                else return date.toISOString().substr( 11, 8 );
            },

        },

    }
</script>