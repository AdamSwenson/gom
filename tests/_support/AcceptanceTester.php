<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = null)
 *
 * @SuppressWarnings(PHPMD)
 */
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    public $loginPageRoute = '/auth/login';
    public $loginEmail = 'test2@gradeomatic.net';
    public $loginPassword = 'testtest';

    /**
     * Define custom actions here
     */

    function start_artisan()
    {
        //  shell_exec('APP_ENV=codeceptWorld php artisan serve');
    }

    /**
     * Logs in to the gradeomatic.
     * Will use standard credentials and attempt to do it from
     * a stored snapshot if the custom credentials are null.
     * If custom credentials are used, it will not save a snapshot
     * @param $I
     * @param null $customEmail
     * @param null $customPassword
     */
    function test_login($I, $customEmail = null, $customPassword = null)
    {
        if(is_null($customEmail) && is_null($customPassword)){
            // If no custom credentials have been entered, then can
            // safely log in using snapshot if it exists.
            // if snapshot exists - skip login
            if ( $I->loadSessionSnapshot('login') )
            {
                return;
            }
        }

        $name = ! is_null($customEmail) ? $customEmail : $this->loginEmail;
        $password = ! is_null($customPassword) ? $customPassword : $this->loginPassword;

        // log in
        $I->amOnPage($this->loginPageRoute);
        $I->fillField(['id' => 'email'], $this->loginEmail);
        $I->fillField('//*[@id="password"]', $this->loginPassword);
        $I->click('#login');

        if(is_null($customEmail) && is_null($customPassword))
        {
            //Don't want to save the snapshot if the login info
            //was custom.
            // save snapshot
            $I->saveSessionSnapshot('login');
        }
    }

    /**
     * From http://theaveragedev.com/two-codeception-acceptance-tests-gotchas/
     * See also http://stackoverflow.com/questions/23825924/codeception-selenium-waitforjs-and-ajax
     * @param $I
     */
    public function waitForAjax($I)
    {
// some js will fire here and the `foo` query var should be appended to the URL
        $I->waitForJs('return jQuery.active == 0', 10);

    }


}
