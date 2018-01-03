<template>
    <div class="grade-area">
        <div class="tile">
            <div class="table-area">
                <table class="table is-narrow">
                    <tbody>
                    <tr>
                        <th>Grade</th>
                        <td>{{letterGrade}}</td>
                    </tr>
                    <tr>
                        <th>Score</th>
                        <td>{{totalScore}} / {{ maxPossible}}</td>
                    </tr>

                    </tbody>
                </table>
            </div>
            <div class="tile">
<overall-chart :exam="exam" :student="student"></overall-chart>
            </div>
        </div>
    </div>
</template>

<style lang="scss">

</style>

<script>
    import * as gTypes from '../../../store/getter-types';
    import * as aTypes from '../../../store/action-types';

    import * as nggTypes from '../../../store/modules/newgrading/new-grading-getter-types';
    import ItemStat from '../../../models/ItemStat';

    import { getItemScoreSummaryForExam, getItemSummaryStats } from '../../../api/requests/statsRequests';

    import feedbackMixin from './feedback.mixin';
    import OverallChart from "./overall-chart";

    export default {
        mixins: [ feedbackMixin ],

        props: [ 'exam', 'student' ],

        components: { OverallChart },

        data: function () {
            return {
                placeHolder: '-',
                defaults: {}
            }
        },

        watch: {
            exam: function ( newVal, oldVal ) {
                //When the exam gets around to being defined,
                //this loads the grade assignment schema from
                //the server.
                if ( _.isUndefined( oldVal ) ) this.$store.dispatch( aTypes.loadGradeAssignmentsFromServer, this.exam );
            }
        },

        asyncComputed: {
            gradeAssignmentObject: function () {
                let me = this;
                if ( this.totalScore !== this.placeHolder ) {
                    let ga = me.$store.getters[ gTypes.getGradeAssignmentForScore ]( me.totalScore );
                    return ga;
                 }

            },
        },

        computed: {
            chartDivId: function () {
                return 'overallScoreChart';
            },

            totalScore: function () {
                if ( _.isUndefined( this.student ) || _.isNull( this.student ) ) return this.placeHolder;
                return this.$store.getters[ nggTypes.getTotalScoreForStudent]( this.student );
            },

            maxPossible: function () {
                let s = this.$store.getters[ gTypes.getMaxPossibleScore ];
                return !_.isUndefined( s ) ? s : this.placeHolder;
            },

            letterGrade: function () {
                if ( this.gradeAssignmentObject ) return this.gradeAssignmentObject.displayValue;

                return this.placeHolder;
            }

        },

    }
</script>