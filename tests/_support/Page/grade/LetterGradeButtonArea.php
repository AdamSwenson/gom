<?php
namespace Page\grade;

class LetterGradeButtonArea
{
    // include url of current page
    public static $URL = '';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL.$param;
    }

    /* ----------- Letter grade button -----------*/
    public static $letterGradeButtonContainerLocator = ["id" => "letterGradeArea"];

    public static $letterGradeButtonText = "Letter grade";

    public static $letterGradeListLocator = ['css' => '.letterGradeList'];


    /**
     * Returns the xpath to the label of the button
     * @param $questionNumber
     * @return string
     */
    public static function letterGradeButtonLabelLocator($questionNumber){
        return ['id' => "letterGradeForQuestion{$questionNumber}"];
    }

    public static function letterGradeButtonLocator($questionNumber){
        return ['id' => "letterGradeForQuestion{$questionNumber}"];
    }

public static function assertLetterGradeButtonVisible($I, $questionNumber){
    $I->amGoingTo("check that the letter grade button for question $questionNumber is visible");
    $I->seeElement(self::letterGradeButtonLabelLocator($questionNumber));
    $I->seeElement(self::letterGradeButtonLocator($questionNumber));
    $I->see(self::$letterGradeButtonText, self::letterGradeButtonLabelLocator($questionNumber));
}

    /**
     * @param $I
     * @param $questionNumber
     * @param $letterGrades List of arrays. Constituent arrays should have key display_value
     */
    public static function assertClickingLetterGradeButtonRevealsGradeList($I, $questionNumber, $letterGrades)
    {
        $I->expectTo("see the list of grades once I click the button");
        $I->click(self::letterGradeButtonLocator($questionNumber));
$I->wait(1);
      //  $I->waitForElementVisible(self::$letterGradeListLocator);
        $I->seeElement(self::$letterGradeListLocator);

        $I->expectTo("see each of the letter grades ");
        foreach ( $letterGrades as $g )
        {
            $I->expectTo("see the grade {$g['display_value']}");
            $I->see($g['display_value'], self::$letterGradeListLocator);
        }
    }


}
