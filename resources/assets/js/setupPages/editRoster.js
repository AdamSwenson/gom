var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

require( 'bootstrap' );

var common = require( '../common.js' );

var bootbox = require('bootbox');

var rosterTable = require('./rosterTable.js');

var rosterImport = require('./rosterFileImport.js');
//require('./rosterFileImport.js')();

$(".deleteStudentButton" ).on('click', function(){
   var rowId = $(this ).data('rowid');
    if(rowId){
        rosterTable.deleteStudent(rowId);
    }
});

$("#sortByFirstName" ).on('click', function(){
    rosterTable.sortRosterBy('firstName')
});
$("#sortByLastName" ).on('click', function(){
    rosterTable.sortRosterBy('lastName')
});

$("#sortByStudentIdentifier" ).on('click', function(){
    rosterTable.sortRosterBy('studentIdentifier')
});
$("#sortByEmail" ).on('click', function(){
    rosterTable.sortRosterBy('email')
});


$("#addStudent" ).on('click', function(){
    rosterTable.addStudent();
});
$("#deleteRoster" ).on('click', function(){
    rosterTable.deleteRoster();
});


$("#importHelpButton" ).on('click', function(){
    showImportHelp()
});
$("#backNavButton" ).on('click', function(){
    submitAndNavigateTo(backNavTarget);
});
$("#forwardNavButton" ).on('click', function(){
    submitAndNavigateTo(forwardNavTarget);
});

function rosterHelpUrl(){
    return baseUrl + '/help#rosterSetup';
}


/*
 THINGS TODO:
 - column swapping
 - XLS / XLSX support
 */

function showImportHelp() {
    bootbox.dialog({
        message: "<p>Student roster files should be formatted as a .CSV file type.</p>" +
        "<p>Each row holds one student's data, with the following information:</p>" +
        "<ul><li>Last name</li> <li>first name</li> <li>ID (optional)</li> <li>email (optional)</li></ul>" +
        "<p>Using these 4 fields as the first row of the file, though not required, " +
        "will make it more likely that the data can be imported correctly.</p>" +
        "For more detailed instructions, please see <a href='" + rosterHelpUrl() + "'>" + rosterHelpUrl() + "</a>",
        title: "Import Help",
        buttons: {
            success: {
                label: "Ok",
                className: "btn-primary",
                callback: function () {
                }
            }
        }
    });
}

function submitAndNavigateTo(target) {
    var $table = $('#studentRosterBody');
    var valid = true;

    // check that first and last names have values
    $table.find('[id$="Name"]').each(function () {
        if ($(this).val() == '') {
            valid = false;
        }
    });

    if (valid) {
        $('[name="navigateTo"]').val(target);
        $('#rosterData').submit();
    } else {
        bootbox.alert("Name missing! Make sure all students have a first and last name before proceeding.",
            function () {
            });
    }
}

//$(document).ready(function () {
    // 'upload file' listener
    $('#fileInput').change(function () {
        rosterImport.startRead();
        $(this).val(null);
    });
    //return false;
