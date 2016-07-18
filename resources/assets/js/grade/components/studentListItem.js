/**
 * Created by adam on 7/11/16.
 */
//var $ = require('jquery');
//window.$ = $;

module.exports = {

    template: require( '../templates/student-list-item.template.html' ),

    props: [
        'studentIndex',
        'firstName',
        'lastName',
        'studentIdentifier',
        'studentId'
    ],

    data: function () {
        return {

            /**
             * The data repository store shared by everyone
             */
            store: store,

            // rowColor: {
            //     'unalteredStudentRow': this.isUnaltered,
            //     'activeStudentRow': this.isActiveStudent,
            //     'gradedStudentRow': this.isGraded
            // },

            sortAsc: true,

            studentNamesVisible: true,

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
        rowIdString: function(){
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
            var grade = this.store.examGrades[ this.studentIndex ];
            if ( (grade != 'undefined') && (grade != '') && ( grade >= 0 ) ) {
                window.console.log( 'isGraded', true );
                return true;
            }
            window.console.log( 'isGraded', false );
            return false;
        },

        /**
         * Whether this is the active student.
         * The activeStudentRow class is bound to this.
         */
        isActiveStudent: function () {
            if ( (typeof this.store.activeStudent != 'undefined') && (this.store.activeStudent != null)  && (this.store.activeStudent == this.studentIndex) ) {
                window.console.log( 'isActive', true );
                return true;
            }
            window.console.log( 'isActive', false );
            return false;

        },

        /**
         * Whether the student is neither graded nor active.
         * The unalteredStudentRow class is bound to this
         */
        isUnaltered: function () {

            if ( (! this.isActiveStudent) && (! this.isGraded) ) {
                window.console.log( 'isUnaltered', true );
                return true;
            }
            window.console.log( 'isUnaltered', false );
            return false;
        },

        /**
         * Sets the displayed grade to the actual score or the placeholder
         * @returns {*}
         */
        examGrade: function () {
            if ( this.isGraded ) {
                return this.store.examGrades[ this.studentIndex ];
            }
            // the student has no grade (val of -1)
            return this.examGradePlaceholder;
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
                return this.studentPlaceholder;
            }
        },

        studentName: function () {
            if ( this.isBlind ) {
                return this.defaults.studentPlaceholder;
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

            this.store.activeStudent = this.studentIndex;
            this.notifyStudentSelectEvent();

            // var $student = $( '#studentListItem' + this.activeStudent );
            // // only show names if set to visible
            // var name = this.nameHiddenString;
            // if ( this.studentNamesVisible ) {
            //     name = $student.attr( 'data-lName' ) + ", " + $student.attr( 'data-fName' );
            // }
            // // if no student has been selected, always display noActiveStudentString
            // if ( ! this.activeStudent ) {
            //     name = this.noActiveStudentString;
            // }
            // var id = $student.data( 'student-identifier' );
            // $( "#activeStudentName" ).val( name );
            // $( "#activeStudentIdentifier" ).val( id );
        },

        /**
         * Change the styling of this student row to
         * indicate that this student is currently being
         * graded.
         */
        representAsActiveStudent: function () {
            $( this.el )
                .removeClass( 'gradedStudentRow' )
                .removeClass( 'unalteredStudentRow' )
                .addClass( 'activeStudentRow' );
        },

        /**
         * Removes the styling which indicated that this student is
         * currently being graded.
         */
        removeActiveStudentRepresentation: function () {
        },

        /**
         * Adds styling to indicate that this student has been graded.
         */
        representAsGraded: function () {
            $( this.el )
                .removeClass( 'activeStudentRow' )
                .removeClass( 'unalteredStudentRow' )
                .addClass( 'gradedStudentRow' );
        },

        /**
         * Removes the styling which indicates that this student has been graded.
         */
        representAsNotGraded: function () {
        },
        /**
         * set background colors in the student roster
         *  graded = green
         *  ungraded = white
         *  active = blue
         */
        setStudentBackgroundColors: function ( data ) {
            for ( var i = 0; i < Object.keys( data.examGrades ).length; i ++ ) {
                var name = "#studentListItem" + i;
                var $item = $( '#studentRoster' ).find( name );
                if ( this.activeStudent && this.activeStudent == i ) {
                    this.setRowToActiveStudent( $item );
                } else if ( data.isGraded( i ) ) {
                    this.setRowToGraded( $item );
                } else {
                    this.setRowToUnaltered( $item )
                }
            }
        },

        setRowToUnaltered: function ( item ) {
            $( item )
                .removeClass( 'activeStudentRow' )
                .removeClass( 'gradedStudentRow' )
                .addClass( 'unalteredStudentRow' );
        },

        /**
         * set color for a student roster row
         * @param item
         * @param backColor
         * @param textColor
         */
        setRosterBackgroundColor: function ( item, backColor, textColor ) {
            $( item ).find( '[class^="col"]' ).css( 'background-color', backColor );
            $( item ).css( 'color', textColor );
        },


        /* ------------------------ Notifications and events --------------------- */
        handleRowClick: function(){
            window.console.log('studentListItem', 'click', this.studentIndex);
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
            this.$broadcast( 'student-select-event', toSend );
        }

    },

    directives: {},

    ready: function () {
        window.console.log('studentListItem', 'ready', this.studentIndex);
    }
};