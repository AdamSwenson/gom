<?php

namespace Tests\Browser;

use App\Exam;
use App\Student;
use App\User;
use Faker\Factory;
use Hamcrest\Core\Set;
use Illuminate\Support\Facades\Auth;
use Tests\Browser\Pages\SetupPage;
use Tests\Browser\Pages\StudentPanePage;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Assert as PHPUnit;
use Illuminate\Foundation\Testing\DatabaseMigrations;


/**
 * @group nn
 * @group setup
 * @group students
 */
class RosterTest extends DuskTestCase
{

    /* ----------------------------- Tool proving -------------------- */
    /**
     * @group setup
     * @group roster
     * @group students
     */
    public function testCreateExamPopulatedWithStudentsAndReturnExam()
    {
        $user = factory(User::class)->create();
        $totalStudents = Factory::create()->numberBetween(10, 100);
        $totalKumi = Factory::create()->numberBetween(0, 10);
        $expectedStudentsPerKumi = ceil($totalStudents / $totalKumi);

        $exam = StudentPanePage::createExamPopulatedWithStudentsAndReturnExam($user, $totalStudents, $totalKumi);

        //check
        PHPUnit::assertEquals($totalKumi, $exam->kumis()->get()->count());
        foreach ( $exam->kumis as $kumi ) {
            PHPUnit::assertEquals($expectedStudentsPerKumi, $kumi->students()->get()->count());
        }
    }


    /* ----------------------------- Intact, Toggling ---------------- */
    /**
     * @group setup
     * @group roster
     * @group students
     */
    public function testShowRoster()
    {
        $this->browse(function ( Browser $browser ) {
            $user = factory(User::class)->create();
            Auth::login($user);

            $exam = factory(Exam::class)->create();
            $this->browse(function ( Browser $browser ) use ( $user, $exam ) {
                $browser->loginAs($user)
                    ->visit(new SetupPage())
                    ->on(new StudentPanePage())
                    ->click('#exam-settings-button')
                    ->assertVisible('#exam-nav-tabs')
                    ->assertVisible('#exam-nav-tabs li a .students-nav')
                    ->assertVisible(StudentPanePage::navButton)
                    ->click(StudentPanePage::navButton)
                    ->assertVisible('.add-students-panel')
                    ->assertStudentPaneIntact();

            });
        });
    }


    /**
     *
     * @group setup
     * @group roster
     * @group import
     * @group students
     */
    public function testToggleImportStudentsAndFileSelectionInput()
    {
        $this->browse(function ( Browser $browser ) {
            $user = factory(User::class)->create();
            $this->browse(function ( Browser $browser ) use ( $user ) {
                $browser->loginAs($user)
                    ->visit(new SetupPage())
                    ->on(new StudentPanePage())
                    ->navigateToStudentsPane()
                    ->assertVisible('.add-students-panel')
                    ->assertVisible('#add-students-button')
                    ->assertMissing('#file-input')
                    ->click('#add-students-button')
                    ->assertVisible('#file-input');
            });
        });
    }


    /* ------------------------------- Uploading and adding students --------------- */

    /**
     *
     * @group setup
     * @group roster
     * @group students
     * @group createStudent
     */
    public function testManuallyAddNewStudent()
    {
        //prep
        $user = factory(User::class)->create();
        $this->browse(/**
         * @param Browser $browser
         */
            function ( Browser $browser ) use ( $user ) {
                $student = \factory(Student::class)->make();
                $lastName = $student->last_name;
                $firstName = $student->first_name;
                $email = $student->email;
                $identifier = $student->student_identifier;

                $browser->loginAs($user)
                    ->visit(new SetupPage())
                    ->on(new StudentPanePage())
                    ->navigateToStudentsPane()
                    ->assertVisible('.add-students-panel')
                    ->assertSeeNewStudentFields(true)
                    //click the button
                    // this clicks and performs assertions on row count
                    ->clickNewStudentButton()
                    //see the new student fields
                    ->assertSeeNewStudentFields()
                    //fill them in
                    ->type("[id^='first-name-']", $firstName)
                    ->type("[id^='last-name-']", $lastName)
                    ->type("[id^='email-']", $email)
                    ->type("[id^='identifier-']", $identifier)
                    //let the client side do its processing
                    //before refreshing the page
                    ->pause(10000);

                Auth::login($user);
                $s = Student::where('first_name', $firstName)
                    ->where('last_name', $lastName)
                    ->where('email', $email)
                    ->where('student_identifier', $identifier)->first();

                PHPUnit::assertTrue(isset($s));
                PHPUnit::assertEquals($firstName, $s->first_name);
                PHPUnit::assertEquals($lastName, $s->last_name);
                PHPUnit::assertEquals($email, $s->email);
                PHPUnit::assertEquals($identifier, $s->student_identifier);


//                //reload the page and make sure see them
//                ->refresh()
//                ->pause(20000)
////                ->visit(new Setup())
//                ->navigateToStudentsPane()
//                ->assertVisible('.add-students-panel')
//                ->assertSeeNewStudentFields(false)
//                ->waitFor("[id^='first-name-']")
//                ->assertVisible('.add-students-panel')
//                ->assertInputValue("[id^='first-name-']", $firstName)
//                ->assertInputValue("[id^='last-name-']", $lastName)
//                ->assertInputValue("[id^='email-']", $email)
//                ->assertInputValue("[id^='identifier-']", $identifier);

                //todo Maybe check the db too?
            });
    }


