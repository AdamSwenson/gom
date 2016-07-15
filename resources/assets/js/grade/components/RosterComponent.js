/**
 * Created by adam on 7/11/16.
 */

var $ = require('jquery');
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

module.exports = {

    template: require( '../templates/roster-component.template.html' ),

    props: [],

    data: function () {
        return {    
            store: store,

            sortAsc: true,

            /**
             * Whether to show student names
             * false is blind grading.
             */
            studentNamesVisible: true,

            activeStudentTime: null,
            standardScoring: false,

            settings : {
                nameHiddenString: "Name Hidden", // text to show when student names are invisible
                noActiveStudentString: "No Student Selected",
                activeStudentColor: '#337ab7',
                alteredStudentTextColor: 'white',
                gradedStudentColor: '#5cb85c',
                initialStudentColor: 'white',
                initialTextColor : 'black',
            },

            // standardScoring: false,
            //
            // sortAsc: true,
            // studentNamesVisible: true,
            // nameHiddenString: "Name Hidden", // text to show when student names are invisible
            // noActiveStudentString: "No Student Selected",
            // activeStudentColor: '#337ab7',
            // alteredStudentTextColor: 'white',
            // gradedStudentColor: '#5cb85c',
            // initialStudentColor: 'white',
            // initialTextColor : 'black',
        };
    },

    computed: {
        activeStudent : function(){
            return this.store.activeStudent;
        }
    },

    methods: {

        /**
         * Returns boolean of whether a student is currently being graded
         * @returns {boolean}
         */
        isActiveStudent: function(){
            if ( this.activeStudent !== null ) {
                return true;
            }
            return false;
        },
        /**
         * Returns the id of the student currently being graded
         * @returns {*}
         */
        getActiveStudentId: function () {
            if ( this.activeStudent === null ) {
                return null;
            }
            else {
                return $( '#studentListItem' + this.activeStudent ).attr( 'data-sid' );
            }
        },

        /**
         * sets the activeStudentName and studentId fields
         */
        setSelectedNameAndId: function () {
            var $student = $( '#studentListItem' + this.activeStudent );
            // only show names if set to visible
            var name = this.settings.nameHiddenString;
            if ( this.studentNamesVisible ) {
                name = $student.attr( 'data-lName' ) + ", " + $student.attr( 'data-fName' );
            }
            // if no student has been selected, always display noActiveStudentString
            if ( ! this.activeStudent ) {
                name = this.settings.noActiveStudentString;
            }
            var id = $student.data( 'student-identifier' );
            $( "#activeStudentName" ).val( name );
            $( "#activeStudentIdentifier" ).val( id );
        },


        /**
         * When the pencil icon is selected, toggle visibility of roster names and selected name area
         */
        toggleNameVisibility: function () {
            this.studentNamesVisible = ! this.studentNamesVisible;
            var me = this;
            $( '[id^="studentListItem"]' ).each( function () {
                var nameToDisplay = me.nameHiddenString;
                if ( me.studentNamesVisible ) {
                    nameToDisplay = $( this ).attr( 'data-lName' ) + ", " + $( this ).attr( 'data-fName' );
                }
                $( this ).find( '[id^="studentName"]' ).text( nameToDisplay );
            } );
            this.setSelectedNameAndId();
        },

        /**
         * set the "grade" column in the student roster, or "--" if exam is not graded
         */
        updateRosterGradeDisplay: function ( data ) {
            for ( var i = 0; i < Object.keys(data.examGrades).length; i ++ ) {
                if ( data.examGrades[ i ] >= 0 ) {
                    $( '#examGrade' + i ).text( data.examGrades[ i ] );
                } else {
                    // the student has no grade (val of -1)
                    $( '#examGrade' + i ).text( '--' );
                }
            }
        },

        /**
         * set background colors in the student roster
         *  graded = green
         *  ungraded = white
         *  active = blue
         */
        setStudentBackgroundColors: function ( data ) {
            for ( var i = 0; i < Object.keys(data.examGrades).length; i ++ ) {
                var name = "#studentListItem" + i;
                var $item = $( '#studentRoster' ).find( name );
                if ( this.activeStudent && this.activeStudent == i ) {
                    this.setRowToActiveStudent($item);
                } else if ( data.isGraded(i) ) {
                    this.setRowToGraded($item);
                } else {
                    this.setRowToUnaltered($item)
                }
            }
        },

        /**
         * DEPRECATED. Just use setStudentBackgroundColors
         * set background for the student roster row that is selected
         */
        setActiveStudentBackgroundColor: function ( data ) {
            //if not null
            if ( this.activeStudent ) {
                var $roster = $( '#studentRoster' );

                //remove active from all
                $roster.find('[id^="studentListItem"]').removeClass('activeStudentRow');

                var item = $roster.find( '#studentListItem' + this.activeStudent ); // set the activeStudent
                this.setRowToActiveStudent(item);
                this.setStudentBackgroundColors(data); // reset prev. selected student to it's color (white or green)
//            this.setRosterBackgroundColor( item, this.activeStudentColor, this.alteredStudentTextColor );
            }
        },

        setRowToActiveStudent: function(item){
            $( item )
                .removeClass('gradedStudentRow')
                .removeClass('unalteredStudentRow')
                .addClass('activeStudentRow');
        },

        setRowToGraded: function(item){

            $( item )
                .removeClass('activeStudentRow')
                .removeClass('unalteredStudentRow')
                .addClass('gradedStudentRow');
        },

        setRowToUnaltered: function(item){
            $( item )
                .removeClass('activeStudentRow')
                .removeClass('gradedStudentRow')
                .addClass('unalteredStudentRow');
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


        /**
         * Sorts the StudentRoster by the clicked header. Sort order reverses with each press.
         * @param value
         * @param data
         */
        sortRosterBy: function ( value, data ) {
            var me = this;
            var $roster = $( '#studentRosterBody' );
            $roster.append(
                $roster.find( '[id^="studentListItem"]' ).sort( function ( a, b ) {
                    var i = $( a ).find( '[id^="' + value + '"]' );
                    var j = $( b ).find( '[id^="' + value + '"]' );
                    var result;
                    if ( value == 'studentName' || value == 'studentIdentifier' ) {
                        result = $( i ).text().toUpperCase().localeCompare(
                            $( j ).text().toUpperCase() );
                    } else {
                        // sort by exam grade
                        var gradeA = data.examGrades[ $( a ).attr( 'data-index' ) ];
                        var gradeB = data.examGrades[ $( b ).attr( 'data-index' ) ];
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
        }

    },

    directives: {}
};