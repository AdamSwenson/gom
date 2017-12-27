/**
 * Created by adam on 7/7/17.
 */


const _ = window._ = require( 'lodash' );
// const Vue = require( 'vue' );

import * as mTypes from '../../mutation-types'
import * as aTypes from '../../action-types'
import * as gTypes from '../../getter-types'

import Payload from '../../../models/Payload'
import Student from '../../../models/Student'

import Kumi from '../../../models/Kumi'


// commonNames[] is a list of the most common first names for students born between 1990-2000
// It is used to scan a column and make a guess at which contains first names
const commonNames = [
    'Michael', 'Christopher', 'Matthew',
    'Joshua', 'Jacob', 'Nicholas',
    'Jessica', 'Ashley', 'Emily',
    'Sarah', 'Samantha', 'Amanda'
];

/**
 * [ separatorChar] defines the character that will be used to divide lines into fields
 * default: comma
 */
const separatorChar = ',';

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
const guessColumnDataByTitles = function ( titles, cols = {
    emailCol: -1,
    idCol: -1,
    firstNameCol: -1,
    lastNameCol: -1
} ) {
    var numColumns = titles.length;

    for (var i = 0; i < numColumns; i++) {
        if ( titles[ i ].search( /mail/i ) >= 0 ) {
            cols.emailCol = i;
        } else if ( titles[ i ].search( /id/ ) >= 0 ) {
            cols.idCol = i;
        } else if ( titles[ i ].search( /first/ ) >= 0 ) {
            cols.firstNameCol = i;
        } else if ( titles[ i ].search( /last/ ) >= 0 ) {
            cols.lastNameCol = i;
        } else {
            console.log( 'column not found: "' + titles[ i ] + '"' );
        }
    }

    // return cols;
};

/**
 * Examine table data to pick out column ordering
 */
const guessColumnDataByContent = function ( students, columns = {
    emailCol: -1,
    idCol: -1,
    firstNameCol: -1,
    lastNameCol: -1
} ) {
    window.console.log( 'studentFileImporter', 'guessColumnDataByContent', 90, students );
    var startCol = 0;
    var startRow = 0;

    var numColumns = students[ 0 ].length;
    var foundColumns = [];

    for (var i = startCol; i < numColumns; i++) {
        if ( students[ 0 ][ i ].search( /@/ ) >= 0 ) {
            // look for @, that's the email
            columns.emailCol = i;
            foundColumns.push( i );
        } else if ( students[ 0 ][ i ].search( /[0-9]{3}/ ) >= 0 ) {
            // look for 3 digits in a row, that's the studentId
            columns.idCol = i;
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
                if ( columns.lastNameCol == -1 )
                    columns.lastNameCol = i;
                else if ( columns.lastNameCol != i ) {
                    columns.firstNameCol = i;
                }
            }
            // look for common names and set firstNameCol if any are found
            if ( students[ j ][ i ].search( commonNames ) ) {
                columns.firstNameCol = i;
                if ( columns.lastNameCol == columns.firstNameCol ) {
                    columns.lastNameCol = -1;
                }
                foundColumns.push( i );
                break;
            }
        }
    }
    return columns
}

const filterHeaderRows = ( students ) => {

    // remove any resulting lines with 1 or fewer elements
    for (let i = students.length - 1; i >= 0; i--) {
        // since this looks for rows with 2 or more consecutive commas, rows that import with a few empty columns
        // at the beginning (eg:  [,,,data,data,data] ) will be spliced. IT should remove lines with only commas.
        if ( students[ i ].length <= 1 || (students[ i ].search( /,,+/ ) >= 0 ) ) {
            students.splice( i, 1 );
        }
    }
    return students;
};


module.exports = {

//actions
    importStudentsFromFile: ( { state, dispatch, commit, getters }, inputFile ) => {
        // return new Promise( ( resolve, reject ) => {
        //todo Temporarily commented out the promise while working on this since the below log gets called twice
        //todo The doubling of students on read happens because this action gets called twice. So in looking for the cause, don't focus here.... Are you listening Adam?

        window.console.log( 'studentFileImporter', 'importStudentsFromFile called', 'inputFile', inputFile );


        if ( !browserSupportFileUpload() ) {
            alert( 'The file upload function is not fully supported in this browser!' );
            return;
        }

        var reader = new FileReader();

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
            // reset columns. prevents bugs if two files with different orderings are imported.
            var columns = { emailCol: -1, idCol: -1, firstNameCol: -1, lastNameCol: -1 }

            //holds the students extracted from the file
            let students = [];

            /* We start by reading and decomposing the file */
            // convert line endings
            var rows = event.target.result.toString().replace( /[\r\n]+/g, "\n" ).split( "\n" );

            // break each row into its elements, pushing them into students
            for (var i = 0; i < rows.length; i++) {
                students[ i ] = rows[ i ].toString().split( separatorChar );
            }

            /*
            Now we can process the read data
            */
            // remove any resulting lines with 1 or fewer elements
            for (i = students.length - 1; i >= 0; i--) {
                // since this looks for rows with 2 or more consecutive commas, rows that import with a few empty columns
                // at the beginning (eg:  [,,,data,data,data] ) will be spliced. IT should remove lines with only commas.
                if ( students[ i ].length <= 1 || (rows[ i ].search( /,,+/ ) >= 0 ) ) {
                    students.splice( i, 1 );
                    rows.splice( i, 1 );
                }
            }

            /*
            At this point we have a nice clean representation
            of the input file.

            We now need to remove any non-data rows. But before
            we do that, we need to figure out what data is contained
            in each column.
             */
            // analyze the file and look for column headers
            var firstLine = students[ 0 ];
            var startRow = 0;
            if ( firstRowContainsTitles( firstLine ) ) {
                guessColumnDataByTitles( firstLine, columns );
                // remove the header line as we don't need it any longer
                rows.splice( 0, 1 );
                students.splice( 0, 1 );
            } else {
                guessColumnDataByContent( students, columns );
            }

            /* Test point: The data should be in students and columns should have correct order values */
            window.console.log( 'studentFileImporter---initialRead TP', 'students', students, 'columns', columns );


            /*
            Now that everything is processed, we can send the student
            to storage and the server
             For bug fixing, here are the values in the standard file
                // let ident = student[ 0 ];
                // let last = student[ 1 ];
                // let first = student[ 2 ];
                // let email = student[ 3 ];
             */
            _.forEach( students, ( student ) => {
                // window.console.log( 'studentFileImporter', 'student', 249, student );
                let ident = student[ columns.idCol ];
                let last = student[ columns.lastNameCol ];
                let first = student[ columns.firstNameCol ];
                let email = student[ columns.emailCol ];


                //create a student object
                let s = Student.factory( {
                    lastName: last,
                    firstName: first,
                    studentIdentifier: ident,
                    email: email
                } );
                //Push the student into local storage and create
                //a new student on the server
                dispatch(aTypes.handleNewStudentStorageAndAssociation, s );
            } );

        };

        reader.onerror = function ( inputFile ) {
            let errorText = 'Unable to read file'; //+ inputFile.fileName;
            alert( errorText );
            // reject( Error( errorText ) );
            throw Error( errorText );
        };

        return reader.readAsText( inputFile );

// resolve();
//         } );

    }

};


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

