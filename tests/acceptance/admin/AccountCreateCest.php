<?php


use Page\admin\AccountCreatePage;
use Page\SetupExamSelectPage;

class AccountCreateCest
{
    public $faker;

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('auth/logout');
        $I->amOnPage(AccountCreatePage::$URL);

        $this->faker = Faker\Factory::create();
    }

    public function _after(AcceptanceTester $I)
    {
    }

    /**
     * @group admin
     * @param AcceptanceTester $I\
     */
    public function checkIntact(AcceptanceTester $I)
    {
        AccountCreatePage::assertPageIntact($I);
    }

    /**
     * @group admin
     * @param AcceptanceTester $I\
     */
    public function submitValid(AcceptanceTester $I){
        $I->amGoingTo("fill in fields");
        $I->fillField(AccountCreatePage::$userNameLocator, $this->faker->username);
        $I->fillField(AccountCreatePage::$emailLocator, $this->faker->email);
        $password = $this->faker->password;
        $I->fillField(AccountCreatePage::$passwordLocator, $password);
        $I->fillField(AccountCreatePage::$confirmPasswordLocator, $password);

        $I->amGoingTo("submit the form");
        $I->click(AccountCreatePage::$submitButtonLocator);

        $I->expect("to see the successful redirected page");
        $I->seeInCurrentUrl(SetupExamSelectPage::$URL);
    }

    /**
     * @group admin
     * @param AcceptanceTester $I\
     */
    public function submitValidNonParticipatingSchool(AcceptanceTester $I, $scenario)
    {
        $scenario->incomplete();

    }

    /**
     * @group admin
     * @param AcceptanceTester $I\
     */
    public function submitInvalidBlankEmail(AcceptanceTester $I, $scenario)
    {
        $scenario->incomplete();

        $I->amGoingTo("fill in fields");
        $I->fillField(AccountCreatePage::$userNameLocator, $this->faker->username);
        //$I->fillField(AccountCreatePage::$emailLocator, $this->faker->email);
        $password1 = $this->faker->password;
        $I->fillField(AccountCreatePage::$passwordLocator, $password1);
        $I->fillField(AccountCreatePage::$confirmPasswordLocator, $password1);

        $I->amGoingTo("submit the form");
        $I->click(AccountCreatePage::$submitButtonLocator);

        $I->expect("to see the error message for username");
        $I->wait(3);
        $I->see();
    }

    /**
     * @group admin
     * @param AcceptanceTester $I\
     */
    public function submitInvalidEmailInvalid(AcceptanceTester $I, $scenario)
    {
        $scenario->incomplete();
    }

    /**
     * @group admin
     * @param AcceptanceTester $I\
     */
    public function submitInvalidBlankUsername(AcceptanceTester $I)
    {
        $I->amGoingTo("fill in fields");
       // $I->fillField(AccountCreatePage::$userNameLocator, $this->faker->username);
        $I->fillField(AccountCreatePage::$emailLocator, $this->faker->email);
        $password1 = $this->faker->password;
        $I->fillField(AccountCreatePage::$passwordLocator, $password1);
        $I->fillField(AccountCreatePage::$confirmPasswordLocator, $password1);

        $I->amGoingTo("submit the form");
        $I->click(AccountCreatePage::$submitButtonLocator);

        $I->expect("to see the error message for username");
        $I->wait(3);
        $I->see();
    }

    /**
     * @group admin
     * @param AcceptanceTester $I
     */
    public function submitInvalidPasswordMismatch(AcceptanceTester $I)
    {
        $I->amGoingTo("fill in fields");
        $I->fillField(AccountCreatePage::$userNameLocator, $this->faker->username);
        $I->fillField(AccountCreatePage::$emailLocator, $this->faker->email);
        $password1 = $this->faker->password;
        $password2 = $this->faker->password;
        $I->fillField(AccountCreatePage::$passwordLocator, $password1);
        $I->fillField(AccountCreatePage::$confirmPasswordLocator, $password2);

        $I->amGoingTo("submit the form");
        $I->click(AccountCreatePage::$submitButtonLocator);

        $I->wait(3);

        $I->see("The password confirmation does not match.");

    }


    /**
     * @group admin
     * @param AcceptanceTester $I
     */
    public function submitInvalidPasswordEmpty(AcceptanceTester $I)
    {
        $I->amGoingTo("fill in fields");
        $I->fillField(AccountCreatePage::$userNameLocator, $this->faker->username);
        $I->fillField(AccountCreatePage::$emailLocator, $this->faker->email);
        $password1 = $this->faker->password;
//        $I->fillField(AccountCreatePage::$passwordLocator, $password1);
        $I->fillField(AccountCreatePage::$confirmPasswordLocator, $password1);

        $I->amGoingTo("submit the form");
        $I->click(AccountCreatePage::$submitButtonLocator);

        $I->wait(3);

        $I->see("The password confirmation does not match.");

    }


    /**
     * @group admin
     * @param AcceptanceTester $I
     */
    public function submitInvalidPasswordConfirmEmpty(AcceptanceTester $I)
    {
        $I->amGoingTo("fill in fields");
        $I->fillField(AccountCreatePage::$userNameLocator, $this->faker->username);
        $I->fillField(AccountCreatePage::$emailLocator, $this->faker->email);
        $password1 = $this->faker->password;
        $I->fillField(AccountCreatePage::$passwordLocator, $password1);
//        $I->fillField(AccountCreatePage::$confirmPasswordLocator, $password1);

        $I->amGoingTo("submit the form");
        $I->click(AccountCreatePage::$submitButtonLocator);

        $I->wait(3);

        $I->see("The password confirmation does not match.");

    }

}
