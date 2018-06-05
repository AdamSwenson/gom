<template>
    <table class="table is-narrow is-striped" id="gradingRoster">
        <thead>
        <tr>
            <th id="nameHeader"
                title="Sort by name"
                v-on:click="sortRosterBy('studentName')"
            >Name</th>
            <th class=""
                id="idHeader"
                v-on:click="sortRosterBy('studentIdentifier')"
                title="Sort by ID"
            >ID
            </th>
            <th class=""
                id="gradeHeader"
                title="Sort by grade"
                v-on:click="sortRosterBy()"
            >Grade
            </th>
        </tr>

        </thead>
        <tbody id="studentRosterBody">

        <tr v-for="s in students"
            v-on:click="handleStudentRowClick(s.studentIndex)"
            v-bind:class="{ 'unalteredStudentRow': isUnalteredStyle(s.studentIndex),'activeStudentRow': isActiveStyle(s.studentIndex),'gradedStudentRow': isGradedStyle(s.studentIndex) }"
            id="studentListItem{{ s.studentIndex }}"
            class="studentListItem "
            data-index="{{ s.studentIndex }}"
            data-fName="{{ s.firstName }}"
            data-lName="{{ s.lastName }}"
            data-sid="{{ s.studentId }}"
            data-student-identifier="{{ s.studentIdentifier }}"
        >
            <td class="col-xs-6"
                id="studentName{{ s.studentIndex }}">{{ getName(s.studentIndex) }}</td>
            <td class="col-xs-4"
                id="studentIdentifier{{ s.studentIndex }}">{{ getIdentifier(s.studentIndex) }}</td>
            <td class="col-xs-2"
                id="examGrade{{ s.studentIndex }}">{{ getGrade(s.studentIndex) }}</td>
        </tr>
        </tbody>
    </table>

</template>
<style></style>
<script>
var Requests = require( './requests.tools' );