    /**
     * todo Add test that input value clears and file input disappears
     *
     * @group setup
     * @group importStudents
     * @group roster
     * @group students
     * @group csvStudentImport
     */
    public function testUploadIdealFile()
    {
        $user = factory(User::class)->create();
        $this->browse(function ( Browser $browser ) use ( $user ) {
            $parentDir = dirname(dirname(__FILE__));

            //This has all fields in the right order and values in each
            $rosterFile = $parentDir . '/_data/acceptance_test_roster_simple.csv';

//            $rosterFile = $parentDir . '/_data/acceptance_test_roster.csv';
            $rowsInRosterFile = 5;
            $origRows = 0;
            $expectedRows = $origRows + $rowsInRosterFile;

            $browser->loginAs($user)
                ->visit(new SetupPage())
                ->on(new StudentPanePage())
                ->navigateToStudentsPane()
                ->assertVisible('.add-students-panel')
                ->assertStudentRowCountIs($origRows)
                ->click('#add-students-button')
                ->assertVisible('#file-input')
                ->attach('#file-input', $rosterFile)
                ->pause(6000)
                //check
                ->assertStudentRowCountIs($expectedRows)
                ->assertStudentDbCountChanged($user, 0, $expectedRows);

            //todo reenable check display, will require navigating to the same exam
//                ->assertStudentRowCountIs($expectedRows);
//
//            //now lets reload the page and make sure we see
//            //the new students
//            $browser->loginAs($user)
//                ->visit(new SetupPage())
//                ->on(new StudentPanePage())
//                ->navigateToStudentsPane()
//                ->assertVisible('.add-students-panel')
//                ->pause(6000)
//                ->assertStudentRowCountIs($expectedRows);
        });

    }

    /**
     *
     * @group setup
     * @group roster
     * @group importStudents
     * @group students
     * @group csvStudentImport
     */
    public function testUploadFileRequiringHeaderGuess()
    {
        $user = factory(User::class)->create();
        $this->browse(function ( Browser $browser ) use ( $user ) {
            $parentDir = dirname(dirname(__FILE__));

            //This has all fields in the right order and values in each, but
            //no header row
            $rosterFile = $parentDir . '/_data/acceptance_test_roster_no_headers.csv';

            $rowsInRosterFile = 5;
            $origRows = 0;
            $expectedRows = $origRows + $rowsInRosterFile;

            $browser->loginAs($user)
                ->visit(new SetupPage())
                ->on(new StudentPanePage())
                ->navigateToStudentsPane()
                ->assertVisible('.add-students-panel')
                ->assertStudentRowCountIs($origRows)
                ->click('#add-students-button')
                ->assertVisible('#file-input')
                ->attach('#file-input', $rosterFile)
                ->pause(6000)
                ->assertStudentRowCountIs($expectedRows)
                ->assertStudentDbCountChanged($user, 0, $expectedRows);
//
//
//            //now lets reload the page and make sure we see
//            //the new students
//            $browser->loginAs($user)
//                ->visit(new StudentPanePage())
//                ->navigateToStudentsPane()
//                ->assertVisible('.add-students-panel')
//                ->assertStudentRowCountIs($expectedRows);
        });

    }

