<template>
    <table class="grade-table table is-narrow">
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

</template>

<style lang="scss">

</style>

<script>
    import * as gTypes from '../../../store/getter-types';
    import * as aTypes from '../../../store/action-types';

    import * as nggTypes from '../../../store/new-grading-getter-types';
    import ItemStat from '../../../models/ItemStat';

    import { getItemScoreSummaryForExam, getItemSummaryStats } from '../../../api/requests/statsRequests';

    import feedbackMixin from './feedback.mixin';

    export default {
        // mixins: [ feedbackMixin ],

        props: [ 'exam', 'student' ],


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

            totalScore: function () {

                //On the page given to the student, this is loaded as a prop, so use that
                if(!_.isUndefined(this.staticTotalScore)) return this.staticTotalScore;

                //Otherwise use what's in the store
                if ( _.isUndefined( this.student ) || _.isNull( this.student ) ) return this.placeHolder;
                return this.$store.getters[ nggTypes.getTotalScoreForStudent ]( this.student );
            },

            maxPossible: function () {
                let s = this.$store.getters[ gTypes.getMaxPossibleScore ];
                return !_.isUndefined( s ) ? s : this.placeHolder;
            },


            letterGrade: function () {
                if(!_.isUndefined(this.staticLetterGrade)) return this.staticLetterGrade;

                //Use the value from store
                if ( this.gradeAssignmentObject ) return this.gradeAssignmentObject.displayValue;

                return this.placeHolder;
            },


            /**
             * For some uses, the letter grade may have been defined statically in
             * the page html. This gets and returns it
             */
            staticLetterGrade: function () {
                let el = document.getElementById( 'letterGrade' );
                if(! _.isNull(el)) return el.getAttribute( 'data' );
            },

            /**
             * For some uses, the total score may have been defined statically in
             * the page html. This gets and returns it
             */
            staticTotalScore: function () {
                let el = document.getElementById( 'totalScore' );
                if(!_.isNull(el)) return el.getAttribute( 'data' );
            }

        },

    }
</script>