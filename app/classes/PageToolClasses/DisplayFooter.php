<?php
namespace PageToolClasses;
/**
 * Displays a footer with the last time the file was alterd, copyright notice, and whether a test version is running
 *
 * @author adam
 */
class DisplayFooter
{
    public function __construct()
    {
        self::show();
    }

    public static function show()
    {
        $copyrightyear = date("Y");
        $testline = TestVersionIndicate::isTest('inFooter');
        $editing = self::display_editing();
        $out = <<<OUT
        <div class="footer">
        <p>&#169; Merp Co., Intl 2008-$copyrightyear</p>
        $testline
        $editing
        </div>
OUT;
echo $out;
    }
    

    /**
     * Checks if this is being displayed on my home computer. If so,
     * displays the last date the page file was edited
     */
    public static function display_editing(){
        if ((isset($_SESSION)) && (isset($_SESSION['personal'])) && ($_SESSION['personal'] === TRUE)) {
            date_default_timezone_set('America/Los_Angeles');
            $lastmod = strftime("%A %B %d, %Y", filemtime($_SERVER['SCRIPT_FILENAME']));
            return "<p> Last Modified: {$lastmod}</p>";
        }else{
            return '';
        }
    }
}
