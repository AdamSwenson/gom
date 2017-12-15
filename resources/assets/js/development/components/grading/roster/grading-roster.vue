<template xmlns="http://www.w3.org/1999/html">
    <nav id="grading-roster"
         class="panel">
        <div class="panel-block">
            <!-- save & finish button -->
            <finish-button></finish-button>
        </div>

        <div class="panel-heading">
            <div class="level">
                <div class="level-left">

                    <div class="level-item">
                        <student-name-visibility></student-name-visibility>
                    </div>
                </div>
                <div class="level-right">

                    <div class="level-item">
                        <active-student-area></active-student-area>
                    </div>

                </div>
            </div>
        </div>
        <div class="panel-block">
            <student-search-bar></student-search-bar>
        </div>

        <p class="panel-tabs ">

            <a class="isActiveClass('name')"
               id="nameHeader"
               title="Sort by name"
               v-on:click="sortRosterBy('lastName')"
               v-if="studentNamesVisible"
            >Name</a>

            <a class="isActiveClass('identifier')"
               id="idHeader"
               v-on:click="sortRosterBy('studentIdentifier')"
               title="Sort by ID"
            >ID
            </a>

            <a class="isActiveClass('grade')"
               id="gradeHeader"
               title="Sort by grade"
               v-on:click="sortRosterBy('grade')"
            >Grade
            </a>

            <a id="sortHeader"
               title="Reverse sort direction "
               v-on:click="toggleSortDirection"
            >
                <span class="icon">
                    <i v-if="sortAsc" class="fa sort-alpha-asc"></i>
                    <i v-else class="fa sort-alpha-desc"></i> sort
            </span>
            </a>
        </p>

        <a v-for="student in students"
           v-bind:key="student.id"
           class="panel-block student-row"
           v-bind:class="rowStyling(student)"
           v-on:click="handleRowSelection(student)"
        >
            <span class="panel-icon">
                <i class="fa fa-user"></i>
            </span>
            <span class="student-name" v-if="studentNamesVisible">{{ student.nameLastFirst }}</span>
            <span class="student-identifier ">{{ student.identifier }}</span>
        </a>
    </nav>