    /**
     *
     * @group setup
     * @group roster
     * @group importStudents
     * @group students
     * @group csvStudentImport
     */
    public function testUploadFileRequiringContentGuess()
    {
        $user = factory(User::class)->create();
        $this->browse(function ( Browser $browser ) use ( $user ) {
            $parentDir = dirname(dirname(__FILE__));

            //This has all fields in the right order and values in each
            //But the header fields are misnamed
            $rosterFile = $parentDir . '/_data/acceptance_test_roster_requires_content_guess.csv';

            $rowsInRosterFile = 5;
            $origRows = 0;
            $expectedRows = $origRows + $rowsInRosterFile;

            $browser->loginAs($user)
                ->visit(new SetupPage())
                ->on(new StudentPanePage())
                ->navigateToStudentsPane()
                ->assertVisible('.add-students-panel')
                ->assertStudentRowCountIs($origRows)
                ->click('#add-students-button')
                ->assertVisible('#file-input')
                ->attach('#file-input', $rosterFile)
                ->pause(6000)
                ->assertStudentRowCountIs($expectedRows)
                ->assertStudentDbCountChanged($user, 0, $expectedRows);
//
//            //now lets reload the page and make sure we see
//            //the new students
//            $browser->loginAs($user)
//                ->visit(new StudentPanePage())
//                ->navigateToStudentsPane()
//                ->assertVisible('.add-students-panel')
//                ->assertStudentRowCountIs($expectedRows);
        });

    }


    /* ----------------- Editing students ----------------------- */

    /**
     * @group setup
     * @group roster
     * @group students
     * @group editStudents
     */
    public function testEditExistingStudentAndSeeChangesPersist()
    {

    }


    /* ------------------- Operations buttons ------------------------ */
    /**
     * @group setup
     * @group roster
     * @group students
     * @group studentOps
     */
    public function testOperationButtonsDisplayCorrectly()
    {
        $user = factory(User::class)->create();
        $exam = StudentPanePage::createExamPopulatedWithStudentsAndReturnExam($user);

        $operations = ['delete', 'move', 'remove'];
        foreach ( $operations as $operation ) {
            $this->browse(function ( Browser $browser ) use ( $user, $exam, $operation ) {
                $divClass = ".{$operation}-operation-area";
                $buttonId = "#student-{$operation}-button";
                $browser->loginAs($user)
                    ->on(new SetupPage())
                    ->navigateToExam($exam, $user)
                    ->on(new StudentPanePage())
                    ->navigateToStudentsPane()
                    ->clickNewStudentButton()//we need to do this to ensure there is at least one row visible
                    ->toggleStudentEditingCheckboxes($operation)
                    ->waitFor($divClass)
                    //these duplicate assertions made by toggleStudentEditingCheckboxes
                    //Doing them explicitly here so easier for future selves to see that
                    //the behavior has been checked
                    ->assertVisible('@studentOperationsConfirmationButton')
                    ->assertVisible('@studentOperationsCancellationButton')
                    //toggle it back
                    ->click('@studentOperationsCancellationButton')
                    ->waitUntilMissing($divClass)
                    ->assertMissing($divClass)
                    ->assertMissing('@studentOperationsConfirmationButton')
                    ->assertMissing('@studentOperationsCancellationButton');
            });
        }
    }


    /**
     *
     * @group setup
     * @group roster
     * @group students
     * @group studentOps
     * @group deleteStudent
     */
    public function testDeleteStudentOperations()
    {

        //this isn't really necessary given that we start
        //with 0. But we may want to extend this test later
        //in ways where having this structure may help.
        $user = factory(User::class)->create();
        Auth::login($user);
        $numStudents = Student::all()->count();
        Auth::logout();

        $this->browse(function ( Browser $browser ) use ( $user, $numStudents ) {
            $divClass = ".delete-operation-area";
            $browser->loginAs($user)
                ->visit(new SetupPage())
                ->on(new StudentPanePage())
                ->navigateToStudentsPane()
                ->clickNewStudentButton()
                //we need to do this to ensure there is
                //at least one row visible, which we now
                //check
                ->assertSeeNewStudentFields()
                //check that the db has caught up
                ->pause(10000)
                ->assertStudentDbCountChanged($user, $numStudents, 1)
                //Everything is good, so now we start the
                //delete operation
                ->toggleStudentEditingCheckboxes('delete')
                ->assertVisible($divClass)
                //make sure anything distinctive about
                //the delete operation is properly displayed
                ->assertSee('Delete')
                //select the one existing student
                ->check('.student-operation-checkbox')
                //confirm the operation
                ->click('@studentOperationsConfirmationButton')
                //make sure the delete boxes disappear
                ->waitUntilMissing($divClass)
                ->assertMissing($divClass)
                ->assertMissing('@studentOperationsConfirmationButton')
                //make sure the student is gone
                //since we never entered text, we can
                //do this by checking that the new student
                //inputs are not present
                ->assertSeeNewStudentFields(true)
                //Finally, the delete operation should've removed
                //the student completely from the db
                //So let's check that (after giving it time to run)
                ->pause(20000)
                ->assertStudentDbCountChanged($user, $numStudents, 0);
        });

    }

