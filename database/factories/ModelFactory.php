<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use App\AccessKey;
use App\Exam;
use App\Grade;
use App\Models\NewGom\Note;
use App\Models\NewGom\Tag;
use App\Question;
use App\Repositories\Grade\GradeFactory;
use App\Scopes\UserOnlyScope;
use App\Student;
use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


/*
 * Note, almost none of this will never fucking work because BaseModel
 * somehow interferes with larvel's mass fucking assignment.
 *
 * Probably fixed: Problem was actually the models overriding the constructor for models
 *
 */

$factory->define(App\User::class, function ( Faker\Generator $faker ) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Exam::class, function ( Faker\Generator $faker ) {
    return [
        'term' => $faker->text(10),
        'name' => $faker->text(15),
        'year' => $faker->year,
        'released' => 0,
        'locked' => 0,
    ];
});

$factory->define(App\Kumi::class, function ( Faker\Generator $faker ) {
    return [
        'year' => $faker->year,
        'name' => $faker->text(30),
    ];
});
$factory->defineAs(App\Kumi::class, 'with_exam', function ( Faker\Generator $faker ) use ( $factory ) {
    return [
        'year' => $faker->year,
        'name' => $faker->text(30),
    ];
});

/* ---------------------------- Student --------------------------------- */
$factory->define(App\Student::class, function ( Faker\Generator $faker ) {
    return [
        'student_identifier' => $faker->randomNumber(9),
        'last_name' => $faker->lastName,
        'first_name' => $faker->firstName,
        'email' => $faker->email,
    ];
});


/* ----------------------------- Exam components -------------------------- */

