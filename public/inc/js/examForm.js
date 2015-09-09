// set 'Setup' tab as active
$('[id^="nav"]').attr('class', '');
$('#navSetup').attr('class', 'active');

function submitForm(target) {
    $('#nextAction').val(target);
    if  ( formFieldsValid() )
        $("#examForm").submit();
    else {
        bootbox.alert('The exam must have a name, year and term to continue.');
    }
}

function formFieldsValid() {
    var valid = true;
    if( $('#name').val() == ''     ||
        $('#term').text() == 'Term' ||
        $('#year').text() == 'Year' )
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