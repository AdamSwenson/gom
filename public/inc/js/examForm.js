/*
    Functions used by create_exam and edit_exam pages to perform validation,
    submit the form and set the navigation buttons (prev / next) to their proper targets
 */

// set 'Setup' tab as active
$('[id^="nav"]').attr('class', '');
$('#navSetup').attr('class', 'active');

function submitForm(target) {
    $('#nextAction').val(target);
    if  ( formFieldsValid() )
        $("#examForm").submit();
    else {
        bootbox.alert('Please enter a name, year and term for this exam.');
    }
}

function formFieldsValid() {
    var valid = true;
    if( $('#name').val() == ''     ||
        $('#hiddenTerm').val() == '' ||
        $('#hiddenYear').val() == '' )
    {
        valid = false;
    }
    return valid;
}

$(document).ready(function() {

    $('#termList li').on('click', function () {
        var $term = $(this).text();
        $('#hiddenTerm').val( $term );

        var $icon = ' <span class="glyphicon glyphicon-menu-down"></span>';
        $('#term').html($term + $icon );
    });

    $('#yearList li').on('click', function () {
        var $year = $(this).text();
        $('#hiddenYear').val( $year );

        var $icon = ' <span class="glyphicon glyphicon-menu-down"></span>';
        $('#year').html($year + $icon);
    });

    return false;
});