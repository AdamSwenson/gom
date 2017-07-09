/**
 * Created by adam on 7/7/17.
 */


const _ = window._ = require( 'lodash' );
// const Vue = require( 'vue' );

import * as mTypes from '../../store/mutation-types'
import * as aTypes from '../../store/action-types'
import * as gTypes from '../../store/getter-types'

import Payload from '../../models/Payload'
import Student from '../../models/Student'


/**
 * check that the browser isn't ancient
 * @returns {boolean}
 */
const browserSupportFileUpload = () => {
    var isCompatible = false;
    if ( window.File && window.FileReader && window.FileList && window.Blob ) {
        isCompatible = true;
    }
    return isCompatible;
};

/**
 * determines if the first row contains column headers that describe the column's content
 * @param firstLine
 * @returns {boolean}
 */
const firstRowContainsTitles = function ( firstLine ) {
    var result = false;
    if ( typeof firstLine != 'undefined' ) {
        for (var i = 0; i < firstLine.length; i++) {
            if ( firstLine[ i ].search( /mail/i ) >= 0 || firstLine[ i ].search( /name/i ) >= 0 ) {
                result = true;
            }
            if ( firstLine[ i ].search( /@/ ) >= 0 ) {
                result = false;
            }
        }
    }
    return result;
};

/**
 * examine column titles to pick likely ordering
 * @param titles
 */
const guessColumnDataByTitles = function ( titles ) {
    let cols = { emailCol: -1, idCol: -1, firstNameCol: -1, lastNameCol: -1 }

    var numColumns = titles.length;

    for (var i = 0; i < numColumns; i++) {
        if ( titles[ i ].search( /mail/i ) >= 0 ) {
            this.emailCol = i;
        } else if ( titles[ i ].search( /id/ ) >= 0 ) {
            this.idCol = i;
        } else if ( titles[ i ].search( /first/ ) >= 0 ) {
            this.firstNameCol = i;
        } else if ( titles[ i ].search( /last/ ) >= 0 ) {
            this.lastNameCol = i;
        } else {
            //console.log('column not found: "' + titles[i] + '"');
        }
    }

    return cols;
};

/**
 * Examine table data to pick out column ordering
 */
const guessColumnDataByContent = function ( students ) {
    window.console.log( 'guess', students );
    var startCol = 0;
    var startRow = 0;

    var numColumns = students[ 0 ].length;
    var foundColumns = [];

    // commonNames[] is a list of the most common first names for students born between 1990-2000
    // It is used to scan a column and make a guess at which contains first names
    var commonNames = [
        'Michael', 'Christopher', 'Matthew',
        'Joshua', 'Jacob', 'Nicholas',
        'Jessica', 'Ashley', 'Emily',
        'Sarah', 'Samantha', 'Amanda'
    ];


    for (var i = startCol; i < numColumns; i++) {
        if ( students[ 0 ][ i ].search( /@/ ) >= 0 ) {
            // look for @, that's the email
            this.emailCol = i;
            foundColumns.push( i );
        } else if ( students[ 0 ][ i ].search( /[0-9]{3}/ ) >= 0 ) {
            // look for 3 digits in a row, that's the studentId
            this.idCol = i;
            foundColumns.push( i );
        } else if ( students[ 0 ][ i ] == '' ) {
            // add any empty columns to the blacklist so they are skipped later
            foundColumns.push( i );
        }
    }

    for (i = startCol; i < numColumns; i++) {
        // skip any columns which have already been flagged as email or student ID
        if ( foundColumns.indexOf( i ) > -1 ) {
            continue;
        }
        for (var j = startRow; j < students.length; j++) {
            // any column with 3 more letters is set as last name. Next column found with letters is first name
            if ( students[ j ][ i ].search( /.{3,}/ ) > -1 ) {
                if ( this.lastNameCol == -1 )
                    this.lastNameCol = i;
                else if ( this.lastNameCol != i ) {
                    this.firstNameCol = i;
                }
            }
            // look for common names and set firstNameCol if any are found
            if ( students[ j ][ i ].has( commonNames ) ) {
                this.firstNameCol = i;
                if ( this.lastNameCol == this.firstNameCol ) {
                    this.lastNameCol = -1;
                }
                foundColumns.push( i );
                break;
            }
        }
    }
}

const filterHeaderRows = ( students ) => {

    // remove any resulting lines with 1 or fewer elements
    for (i = students.length - 1; i >= 0; i--) {
        // since this looks for rows with 2 or more consecutive commas, rows that import with a few empty columns
        // at the beginning (eg:  [,,,data,data,data] ) will be spliced. IT should remove lines with only commas.
        if ( students[ i ].length <= 1 || (rows[ i ].search( /,,+/ ) >= 0 ) ) {
            students.splice( i, 1 );
            rows.splice( i, 1 );
        }
    }
    return students;
};

/**
 * [ separatorChar] defines the character that will be used to divide lines into fields
 * default: comma
 */
const separatorChar = ',';

/**
 * This does the actual reading of the file and returns
 * an array of students
 * @param event
 * @returns {Array}
 */
