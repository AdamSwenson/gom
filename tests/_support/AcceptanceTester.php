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

    function start_artisan(){
      //  shell_exec('APP_ENV=codeceptWorld php artisan serve');
    }

    /**
     * @param $I
     */
    function test_login($I){
        // if snapshot exists - skipping login
        if ($I->loadSessionSnapshot('login')) return;
        // logging in
        $I->amOnPage($this->loginPageRoute);
        $I->fillField(['id' => 'email'], $this->loginEmail);
        $I->fillField('//*[@id="password"]', $this->loginPassword);
        $I->click('#login');
        // saving snapshot
        $I->saveSessionSnapshot('login');
    }



}
