<?php

namespace Page;
use Page\ItemCard;
class ExamCard
{

    #common
    public static $mainBodyLocator = ['id' => 'exam-card'];


    #form fields
    public static function examNameLocator()
    {
        return ['id' => 'privateName'];
    }

    public static function publicExamNameLocator()
    {
        return ['id' => 'publicName'];
    }

    public static function examDetailPaneLocator()
    {
        return ['class' => 'panel-exam-detail-component'];
    }

    public static function termLocator()
    {
        return ['id' => 'term'];
    }

    public static function yearLocator()
    {
        return ['id' => 'year'];
    }


    public static $defaultTerms = ['Winter', 'Spring', 'Summer', 'Fall'];

    /* -------------------------- tests -------------------------- */
    public static function assertCardIntact( $I )
    {
        $I->expectTo("See all the major page level elements and form fields for the exam card");
        $I->seeElement(self::$mainBodyLocator);
        $I->seeElement(self::examNameLocator());
        $I->seeElement(ItemCard::settingsButtonLocator(0));
        $I->dontSeeElement(self::examDetailPaneLocator());
    }

}
