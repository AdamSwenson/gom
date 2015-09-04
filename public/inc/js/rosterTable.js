var file;
var rows;

function addRow(row) {
    var fName = "--";
    if (firstNameCol >= 0)
        fName = row[firstNameCol];

    var lName = "--";
    if (lastNameCol >= 0)
        lName = row[lastNameCol];

    var id = "--";
    if (idCol >= 0)
        id = row[idCol];

    var email = "--";
    if (emailCol >= 0)
        email = row[emailCol];

    var $newRow = $('#dataRow0').clone();
    $newRow.find('#lastName').attr('value', lName);
    $newRow.find('#firstName').attr('value', fName);
    $newRow.find('#studentIdentifier').attr('value', id);
    $newRow.find('#email').attr('value', email);
    $newRow.appendTo($('#studentRosterBody'));
    updateRowValues();
}

// basic setup for # of columns and column ordering. These will change based on the imported roster file
var numColumns = 4;
var lastNameCol = -1;
var firstNameCol = -1;
var idCol = -1;
var emailCol = -1;
// [separatorChar] defines the character that will be used to divide lines into fields
// by default, this is ',' for a CSV file.
var separatorChar = ',';

function startRead() {
    var fr = new FileReader();
    var $inputFile = $('#fileInput')[0].files[0];

    if ('name' in $inputFile) {
        fr.onload = (function (theFile) {
            // this is called once the readAsText($inputFile) function reports done.
            return function (e) {
                rows = e.target.result.toString().split('\n');
                var lines = [];
                var lineLength = 0;
                // break each row into its CSVs
                for (var i = 0; i < rows.length; i++) {
                    lines[i] = rows[i].toString().split(separatorChar);
                    if (i === 0) {
                        lineLength = lines[0].length;
                    }
                    // make sure all lines have the same number of elements
                    if (lineLength != lines[i].length) {
                        console.log(' line ' + i + ' not of length ' + lineLength + '. Removing.');
                        // TODO: print "not all lines are of equal length" error
                    }

                    if (lines[i].length < 2) {
                        lines.splice(i, 1); // remove any lines with 1 or no elements
                    }
                }
                var firstLine = lines[0];
                var startRow = 0;
                if (firstRowContainsTitles(firstLine)) {
                    startRow = 1;
                    //console.log('file contains titles');
                    guessColumnDataByTitles(firstLine);
                } else {
                    //console.log('file does not contain titles');
                    guessColumnDataByContent(lines);
                }

                console.log('lname:' + lastNameCol + ' fname:' + firstNameCol + ' id:' + idCol + ' email:' + emailCol);

                for (var i = startRow; i < rows.length - 1; i++) {
                    addRow(rows[i].toString().split(separatorChar));
                }
            };
        })($inputFile);

        fr.readAsText($inputFile);
    }
}

// determines if the first row contains column headers that describe the column's content
function firstRowContainsTitles(firstLine) {
    var result = false;
    for (var i = 0; i < firstLine.length; i++) {
        if (firstLine[i].search(/mail/i) >= 0 || firstLine[i].search(/name/i) >= 0) {
            result = true;
        }
        if (firstLine[i].search(/@/) >= 0) {
            result = false;
        }
    }
    return result;
}

// examine column titles to pick likely ordering
function guessColumnDataByTitles(titles) {
    numColumns = titles.length;

    for (var i = 0; i < numColumns; i++) {
        if (titles[i].search(/mail/i) >= 0) {
            emailCol = i;
        } else if (titles[i].search(/id/) >= 0) {
            idCol = i;
        } else if (titles[i].search(/first/) >= 0) {
            firstNameCol = i;
        } else if (titles[i].search(/last/) >= 0) {
            lastNameCol = i;
        } else {
            //console.log('column not found: "' + titles[i] + '"');
        }
    }
}

