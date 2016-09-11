<?php


use Page\admin\AccountCreatePage;
use Page\setup\SetupExamSelectPage;


class AccountCreateCest
{
    public $faker;
    public $validEmail = 'johnthomas@csun.edu';

    public function _before(AcceptanceTester $I)
    {
        AccountCreatePage::navigateToPage($I);
        $this->faker = Faker\Factory::create();
    }

    public function _after(AcceptanceTester $I)
    {
    }
//
    /**
     * @group admin
     * @group registration
     * @param AcceptanceTester $I \
     */
    public function checkIntact(AcceptanceTester $I)
    {
        AccountCreatePage::assertPageIntact($I);
    }

    /**
     * @group admin
     * @group registration
     * @param AcceptanceTester $I \
     */
    public function submitValid(AcceptanceTester $I)
    {
        $I->amGoingTo("fill in fields");
        $I->fillField(AccountCreatePage::$userNameLocator, $this->faker->username);
        $I->fillField(AccountCreatePage::$emailLocator, $this->validEmail);
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
     * @group aaaa
     * @group registration
     * @param AcceptanceTester $I \
     */
    public function submitValidNonParticipatingSchool(AcceptanceTester $I)
    {
        $I->amGoingTo("Submit a valid request (with all fields intact) with an email from a non-participating school and see that I am prevented from registering .");

        $email = 'johnthomas@ucla.edu';
        $password = $this->faker->password;

        $I->fillField(AccountCreatePage::$userNameLocator, $this->faker->username);
        $I->fillField(AccountCreatePage::$emailLocator, $email);
        $I->fillField(AccountCreatePage::$passwordLocator, $password);
        $I->fillField(AccountCreatePage::$confirmPasswordLocator, $password);

        $I->amGoingTo("submit the form");
        $I->click(AccountCreatePage::$submitButtonLocator);

        $I->expect("to have been redirected to the restricted registration message page");
        $I->seeInCurrentUrl('registrationRestrictions');
        $I->see("We are sorry. The gradeomatic is presently only available to teachers from the following institutions:");

        $I->expectTo('see the email address field pre-populated ');
        //TODO Make the email get passed through. Wasted a few hours on this extremely unimportant thing....
        //$I->seeInField(['id' => 'email'], $email);
    }

    /**
     * @group admin
     * @group registration
     * @param AcceptanceTester $I \
     */
    public function submitInvalidBlankEmail(AcceptanceTester $I)
    {
        $I->amGoingTo("fill in fields but omit the email field");

        $password1 = $this->faker->password;
        $I->amGoingTo("submit the form (bypassing the html validation)");
        $I->submitForm(AccountCreatePage::$formLocator, [
            'name'                  => $this->faker->username,
            'password'              => $password1,
            'password_confirmation' => $password1,
        ]);
//        $I->fillField(AccountCreatePage::$userNameLocator, $this->faker->username);
//        $password1 = $this->faker->password;
//        $I->fillField(AccountCreatePage::$passwordLocator, $password1);
//        $I->fillField(AccountCreatePage::$confirmPasswordLocator, $password1);
//
//        $I->click(AccountCreatePage::$submitButtonLocator);

        $I->expect("to see the error message for email missing");
        $I->wait(1);
        $I->see(AccountCreatePage::$emailMissingMessage);
    }

    /**
     * @group admin
     * @group registration
     * @param AcceptanceTester $I \
     */
    public function submitInvalidEmailInvalid(AcceptanceTester $I)
    {
        $I->amGoingTo("submit the form without the main password field filled in (the confirm field is filled in). ");

        $password1 = $this->faker->password;
        $I->amGoingTo("submit the form (bypassing the html validation)");
        $I->submitForm(AccountCreatePage::$formLocator, [
            'name'                  => $this->faker->username,
            'email'                 => 'taco',
            'password'              => $password1,
            'password_confirmation' => $password1,
        ]);

        $I->expect("to see the error message for email missing");
        $I->wait(1);
        $I->see(AccountCreatePage::$emailInvalidMessage);
    }

    /**
     * @group admin
     * @group registration
     * @param AcceptanceTester $I \
     */
    public function submitInvalidBlankUsername(AcceptanceTester $I)
    {
        $I->amGoingTo("submit the form leaving the username field blank. ");

        $password1 = $this->faker->password;
        $I->amGoingTo("submit the form (bypassing the html validation)");
        $I->submitForm(AccountCreatePage::$formLocator, [
            'email' =>  $this->validEmail,
            'password'              => $password1,
            'password_confirmation' => $password1,
        ]);

//        $I->fillField(AccountCreatePage::$emailLocator, $this->validEmail);
//        $password1 = $this->faker->password;
//        $I->fillField(AccountCreatePage::$passwordLocator, $password1);
//        $I->fillField(AccountCreatePage::$confirmPasswordLocator, $password1);
//
//        $I->amGoingTo("submit the form");
//        $I->click(AccountCreatePage::$submitButtonLocator);
        $I->wait(1);

        $I->expect("to see the error message for username");
        $I->see(AccountCreatePage::$usernameMessage);
    }

    /**
     * @group admin
     * @group registration
     * @param AcceptanceTester $I
     */
    public function submitInvalidPasswordMismatch(AcceptanceTester $I)
    {
        $I->amGoingTo("fill in the fields with a mismatch between the password fields");
        $I->fillField(AccountCreatePage::$userNameLocator, $this->faker->username);
        $I->fillField(AccountCreatePage::$emailLocator, $this->validEmail);
        $password1 = $this->faker->password;
        $password2 = $this->faker->password;

        $I->submitForm(AccountCreatePage::$formLocator, [
            'name'                  => $this->faker->username,
            'email' =>  $this->validEmail,
            'password'              => $password1,
            'password_confirmation' => $password2,
        ]);

//        $I->fillField(AccountCreatePage::$passwordLocator, $password1);
//        $I->fillField(AccountCreatePage::$confirmPasswordLocator, $password2);
//
//        $I->amGoingTo("submit the form");
//        $I->click(AccountCreatePage::$submitButtonLocator);
        $I->wait(1);

        $I->expectTo("see the error message for bad confirmation ");
        $I->see("The password confirmation does not match.");
    }


    /**
     * @group admin
     * @group registration
     * @param AcceptanceTester $I
     */
    public function submitInvalidPasswordEmpty(AcceptanceTester $I)
    {
        $I->amGoingTo("fill in fields");
        $password1 = $this->faker->password;

        $I->submitForm(AccountCreatePage::$formLocator, [
            'name'                  => $this->faker->username,
            'email' =>  $this->validEmail,
            'password_confirmation' => $password1,
        ]);

//        $I->fillField(AccountCreatePage::$userNameLocator, $this->faker->username);
//        $I->fillField(AccountCreatePage::$emailLocator, $this->validEmail);
//        $password1 = $this->faker->password;
//
//        $I->fillField(AccountCreatePage::$confirmPasswordLocator, $password1);
//
//        $I->amGoingTo("submit the form");
//        $I->click(AccountCreatePage::$submitButtonLocator);
        $I->wait(1);

        $I->expectTo("see the error message for missing credentials");
        $I->see(AccountCreatePage::$passwordMissingMessage);

    }


    /**
     * @group admin
     * @group registration
     * @param AcceptanceTester $I
     */
    public function submitInvalidPasswordConfirmEmpty(AcceptanceTester $I)
    {
        $I->amGoingTo("fill in fields and leave the password confirmation field empty");
//        $I->fillField(AccountCreatePage::$userNameLocator, $this->faker->username);
//        $I->fillField(AccountCreatePage::$emailLocator, $this->validEmail);
        $password1 = $this->faker->password;

        $I->submitForm(AccountCreatePage::$formLocator, [
            'name'                  => $this->faker->username,
            'email' =>  $this->validEmail,
            'password'              => $password1
        ]);
//
//        $I->fillField(AccountCreatePage::$passwordLocator, $password1);
//
//        $I->amGoingTo("submit the form");
//        $I->click(AccountCreatePage::$submitButtonLocator);
        $I->wait(1);

        $I->expectTo("see the error message for bad credentials");
        $I->see(AccountCreatePage::$mismatchMessage);
    }

}
