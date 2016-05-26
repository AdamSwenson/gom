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

    public static $activeStudentColor = '#337ab7';
    public static $gradedStudentColor = '#5cb85c';

    public static $initialStudentColor = 'white';
    public static $initialTextColor = 'black';
    public static $alteredStudentTextColor = 'white';

    /** @var string The class each student row has */
    public static $studentRowClass = 'studentListItem';

    public static $activeStudentRowClassName = 'activeStudentRow';
    public static $gradedStudentRowClassName = 'gradedStudentRow';
    public static $unalteredStudentRowClassName = 'unalteredStudentRow';

    public static $activeStudentRowFullClass = 'studentListItem unalteredStudentRow';
    public static $gradedStudentRowFullClass = 'studentListItem gradedStudentRow';


    public static function studentRowLocator($rowIndex)
    {
        return ['id' => "studentListItem{$rowIndex}"];
    }


    public static function assertRowIsMarkedActive($I, $rowIndex, $not = false)
    {
        if ( $not )
        {
            $I->dontSeeElement(self::studentRowLocator($rowIndex), ['class' => self::$activeStudentRowClassName]);
        } else
        {
            $I->seeElement(self::studentRowLocator($rowIndex), ['class' => self::$activeStudentRowClassName]);
        }
    }

    public static function assertRowIsMarkedGraded($I, $rowIndex, $not = false)
    {
        if ( $not )
        {
            $I->dontSeeElement(self::studentRowLocator($rowIndex), ['class' => self::$gradedStudentRowFullClass]);
        } else
        {
            $I->seeElement(self::studentRowLocator($rowIndex), ['class' => self::$gradedStudentRowFullClass]);
        }

    }

    public static function assertRowIsUnaltered($I, $rowIndex)
    {
        self::assertRowIsMarkedActive($I, $rowIndex, true);
        self::assertRowIsMarkedGraded($I, $rowIndex, true);
        $I->seeElement(self::studentRowLocator($rowIndex), ['class' => self::$unalteredStudentRowClassName]);

//do manual check also since the intial state won't have unaltered Student class?
    }
}
