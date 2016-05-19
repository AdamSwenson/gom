<?php
namespace Page\grade;

/**
 * Properties of the roster area of the grading page
 * Class RosterArea
 * @package Page\grade
 */
class RosterArea
{

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    //students table
    public static $studentsTableLocator = ['id' => "studentRoster"];

    //The cells in the table header row. These are clickable.
    public static $tableHeaderNameLocator = ['id' => "nameHeader"];
    public static $tableHeaderIdLocator = ['id' => "idHeader"];
    public static $tableHeaderGradeLocator = ['id' => "gradeHeader"];


}
