<template>
    <div class="number-graded">
        <p class="h4">Grading Progress</p>
        <div class="box">
            <div v-if="isLoading"
            >
                <loading-indicator
                        :is-loading="isLoading"
                ></loading-indicator>
            </div>

            <div class="number-graded-list"
                 v-if="! isLoading"
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
    import * as aTypes from '../../../../store/action-types';
    import * as mTypes from '../../../../store/mutation-types';
    import Payload from '../../../../models/Payload';

    import loadingIndicator from '../../helpers/loading-indicator.vue';
import statDisplay from './stat-display.vue';

    export default {

        props: [
            'exam'
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

            examCountsAjax: function () {
                let route = 'dev/numgraded/exam/' + this.exam.id;
                let me = this;

//                if( _.isInteger(me.exam.numberStudents) && _.isInteger(me.exam.numberGraded)) return true;

                    this.isLoading = true;

                axios.get( route ).then( ( response ) => {
                    let pl = Payload.factory( {
                        mutateSilently: true,
                        obj: me.exam,
                        updateProp: 'numberStudents',
                        updateVal: _.toInteger(response.data.numStudents)
                    } );

                    //store the number of students on the exam
                    me.$store.commit( mTypes.updateItem, pl );

                    //store the number of graded exams on the exam
                    pl.updateProp = 'numberGraded';
                    pl.updateVal = _.toInteger(response.data.numGraded);
                    me.$store.commit( mTypes.updateItem, pl );

                    me.isLoading = false;
                } );

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
            }

        },


        formatForDisplay: function ( value ) {
            return _.round(value);
        }


    }
</script>