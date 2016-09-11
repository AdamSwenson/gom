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
        $this->user = factory(User::class)->create();
        $this->token = Faker\Factory::create()->sha256();
        $this->email = $this->user->email;

        $I->haveInDatabase('password_resets', ['email' => $this->email, 'token' => $this->token]);
//        DB::insert("INSERT INTO password_resets (email, token) VALUES ('" . $this->email . "', '" . $this->token . "') ");
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
        $I->seeInDatabase('password_resets', ['email' => $this->email, 'token' => $this->token]);
    }

    /* ----------------------- Reset page ------------------------------- */

    /**
     * @group admin
     * @group reset_password
     * @group reset_password_reset
     * @param AcceptanceTester $I
     */
    public function assertResetPageIntact(AcceptanceTester $I){
        PasswordResetPage::navigateToResetPage($I, $this->token);
        PasswordResetPage::assertResetPageIntact($I);
    }

    /**
     * @group admin
     * @group reset_password
     * @group reset_password_reset
     * @param AcceptanceTester $I
     */
    public function submitValidReset(AcceptanceTester $I){
        PasswordResetPage::navigateToResetPage($I, $this->token);

        $I->amGoingTo("Fill in a new password and submit");
        $newPass = Factory::create()->password();
        $I->fillField(PasswordResetPage::$emailFieldLocator, $this->email);
        $I->fillField(PasswordResetPage::$passwordFieldLocator, $newPass);
        $I->fillField(PasswordResetPage::$passwordConfirmFieldLocator, $newPass);
        $I->click(PasswordResetPage::$submitButtonLocator);

        $I->expectTo('be redirected to exam page');
        $I->wait(2);
        $I->seeInCurrentUrl('/exam');

    }
}
