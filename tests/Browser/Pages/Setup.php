<?php

namespace Tests\Browser\Pages;

use App\Assignment;
use App\Exam;
use App\Item;
use App\Repositories\Assignment\AssignmentRepositoryTest;
use App\User;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class Setup extends BasePage
{
    static public $mainBodyLocator = '#examEditor';

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
//        $exam = Exam::all()->random();
        return '/setup';// . $exam->id;
    }

    static public function urlToExam( $examId )
    {
        return '/setup/' . $examId;
        // . $exam->id;
//        $browser->assertPathIs($this->url());
    }

    static public function settingsToggleButton( $height = 0, $depth = 0 )
    {
        return `#item-settings-button-{$height}-{$depth}`;
    }

    static public $addItemToExamButton = '.add-child-to-exam-button';

    static public function navigateToExam( Browser $browser, $examId, $userId = 1 )
    {

        $browser
            ->loginAs(User::find($userId))
            ->visit(self::urlToExam($examId))
            ->assertPathIs(self::urlToExam($examId))
            ->waitFor(self::$mainBodyLocator);

    }

    static public function addChild( Assignment $assignment, Exam $exam )
    {
        $item = factory(Item::class)->create();
        $assign = Assignment::create([
            'exam_id' => $exam->id,
            'item_id' => $item->id
        ]);
        return $assignment->addChild($assign, null, true);

    }


    static public function makeExamData( $exam, $numLevels = 3, $numChildren = 3 )
    {
        $rootItem = factory(Item::class)->create(); //standin for exam
        $parentAssignment = Assignment::create([
            'exam_id' => $exam->id,
            'item_id' => $rootItem->id
        ]);

        function r( $assignment, $exam, $numChildren, $numLevels, $level )
        {
            for ( $h = 0; $h < $numChildren; $h++ ) {
                $child = Setup::addChild($assignment, $exam);
                //if we aren't as deep as we need to go,
                //repeat everything for the child

                $level += 1;
                if ( $level <= $numLevels ) {
                    r($child, $exam, $numChildren, $numLevels, $level);
                }
            }
        }
        r($parentAssignment, $exam, $numChildren, $numLevels, 0);
        return $parentAssignment;
    }


    static public function makeOrderJsonData( $exam, $numLevels = 3, $numAtLevel = 3 )
    {
        $order = [];

        if ( !$exam ) factory(Exam::class)->create();

        $root = factory(Item::class)->create(); //standin for exam

        for ( $level = 0; $level < $numLevels; $level++ ) {

            for ( $h = 0; $h < $numAtLevel; $h++ ) {
                $item = factory(Item::class)->create();
                $order[] = [
                    'examId' => $exam->id,
                    'parentId' => $root->id,
                    'itemId' => $item->id,
                    'itemOrder' => $h];
            }
            //On the last time through, we skip
            //Otherwise, we make children
            if ( $level < $numLevels ) {
                for ( $j = 0; $j < $numAtLevel; $j++ ) {
                    $child = factory(Item::class)->create();
                    $order[] = [
                        'examId' => $exam->id,
                        'parentId' => $item->id,
                        'itemId' => $child->id,
                        'itemOrder' => $j];
                }
            }
        }
        return $order;
    }


    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser $browser
     * @return void
     */
    public function assert( Browser $browser )
    {
//        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@element' => '#selector',
            '@addSibling' => '.add-sibling-button',
            '@addQuestion' => 'button.add-child-to-exam-button',
            '@addChild' => '.add-child-button',
            '@item-card' => 'div .item-card-component',
            '@item-name' => 'item-name'
        ];
    }
}
