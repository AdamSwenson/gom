var $ = require('jquery');
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

module.exports = {
    activeStudent: null,
    activeStudentTime: null,

    standardScoring: false,

    sortAsc: true,
    studentNamesVisible: true,
    nameHiddenString: "Name Hidden", // text to show when student names are invisible
    noActiveStudentString: "No Student Selected",
    activeStudentColor: '#337ab7',
    gradedStudentColor: '#5cb85c',

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
        var name = this.nameHiddenString;
        if ( this.studentNamesVisible ) {
            name = $student.attr( 'data-lName' ) + ", " + $student.attr( 'data-fName' );
        }
        // if no student has been selected, always display noActiveStudentString
        if ( ! this.activeStudent ) {
            name = this.noActiveStudentString;
        }
        var id = $student.data( 'student-identifier' );
        //$("#activeStudentName").text(name);
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
        for ( var i = 0; i < data.examGrades.length; i ++ ) {
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
        for ( var i = 0; i < data.examGrades.length; i ++ ) {
            var name = "#studentListItem" + i;
            var item = $( '#studentRoster' ).find( name );
            if ( this.activeStudent == i ) {
                this.setRosterBackgroundColor( item, this.activeStudentColor, 'white' )
            } else if ( data.examGrades[ i ] >= 0 ) {
                this.setRosterBackgroundColor( item, this.gradedStudentColor, 'white' );
            } else {
                this.setRosterBackgroundColor( item, 'white', 'black' );
            }
        }
    },

    /**
     * set background for the student roster row that is selected
     */
    setActiveStudentBackgroundColor: function ( data ) {
        if ( this.activeStudent ) {
            this.setStudentBackgroundColors(data); // reset prev. selected student to it's color (white or green)
            var item = $( '#studentRoster' ).find( '#studentListItem' + this.activeStudent ); // set the activeStudent
            this.setRosterBackgroundColor( item, this.activeStudentColor, 'white' );
        }
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
     */
    sortRosterBy: function ( value ) {
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
                    var gradeA = examGrades[ $( a ).attr( 'data-index' ) ];
                    var gradeB = examGrades[ $( b ).attr( 'data-index' ) ];
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

};