/*
 // handleRead = function ( event ) {
 //     // convert line endings
 //     var rows = event.target.result.toString().replace( /[\r\n]+/g, "\n" ).split( "\n" );
 //
 //     // break each row into its elements
 //     for (var i = 0; i < rows.length; i++) {
 //         students[ i ] = rows[ i ].toString().split( separatorChar );
 //     }
 //
 //     window.console.log( 'initialRead', students );
 //
 //     // remove any resulting lines with 1 or fewer elements
 //     for (i = students.length - 1; i >= 0; i--) {
 //         // since this looks for rows with 2 or more consecutive commas, rows that import with a few empty columns
 //         // at the beginning (eg:  [,,,data,data,data] ) will be spliced. IT should remove lines with only commas.
 //         if ( students[ i ].length <= 1 || (rows[ i ].search( /,,+/ ) >= 0 ) ) {
 //             students.splice( i, 1 );
 //             rows.splice( i, 1 );
 //         }
 //     }
 //     // todo restore the detection stuff once working
 //     // // analyze the file and look for column headers
 //     // var firstLine = students[ 0 ];
 //     // var startRow = 0;
 //     // if ( firstRowContainsTitles( firstLine ) ) {
 //     //     guessColumnDataByTitles( firstLine );
 //     //     // remove the header line as we don't need it any longer
 //     //     rows.splice( 0, 1 );
 //     //     students.splice( 0, 1 );
 //     // } else {
 //     //     guessColumnDataByContent( students );
 //     // }
 //
 //     // console.log( 'lnameCol:' + this.lastNameCol + ' fnameCol:' + this.firstNameCol + ' idCol:' + this.idCol + ' emailCol:' + this.emailCol );
 //
 //     return students;
 // };

 */

module.exports = {
//actions
    importStudentsFromFile: ( { state, dispatch, commit, getters }, inputFile ) => {
        return new Promise( ( resolve, reject ) => {
            console.log( 'students actions', 'startRead called: reading file', 'inputFile', inputFile );

            /*
             // reset columns. prevents bugs if two files with different orderings are imported.
             // var lastNameCol = - 1;
             // var firstNameCol = - 1;
             // var emailCol = - 1;
             // var idCol = - 1;
             //
             // var me = this;
             */

            if ( !browserSupportFileUpload() ) {
                alert( 'The file upload function is not fully supported in this browser!' );
                return;
            }

            var reader = new FileReader();
            reader.readAsText( inputFile );

            /**
             * Run the processing
             * From docs
             * The FileReader.onload property contains an event handler
             * executed when the load event is fired, when content read
             * with readAsArrayBuffer, readAsBinaryString, readAsDataURL
             * or readAsText is available.
             * https://developer.mozilla.org/en-US/docs/Web/API/FileReader/onload
             *
             * @param event
             */
            reader.onload = ( event ) => {
                let students = [];
                // convert line endings
                var rows = event.target.result.toString().replace( /[\r\n]+/g, "\n" ).split( "\n" );

                // break each row into its elements
                for (var i = 0; i < rows.length; i++) {
                    students[ i ] = rows[ i ].toString().split( separatorChar );
                }

                window.console.log( 'initialRead', students );

                // // remove any resulting lines with 1 or fewer elements
                // let students = filterHeaderRows(students);
                //dev todo re-enable filter header rows instead of just dropping them
                students.splice( 0, 1 );

                _.forEach( students, ( student ) => {
                    window.console.log( 'studentFileImporter', 'student', 249, student );

                    //todo select indexes by guessed columns
                    let ident = student[ 0 ];
                    let last = student[ 1 ];
                    let first = student[ 2 ];
                    let email = student[ 3 ];

                    //create a student object
                    let s = Student.factory( { lastName: last, firstName: first, identifier: ident, email: email } );

                    let pl = Payload.factory( { obj: s } );

                    commit( 'addStudentToRoster', pl );
                } )
                resolve();
            }
            reader.onerror = function () {
                alert( 'Unable to read ' + file.fileName ) ;
                reject();
            };

        } );

    }

};
    //
    //     function ( event ) {
    //     // convert line endings
    //     var rows = event.target.result.toString().replace( /[\r\n]+/g, "\n" ).split( "\n" );
    //     var students = [];
    //
    //     // break each row into its elements
    //     for ( var i = 0; i < rows.length; i ++ ) {
    //         students[ i ] = rows[ i ].toString().split( me.separatorChar );
    //     }
    //
    //     window.console.log('initialRead', students);
    //
    //     // remove any resulting lines with 1 or fewer elements
    //     for ( i = students.length - 1; i >= 0; i -- ) {
    //         // since this looks for rows with 2 or more consecutive commas, rows that import with a few empty columns
    //         // at the beginning (eg:  [,,,data,data,data] ) will be spliced. IT should remove lines with only commas.
    //         if ( students[ i ].length <= 1 || (rows[ i ].search( /,,+/ ) >= 0 ) ) {
    //             students.splice( i, 1 );
    //             rows.splice( i, 1 );
    //         }
    //     }
    //
    //     // analyze the file and look for column headers
    //     var firstLine = students[ 0 ];
    //     var startRow = 0;
    //     if ( me.firstRowContainsTitles( firstLine ) ) {
    //         me.guessColumnDataByTitles( firstLine );
    //         // remove the header line as we don't need it any longer
    //         rows.splice( 0, 1 );
    //         students.splice( 0, 1 );
    //     } else {
    //         me.guessColumnDataByContent( students );
    //     }
    //
    //     console.log( 'lnameCol:' + me.lastNameCol + ' fnameCol:' + me.firstNameCol + ' idCol:' + me.idCol + ' emailCol:' + me.emailCol );
    //
    //     return students;
    // };

