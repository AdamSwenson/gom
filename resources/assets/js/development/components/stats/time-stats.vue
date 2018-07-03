<template>
    <div class="time-stats ">
        <div class="box">
            <p class="h4">Grading Time</p>

            <div v-if="isLoading" class="loadArea"
            >
                <loading-indicator
                        :is-loading="isLoading"
                ></loading-indicator>
            </div>

            <div class="time-list"
                 v-if="showTables"
            >
                <table class="table is-narrow">

                    <stat-display-table-row>
                        <div slot="label">Elapsed</div>
                        <div slot="value">{{timeElapsed}}</div>
                    </stat-display-table-row>

                    <stat-display-table-row>
                        <div slot="label">Average</div>
                        <div slot="value">{{averageGradingTime}}</div>
                    </stat-display-table-row>

                    <stat-display-table-row>
                        <div slot="label">Remaining</div>
                        <div slot="value">{{timeRemaining}}</div>
                    </stat-display-table-row>

                </table>

            </div>


            <div class="time-list"
                 v-if="showColumns"
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
    import * as aTypes from '../../../store/action-types';
    import * as mTypes from '../../../store/mutation-types';
    import Payload from '../../../models/Payload';


    import timeRequests from '../../../api/requests/timeRequests';
    import loadingIndicator from '../helpers/loading-indicator.vue';
    import statDisplay from './stat-display-columns.vue';
    import StatDisplayTableRow from "./stat-display-table-row.vue";

    export default {

        props: [
            'exam', //the exam object we are to get stats for
        ],

        components: {
            StatDisplayTableRow,
            'loading-indicator': loadingIndicator,
            'stat-display': statDisplay
        },

        data: function () {
            return {
                isLoading: false,

                format: 'table',
                formats: [ 'columns', 'table' ],

                defaults: {}
            }
        },

        asyncComputed: {

            timeElapsedAjax: function () {
                if(_.isUndefined(this.exam) || this.exam.id === -1) return false;

                let me = this;

                me.isLoading = true;

                let p = this.getTotalGradingTime( this.exam );

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
                return this.$store.getters.rootItem;
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
            showColumns: function () {
                if ( !this.isLoading && this.format === 'columns' ) return true;
                return false;
            },
            showTables: function () {
                if ( !this.isLoading && this.format === 'table' ) return true;
                return false;
            },


        },

        methods: {
            //makes it easier to stub for testing
            ...timeRequests,

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