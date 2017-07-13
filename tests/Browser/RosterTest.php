<?php

namespace Tests\Browser;

use App\Exam;
use App\User;
use Hamcrest\Core\Set;
use Illuminate\Support\Facades\Auth;
use Tests\Browser\Pages\Setup;
use Tests\Browser\Pages\StudentPane;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;


/**
 * @group nn
 * @group setup
 * @group students
 */
class RosterTest extends DuskTestCase
{
    /**
     */
    public function testShowRoster()
    {
        $this->browse(function ( Browser $browser ) {
            $user = factory(User::class)->create();
            Auth::login($user);
            new StudentPane();
            $exam = factory(Exam::class)->create();
            $this->browse(function ( Browser $browser ) use ( $user, $exam ) {
                $browser->loginAs($user)
                    ->visit(new Setup())
                    ->click('#exam-settings-button')
                    ->assertVisible('#exam-nav-tabs')
                    ->assertVisible('#exam-nav-tabs li a .students-nav')
                    ->assertVisible(StudentPane::navButton)
                    ->click(StudentPane::navButton)
                    ->assertVisible('.add-students-panel');
            });
        });
    }

    public function testClickNewStudent()
    {
        $this->browse(function ( Browser $browser ) {
            $user = factory(User::class)->create();
            $this->browse(function ( Browser $browser ) use ( $user ) {
                $browser->loginAs($user)
                    ->visit(new StudentPane())
                    ->navigateToStudentsPane()
                    ->assertVisible('.add-students-panel')
                    ->assertVisible('#add-students-button')
                    ->assertMissing('#file-input')
                    ->click('#add-students-button')
                    ->assertVisible('#file-input');
            });
        });
    }

    /**
     * @group nnn
     */
    public function testUploadFile()
    {
        $user = factory(User::class)->create();
        $this->browse(function ( Browser $browser ) use ( $user ) {
            $parentDir = dirname(dirname(__FILE__));

            //This has all fields in the right order and values in each
            $rosterFile = $parentDir . '/_data/acceptance_test_roster_simple.csv';

//            $rosterFile = $parentDir . '/_data/acceptance_test_roster.csv';
            $rowsInRosterFile = 5;
            $origRows = 2;
            $expectedRows = $origRows+ $rowsInRosterFile;

            $browser->loginAs($user)
                ->visit(new Setup())
                ->on(new StudentPane())
                ->navigateToStudentsPane()
                ->assertVisible('.add-students-panel')
                ->assertStudentRowCountIs($origRows)
                ->click('#add-students-button')
                ->assertVisible('#file-input')
                ->attach('#file-input', $rosterFile)
                ->pause(3000)
                ->assertStudentRowCountIs($expectedRows);

            //now lets reload the page and make sure we see
            //the new students
            $browser->loginAs($user)
                ->visit(new StudentPane())
                ->navigateToStudentsPane()
                ->assertVisible('.add-students-panel')
                ->assertStudentRowCountIs($expectedRows);
        });

    }
}
