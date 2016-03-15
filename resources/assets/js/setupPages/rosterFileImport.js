/**
 * Created by Brian on 9/12/2015.
 *
 * Functions for file import logic.
 *
 */

var $ = require('jquery');
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

require('bootstrap');

module.exports = {

    test: function(){
        window.console.log('test good');
    },

    // basic setup for # of columns and column ordering. These will change based on the imported roster file
    numColumns: 4,
    lastNameCol: - 1,
    firstNameCol: - 1,
    idCol: - 1,
    emailCol: - 1,

    // [separatorChar] defines the character that will be used to divide lines into fields
    // default: comma
    separatorChar: ',',

    /**
     * Map values found for firstNameCol, lastNameCol, idCol, and emailCol to display in the form.
     // If a value type isn't discovered (-1) it won't be displayed.
     * @param row
     */
    addRow: function ( row ) {
        var defaultChar = '';

        var fName = defaultChar;
        if ( this.firstNameCol >= 0 )
            fName = row[ firstNameCol ];

        var lName = defaultChar;
        if ( this.lastNameCol >= 0 )
            lName = row[ lastNameCol ];

        var id = defaultChar;
        if ( this.idCol >= 0 )
            id = row[ idCol ];

        var email = defaultChar;
        if ( this.emailCol >= 0 )
            email = row[ emailCol ];

        addStudentToTable( lName, fName, id, email );
    },

    /**
     * check that the browser isn't ancient
     * @returns {boolean}
     */
    browserSupportFileUpload: function () {
        var isCompatible = false;
        if ( window.File && window.FileReader && window.FileList && window.Blob ) {
            isCompatible = true;
        }
        return isCompatible;
    },

    startRead: function () {
        // reset columns. prevents bugs if two files with different orderings are imported.
        var lastNameCol = - 1;
        var firstNameCol = - 1;
        var emailCol = - 1;
        var idCol = - 1;

        console.log( 'reading file' );
        if ( ! this.browserSupportFileUpload() ) {
            alert( 'The file upload function is not fully supported in this browser!' );
            return;
        }

        var reader = new FileReader();
        var $inputFile = $( '#fileInput' )[ 0 ].files[ 0 ];

        reader.readAsText( $inputFile );

        reader.onload = function ( event ) {
            // convert line endings
            var rows = event.target.result.toString().replace( /[\r\n]+/g, "\n" ).split( "\n" );
            var students = [];

            // break each row into its elements
            for ( var i = 0; i < rows.length; i ++ ) {
                students[ i ] = rows[ i ].toString().split( this.separatorChar );
            }

            // remove any resulting lines with 1 or fewer elements
            for ( i = students.length - 1; i >= 0; i -- ) {
                // since this looks for rows with 2 or more consecutive commas, rows that import with a few empty columns
                // at the beginning (eg:  [,,,data,data,data] ) will be spliced. IT should remove lines with only commas.
                if ( students[ i ].length <= 1 || (rows[ i ].search( /,,+/ ) >= 0 ) ) {
                    students.splice( i, 1 );
                    rows.splice( i, 1 );
                }
            }

            // analyze the file and look for column headers
            var firstLine = students[ 0 ];
            var startRow = 0;
            if ( firstRowContainsTitles( firstLine ) ) {
                this.guessColumnDataByTitles( firstLine );
                // remove the header line as we don't need it any longer
                rows.splice( 0, 1 );
                students.splice( 0, 1 );
            } else {
                guessColumnDataByContent( students );
            }

            console.log( 'lnameCol:' + lastNameCol + ' fnameCol:' + firstNameCol + ' idCol:' + idCol + ' emailCol:' + emailCol );

            for ( i = startRow; i < rows.length; i ++ ) {
                addRow( students[ i ] );
            }
        };

        reader.onerror = function () {
            alert( 'Unable to read ' + file.fileName );
        };
    },

    /**
     * determines if the first row contains column headers that describe the column's content
     * @param firstLine
     * @returns {boolean}
     */
    firstRowContainsTitles: function ( firstLine ) {
        var result = false;
        for ( var i = 0; i < firstLine.length; i ++ ) {
            if ( firstLine[ i ].search( /mail/i ) >= 0 || firstLine[ i ].search( /name/i ) >= 0 ) {
                result = true;
            }
            if ( firstLine[ i ].search( /@/ ) >= 0 ) {
                result = false;
            }
        }
        return result;
    },

    /**
     * examine column titles to pick likely ordering
     * @param titles
     */
    guessColumnDataByTitles: function ( titles ) {
        numColumns = titles.length;

        for ( var i = 0; i < numColumns; i ++ ) {
            if ( titles[ i ].search( /mail/i ) >= 0 ) {
                emailCol = i;
            } else if ( titles[ i ].search( /id/ ) >= 0 ) {
                idCol = i;
            } else if ( titles[ i ].search( /first/ ) >= 0 ) {
                firstNameCol = i;
            } else if ( titles[ i ].search( /last/ ) >= 0 ) {
                lastNameCol = i;
            } else {
                //console.log('column not found: "' + titles[i] + '"');
            }
        }
    },

    /**
     * Examine table data to pick out column ordering
     */
    guessColumnDataByContent: function ( students ) {
        var startCol = 0;
        var startRow = 0;

        numColumns = students[ 0 ].length;
        var foundColumns = [];
        for ( var i = startCol; i < numColumns; i ++ ) {
            if ( students[ 0 ][ i ].search( /@/ ) >= 0 ) {
                // look for @, that's the email
                emailCol = i;
                foundColumns.push( i );
            } else if ( students[ 0 ][ i ].search( /[0-9]{3}/ ) >= 0 ) {
                // look for 3 digits in a row, that's the studentId
                idCol = i;
                foundColumns.push( i );
            } else if ( students[ 0 ][ i ] == '' ) {
                // add any empty columns to the blacklist so they are skipped later
                foundColumns.push( i );
            }
        }

        // commonNames[] is a list of the most common first names for students born between 1990-2000
        // It is used to scan a column and make a guess at which contains first names
        var commonNames = [ 'Michael', 'Christopher', 'Matthew', 'Joshua', 'Jacob', 'Nicholas', 'Jessica', 'Ashley', 'Emily',
            'Sarah', 'Samantha', 'Amanda' ];

        for ( i = startCol; i < numColumns; i ++ ) {
            // skip any columns which have already been flagged as email or student ID
            if ( foundColumns.indexOf( i ) > - 1 ) {
                continue;
            }
            for ( var j = startRow; j < students.length; j ++ ) {
                // any column with 3 more letters is set as last name. Next column found with letters is first name
                if ( students[ j ][ i ].search( /.{3,}/ ) > - 1 ) {
                    if ( lastNameCol == - 1 )
                        lastNameCol = i;
                    else if ( lastNameCol != i ) {
                        firstNameCol = i;
                    }
                }
                // look for common names and set firstNameCol if any are found
                if ( $.inArray( students[ j ][ i ], commonNames ) > - 1 ) {
                    firstNameCol = i;
                    if ( lastNameCol == firstNameCol ) {
                        lastNameCol = - 1;
                    }
                    foundColumns.push( i );
                    break;
                }
            }
        }
    }

};