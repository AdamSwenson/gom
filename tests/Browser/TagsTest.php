<?php

namespace Tests\Browser;

use App\User;
use Tests\Browser\Pages\SetupPage;
use Tests\Browser\Pages\TagsPage;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TagsTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testSeeTagsOnItemDetailPane()
    {

    }

    /**
     * @group tags
     */
    public function testAddTagsForItem()
    {

        $user = factory(User::class)->create();
        $this->browse(function ( Browser $browser ) use ( $user ) {
            $testText = 'taco';
            $browser->loginAs($user)
                //navigate
                ->visit(new SetupPage())
                ->waitFor(SetupPage::$mainBodyLocator)
                ->assertVisible(SetupPage::$mainBodyLocator)
                //navigate to item detail to look at tags
                ->navigateToItemDetail()
                ->on(new TagsPage())
                //reveal the menu for associating/disassociating and new tags
                ->assertTagsDisplayAreaIntact()
                ->toggleTagsMenu()
                ->assertTagsMenuVisible()
                //display the fields for creating a tag
                ->openNewTagsArea()
                //type some text in the tag name
                ->type('@newTagNameField', $testText)
                //set the priority

                //click save
                ->click("Save")
                ->pause(2000)
                //check that it displays in the object's list
                ->assertSeeIn('@tagList', $testText)
                //check that it displays in the menu list
                ->assertSeeIn('@tagMenuRow', $testText);


        });
    }

    public function testRemoveTagsFromItem()
    {
    }

    public function testAddTagsForExam()
    {
    }

    public function testRemoveTagsFromExam()
    {
    }

    public function testAddTagsForStudent()
    {
    }

    public function testRemoveTagsFromStudent()
    {
    }

    public function testAddTagsForKumi()
    {
    }

    public function testRemoveTagsFromKumi()
    {
    }
}
