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

    //hiding names
    public static $nameVisibilityControlButtonLocator = ['id' => 'nameVisibilityControl'];
    public static $hiddenNameText = "Name Hidden"; // text to show when student names are invisible
    public static $gradeHiddenText = "--";


    public static $typeaheadNameDropdownListLocator= ['xpath' => '//*[@id="activeStudentNameArea"]/ul'];
// '#activeStudentNameArea > ul'];

    public static $typeaheadIdDropdownListLocator= ['xpath' =>  '//*[@id="activeStudentIdentifierArea"]/ul'];

    public static function studentRowLocator($rowIndex)
    {
        return ['id' => "studentListItem{$rowIndex}"];
    }

    /**
     * Row index is 0-based
     * @param $rowIndex
     * @return array
     */
    public static function studentNameLocator($rowIndex){
        return ['id' => "studentName{$rowIndex}"];
    }

    public static function studentIdLocator($rowIndex){
        return ['id' => "studentIdentifier{$rowIndex}"];
    }

    public static function studentGradeLocator($rowIndex){
        return ['id' => "examGrade{$rowIndex}"];
    }


    /* ----------------------------- Helpers --------------------------------- */
    /**
     * Returns the student name string from the test data.
     * row number starts at 1
     * @param $rowNumber
     * @return string
     */
    public static function expectedStudentName($rowNumber){
        return "lastNameOfExisting{$rowNumber}, firstNameOfExisting{$rowNumber}";
    }

    /**
     * Returns the student id string/int from the test data
     * row number starts at 1
     * @param $rowNumber
     * @return mixed
     */
    public static function expectedStudentId($rowNumber)
    {
        $testStudentIds = [false, '--', '--', 333333333, 444444444, 555555555];
        return $testStudentIds[$rowNumber];
    }

    /* ----------------------------- Assertions ------------------------------ */

    public static function assertRowIsMarkedActive($I, $rowIndex, $not = false)
    {
        if ( $not )
        {
            $I->dontSeeElement(self::studentRowLocator($rowIndex), ['class' => 'studentListItem ' . self::$activeStudentRowClassName]);
        } else
        {
            $I->seeElement(self::studentRowLocator($rowIndex), ['class' => 'studentListItem ' . self::$activeStudentRowClassName]);
        }
    }

    public static function assertRowIsMarkedGraded($I, $rowIndex, $not = false)
    {
        if ( $not )
        {
            $I->expect("that row index $rowIndex is not marked graded");
            $I->dontSeeElement(self::studentRowLocator($rowIndex), ['class' => self::$gradedStudentRowFullClass]);
        } else
        {
            $I->seeElement(self::studentRowLocator($rowIndex), ['class' => self::$gradedStudentRowFullClass]);
        }

    }

    /**
     * Asserts that does not have active or graded classes, and does have unaltered class
     * @param $I
     * @param $rowIndex
     */
    public static function assertRowIsUnaltered($I, $rowIndex)
    {
        self::assertRowIsMarkedActive($I, $rowIndex, true);
        self::assertRowIsMarkedGraded($I, $rowIndex, true);
        $I->seeElement(self::studentRowLocator($rowIndex), ['class' => 'studentListItem ' . self::$unalteredStudentRowClassName]);

//do manual check also since the initial state won't have unaltered Student class?
    }


    public static function assertNamesAreHidden($I, $numberStudents, $not=false)
    {
        $I->expect("that the names are hidden");
        for($i=0; $i<$numberStudents; $i++){
            if($not){
                $I->expect("that the name in row index $i is hidden");
                $I->dontSee(RosterArea::$hiddenNameText, RosterArea::studentNameLocator($i));
            }else{
                $I->expect("that the name in row index $i is visible");
                $I->see(RosterArea::$hiddenNameText, RosterArea::studentNameLocator($i));
            }
        }

    }
}
