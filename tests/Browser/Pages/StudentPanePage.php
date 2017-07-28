<?php

namespace Tests\Browser\Pages;

use App\Exam;
use App\Kumi;
use App\Student;
use App\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;
use PHPUnit\Framework\Assert as PHPUnit;

class StudentPanePage extends Page
{

    const navButton = '#exam-nav-tabs li a .students-nav';

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/setup';
//        return Setup::urlToExam($examId);
//        return '/';
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

    public function navigateToStudentsPane( Browser $browser )
    {
        return $browser->click('#exam-settings-button')
            ->click(' .students-nav')
            ->assertVisible('.add-students-panel');

    }

    /**
     * Make sure that all expected fields and controls are visible
     * @param Browser $browser
     * @return Browser
     */
    public function assertStudentPaneIntact( Browser $browser )
    {
        return $browser
            ->assertVisible('@addStudentsPanel')
            //adding buttons
            ->assertVisible('@newStudentButton')
            ->assertVisible('@importStudentsButton')
            //toggle buttons
            ->assertVisible('@studentDeleteButton')
            ->assertVisible('@studentMoveButton')
            ->assertVisible('@studentRemoveButton');
    }

    public function assertStudentRowCountIs( Browser $browser, $count )
    {
        PHPUnit::assertCount($count, $browser->elements('@studentRow'));
    }

    public function assertStudentDbCountChanged( Browser $browser, $user, $oldCount, $expectedDelta )
    {
        Auth::login($user);
        $newCount = Student::all()->count();
        PHPUnit::assertEquals($oldCount + $expectedDelta, $newCount);
        Auth::logout();
    }

    public function assertSeeNewStudentFields( Browser $browser, $notSee = false )
    {
        $fields = ["[id^='first-name-']",
            "[id^='last-name-']",
            "[id^='email-']",
            "[id^='identifier-']"];

        foreach ( $fields as $field ) {
            if ( $notSee ) {
                $browser->assertMissing($field);
            } else {
                $browser->assertVisible($field);
            }
        }
    }

    public function getStudentRowCount( Browser $browser )
    {
        return sizeof($browser->elements('@studentRow'));
    }


    public function clickNewStudentButton( Browser $browser )
    {

        $count = $this->getStudentRowCount($browser);
        $expectedCount = $count + 1;

        return $browser
            //->navigateToStudentsPane()
            ->assertVisible('@newStudentButton')
            ->click('@newStudentButton')
            ->assertStudentRowCountIs($expectedCount);
    }

    /**
     * This gets the last row, which should be the
     * newly created one.
     * @param Browser $browser
     */
    public function getNewStudentRow( Browser $browser )
    {
        $rows = $browser->elements('@studentRow');
        $length = sizeof($rows);
//        var_dump($rows);
        return $rows[$length - 1];
    }

    public function populateNewStudentRow( Browser $browser )
    {
        $row = $browser->getNewStudentRow();

    }

    /**
     * @param Browser $browser
     * @param $operation String Either delete , move , or remove
     * @return $this
     */
    public function toggleStudentEditingCheckboxes( Browser $browser, $operation )
    {
        $divClass = ".{$operation}-operation-area";
        $buttonId = "#student-{$operation}-button";
        return $browser->assertVisible($buttonId)
            ->click($buttonId)
            ->assertVisible($divClass)
            ->assertVisible('@studentOperationsConfirmationButton')
            ->assertVisible('@studentOperationsCancellationButton');
    }


    public static function createExamPopulatedWithStudentsAndReturnExam( $user, $totalStudents = 10, $totalKumi = 2 )
    {
        Auth::login($user);
        $studentsPerKumi = ceil($totalStudents / $totalKumi);
        $exam = factory(Exam::class)->create();
        $kumis = factory(Kumi::class, $totalKumi)->create();
        foreach ( $kumis as $kumi ) {
            $exam->kumis()->attach($kumi);
            $exam->save();

            //populate with students
            $students = factory(Student::class, $studentsPerKumi)->create();
            foreach ( $students as $student ) {
                $kumi->students()->attach($student);
            }
        }
        return $exam;
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@addStudentsPanel' => '.add-students-panel',
            '@studentRow' => '.student-row',
            '@studentNavTab' => '#exam-nav-tabs li a .students-nav',
            //add and import
            '@newStudentButton' => '#new-student-button', //the create new student button
            '@importStudentsButton' => '#add-students-button',
            //toggle operation checkboxes buttons
            '@studentMoveButton' => '#student-move-button',
            '@studentDeleteButton' => '#student-delete-button',
            '@studentRemoveButton' => '#student-remove-button',
            '@studentOperationCheckboxes' => 'input[class=student-operation-checkbox]',
            //confirm and cancel
            '@studentOperationsConfirmationButton' => '#confirm-student-operation-button',
            '@studentOperationsCancellationButton' => '#cancel-student-operation-button',
            //student fields
            '@firstNameFields' => "[id^='first-name-']",
            '@lastNameFields' => "[id^='last-name-']",
            '@emailFields' => "[id^='email-']",
            '@identifierFields' => "[id^='identifier-']",
            //move operations
            '@kumiSelector' => "#kumi-selector"
        ];
    }
}
