<template>

    <div id="quality-control-panel"
         class="mainBodyLocator">
        <p class="title"><span class="icon"><i class="fa fa-rocket" aria-hidden="true"></i></span> Quality Control</p>
        <p class="subtitle">
            <>Catch grading errors before your students do
        </p>

        <h4>Please note: The tools on this page are still under development. </h4>

        <div class="box">

            <div class="panel-body has-text-justified">
                <p>Grading is boring and hard. Mistakes are both inevitable and consequential. A struggling student who
                    gets
                    a D instead of the C she deserves might lose financial aid and drop out of college. At the same
                    time, it
                    is difficult to do any real quality control without expending an unreasonable amount of time and
                    effort.</p>
                <p>We are working on algorithms to better identify potential grading errors. In the meantime, here are
                    some
                    representations of your grading process which can help you visually identify potential problems. Use
                    them to identify exams to quickly glance over and double-check your work.</p>
                <p>Clicking on exams in the following charts adds them to the list of exams on the right. </p>
            </div>


            <div class="tile is-ancestor">
                <div class="tile is-parent is-vertical">
                    <div class="tile box">
                        <grade-order-chart :qc-data="qcData"></grade-order-chart>
                    </div>

                    <div class="tile box">
                        <grading-time-hist :qc-data="qcData"></grading-time-hist>
                    </div>

                    <div class="tile box">
                        <time-score-scatter :qc-data="qcData"></time-score-scatter>
                    </div>

                    <div class="tile box">
                        <revisit-list :to-revisit="toRevisit"></revisit-list>
                    </div>
                </div>
            </div>


        </div>

    </div>

</template>

<style lang="scss">

</style>

<script>

    /*
    How about a chart which represents the grade distibution by
    student mean item scores and compares it to the total
    score distrubution
     */

    import { GoogleCharts } from 'google-charts';
    import GradeOrderChart from "./quality/grade-order-chart";
    import GradingTimeHist from "./quality/grading-time-hist";
    import TimeScoreScatter from "./quality/time-score-scatter";
    import RevisitList from "./quality/revisit-list";

    import { getQCData } from "../../../api/requests/qualityRequests";

    export default {

        props: [],

        components: {
            RevisitList,
            TimeScoreScatter,
            GradingTimeHist,
            GradeOrderChart
        },

        data: function () {
            return {
                itemSerialNumber: _.toInteger( this.$route.params.serialNumber ),

                toRevisit: [],
                defaults: {}
            }
        },

        asyncComputed: {

            qcData: function () {
                let me = this;

                //If already loaded, use it
                let g = this.$store.getters.getByGradedOrder;
                if ( !_.isUndefined( g ) && g.length > 0 ) return g;

                //otherwise, fetch it from the server
                let p2 = me.$store.dispatch( 'loadQCDataFromServer', this.exam );
                return p2.then( function () {
                    return me.$store.getters.getByGradedOrder;
                } );

            },

        },

        computed: {
            exam: function () {
                return this.item;
            },
            /**
             * The exam or item the note is associated with
             */
            item: function () {
                return this.$store.getters.getItemBySerialNumber( this.itemSerialNumber );
            },

            isExam: function () {
                return this.item ? this.item.isExam() : false;
            },

        },

        methods: {

            /**
             * Adds the clicked on student to the list of students whose exams should
             * be revisited.
             * TODO Make bar change color when clicked.
             * @param chart
             */
            chartClickHandler: function ( chart ) {
                var me = this;
                var selection = chart.getSelection();
                for (var i = 0; i < selection.length; i++) {
                    var item = selection[ i ];
                    if ( item.row != null && item.column != null ) {
                        var selectedData = scoresAndTimesAll[ item.row ];
                        me.addStudentToList( selectedData[ 4 ], selectedData[ 3 ] );
                        //item.row.color = 'red';
                        window.console.log( 'click happened', selectedData );
                    }
                }
            },

            /**
             * Appends student info to the list of students whose exams should be revisited
             * @param studentName
             * @param studentIdentifier
             */
            addStudentToList: function ( studentId ) {
                this.toRevisit.push(studentId);
                // var listItem = "<li class='list-group-item'>" + studentName + " (id: " + studentIdentifier + ") [Link to comments] [Link to grading] <span class='text-right'><span class='toRemove glyphicon glyphicon-remove'></span></span></li>";
                // $( "#revisitList" ).append( listItem );
                // $( ".toRemove" ).on( 'click', function () {
                //     $( this ).parent().remove();
                // } );
            },

        },

        mounted: function () {
        }
    }
</script>