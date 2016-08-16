<?php


use Page\admin\AccountCreatePage;
use Page\SetupExamSelectPage;

class AccountCreateCest
{
    public $faker;
    public $validEmail = 'johnthomas@csun.edu';

    public function _before(AcceptanceTester $I)
    {
//        $I->amOnPage('auth/logout');
//        $I->amOnPage(AccountCreatePage::$URL);
//
//        $this->faker = Faker\Factory::create();
    }

    public function _after(AcceptanceTester $I)
    {
    }
//
//    /**
//     * @group admin
//     * @param AcceptanceTester $I\
//     */
//    public function checkIntact(AcceptanceTester $I)
//    {
//        AccountCreatePage::assertPageIntact($I);
//    }
//
//    /**
//     * @group admin
//     * @group registration
//     * @param AcceptanceTester $I\
//     */
//    public function submitValid(AcceptanceTester $I){
//        $I->amGoingTo("fill in fields");
//        $I->fillField(AccountCreatePage::$userNameLocator, $this->faker->username);
//        $I->fillField(AccountCreatePage::$emailLocator, $this->validEmail);
//        $password = $this->faker->password;
//        $I->fillField(AccountCreatePage::$passwordLocator, $password);
//        $I->fillField(AccountCreatePage::$confirmPasswordLocator, $password);
//
//        $I->amGoingTo("submit the form");
//        $I->click(AccountCreatePage::$submitButtonLocator);
//
//        $I->expect("to see the successful redirected page");
//        $I->seeInCurrentUrl(SetupExamSelectPage::$URL);
//    }
//
//    /**
//     * @group admin
//     * @group registration
//     * @param AcceptanceTester $I\
//     */
//    public function submitValidNonParticipatingSchool(AcceptanceTester $I, $scenario)
//    {
//        $I->amGoingTo("Submit a valid request (with all fields intact) with an email from a non-participating school and see that I am prevented from registering .");
//
//        $email = 'johnthomas@ucla.edu';
//        $password = $this->faker->password;
//
//        $I->fillField(AccountCreatePage::$userNameLocator, $this->faker->username);
//        $I->fillField(AccountCreatePage::$emailLocator, $email);
//        $I->fillField(AccountCreatePage::$passwordLocator, $password);
//        $I->fillField(AccountCreatePage::$confirmPasswordLocator, $password);
//
//        $I->amGoingTo("submit the form");
//        $I->click(AccountCreatePage::$submitButtonLocator);
//
//        $I->expect("to have been redirected to the restricted registration message page");
//        $I->seeInCurrentUrl(AccountCreatePage::$URL);
//        $I->see("We are sorry. The gradeomatic is presently only available to teachers from the following institutions:");
//
//    $I->expectTo('see the email address field pre-populated ');
//        $I->seeInField(['id' => 'email'], $email);
//    }
//
//    /**
//     * @group admin
//     * @group registration
//     * @param AcceptanceTester $I\
//     */
//    public function submitInvalidBlankEmail(AcceptanceTester $I, $scenario)
//    {
//        $I->amGoingTo("fill in fields but omit the email field");
//
//        $I->fillField(AccountCreatePage::$userNameLocator, $this->faker->username);
//        //$I->fillField(AccountCreatePage::$emailLocator, $this->faker->email);
//        $password1 = $this->faker->password;
//        $I->fillField(AccountCreatePage::$passwordLocator, $password1);
//        $I->fillField(AccountCreatePage::$confirmPasswordLocator, $password1);
//
//        $I->amGoingTo("submit the form");
//        $I->click(AccountCreatePage::$submitButtonLocator);
//
//        $I->expect("to see the error message for email missing");
//        $I->wait(3);
//        $I->see(AccountCreatePage::$emailMissingMessage);
//    }
//
//    /**
//     * @group admin
//     * @group registration
//     * @param AcceptanceTester $I\
//     */
//    public function submitInvalidEmailInvalid(AcceptanceTester $I, $scenario)
//    {
//        $I->amGoingTo("submit the form without the main password field filled in (the confirm field is filled in). ");
//
//        $I->fillField(AccountCreatePage::$userNameLocator, $this->faker->username);
//        $I->fillField(AccountCreatePage::$emailLocator, 'taco');
//        $password1 = $this->faker->password;
//        $I->fillField(AccountCreatePage::$passwordLocator, $password1);
//        $I->fillField(AccountCreatePage::$confirmPasswordLocator, $password1);
//
//        $I->amGoingTo("submit the form");
//        $I->click(AccountCreatePage::$submitButtonLocator);
//
//        $I->expect("to see the error message for email missing");
//        $I->wait(3);
//        $I->see(AccountCreatePage::$emailInvalidMessage);
//    }
//
//    /**
//     * @group admin
//     * @group registration
//     * @param AcceptanceTester $I\
//     */
//    public function submitInvalidBlankUsername(AcceptanceTester $I)
//    {
//        $I->amGoingTo("submit the form leaving the username field blank. ");
//
//        $I->fillField(AccountCreatePage::$emailLocator, $this->validEmail);
//        $password1 = $this->faker->password;
//        $I->fillField(AccountCreatePage::$passwordLocator, $password1);
//        $I->fillField(AccountCreatePage::$confirmPasswordLocator, $password1);
//
//        $I->amGoingTo("submit the form");
//        $I->click(AccountCreatePage::$submitButtonLocator);
//        $I->wait(3);
//
//        $I->expect("to see the error message for username");
//        $I->see(AccountCreatePage::$usernameMessage);
//    }
//
//    /**
//     * @group admin
//     * @group registration
//     * @param AcceptanceTester $I
//     */
//    public function submitInvalidPasswordMismatch(AcceptanceTester $I)
//    {
//        $I->amGoingTo("fill in the fields with a mismatch between the password fields");
//        $I->fillField(AccountCreatePage::$userNameLocator, $this->faker->username);
//        $I->fillField(AccountCreatePage::$emailLocator, $this->validEmail);
//        $password1 = $this->faker->password;
//        $password2 = $this->faker->password;
//        $I->fillField(AccountCreatePage::$passwordLocator, $password1);
//        $I->fillField(AccountCreatePage::$confirmPasswordLocator, $password2);
//
//        $I->amGoingTo("submit the form");
//        $I->click(AccountCreatePage::$submitButtonLocator);
//        $I->wait(3);
//
//        $I->expectTo("see the error message for bad confirmation ");
//        $I->see("The password confirmation does not match.");
//    }
//
//
//    /**
//     * @group admin
//     * @group registration
//     * @param AcceptanceTester $I
//     */
//    public function submitInvalidPasswordEmpty(AcceptanceTester $I)
//    {
//        $I->amGoingTo("fill in fields");
//        $I->fillField(AccountCreatePage::$userNameLocator, $this->faker->username);
//        $I->fillField(AccountCreatePage::$emailLocator, $this->validEmail);
//        $password1 = $this->faker->password;
//
//        $I->fillField(AccountCreatePage::$confirmPasswordLocator, $password1);
//
//        $I->amGoingTo("submit the form");
//        $I->click(AccountCreatePage::$submitButtonLocator);
//        $I->wait(3);
//
//        $I->expectTo("see the error message for missing credentials");
//        $I->see(AccountCreatePage::$passwordMissingMessage);
//
//    }
//
//
//    /**
//     * @group admin
//     * @group registration
//     * @param AcceptanceTester $I
//     */
//    public function submitInvalidPasswordConfirmEmpty(AcceptanceTester $I)
//    {
//        $I->amGoingTo("fill in fields and leave the password confirmation field empty");
//        $I->fillField(AccountCreatePage::$userNameLocator, $this->faker->username);
//        $I->fillField(AccountCreatePage::$emailLocator, $this->validEmail);
//        $password1 = $this->faker->password;
//        $I->fillField(AccountCreatePage::$passwordLocator, $password1);
//
//        $I->amGoingTo("submit the form");
//        $I->click(AccountCreatePage::$submitButtonLocator);
//        $I->wait(3);
//
//        $I->expectTo("see the error message for bad credentials");
//        $I->see(AccountCreatePage::$mismatchMessage);
//    }

}
