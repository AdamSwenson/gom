<template xmlns="http://www.w3.org/1999/html">
    <nav id="grading-roster"
         class="panel"
    >

        <div class="panel-heading">
            <active-student-area></active-student-area>
        </div>

        <div class="panel-block">
            <student-search-bar></student-search-bar>
        </div>

        <p class="panel-tabs ">

            <a id="nameHeader"
               title="Sort by name"
               v-on:click="sortRosterBy('lastName')"
               v-bind:class="sortField == 'lastName' ? 'is-active' : ''"
               v-if="studentNamesVisible"
            >Name</a>

            <a id="idHeader"
               v-bind:class="sortField == 'studentIdentifier' ? 'is-active' : ''"
               v-on:click="sortRosterBy('studentIdentifier')"
               title="Sort by ID"
            >Id</a>

            <a class="isActiveClass('grade')"
               id="gradeHeader"
               title="Sort by grade"
               v-bind:class="sortField == 'grade' ? 'is-active' : ''"
               v-on:click="sortRosterBy('grade')"
            >Grade</a>

            <a id="sortHeader"
               title="Reverse sort direction "
               v-on:click="toggleSortDirection"
            >
                <span class="panel-icon">
                    <i v-if="sortAsc" class="fa fa-sort-alpha-asc"></i>
                    <i v-else class="fa fa-sort-alpha-desc"></i>
                </span>
            </a>
        </p>

        <roster-row v-for="student in students"
                    v-bind:key="student.id"
                    :student="student"
        ></roster-row>

    </nav>

</template>

<style lang="scss">

</style>

<script>
    import * as ngmTypes from '../../../../store/new-grading-mutation-types';
    import * as ngaTypes from '../../../../store/new-grading-action-types';
    import * as nggTypes from '../../../../store/new-grading-getter-types';

    import * as gTypes from '../../../../store/getter-types';

    import Payload from '../../../../models/Payload';

    import StudentSearchBar from './student-search-bar.vue';
    import ActiveStudentArea from './active-student-area.vue';
    import StudentNameVisibility from '../controls/student-name-visibility.vue';
    import FinishButton from "../inputs/finish-button.vue";

    import RosterRow from "./roster-row.vue";

    module.exports = {
        components: { ActiveStudentArea, FinishButton, StudentSearchBar, StudentNameVisibility, RosterRow },

        props: [],

        data: function () {
            return {

                standardScoring: false,

                sortIcons: {
                    asc: '<i class="fa sort-alpha-asc"><i></i>',
                    desc: '<i class="fa sort-alpha-desc"><i></i>'
                },

                settings: {
                    nameHiddenString: "Name Hidden", // text to show when student names are invisible
                    noActiveStudentString: "No Student Selected",
                    activeStudentColor: '#337ab7',
                    alteredStudentTextColor: 'white',
                    gradedStudentColor: '#5cb85c',
                    initialStudentColor: 'white',
                    initialTextColor: 'black',
                },

            };
        },
        asyncComputed: {

            /**
             * Returns a list of student objects,
             * sorted by whatever criteria is selected
             * in the store
             */
            students: function () {
                return this.$store.getters[ 'getSortedStudents' ];
            },

        },

        computed: {
            activeStudent: function () {
                return this.$store.getters[ nggTypes.getActiveStudent ];
            },

            /** The direction to sort */
            sortAsc: function () {
                return this.$store.getters.getSortAsc;
            },

            /** The name of the field to sort the table by */
            sortField: function () {
                return this.$store.getters[ 'getSortedBy' ];
            },

            /**
             * Whether to show student names.
             * False is blind grading.
             */
            studentNamesVisible: function () {
                return this.$store.getters[ nggTypes.areStudentNamesVisible ];
            },

        },

        methods: {

            /**
             * Sets the field to sort the roster by
             */
            sortRosterBy: function ( field ) {
                this.$store.commit( 'setSortedBy', Payload.factory( { updateVal: field, mutateSilently: true } ) );

            },

            /**
             * Toggles the order in which the rows are sorted
             */
            toggleSortDirection: function () {
                this.$store.commit( 'toggleSortAscending' );
            }
        },

    };

</script>