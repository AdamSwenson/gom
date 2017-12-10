<template>

    <tr id="{{ rowIdString }}"
        class="studentListItem "
        v-on:click="handleRowClick"
        v-bind:class="{ 'unalteredStudentRow': isUnaltered, 'activeStudentRow': isActiveStudent, 'gradedStudentRow': isGraded }"
        data-index="{{ studentIndex }}"
        data-fName="{{ firstName }}"
        data-lName="{{ lastName }}"
        data-sid="{{ studentId }}"
        data-student-identifier="{{ studentIdentifier }}">
        <td class="col-xs-6"
            id="studentName{{ studentIndex }}">{{ studentName }}</td>
        <td class="col-xs-4"
            id="studentIdentifier{{ studentIndex }}">{{ studentIdentifierDisplay }}</td>
        <td class="col-xs-2"
            id="examGrade{{ studentIndex }}">{{ examGrade }}</td>
    </tr>

</template>
<script>
module.exports = {

    template: require( '../templates/student-list-item.template.html' ),

    props: [
        'studentIndex',
        // 'firstName',
        // 'lastName',
        // 'studentIdentifier',
        // 'studentId'
    ],

    data: function () {
        return {

            /**
             * The data repository store shared by everyone
             */
            store: store,

            sortAsc: true,

//            studentNamesVisible: true,

            defaults: {
                examGradePlaceholder: '--',
                studentPlaceholder: '--',
                nameHiddenString: "Name Hidden", // text to show when student names are invisible
                noActiveStudentString: "No Student Selected",
                activeStudentColor: '#337ab7',
                alteredStudentTextColor: 'white',
                gradedStudentColor: '#5cb85c',
                initialStudentColor: 'white',
                initialTextColor: 'black',
            }
        };
    },

    computed: {
        firstName: function () {
            let student = this.store.getStudent( this.studentIndex );
            return student.firstName;
        },
        lastName: function () {
            let student = this.store.getStudent( this.studentIndex );
            return student.lastName;
        },
        studentIdentifier: function () {
            let student = this.store.getStudent( this.studentIndex );
            // window.console.log(student.studentIdentifier);
            return student.studentIdentifier;
        },
        studentId: function () {
            let student = this.store.getStudent( this.studentIndex );
            // window.console.log(student.studentId );
            return student.studentId;
        },

        /**
         * Returns the id attribute for the item
         * @returns {string}
         */
        rowIdString: function () {
            return "studentListItem" + this.studentIndex;
        },

        /**
         * Whether student names should be hidden
         * @returns boolean
         */
        isBlind: function () {
            return this.store.isBlind;
        },

        /**
         * Whether this student has been graded.
         * The gradedStudentRow class is bound to this.
         */
        isGraded: function () {
            var grade = this.store.getExamGrade( this.studentIndex );
            if ( (grade != 'undefined') && (grade != '') && ( grade >= 0 ) ) {
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
        isActiveStudent: function () {
            if ( this.store.getActiveStudentIndex() == this.studentIndex ) {
                // window.console.log( 'isActive', this.studentIndex, true );
                return true;
            }
            // window.console.log( 'isActive', false );
            return false;

        },

        /**
         * Whether the student is neither graded nor active.
         * The unalteredStudentRow class is bound to this
         */
        isUnaltered: function () {

            if ( (! this.isActiveStudent) && (! this.isGraded) ) {
                // window.console.log( 'isUnaltered', true );
                return true;
            }
            // window.console.log( 'isUnaltered', false );
            return false;
        },

        /**
         * Sets the displayed grade to the actual score or the placeholder
         * @returns {*}
         */
        examGrade: function () {
            if ( this.isGraded ) {
                return this.store.getExamGrade( this.studentIndex );
            }
            // the student has no grade (val of -1)
            return this.defaults.examGradePlaceholder;
        },

        /**
         * The student identifier (if exists) associated with the student.
         * This is not the db's id for the student.
         * @returns {*}
         */
        studentIdentifierDisplay: function () {
            if ( (this.studentIdentifier != 'undefined') && (this.studentIdentifier != '') ) {
                return this.studentIdentifier;
            }
            else {
                return this.defaults.studentPlaceholder;
            }
        },

        studentName: function () {
            if ( this.isBlind ) {
                return this.defaults.nameHiddenString;
            }
            return this.lastName + ", " + this.firstName;
        }
    },

    methods: {
        /**
         * Sets this student as the active student and
         * dispatches appropriate notifications
         */
        setAsActiveStudent: function () {
            this.store.setActiveStudent( this.studentIndex, this.studentId );
            this.notifyStudentSelectEvent();
        },


        /* ------------------------ Notifications and events --------------------- */
        handleRowClick: function () {
            // window.console.log('studentListItem', 'click', this.studentIndex);
            this.setAsActiveStudent();
        },
        /**
         * Emits a notification that a student has been selected.
         * This is the only place the student name and identifier are stored
         * so we need to send them to whomever is going to display them.
         */
        notifyStudentSelectEvent: function () {
            var toSend = {};
            toSend.studentName = this.studentName;
            toSend.studentIdentifier = this.studentIdentifier;
            this.$dispatch( 'student-select-event', toSend );
        }

    },

    directives: {},

    ready: function () {
        // window.console.log('studentListItem', 'ready', this.studentIndex);
    }
};</script>