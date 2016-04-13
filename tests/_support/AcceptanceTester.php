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

   /**
    * Define custom actions here
    */

    /**
     * @param $I
     */
    function test_login($I){
        // if snapshot exists - skipping login
        if ($I->loadSessionSnapshot('login')) return;
        // logging in
        $I->amOnPage('/auth/login');
        $I->fillField(['id' => 'email'], 'test2@gradeomatic.net');
        $I->fillField('//*[@id="password"]', 'testtest');
        $I->click('#login');
        // saving snapshot
        $I->saveSessionSnapshot('login');
    }

}
