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
    public $logoutRoute = '/auth/logout';

    /**
     * Define custom actions here
     */

    function start_artisan()
    {
       // $this->runShellCommand('APP_ENV=codeceptWorld php artisan up');
        //  shell_exec('APP_ENV=codeceptWorld php artisan serve');
    }
    
    function stop_artisan()
    {
        
        codecept_debug($this->runShellCommand('APP_ENV=codeceptWorld php artisan down'));
        codecept_debug('closed artisan');
        //  shell_exec('APP_ENV=codeceptWorld php artisan serve');
    }

    function log_out(){
        $this->amOnPage($this->logoutRoute);
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
       // $this->start_artisan();
        if(is_null($customEmail) && is_null($customPassword)){
            // If no custom credentials have been entered, then can
            // safely log in using snapshot if it exists.
            // if snapshot exists - skip login
            if ( $this->loadSessionSnapshot('login') )
            {
                return;
            }
        }

        $email = ! is_null($customEmail) ? $customEmail : $this->loginEmail;
        $password = ! is_null($customPassword) ? $customPassword : $this->loginPassword;

        // log in
        $this->amOnPage($this->loginPageRoute);
        $this->waitForElementVisible(['id' => 'email']);

        $this->fillField(['id' => 'email'], $email);
        $this->fillField(['id' => "password"], $password);
//        $I->fillField('//*[@id="password"]', $password);
        $this->click(['id' => 'login']);

        if(is_null($customEmail) && is_null($customPassword))
        {
            //Don't want to save the snapshot if the login info
            //was custom.
            // save snapshot
            $this->saveSessionSnapshot('login');
        }
        $this->wait(2);
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