    /**
     * @group zzzz
     * @group setup
     * @group roster
     * @group students
     * @group studentOps
     * @group removeStudent
     */
    public function testRemoveStudentOperations()
    {
        $user = factory(User::class)->create();
        Auth::login($user);
        $numStudents = 20;

        $exam = StudentPanePage::createExamPopulatedWithStudentsAndReturnExam($user, 20);
//        $numStudents = Student::all()->count();
        Auth::logout();

        $this->browse(function ( Browser $browser ) use ( $user, $numStudents, $exam ) {
            $divClass = "div[class='remove-operation-area']";
            $browser->loginAs($user)
                ->visit(new SetupPage())
//                ->on(new SetupPage())
//                ->navigateToExam($exam, $user)
                ->on(new StudentPanePage())
                ->navigateToStudentsPane()
                ->clickNewStudentButton()
                //we need to do this to ensure there is
                //at least one row visible, which we now
                //check
                ->assertSeeNewStudentFields()
                //check that the db has caught up
                ->pause(5000)
//                ->assertStudentDbCountChanged($user, $numStudents, 1)

                //Everything is good, so now we start the
                //removal operation
                ->toggleStudentEditingCheckboxes('remove')
                ->assertVisible($divClass)
                //make sure anything distinctive about
                //the delete operation is properly displayed
                ->assertSee('Remove')
                //                //select the one existing student

//                ->click("input[label='Remove']")
                ->assertVisible("input[id^='student-operation-checkbox']")
                ->check("input[id^='student-operation-checkbox']")
                //                ->waitFor("input[id^='student-operation-checkbox']")
//                ->check("input[id^='student-operation-checkbox']")
                //confirm the operation
                ->click('@studentOperationsConfirmationButton')
                //make sure the delete boxes disappear
                ->waitUntilMissing($divClass)
                ->assertMissing($divClass)
                ->assertMissing('@studentOperationsConfirmationButton')
                //make sure the student is gone
                //since we never entered text, we can
                //do this by checking that the new student
                //inputs are not present
                ->assertSeeNewStudentFields(true)
                //Finally, the remove operation should not
                //have  removed the student completely from the db
                //So let's check that the increased count is
                //still the same (after giving it time to run)
                ->pause(5000)
                ->assertStudentDbCountChanged($user, $numStudents, 1);
        });
    }

    /**
     *
     * @group setup
     * @group roster
     * @group students
     * @group studentOps
     * @group moveStudent
     */
    public function testMoveStudentOperations()
    {
        $user = factory(User::class)->create();
        Auth::login($user);
        $numStudents = Student::all()->count();
        Auth::logout();

        $this->browse(function ( Browser $browser ) use ( $user, $numStudents ) {
            $divClass = ".move-operation-area";

            $browser->loginAs($user)
                ->visit(new SetupPage())
                ->on(new StudentPanePage())
                ->navigateToStudentsPane()
                ->clickNewStudentButton()
                //we need to do this to ensure there is
                //at least one row visible, which we now
                //check
                ->assertSeeNewStudentFields()
                //check that the db has caught up
                ->pause(5000)
                ->assertStudentDbCountChanged($user, $numStudents, 1)
                //Everything is good, so now we start the
                //removal operation
                ->toggleStudentEditingCheckboxes('move')
                ->assertVisible($divClass)
                //make sure anything distinctive about
                //the delete operation is properly displayed
                ->assertSee('Select group to move student to')
                ->assertVisible('@kumiSelector')
                //select the one existing student
                ->check("[id^='student-operation-checkbox']")
                //select destination group
                //todo

                //confirm the operation
                ->click('@studentOperationsConfirmationButton')
                //make sure the delete boxes disappear
                ->waitUntilMissing($divClass)
                ->assertMissing($divClass)
                ->assertMissing('@studentOperationsConfirmationButton')
                //make sure the student is gone
                //since we never entered text, we can
                //do this by checking that the new student
                //inputs are not present
                ->assertSeeNewStudentFields(true)
                //Finally, the remove operation should not
                //have  removed the student completely from the db
                //So let's check that the increased count is
                //still the same (after giving it time to run)
                ->pause(5000)
                ->assertStudentDbCountChanged($user, $numStudents, 1);
        });
    }
}



