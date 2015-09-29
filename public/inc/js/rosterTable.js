/**
 *  Functions used by the edit_roster page to add / edit / delete & sort students.
 *   9/11/2015 -bb
 */

var file;
var rows;

// clone and populate a new row in the roster table. The file importer calls this to place items in the form.
function addStudentToTable(lName, fName, id, email) {
    var $newRow = $('#dataRow0').clone();
    $newRow.find('#lastName').attr('value', lName);
    $newRow.find('#firstName').attr('value', fName);
    $newRow.find('#studentIdentifier').attr('value', id);
    $newRow.find('#email').attr('value', email);
    $newRow.appendTo($('#studentRosterBody'));
    updateRowValues();

    return $newRow;
}

// called by 'Add Student' button
function addStudent() {
    var $newRow = addStudentToTable('', '', '', '');
    $newRow.find('#lastName').focus();
}

function deleteStudent(row) {
    // skip confirmation if row is empty
    var $student = $('#dataRow' + row);
    if (!$student.find('#lastName').val() && !$student.find('#firstName').val() && !$student.find('#email').val() && !$student.find('#studentIdentifier').val()) {
        $student.remove();
        return;
    }

    bootbox.dialog({
        message: '<span class="glyphicon glyphicon-warning-sign text-danger" aria-hidden="true"></span> ' +
                    'Warning: this will delete the student, including their feedback and scores.',
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
                    $student.remove();
                    updateRowValues();
                }
            }
        }
    });
}

// confirm, then delete all students.
function deleteRoster() {
    var $roster = $('#studentRosterBody').find('tr');
    if ($roster.length == 0) return;

    bootbox.dialog({
        message: "Warning: This will remove all students from the current roster, including grades and feedback.",
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
                    $roster.each(function () {
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

