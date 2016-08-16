<?php


use App\Jobs\Feedback\NotifySingleStudent;
use Page\report\StudentControlsPage;

class ReportControllerCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function notifyStudent(FunctionalTester $I)
    {
        $examId = 1;
        StudentControlsPage::navigateToPage($I, $examId);
        $this->expectsJobs(NotifySingleStudent::class);
    }
}
