<?php


use App\Exam;
use Illuminate\Support\Facades\Auth;
use Page\report\AnalyticsPage;

class AnalyticsPageCest
{
    public $exam;

    public function _before(AcceptanceTester $I)
    {
        Auth::loginUsingId(1);
        $this->exam = Exam::find(1);
        AnalyticsPage::navigateToPage($I, $this->exam->id);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    /**
     * @group report
     * @group analytics
     * @param AcceptanceTester $I
     */
    public function checkPageIntact(AcceptanceTester $I)
    {
        AnalyticsPage::assertPageIntact($I, $this->exam->id, $this->exam->name, $this->exam->term, $this->exam->year);
    }
    
    
    
}
