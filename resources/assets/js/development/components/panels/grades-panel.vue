<template>

    <div class="grades-panel">
        <p class="title">
            Setting grade distribution happens here
        </p>

        <div class="tile is-ancestor box">

            <div class="assignment-table  tile is-parent is-vertical">
                <p>Maximum possible score: {{ examMaxScore }}</p>

                <div class="tile is-child">
                    <table class="table is-narrow">
                        <thead>
                        <tr>
                            <th>Grade</th>
                            <th>Minimum score</th>
                            <th># Students</th>
                        </tr>
                        </thead>

                        <tbody>

                        <assignment-row
                                v-for="g in gradeAssignments"
                                v-bind:key="g.displayValue"
                                :grade="g"
                        ></assignment-row>

                        </tbody>
                    </table>
                </div>

                <div class="assignment-controls tile is-child">
                    <a class="button is-danger">Clear</a>

                    <a class="button is-warning">Undo</a>

                </div>


            </div>

            <div class="right-side tile is-parent is-vertical">


                <div class="tile is-child">
                    <div class="freq-chart-area">
                        <grade-freq-chart :grade-frequencies="frequencies"
                        ></grade-freq-chart>
                    </div>
                </div>

                <div class="score-chart-area tile is-child">
                    <score-chart :scores="scores"></score-chart>
                </div>

                <div class="tile is-child ">
                    <dist-area :list-of-values="grades" :show-letter="true">
                        <span slot="heading">Grades</span>
                    </dist-area>
                </div>

                <div class="tile is-child ">
                    <dist-area :list-of-values="scores">
                        <div slot="heading">Total scores</div>
                    </dist-area>
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
    import * as gTypes from '../../../store/getter-types';

    import Payload from '../../../models/Payload';
    import GradeAssignment from '../../../models/GradeAssignment';

    import gradeAssignmentField from './grade/cutoff-field.vue';

    import loadingIndicator from '../helpers/loading-indicator.vue';

    import requests from '../../../api/requests/gradeAssignmentRequests';
    import row from './grade/assignment-table-row';

    import distStats from './grade/grade-distribution-stats';
    import gradeFreqChart from './grade/frequency-chart';
    import scoreChart from './grade/scores-chart';
    import distArea from './grade/dist-area';


    export default {
//        props: ['serialNumber'], //the serial number of the note

        components: {
            'assignment-row': row,
            'grade-freq-chart': gradeFreqChart,
            'loading-indicator': loadingIndicator,
            'grade-assignment-field': gradeAssignmentField,
            'dist-stats': distStats,
            'dist-area': distArea,
            'score-chart': scoreChart
        },

        data: function () {
            return {
                serialNumber: _.toInteger( this.$route.params.serialNumber ),
                gradeTypes: GradeAssignment.letterGrades,
                placeholders: {},
            };
        },

        asyncComputed: {


            gradesAjax: function () {
                let me = this;
                let p = requests.getGradeAssignments( this.exam );
                p.then( function ( data ) {
                    _.forEach( data, function ( d ) {
//                        window.console.log( 'grades-panel', 'gradesAjax', 73, d);
                        //get the correct grade assignment
                        let ga = me.$store.getters[ gTypes.getCutOffsForLetterGrade ]( d.letterGrade );
                        //update with the server id
                        let pl = Payload.factory( {
                            obj: ga,
                            updateProp: 'id',
                            updateVal: d[ 'id' ],
                            mutateSilently: true
                        } );
                        me.$store.commit( mTypes.updateGradeCutoffs, pl );

                        //and update the minScore
                        let pl2 = Payload.factory( {
                            obj: ga,
                            updateProp: 'minScore',
                            updateVal: d[ 'minScore' ],
                            mutateSilently: true
                        } );
                        me.$store.commit( mTypes.updateGradeCutoffs, pl2 );

                        let pl3 = Payload.factory( {
                            obj: ga,
                            updateProp: 'displayValue',
                            updateVal: d[ 'letterGrade' ],
                            mutateSilently: true
                        } );
                        me.$store.commit( mTypes.updateGradeCutoffs, pl3 );

                    } );


                } );
            },

            totalScores: function () {
                let me = this;
                let p = requests.getTotalScores( this.exam );
                p.then( function ( data ) {
                    me.$store.commit( mTypes.loadTotalScores, Payload.factory( {
                        updateVal: _.values( data ),
                        mutateSilently: true
                    } ) );
                } );

            }
        },


        computed: {
            gradeAssignments: function () {
                return this.$store.getters.getGradeAssignments;
            },


            examMaxScore: function () {
                return this.$store.getters[gTypes.getMaxPossibleScore];
            },


            scores: function () {
                return this.$store.getters[ gTypes.getTotalScores ];
            },

            grades: function () {
                return this.$store.getters.getListOfGradeValues;
            },


            frequencies: function () {
                return this.$store.getters[ gTypes.getGradeFrequencies ];
            },

            exam: function () {
                return this.item.isExam() ? this.item : this.$store.getters.currentExam;
            },

            id: function () {
                return this.item.id;
            },

            //if this is not the panel for the exam
            item: function () {
                return this.$store.getters.getItemBySerialNumber( this.serialNumber );
            },

            isExam: function () {
                return this.item ? this.item.isExam() : false;
            }

        },

        methods: {


            /**
             * Returns the number of students receiving
             * the provided grade on the current assignment scheme
             */
            gradeFrequency: function ( letterGrade ) {
                if ( _.isUndefined( this.grade ) ) return false;

                let freqs = this.$store.getters[ gTypes.getGradeFrequencies ];

                if ( _.isUndefined( freqs ) ) return false;

                return freqs[ letterGrade ];
            }
        }

    }
</script>
