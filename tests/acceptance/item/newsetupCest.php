<?php
namespace item;
use \AcceptanceTester;
use Page\newSetupPage;

class newSetupCest
{
    public function _before(AcceptanceTester $I)
    {
        NewSetupPage::navigateToPage($I);
    }

    public function _after(AcceptanceTester $I)
    {
    }


    /**
     * @group item
     * @group setup
     * @param AcceptanceTester $I
     */
    public function checkIntact(AcceptanceTester $I)
    {
        NewSetupPage::checkIntact($I);
    }

}
