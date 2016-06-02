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
use App\Exam;
use App\Question;
use App\Scopes\UserOnlyScope;
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

$factory->define(App\User::class, function (Faker\Generator $faker)
{
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Exam::class, function (Faker\Generator $faker)
{
    return [
        'term' => $faker->text,
        'name' => $faker->text,
        'year' => $faker->year,
        'released' => 0,
        'locked' => 0
    ];
});


$factory->define(App\Student::class, function (Faker\Generator $faker)
{
    return [
        'student_identifier' => $faker->randomNumber(9),
        'last_name' => $faker->lastName,
        'first_name' => $faker->firstName,
        'email' => $faker->email
    ];
});

$factory->defineAs(App\Student::class, 'no_email', function (Faker\Generator $faker) use ($factory) {
    $student = $factory->raw(App\Student::class);
    $student->email = null;
    return $student;
});


$factory->define(App\Question::class, function (Faker\Generator $faker)
{
    $possibleMaxScores = [10, 25, 100, 200, 1000];
    return [
        'questionName' => $faker->text(20),
        'questionText' => $faker->text(200),
        'max_score' => $faker->randomElement($possibleMaxScores),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ];
});

$factory->define(App\Element::class, function(Faker\Generator $faker){
    return [
        'elementName' => $faker->text(20),
        'displayText' =>  $faker->text(200),
        'commentText' => $faker->paragraph()
    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker)
{

    return [
        'element_id' => \App\Element::all()->random()->id,
        'valence' => $faker->randomElement(\App\Comment::$valences),
        'body' => $faker->text(200),
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime()
    ];

});

$factory->define(App\QuestionAssignment::class, function (Faker\Generator $faker)
{
    $userId = 1;
    Auth::logInUsingId($userId);
    $questionId = App\Question::all()->random()->id;
    $examId = App\Exam::all()->random()->id;

    return [
        'question_id' => $questionId,
        'exam_id' => $examId,
        'question_number' => $faker->randomDigitNotNull
        ];

});

$factory->define(App\ElementAssignment::class, function (Faker\Generator $faker)
{
    $userId = 1;
    Auth::logInUsingId($userId);
    $questionId = App\Question::all()->random()->id;
    $elementId = App\Element::all()->random()->id;
    $examId = App\Exam::all()->random()->id;

    return [
        'question_id' => $questionId,
        'element_id' => $elementId,
        'exam_id' => $examId,
        'subtask' => $faker->randomDigitNotNull
    ];

});

$factory->define(App\QuestionScore::class, function (Faker\Generator $faker)
{
    $userId = 1;
    Auth::logInUsingId($userId);
    $assignmentId = App\QuestionAssignment::all()->random()->id;
    $studentId = App\Student::all()->random()->id;

    return [
        'question_assignment_id' => $assignmentId,
        'student_id' => $studentId,
        'score' => $faker->randomFloat(2)
    ];
});

$factory->define(App\ElementScore::class, function (Faker\Generator $faker)
{
    $userId = 1;
    Auth::logInUsingId($userId);
    $assignmentId = App\ElementAssignment::all()->random()->id;
    $studentId = App\Student::all()->random()->id;
    return [
        'element_assignment_id' => $assignmentId,
        'student_id' => $studentId,
        'score' => $faker->randomFloat(2)
    ];
});