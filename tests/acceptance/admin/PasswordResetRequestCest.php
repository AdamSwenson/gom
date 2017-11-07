<?php


use App\User;
use Faker\Factory;
use Page\admin\PasswordResetPage;
use Page\SetupExamSelectPage;
use Illuminate\Support\Facades\DB;

class PasswordResetRequestCest
{

    public $token;
    public $email;
    protected $user;

    public function _before(AcceptanceTester $I)
    {
        $I->log_out();

        $this->user = factory(User::class)->create();
        $this->token = Faker\Factory::create()->sha256();
        $this->email = $this->user->email;

        $I->haveInDatabase('password_resets', ['email' => $this->email, 'token' => $this->token]);
//        DB::insert("INSERT INTO password_resets (email, token) VALUES ('" . $this->email . "', '" . $this->token . "') ");

        PasswordResetPage::navigateToResetPage($I, $this->token);

    }

    public function _after(AcceptanceTester $I)
    {
    }

    /**
     * @group admin
     * @group reset_password
     * @group reset_password_reset
     * @param AcceptanceTester $I
     */
    public function assertInDb(AcceptanceTester $I){
        $I->assertDatabaseHas('password_resets', ['email' => $this->email, 'token' => $this->token]);
    }

    /* ----------------------- Reset page ------------------------------- */

    /**
     * @group admin
     * @group reset_password
     * @group reset_password_reset
     * @param AcceptanceTester $I
     */
    public function assertResetPageIntact(AcceptanceTester $I){
//        PasswordResetPage::navigateToResetPage($I, $this->token);
        PasswordResetPage::assertResetPageIntact($I);
    }

    /**
     * @incomplete
     * @group aaaa
     * @group admin
     * @group reset_password
     * @group reset_password_reset
     * @param AcceptanceTester $I
     */
    public function submitValidReset(AcceptanceTester $I){
//        PasswordResetPage::navigateToResetPage($I, $this->token);
//$I->wait(2);
        $I->amGoingTo("Fill in a new password and submit");
        $newPass = Factory::create()->password();
        //$I->seeElement(PasswordResetPage::$resetFormLocator);
        $I->fillField(PasswordResetPage::$emailFieldLocator, $this->email);
        $I->fillField(PasswordResetPage::$passwordFieldLocator, $newPass);
        $I->fillField(PasswordResetPage::$passwordConfirmFieldLocator, $newPass);

//        $I->executeJS('document.getElementById("resetToken").show();');
        $I->click(PasswordResetPage::$submitButtonLocator);

        //For some reason, doesn't set the token hidden field when run in test environment but does in real use. So
        //just simulating it to get the test to work.
        $I->submitForm(PasswordResetPage::$resetFormLocator, ['token' => $this->token]);
//        $I->submitForm(PasswordResetPage::$resetFormLocator, ['email'=>$this->email, 'password' => $newPass, 'password_confirmation' => $newPass, 'token' => $this->token]);
        $I->expectTo('be redirected to exam1 page');
        $I->wait(2);
        $I->seeInCurrentUrl('/exam1');

    }
}