// examine table data to pick out column ordering
function guessColumnDataByContent(lines) {
    var startCol = 0;
    var startRow = 0;
    numColumns = lines[0].length;
    var foundColumns = [];
    for (var i = 0; i < numColumns; i++) {
        if (lines[0][i].search(/@/) >= 0) {
            // look for @, that's the email
            emailCol = i;
            foundColumns.push(i);
        } else if (lines[0][i].search(/[0-9]{3}/) >= 0) {
            // look for 3 digits in a row, that's the studentId
            idCol = i;
            foundColumns.push(i);
        } else if (lines[0][i] == '') {
            // add any empty columns to the blacklist so they are skipped later
            foundColumns.push(i);
        }
    }

    // commonNames[] is a list of the most common first names for students born between 1990-2000
    // It is used to scan a column and make a guess at which contains first names
    var commonNames = ['Michael', 'Christopher', 'Matthew', 'Joshua', 'Jacob', 'Nicholas', 'Jessica', 'Ashley', 'Emily',
        'Sarah', 'Samantha', 'Amanda'];

    // look for first names in each remaining column
    for (i = startCol; i < numColumns; i++) {
        if (foundColumns.indexOf(i) > -1) {
            continue;
        }
        for (var j = startRow; j < lines.length; j++) {
            console.log('looking at ' + j + ',' + i + ': ' + lines[j][i]);
            // any column with 3 more letters is last name. Next one found is first name
            if (lines[j][i].search(/.{3,}/) > -1) {
                if (lastNameCol == -1)
                    lastNameCol = i;
                else if (lastNameCol != i) {
                    firstNameCol = i;
                }
            }
            // look for common names and set firstNameCol if any are found
            if ($.inArray(lines[j][i], commonNames) > -1) {
                firstNameCol = i;
                if (lastNameCol == firstNameCol) {
                    lastNameCol = -1;
                }
                foundColumns.push(i);
                break;
            }
        }
    }
}


// creates a modal that allows the user to add a new student.
function addStudent() {
    updateRowValues();
}

function deleteStudent(row) {
    bootbox.dialog({
        message: "Warning: this will delete the student, including their feedback and scores.",
        title: "Delete Student",
        buttons: {
            success: {
                label: 'Cancel',
                className: "btn-sm",
                callback: function () {
                }
            },
            danger: {
                label: '<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Delete',
                className: "btn-danger btn-sm",
                callback: function () {
                    $('#dataRow' + row).remove();
                    updateRowValues();
                }
            }
        }
    });
}

function deleteRoster() {
    bootbox.dialog({
        message: "Warning: This will remove all students from the current roster",
        title: "Delete Roster",
        buttons: {
            success: {
                label: 'Cancel',
                className: "btn-sm",
                callback: function () {
                }
            },
            danger: {
                label: '<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Delete',
                className: "btn-danger btn-sm",
                callback: function () {
                    var $roster = $('#studentRosterBody').find('tr');
                    $roster.each(function (index) {
                        $(this).remove();
                    });
                }
            }
        }
    });
}

// sorts the StudentRoster by the clicked header. Sort order reverses with each press.
var sortAsc = true;

function sortRosterBy(value) {
    var $roster = $('#studentRosterBody');
    $roster.append(
        $roster.find('.dataRow').sort(function (a, b) {
            var i = $(a).find('[id^="' + value + '"]');
            var j = $(b).find('[id^="' + value + '"]');
            var result = $(i).prop('value').toUpperCase().localeCompare(
                $(j).prop('value').toUpperCase());
            // flip results if we're sorting in DESC
            if (!sortAsc) {
                result *= -1;
            }
            return result;
        })
    );
    sortAsc = !sortAsc;
    updateRowValues();
}

// set all attributes to the proper row values
function updateRowValues() {
    var $rows = $('#studentRosterBody').find('.dataRow');
    $rows.each(function (index) {
        index += 1;
        $(this).attr('id', 'dataRow' + index);
        $(this).find('#lastName').attr('name', 'lastName' + index);
        $(this).find('#firstName').attr('name', 'firstName' + index);
        $(this).find('#email').attr('name', 'email' + index);
        $(this).find('#studentIdentifier').attr('name', 'studentIdentifier' + index);
        $(this).find('#deleteButton').attr('onclick', 'deleteStudent(' + index + ')');
        $(this).find('[name^="id"]').attr('name', 'id' + index);
    });
}

