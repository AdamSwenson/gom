<?php
use Page\report\FeedbackPage;

//@group report
//@group feedback

//$scenario->group(['report', 'feedback']);
class StudentFeedbackCest{
public $accessKey = "634b0f6bb2e56e46da6ab48d284d08b101ec1aa168cd715a9a0e570f5947135b";
public $numQuestions = 5;
public $numElements = 5;
public $letterGrade = "A+";
public $name = 'name1';
public $identifier = 'identifier1';


public function _before(AcceptanceTester $I)
{
    $I->amOnPage(FeedbackPage::routeWithAccessKeyInRequest($this->accessKey));
    $I->waitForElementVisible(FeedbackPage::$mainBodyLocator);
}

    public function checkIntact(AcceptanceTester $I)
    {
        $I->expectTo("see that the expected student info is present");
        $I->see($this->accessKey, ['id' => FeedbackPage::$accessKeyId]);
        $I->see($this->identifier, ['id' => FeedbackPage::$studentIdentifierId]);
        $I->see($this->letterGrade, ['id' => FeedbackPage::$gradeId]);
        $I->see($this->name, ['id' => FeedbackPage::$studentNameId]);


        $I->expectTo("see that the headings and divs are present for each question and element");
        for ( $i = 1; $i <= $this->numQuestions; $i++ )
        {
            $I->see("Q{$i}:");
            $I->expectTo('see that question divs present (from outer to inner)');
            $I->seeElementInDOM(['id' => "q{$i}"]);
            $I->seeElementInDOM(['id' => "q{$i}Comments"]); //text div
            $I->seeElementInDOM(['id' => "s{$this->accessKey}_q{$i}"]); //chart div

            for ( $k = 1; $k <= $this->numElements; $k++ )
            {
                $I->seeElement(['id' => "q{$i}e{$k}"]);
            }
        }

    }


}