<?php

namespace Tests\Browser\Pages;

use App\Assignment;
use App\Exam;
use App\Item;
use App\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Assert as PHPUnit;

class SetupPage extends Page
{
    const URL_BASE = '/dev/setup';
    static public $mainBodyLocator = '#examEditor';
    static public $addItemToExamButton = '.add-child-to-exam-button';

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return self::URL_BASE;
    }

    /**
     * Returns the url to visit setup for a particular preexisting exam
     * @param $examId
     * @return string
     */
    static public function urlToExam( $examId )
    {
        return self::URL_BASE . '/' . $examId;
    }

    static public function settingsToggleButton( $height = 0, $depth = 0 )
    {
        return `#item-settings-button-{$height}-{$depth}`;
    }


    /**
     * Visit a setup page for a particular exam
     * Performs assertions on path and waits for mainBodyLocator
     *
     * @param Browser $browser
     * @param $examOrExamId
     * @param $userOrUserId
     * @return $this
     */
    public function navigateToExam( Browser $browser, $examOrExamId, $userOrUserId )
    {
        $user = $userOrUserId instanceof User ? $userOrUserId : User::find($userOrUserId);
        Auth::login($user);
        $exam = $examOrExamId instanceof Exam ? $examOrExamId : Exam::find($examOrExamId);
        Auth::logout();
        return $browser
            ->loginAs($user)
            ->visit(self::urlToExam($exam->id))
            ->assertPathIs(self::urlToExam($exam->id))
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
                $child = Page::addChild($assignment, $exam);
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

    public function waitForServerSyncToFinish(Browser $browser)
    {
        $browser->waitUntil("document.getElementById('isSyncing' ).value === 'false'");
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
            '@mainBodyLocator' => self::$mainBodyLocator,
            '@addItemToExamButton' => self::$addItemToExamButton,
            '@examSettingsButton' => "[id^='exam-settings-button']",
            '@addSibling' => '.add-sibling-button',
            '@addQuestion' => 'button.add-child-to-exam-button',
            '@addChild' => '.add-child-button',
            '@addChildButton' => "[id^='add-child-to-exam-button-']",
            '@item-card' => 'div .item-card-component',
            '@item-name' => 'item-name'
        ];
    }
}
