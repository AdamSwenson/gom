<?php

namespace Page;

/**
 * This covers the item cards
 * Class ItemCard
 * @package Page
 */
class ItemCard
{

    public static function itemCardLocator( $itemNum )
    {
        return ['id' => 'item-card-' . $itemNum];
    }

    public static function itemNameFieldLocator( $index )
    {
        return ['id' => 'item-name-' . $index];
    }

    public static function addYoungerSiblingButtonLocator( $index )
    {
        return ['id' => 'younger-sibling-add-button-' . $index];
    }

    public static function addOlderSiblingButtonLocator( $index )
    {
        return ['id' => 'older-sibling-add-button-' . $index];
    }

    public static function settingsButtonLocator( $index )
    {
        return ['id' => 'item-settings-button-' . $index];
    }

    public static function deleteButtonLocator( $index )
    {
        return ['id' => 'delete-item-button-' . $index];
    }

    //Edit pane
    public static function itemTextLocator( $index )
    {
        return 'item-text-' . $index;
    }

    public static function questionNumberLocator( $index )
    {
        return 'question-number-' . $index;
    }

    public static function maxScoreLocator( $index )
    {
        return 'max-score-' . $index;
    }
}