$factory->define(App\Question::class, function ( Faker\Generator $faker ) {
    $possibleMaxScores = [10, 25, 100, 200, 1000];

    return [
        'questionName' => $faker->text(20),
        'questionText' => $faker->text(200),
        'max_score' => $faker->randomElement($possibleMaxScores),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});

$factory->define(App\Element::class, function ( Faker\Generator $faker ) {
    return [
        'elementName' => $faker->text(20),
        'displayText' => $faker->text(200),
        'commentText' => $faker->paragraph(),
    ];
});

$factory->define(App\Comment::class, function ( Faker\Generator $faker ) {

    return [
        'element_id' => \App\Element::all()->random()->id,
        'valence' => $faker->randomElement(\App\Comment::$valences),
        'body' => $faker->text(200),
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});


/* ------------------- Question Assignment ---------------------------- */
/** Makes a question assignment with brand new exam and question */
$factory->define(App\QuestionAssignment::class, function ( Faker\Generator $faker ) {
    $questionId = factory(App\Question::class)->create()->id;
    $examId = factory(App\Exam::class)->create()->id;

    return [
        'question_id' => $questionId,
        'exam_id' => $examId,
        'question_number' => $faker->randomDigitNotNull,
    ];
});

$factory->defineAs(App\QuestionAssignment::class, 'preexisting', function ( Faker\Generator $faker ) use ( $factory ) {
    $userId = 1;
    Auth::logInUsingId($userId);
    $questionId = App\Question::all()->random()->id;
    $examId = App\Exam::all()->random()->id;

    return [
        'question_id' => $questionId,
        'exam_id' => $examId,
        'question_number' => $faker->randomDigitNotNull,
    ];
});


/* ------------------- Element Assignment ---------------------------- */
$factory->define(App\ElementAssignment::class, function ( Faker\Generator $faker ) {
    $userId = 1;
    Auth::logInUsingId($userId);
    $questionId = factory(App\Question::class)->create()->id;
    $elementId = factory(App\Element::class)->create()->id;
    $examId = factory(App\Exam::class)->create()->id;

    return [
        'question_id' => $questionId,
        'element_id' => $elementId,
        'exam_id' => $examId,
        'subtask' => $faker->randomDigitNotNull,
    ];
});
$factory->defineAs(App\ElementAssignment::class, 'preexisting', function ( Faker\Generator $faker ) use ( $factory ) {
    $userId = 1;
    Auth::logInUsingId($userId);
    $questionId = App\Question::all()->random()->id;
    $elementId = App\Element::all()->random()->id;
    $examId = App\Exam::all()->random()->id;

    return [
        'question_id' => $questionId,
        'element_id' => $elementId,
        'exam_id' => $examId,
        'subtask' => $faker->randomDigitNotNull,
    ];

});

/* ------------------------------------- Scores ------------------------------*/
$factory->define(App\QuestionScore::class, function ( Faker\Generator $faker ) {
    $userId = 1;
    Auth::logInUsingId($userId);
    $assignmentId = factory(App\QuestionAssignment::class)->create()->id;
    $studentId = factory(App\Student::class)->create()->id;

    return [
        'question_assignment_id' => $assignmentId,
        'student_id' => $studentId,
        'score' => $faker->randomFloat(2, 0, 100),
    ];
});

$factory->defineAs(App\QuestionScore::class, 'preexisting', function ( Faker\Generator $faker ) use ( $factory ) {
    $userId = 1;
    Auth::logInUsingId($userId);
    $assignmentId = App\QuestionAssignment::all()->random()->id;
    $studentId = App\Student::all()->random()->id;

    return [
        'question_assignment_id' => $assignmentId,
        'student_id' => $studentId,
        'score' => $faker->randomFloat(2, 0, 100),
    ];
});


$factory->define(App\ElementScore::class, function ( Faker\Generator $faker ) {
    $userId = 1;
    Auth::logInUsingId($userId);
    $assignmentId = factory(App\ElementAssignment::class)->create()->id;
    $studentId = factory(App\Student::class)->create()->id;

    return [
        'element_assignment_id' => $assignmentId,
        'student_id' => $studentId,
        'score' => $faker->randomFloat(2),
        'comment_text' => $faker->paragraph,
    ];
});
$factory->defineAs(App\ElementScore::class, 'preexisting', function ( Faker\Generator $faker ) use ( $factory ) {
    $userId = 1;
    Auth::logInUsingId($userId);
    $assignmentId = App\ElementAssignment::all()->random()->id;
    $studentId = App\Student::all()->random()->id;

    return [
        'element_assignment_id' => $assignmentId,
        'student_id' => $studentId,
        'score' => $faker->randomFloat(2),
    ];
});


/* ------------------------------------ Feedback ------------------------------ */
//$factory->define(App\AccessKey::class, function (Faker\Generator $faker)
//{
//    $studentId = factory(Student::class)->create()->id;
//    $examId = factory(Exam::class)->create()->id;
//    return [
//        'access_key' => $faker->sha1,
//        'student_id' => $studentId,
//        'exam_id' => $examId
//    ];
//});

/** Makes an access key using brand new exam and student */
$factory->define(App\AccessKey::class, function ( Faker\Generator $faker ) {
    $studentId = factory(Student::class)->create()->id;
    $examId = factory(Exam::class)->create()->id;

    return [
        'access_key' => $faker->sha1,
        'student_id' => $studentId,
        'exam_id' => $examId,
    ];
});

/** Makes an access key object using an already existing exam and already existing student */
$factory->defineAs(App\AccessKey::class, 'preexisting', function ( Faker\Generator $faker ) use ( $factory ) {
    $studentId = Student::all()->random()->id;
    $examId = Exam::all()->random()->id;

    return [
        'access_key' => $faker->sha1,
        'student_id' => $studentId,
        'exam_id' => $examId,
    ];
});


$factory->define(App\Feedback::class, function ( Faker\Generator $faker ) {
    $numberQuestions = 5;
    $numberElements = 5;
    $elAssign = 0;

    $content = [];

    for ( $i = 1; $i <= $numberQuestions; $i++ ) {
        $q = [
            "questionNumber" => $i,
            "questionId" => $i,
            "questionName" => $faker->words,
            "questionAssignmentId" => $i,
            "score" => $faker->randomFloat(2, 0, 10),
            "average" => $faker->randomFloat(2, 0, 10),
            "elements" => [],
        ];
        $elements = [];

        for ( $j = 1; $j <= $numberElements; $j++ ) {
            $elements[$j] = [
                "questionNumber" => $i,
                "subtask" => $j,
                "elementId" => $j,
                "elementAssignmentId" => $elAssign,
                "elementName" => $faker->words,
                "score" => $faker->randomFloat(2, 0, 10),
                "average" => $faker->randomFloat(2, 0, 10),
                "comment" => $faker->paragraph(),
            ];
            $elAssign += 1;
        }
        $q['elements'] = $elements;
        $content[] = $q;
    }

    $g = $faker->randomElement(GradeFactory::$grades);
    $accessKey = factory(App\AccessKey::class)->create();
    $key = $accessKey->access_key;

    return [
        'access_key' => $key,
        'content' => $content,
        'grade_calc' => $g['calc_value'],
        'grade_display' => $g['display_value'],
    ];
});

/** Returns a feedback object using an access key based on already existing exam and student. */
$factory->defineAs(App\Feedback::class, 'preexisting', function ( Faker\Generator $faker ) use ( $factory ) {
    $feedback = $factory->raw(App\Feedback::class);
    $accessKey = factory(App\AccessKey::class, 'preexisting')->create()->access_key;

    return array_merge($feedback, ['access_key' => $accessKey]);
});


/* ---------------------------------- Stats -------------------------------- */
$factory->define(App\GradingTime::class, function ( Faker\Generator $faker ) {
    $examId = factory(App\Exam::class)->create()->id;
    $studentId = factory(App\Student::class)->create()->id;
    $seconds = $faker->randomFloat(2, 0, 1000);

    return [
        'exam_id' => $examId,
        'student_id' => $studentId,
        'seconds' => $seconds,
    ];
});


 // ------------------------------- NEWER -------------------
$factory->define(App\Assignment::class, function ( Faker\Generator $faker ) {
    return ['item_id' => \factory(App\Item::class)->create()->id];
});


$factory->define(App\Item::class, function ( Faker\Generator $faker ) {

    ///Create the maximum score based on the values in
    ///  database seeder
    $score = Factory::create()->randomFloat(2, 1, DatabaseSeeder::MAX_ITEM_SCORE);

    $maxScore = DatabaseSeeder::VARY_MAX_ITEM_SCORES ? $score : DatabaseSeeder::MAX_ITEM_SCORE;

    return [
        'name' => $faker->word,
        'displayText' => $faker->word,
        'comment_text' => $faker->word(),
        'text' => $faker->word(),
        'settings' => [],
        'max_score' => $maxScore
    ];
});


$factory->define(App\Models\NewGom\ItemScore::class, function ( Faker\Generator $faker ) {
//    $userId = 1;
//    Auth::logInUsingId($userId);
    $item = \factory(App\Item::class)->create();
    $exam = \factory(App\Exam::class)->create();
    $student = \factory(App\Exam::class)->create();

    return [
        'item_id' => $item,
        'exam_id' => $exam,
        'student_id' => $student,
        'comment_text' => $faker->sentence,
        'score' => $faker->randomNumber(3)
    ];
});


$factory->define(Note::class, function ( Faker\Generator $faker ) {
//    $userId = 1;
//    Auth::logInUsingId($userId);

    return [
        'name' => $faker->word(),
        'text' => $faker->text(),
        'priority' => $faker->randomElement(Note::PRIORITY_LEVELS),
        'props' => ['testProp' => 'testVal']
    ];

});


$factory->define(Tag::class, function ( Faker\Generator $faker ) {
//    $userId = 1;
//    Auth::logInUsingId($userId);

    return [
        'name' => $faker->word(),
        'text' => $faker->text(),
        'props' => ['testProp' => 'testVal']
    ];

});


$factory->define(Tag::class, function ( Faker\Generator $faker ) {
//    $userId = 1;
//    Auth::logInUsingId($userId);

    return [
        'name' => $faker->word(),
        'text' => $faker->text(),
        'props' => ['testProp' => 'testVal']
    ];

});
