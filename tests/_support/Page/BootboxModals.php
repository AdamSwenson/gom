<?php
namespace Page;

/**
 * Locators and tests for working with bootbox modals
 *
 * @package Page
 */
class BootboxModals
{

    public static function bootboxAlertOkButtonLocator(){
        return ['css' => 'body > div.bootbox.modal.fade.bootbox-alert.in > div > div > div.modal-footer > button'];
    }

    /**
     * Returns the locator for a standard bootbox confirmation
     * modal's confirm button.
     * @return array
     */
    public static function bootboxConfirmButtonLocator()
    {
        return ['css' => 'body > div.bootbox.modal.fade.bootbox-confirm.in > div > div > div.modal-footer > button.btn.btn-primary'];
    }

    /**
     * Returns the locator for a standard bootbox confirmation modal's
     * cancel button
     * @return array
     */
    public static function bootboxCancelButtonLocator()
    {
        return ['css' => 'body > div.bootbox.modal.fade.bootbox-confirm.in > div > div > div.modal-footer > button.btn.btn-default'];
    }


    /**
     * If using a standard bootbox confirm dialog, this will wait
     * for the modal to display and make sure that the main divs
     * are present.
     *
     * Optionally, it will check for the presence of cancel and
     * confirm buttons.
     *
     * It can also wait for the modal to disappear and check that it's gone.
     *
     * @param $I
     * @param bool $expectButtons
     * @param bool $waitForDisappear If true, waits and checks that modal disappeared
     */
    public static function waitForBootboxModal($I, $expectButtons = false, $waitForDisappear = false){
        if( ! $waitForDisappear){
            $I->expect("the standard bootbox confirmation modal to appear");
            $I->waitForElementVisible(['css' => '.modal-content .modal-body']);
            $I->seeElement(['css' => '.modal-content .modal-body']);
            $I->seeElement(['css' => '.modal-content .modal-body .bootbox-body']);

            if($expectButtons){
                $I->expectTo("see the standard bootbox confirm and cancel buttons");
                $I->seeElement(self::bootboxCancelButtonLocator());
                $I->seeElement(self::bootboxConfirmButtonLocator());
            }
        }
        else{
            $I->expect("the standard bootbox confirmation modal to disappear");
            $I->waitForElementNotVisible(['css' => '.modal-content .modal-body']);
            $I->dontSeeElement(['css' => '.modal-content .modal-body']);
            $I->dontSeeElement(['css' => '.modal-content .modal-body .bootbox-body']);
            if($expectButtons){
                $I->expectTo("the standard bootbox confirm and cancel buttons to disappear");
                $I->dontSeeElement(self::bootboxCancelButtonLocator());
                $I->dontSeeElement(self::bootboxConfirmButtonLocator());
            }
        }
    }


}
