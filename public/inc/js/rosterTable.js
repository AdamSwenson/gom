var file;
var rows;

function addRow(firstName, lastName, id, email, rowNum) {
    //window.console.log(firstName);
    if (!document.getElementsByTagName) return;
    var tabBody = document.getElementsByTagName("tbody").item(0);
    var row = document.createElement("tr");

    var cell1 = document.createElement("td");
    var cell2 = document.createElement("td");
    var cell3 = document.createElement("td");
    var cell4 = document.createElement("td");

    var textnode1 = document.createTextNode(firstName);
    var textnode2 = document.createTextNode(lastName);
    var textnode3 = document.createTextNode(id);
    var textnode4 = document.createTextNode(email);

    cell1.appendChild(textnode1);
    cell2.appendChild(textnode2);
    cell3.appendChild(textnode3);
    cell4.appendChild(textnode4);
    row.appendChild(cell1);
    row.appendChild(cell2);
    row.appendChild(cell3);
    row.appendChild(cell4);

    row.setAttribute('id', rowNum);
    tabBody.appendChild(row);
}

// basic setup for # of columns and column ordering. These will change based on the imported roster file
var numColumns = 4;
var lastNameCol = -1;
var firstNameCol = -1;
var idCol = -1;
var emailCol = -1;

function startRead() {
    var fr = new FileReader();
    var $inputFile = $('#fileInput')[0].files[0];

    if ('name' in $inputFile) {
        fr.onload = (function (theFile) {

            return function (e) {
                rows = e.target.result.toString().split('\n');
                var line = rows.toString().split(',');
                var firstLine = rows[0].toString().split(',');

                var startRow = 0;
                if( firstRowContainsTitles(firstLine) ) {
                    startRow = 1;
                    console.log('file contains titles');
                    guessColumnDataByTitles(firstLine);
                } else {
                    console.log('file does not contain titles');
                    guessColumnDataByContent(firstLine);
                }

                console.log('lname:' + lastNameCol + ' fname:' + firstNameCol + ' id:' + idCol + ' email:' + emailCol);

                for (var i = startRow; i < rows.length - 1; i++) {
                    //window.console.log(i);
                    addRow(line[(4 * i)], line[(4 * i) + 1], line[(4 * i) + 2], line[(4 * i) + 3], "row" + (i + 1));
                }
            };
        })($inputFile);

        fr.readAsText($inputFile);
    }
}

// determines if the first row contains column headers that describe the column's content
function firstRowContainsTitles(firstLine) {
    var result = false;
    for(var i = 0; i < firstLine.length; i++) {
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

    for(var i = 0; i < numColumns; i++) {
        if ( titles[i].search(/mail/i) >= 0 ) {
            emailCol = i;
        } else if (titles[i].search(/id/) >= 0 ){
            idCol = i;
        } else if (titles[i].search(/first/) >=0 ){
            firstNameCol = i;
        } else if (titles[i].search(/last/) >=0 ) {
            lastNameCol = i;
        } else {
            //console.log('column not found: ' + titles[i]);
        }
    }
}

// examine table data to pick out column ordering
function guessColumnDataByContent(rows) {
    // tODO finish this
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
                    var $roster = $('.dataRow');
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

function updateRowValues() {
    $('.dataRow').each( function(index) {
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

