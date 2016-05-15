<?php
use Illuminate\Support\Facades\Auth;


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
class FunctionalTester extends \Codeception\Actor
{
    use _generated\FunctionalTesterActions;

    public $userId = 1;

   /**
    * Define custom actions here
    */

    /**
     * @param $I
     */
    public function logIn($I){
        $user = Auth::loginUsingId($this->userId);
        $I->amLoggedAs( $user );
    }

}
