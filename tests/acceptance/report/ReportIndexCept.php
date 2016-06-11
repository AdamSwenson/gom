<?php
use Page\report\QualityControlPage;
use Page\report\AnalyticsPage;
use Page\report\ReportIndexPage;
use Page\report\StudentControlsPage;

$examIdToFollow = 1;
$numberOfExams = 5;
$examIdsToSkip = [3]; //belongs to another user

$scenario->group('report');
$I = new AcceptanceTester($scenario);
$I->wantTo('Inspect the /report page and make sure the navigation functions work correctly. (Releasing and locking are handled in separate file)');
$I->test_login($I);
$I->wait(2);
$I->amOnPage(ReportIndexPage::$URL);
$I->wait(10);
//$I->waitForElement(['id' => 'scriptBox']);

ReportIndexPage::verifyPageIntact($I, $numberOfExams, $examIdsToSkip);

$I->amGoingTo("Click the dropdown toggle button for each exam and see the expected options");
for ( $i = 1; $i <= $numberOfExams; $i++ )
{
    if ( ! in_array($i, $examIdsToSkip) )
    {
        $I->click(ReportIndexPage::dropdownButtonLocator($i));
        $I->wait(1);
        $I->seeLink(ReportIndexPage::$analyticsText, ReportIndexPage::analyticsLink($i));
        $I->seeLink(ReportIndexPage::$qualityControlText, ReportIndexPage::qualityControlLink($i));
        $I->seeLink(ReportIndexPage::$exportControlsText, ReportIndexPage::exportControlsLink($i));
        $I->seeLink(ReportIndexPage::$studentControlsText, ReportIndexPage::studentControlsLink($i));
    }
}

$I->amGoingTo("Try each of the drop down options (except export) and check that I am properly redirected");
    $I->expectTo("be redirected to the analytics page");
    //display menu
    $I->click(ReportIndexPage::dropdownButtonLocator($examIdToFollow));
    $I->wait(1);
    //click link
    $I->click(ReportIndexPage::analyticsLinkLocator($examIdToFollow));
    $I->wait(2);
    //check in right place
    $I->seeInTitle(AnalyticsPage::$pageTitleText);
    $I->canSeeInCurrentUrl(AnalyticsPage::URL($examIdToFollow));
    //go back
    $I->amOnPage(ReportIndexPage::$URL);
    $I->wait(2);
    ReportIndexPage::verifyPageIntact($I, $numberOfExams, $examIdsToSkip);


    $I->expectTo("be redirected to the student controls page");
    //display menu
    $I->click(ReportIndexPage::dropdownButtonLocator($examIdToFollow));
    $I->wait(1);
    //click link
    $I->click(ReportIndexPage::studentControlsLinkLocator($examIdToFollow));
    $I->wait(2);
    //check in right place
    $I->seeInTitle(StudentControlsPage::$pageTitleText);
    $I->canSeeInCurrentUrl(StudentControlsPage::URL($examIdToFollow));
    //go back
    $I->amOnPage(ReportIndexPage::$URL);
    $I->wait(2);
    ReportIndexPage::verifyPageIntact($I, $numberOfExams, $examIdsToSkip);

    $I->expectTo("be redirected to the quality control page");
    //display menu
    $I->click(ReportIndexPage::dropdownButtonLocator($examIdToFollow));
    $I->wait(1);
    //click link
    $I->click(ReportIndexPage::qualityControlLinkLocator($examIdToFollow));
    $I->wait(2);
    //check in right place
    $I->seeInTitle(QualityControlPage::$pageTitleText);
    $I->canSeeInCurrentUrl(QualityControlPage::URL($examIdToFollow));
    //go back
    $I->amOnPage(ReportIndexPage::$URL);
    $I->wait(2);
    ReportIndexPage::verifyPageIntact($I, $numberOfExams, $examIdsToSkip);


$I->wantTo("Check that the correct message displays if no exams have been created");
//<td class="examDetailsCell" ></td>
//<td class="examNameEmptyCell"><i>No Exams Found</i></td>
//<td></td>


//$I->amGoingTo("Check that export buttons work");
//The internet says this isn't worth doing 
//e.g., http://ardesco.lazerycode.com/index.php/2012/07/how-to-download-files-with-selenium-and-why-you-shouldnt/