</template>
<script>


    import * as ngmTypes from '../../../../store/modules/newgrading/new-grading-mutation-types';
    import * as ngaTypes from '../../../../store/modules/newgrading/new-grading-action-types';
    import * as nggTypes from '../../../../store/modules/newgrading/new-grading-getter-types';

    import * as gTypes from '../../../../store/getter-types';

    import Payload from '../../../../models/Payload';

    import StudentSearchBar from './student-search-bar.vue';
    import ActiveStudentArea from './active-student-area.vue';
    import StudentNameVisibility from '../controls/student-name-visibility.vue';
    import FinishButton from "../inputs/finish-button.vue";

    module.exports = {
        components: { ActiveStudentArea, FinishButton, StudentSearchBar, StudentNameVisibility },

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

                rowStylings: {
                    activeStudent: 'is-active',
                    gradedStudent: 'gradedStudentRow',
                    unalteredStudent: 'unalteredStudentRow'
                }
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
             * Whether to show student names
             * false is blind grading.
             */
            studentNamesVisible: function () {
                return this.$store.getters[ nggTypes.areStudentNamesVisible ];
            },

        },

        methods: {

            /**
             * Returns boolean of whether a student is currently being graded
             * @returns {boolean}
             */
            isActiveStudent: function ( student ) {
                if ( this.activeStudent && this.activeStudent.id === student.id ) return true;

                return false;
            },

            /**
             * Tests whether the student has been graded.
             */
            isGraded: function ( student ) {
                return false;
            },


            handleRowSelection: function ( student ) {
                this.$store.dispatch( ngaTypes.setStudentAsActive, student );
            },

            /**
             * Gets the appropriate classes for the student
             */
            rowStyling: function ( student ) {
                if ( this.isActiveStudent( student ) ) return this.rowStylings.activeStudent;

                if ( this.isGraded( student ) ) return this.rowStylings.gradedStudent;

                //  if(this.isUnaltered(student)) return this.rowStylings.isUnaltered;
                return this.rowStylings.isUnaltered;

            },

            sortRosterBy: function ( field ) {
                this.$store.commit( 'setSortedBy', Payload.factory( { updateVal: field, mutateSilently: true } ) );

            },

            toggleSortDirection: function () {
                this.$store.commit( 'toggleSortAscending' );
            }
        },

        directives: {}
    };


    //-----------
    //
    //             /**
    //              * set the "grade" column in the student roster, or "--" if exam is not graded
    //              */
    //             updateRosterGradeDisplay: function ( data ) {
    //                 for (var i = 0; i < Object.keys( data.examGrades ).length; i++) {
    //                     if ( data.examGrades[ i ] >= 0 ) {
    //                         $( '#examGrade' + i ).text( data.examGrades[ i ] );
    //                     } else {
    //                         // the student has no grade (val of -1)
    //                         $( '#examGrade' + i ).text( '--' );
    //                     }
    //                 }
    //             },
    // //
    //
    //             /**
    //              * set background colors in the student roster
    //              *  graded = green
    //              *  ungraded = white
    //              *  active = blue
    //              */
    //             setStudentBackgroundColors: function ( data ) {
    //                 for (var i = 0; i < Object.keys( data.examGrades ).length; i++) {
    //                     var name = "#studentListItem" + i;
    //                     var $item = $( '#studentRoster' ).find( name );
    //                     if ( this.activeStudent && this.activeStudent == i ) {
    //                         this.setRowToActiveStudent( $item );
    //                     } else if ( data.isGraded( i ) ) {
    //                         this.setRowToGraded( $item );
    //                     } else {
    //                         this.setRowToUnaltered( $item )
    //                     }
    //                 }
    //             },
    //
    //             /**
    //              * DEPRECATED. Just use setStudentBackgroundColors
    //              * set background for the student roster row that is selected
    //              */
    //             setActiveStudentBackgroundColor: function ( data ) {
    //                 //if not null
    //                 if ( this.activeStudent ) {
    //                     var $roster = $( '#studentRoster' );
    //
    //                     //remove active from all
    //                     $roster.find( '[id^="studentListItem"]' ).removeClass( 'activeStudentRow' );
    //
    //                     var item = $roster.find( '#studentListItem' + this.activeStudent ); // set the activeStudent
    //                     this.setRowToActiveStudent( item );
    //                     this.setStudentBackgroundColors( data ); // reset prev. selected student to it's color (white or green)
    // //            this.setRosterBackgroundColor( item, this.activeStudentColor, this.alteredStudentTextColor );
    //                 }
    //             },

    // /**
    //  * set color for a student roster row
    //  * @param item
    //  * @param backColor
    //  * @param textColor
    //  */
    // setRosterBackgroundColor: function ( item, backColor, textColor ) {
    //     $( item ).find( '[class^="col"]' ).css( 'background-color', backColor );
    //     $( item ).css( 'color', textColor );
    // },
    //
    //
    // /**
    //  * Sorts the StudentRoster by the clicked header. Sort order reverses with each press.
    //  * @param value
    //  * @param data
    //  */
    // sortRosterBy: function ( value, data ) {
    //     var me = this;
    //     var $roster = $( '#studentRosterBody' );
    //     $roster.append(
    //         $roster.find( '[id^="studentListItem"]' ).sort( function ( a, b ) {
    //             var i = $( a ).find( '[id^="' + value + '"]' );
    //             var j = $( b ).find( '[id^="' + value + '"]' );
    //             var result;
    //             if ( value == 'studentName' || value == 'studentIdentifier' ) {
    //                 result = $( i ).text().toUpperCase().localeCompare(
    //                     $( j ).text().toUpperCase() );
    //             } else {
    //                 // sort by exam grade
    //                 var gradeA = data.examGrades[ $( a ).attr( 'data-index' ) ];
    //                 var gradeB = data.examGrades[ $( b ).attr( 'data-index' ) ];
    //                 result = gradeA - gradeB;
    //             }
    //             // flip results if we're sorting in DESC
    //             if ( !me.sortAsc ) {
    //                 result *= -1;
    //             }
    //             return result;
    //         } )
    //     );
    //     me.sortAsc = !me.sortAsc;
    // }


</script>