<template>
    <div id="feedback-main-page"
         class="feedback-page mainBodyLocator container "
    >

        <feedback-panel :exam="exam" :student="student" ></feedback-panel>

    </div>
</template>

<style lang="scss">

</style>

<script>
    import Student from '../../../models/Student';
    import Exam from '../../../models/Exam';

    import Payload from '../../../models/Payload';
    import Node from '../../../models/Node';
    import Item from '../../../models/Item';
    import ItemScore from '../../../models/ItemScore';
    import * as mTypes from '../../../store/mutation-types';
    import * as gTypes from '../../../store/getter-types';
    import FeedbackPanel from "./feedback-panel";

    import { readJsonFromPageString, processItemObjectsFromJson } from '../../../store/utlities/JsonHelpers';

    export default {

        props: [],

        components: { FeedbackPanel },

        data: function () {
            return {
                jsonLocations: {
                    exam: 'exam',
                    items: 'items',
                    order: 'order',
                    scores: 'scores',
                    students: 'students',
                },

                defaults: {}
            }
        },

        computed: {
            student: function () {
                let loadedStudents = this.$store.getters[ gTypes.getStudentsFromRoster ];
                if ( !_.isUndefined( loadedStudents ) ) return loadedStudents[ 0 ];
            },

            exam: function () {
                return this.$store.getters.currentExam;
            }

        },

        created: function () {
            let me = this;

            me.$store.dispatch( 'loadStudentsFromPageJson', me.jsonLocations )
                .then( function () {
                    me.$store.dispatch( 'loadExamFromPageJson', me.jsonLocations )
                        .then( function () {
                            me.$store.dispatch( 'loadItemsFromPageJson', me.jsonLocations )
                                .then( function () {
                                    me.$store.dispatch( 'loadScoresFromPageJson', me.jsonLocations )
                                        .then( function () {
                                            window.console.log( 'feedback-page', 'ready' );
                                        } );
                                } );
                        } );
                } );
        }
    };
</script>