<template>
    <div class="number-graded">
        <div class="box">

            <p class="h4">Grading Progress</p>
            <div v-if="isLoading" class="loadingArea"
            >
                <loading-indicator
                        :is-loading="isLoading"
                ></loading-indicator>
            </div>

            <div class="number-graded-list"
                 v-if="showTables">
                <table class="table is-narrow">

                    <stat-display-table-row>
                        <div slot="label">To grade</div>
                        <div slot="value">{{totalExams}}</div>
                    </stat-display-table-row>

                    <stat-display-table-row>
                        <div slot="label">Graded</div>
                        <div slot="value">{{examsGraded}}</div>
                    </stat-display-table-row>

                    <stat-display-table-row>
                        <div slot="label">Remaining</div>
                        <div slot="value">{{examsRemaining}}</div>
                    </stat-display-table-row>

                </table>

            </div>


            <div class="number-graded-list"
                 v-if="showColumns"
            >

                <stat-display>
                    <div slot="label">To grade</div>
                    <div slot="value">{{totalExams}}</div>
                </stat-display>

                <stat-display>
                    <div slot="label">Graded</div>
                    <div slot="value">{{examsGraded}}</div>
                </stat-display>

                <stat-display>
                    <div slot="label">Remaining</div>
                    <div slot="value">{{examsRemaining}}</div>
                </stat-display>

            </div>
        </div>

    </div>

</template>

<style lang="scss">
    .number-graded {

    }
</style>


<script>
    import * as aTypes from '../../../store/action-types';
    import * as mTypes from '../../../store/mutation-types';

    import * as ngaTypes from '../../../store/new-grading-action-types';
    import Payload from '../../../models/Payload';

    import loadingIndicator from '../helpers/loading-indicator.vue';
    import statDisplay from './stat-display-columns.vue';
    import StatDisplayTableRow from "./stat-display-table-row.vue";

    import progressRequests from '../../../api/requests/progressRequests';

    export default {

        props: [
            'exam'
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

            examCountsAjax: function () {
                if ( _.isUndefined( this.exam ) ) return false;

                let me = this;

                //This will update the values stored on the exam object
                //thus the exam object need be an async computed property
                let p = me.$store.dispatch( ngaTypes.loadGradingProgress, me.exam );
                return p.then( function () {
                     } );

                //
                // let me = this;
                // return new Promise( function ( resolve, reject ) {
                //     //if we don't have an exam, we can't do anything
                //     if ( _.isUndefined( me.exam ) || me.exam.id === -1 ) {
                //         reject();
                //     }
                //
                //     me.isLoading = true;
                //
                //     me.
                //
                //     //request the data from the server
                //     let p = progressRequests.getGradingProgressForExam( me.exam );
                //     p.then( function ( data ) {
                //
                //         window.console.log( 'number-graded', 'res', 113, data );
                //         let pl = Payload.factory( {
                //             mutateSilently: true,
                //             obj: me.exam,
                //             updateProp: 'numberStudents',
                //             updateVal: _.toInteger( data.numStudents )
                //         } );
                //
                //         //store the number of students on the exam
                //         me.$store.commit( mTypes.updateItem, pl );
                //
                //         //store the number of graded exams on the exam
                //         pl.updateProp = 'numberGraded';
                //         pl.updateVal = _.toInteger( data.numGraded );
                //         me.$store.commit( mTypes.updateItem, pl );
                //
                //         me.isLoading = false;
                //         resolve();
                //     } );
                // } );

            }
        },

        computed: {

            /**
             * The number of exams which ultimately need to be
             * graded
             */
            totalExams: function () {
                return this.exam ? this.exam.numberStudents : '';
            },

            /**
             * The number of exams which have been graded
             */
            examsGraded: function () {
                return this.exam ? this.exam.numberGraded : '';
            },

            /**
             * The number of exams which still need to be graded
             * @returns {*}
             */
            examsRemaining: function () {
                return this.exam ? this.exam.numberRemaining : '';
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
            ...progressRequests,

            formatForDisplay: function ( value ) {
                return _.round( value );
            }
        }
    }
</script>