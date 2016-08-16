<?php

//@group setup
//@group element

//$scenario->group(['setup', 'element']);

class ElementsEditCest
{


    public function _before(AcceptanceTester $I)
    {

    }

    /**
     * @group setup
     * @group element
     * @param AcceptanceTester $I
     * @param $scenario
     */
    public function addElement(AcceptanceTester $I, $scenario)
    {
        $scenario->incomplete();
    }


    /**
     * @group setup
     * @group element
     * @param AcceptanceTester $I
     * @param $scenario
     */
    public function editElement(AcceptanceTester $I, $scenario)
    {
        $scenario->incomplete();
    }

    /**
     * @group setup
     * @group element
     * @param AcceptanceTester $I
     * @param $scenario
     */
    public function reorderElements(AcceptanceTester $I, $scenario)
    {
        $scenario->incomplete();
    }


    /**
     * @group setup
     * @group element
     * @param AcceptanceTester $I
     * @param $scenario
     */
    public function deleteElement(AcceptanceTester $I, $scenario)
    {
        $scenario->incomplete();
    }

}