module.exports = {

    template: require( '../templates/student-table.template.html' ),

    props: [],

    data: function () {
        return {
            /**
             * The data repository store shared by everyone
             */
            store: store,

            sortAsc: true,

            defaults: {
                examGradePlaceholder: '--',
                studentPlaceholder: '--',
                nameHiddenString: "Name Hidden", // text to show when student names are invisible
                noActiveStudentString: "No Student Selected",
            },
            // displayClasses: {
            //     unaltered: 'unalteredStudentRow',
            //     active: 'activeStudentRow',
            //     graded: 'gradedStudentRow'
            // }
        };
    },

    computed: {
        // store: function(){
        //     if(GOM){
        //         return GOM.store;
        //     }
        //
        //     if(store){
        //         return store;
        //     }
        // },

        /**
         * Whether student names should be hidden
         * @returns boolean
         */
        isBlind: function () {
            return this.store.isBlind;
        },

        /**
         * The shared json of students
         * @returns {*}
         */
        students: function () {
            return this.store.getStudents();
        },


    },

    methods: {
        /**
         * Sets this student as the active student and
         * dispatches appropriate notifications
         */
        setAsActiveStudent: function ( studentIndex ) {
            this.store.setActiveStudent( studentIndex );
        },


        /**
         * Whether this student has been graded.
         * The gradedStudentRow class is bound to this.
         */
        isGraded: function ( studentIndex ) {
            let grade = this.store.getExamGrade( studentIndex );
            if ( (grade != 'undefined') && (grade != '') && (grade != 'Letter grade') && ( grade >= 0 ) ) {
                // window.console.log( 'isGraded', true );
                return true;
            }
            // window.console.log( 'isGraded', false );
            return false;
        },

        /**
         * Whether this is the active student.
         * The activeStudentRow class is bound to this.
         */
        isActiveStudent: function ( studentIndex ) {
            if ( this.store.getActiveStudentIndex() == studentIndex ) {
                // window.console.log( 'isActive', this.studentIndex, true );
                return true;
            }
            // window.console.log( 'isActive', false );
            return false;

        },

        /* ------------------------ Notifications and events --------------------- */

        handleStudentRowClick: function ( index ) {
            window.console.log( 'student row click', index );
            this.setAsActiveStudent( index );
            this.notifyStudentSelectEvent( index );
        },

        /**
         * Emits a notification that a student has been selected.
         * This is the only place the student name and identifier are stored
         * so we need to send them to whomever is going to display them.
         */
        notifyStudentSelectEvent: function ( studentIndex ) {
            let studentName = this.getName( studentIndex );
            let studentIdentifier = this.getIdentifier( studentIndex );
            var toSend = new Requests.StudentSelectEvent( studentName, studentIdentifier );

            this.$dispatch( 'student-select-event', toSend );
        },


        /* -------------------------- Getters -------------------------- */
        /**
         * Returns the student's grade for display or a placeholder
         * @param studentIndex
         * @returns {string}
         */
        getGrade: function ( studentIndex ) {
            if ( this.isGraded( studentIndex ) ) {
                return this.store.getExamGrade( studentIndex );
            }
            // the student has no grade (val of -1)
            return this.defaults.examGradePlaceholder;
        },

        /**
         * Returns the student identifier
         * NB, this is the user provided student id, not the db's id
         * @param studentIndex
         * @returns {*}
         */
        getIdentifier: function ( studentIndex ) {
            let student = this.store.getStudent( studentIndex );
            if (typeof student == 'undefined' || ! student.studentIdentifier ) {
                return '--';
            }
            return student.studentIdentifier;
        },

        /**
         * Returns the student's name or the placeholder if the
         * exam is being graded blind
         * @param studentIndex
         * @returns {*}
         */
        getName: function ( studentIndex ) {
            let student = this.store.getStudent( studentIndex );
            // if(typeof student == 'undefined'){
            //     return '';
            // }
            if ( this.isBlind ) {
                return this.defaults.nameHiddenString;
            }
            return student.lastName + ", " + student.firstName;
        },

        /**
         * Returns the student's name or the placeholder if the
         * exam is being graded blind
         * @param studentIndex
         * @returns {*}
         */
        getNameDisplay: function ( studentIndex ) {
            let student = this.store.getStudent( studentIndex );
            // if(typeof student == 'undefined'){
            //     return '';
            // }
            if ( this.isBlind ) {
                return this.defaults.nameHiddenString;
            }
            return student.lastName + ", " + student.firstName;
        },


        /* --------------------------- Row styling ---------------------- */
        /**
         * The active student styling is bound to this
         * @param studentIndex
         * @returns {boolean}
         */
        isActiveStyle: function ( studentIndex ) {

            if ( this.isActiveStudent( studentIndex ) ) {
                return true;
            }
            return false;
        },

        /**
         * The graded student styling is bound to this.
         */
        isGradedStyle: function ( studentIndex ) {
            //check if active first because do not want graded to trump active
            //that is, if a student has been graded and we return to her
            //she should show up as active
            if ( this.isActiveStudent( studentIndex ) ) {
                return false;
            }
            return this.isGraded( studentIndex );
        },

        /**
         * Whether the student is neither graded nor active.
         * The unalteredStudentRow class is bound to this
         */
        isUnalteredStyle: function ( studentIndex ) {

            if ( (! this.isActiveStudent( studentIndex )) && (! this.isGraded( studentIndex )) ) {
                // window.console.log( 'isUnaltered', true );
                return true;
            }
            // window.console.log( 'isUnaltered', false );
            return false;
        },


        /* -------------------------- Table operations ------------------------ */

        /**
         * Sorts the StudentRoster by the clicked header. Sort order reverses with each press.
         * @param value
         * @param data
         */
        sortRosterBy: function ( value) {
            let data = this.store;
            var me = this;
            var $roster = $( '#studentRosterBody' );
            $roster.append(
                $roster.find( '[id^="studentListItem"]' ).sort( function ( a, b ) {
                    let i = $( a ).find( '[id^="' + value + '"]' );
                    let j = $( b ).find( '[id^="' + value + '"]' );
                    let result;
                    if ( value == 'studentName' || value == 'studentIdentifier' ) {
                        result = $( i ).text().toUpperCase().localeCompare(
                            $( j ).text().toUpperCase() );
                    } else {
                        // sort by exam grade
                        let gradeA = data.getExamGrade( $( a ).attr( 'data-index' ) );
                        let gradeB = data.getExamGrade( $( b ).attr( 'data-index' ) );
                        result = gradeA - gradeB;
                        // var gradeA = data.examGrades[ $( a ).attr( 'data-index' ) ];
                        // var gradeB = data.examGrades[ $( b ).attr( 'data-index' ) ];
                        result = gradeA - gradeB;
                    }
                    // flip results if we're sorting in DESC
                    if ( ! me.sortAsc ) {
                        result *= - 1;
                    }
                    return result;
                } )
            );
            me.sortAsc = ! me.sortAsc;
        },

    },

    directives: {},

    events: {},
    ready: function () {
        // window.console.log('student table ready',  this.students );
    }
};</script>