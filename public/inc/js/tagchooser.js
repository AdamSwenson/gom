/* 
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */
/**
 * This contains the javascript for styling and using the tag chooser function (defined in tagchoosermenue.php
 */


//Style
$('#tagChooserSet').buttonset();

//bind listener to tag radio set
$('input[type=radio][name=tagChooser]').bind('change', function() {
    var t = $(this).val();
    $('tr').hide();
    $('tr.' + t).show();
});