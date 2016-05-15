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
use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


/*
 *
 *
 *
 *
 *
 *
 *
 * Note, almost none of this will never fucking work because BaseModel
 * somehow interferes with larvel's mass fucking assignment.
 *
 * I hate you laravel. So fucking much.
 *
 *
 *
 *
 *
 *
 *
 *
 * */

$factory->define(App\User::class, function (Faker\Generator $faker)
{
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => str_random(10),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Exam::class, function (Faker\Generator $faker)
{
    return [
        'user_id' => 1,
        'term' => $faker->text,
        'name' => $faker->text,
        'year' => $faker->year,
        'released' => 0,
        'locked' => 0
    ];
});
//
//$factory->define(App\Exam::class, function (Faker\Generator $faker)
//{
//    return [
//        'user_id' => 1,
//        'term' => Factory::create()->text,
//        'name' => Factory::create()->text,
//        'year' => Factory::create()->year,
//        'released' => 0,
//        'locked' => 0
//    ];
//});



$factory->define(App\Student::class, function (Faker\Generator $faker)
{
    //$faker2 = Factory::create();

    return  ['user_id' => 1,
        'student_identifier' => '345567888',
        'last_name' => 'ssdfdfsdf',
        'first_name' => 'ljsdlfjsldkfj',
        'email' => 'jjsdlf@slkdfjld.com'
    ];
//
//    return [
////        'id' => $faker->unique()->randomNumber(3),
//        'user_id' => 1,
//        'student_identifier' => $faker2->unique()->randomNumber(9),
//        'last_name' => $faker2->lastName,
//        'first_name' => $faker2->firstName,
//        'email' => $faker2->optional()->email
//    ];

});


$factory->define(App\Question::class, function (Faker\Generator $faker)
{
    $faker2 = Faker\Factory::create();
    $possibleMaxScores = [10, 25, 100, 200, 1000];
    $name = $faker2->text(20);
    $text = $faker2->text(200);
    return [
        'questionName' => $name,
        'questionText' => $text,
        'max_score' => 200,
        //'max_score' => $faker->randomElement($possibleMaxScores),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ];
});

$factory->define(App\Element::class, function(Faker\Generator $faker){
    $name = $faker->text(20);
    $display = $faker->text(200);
    $text = $faker->paragraph();

    return [
        'elementName' => $name,
        'displayText' =>  $display,
        'commentText' => $text
    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker)
{

    return [
        'element_id' => \App\Element::all()->random(),
        //'user_id' => \App\User::all()->random(),
        'valence' => $faker->randomElement(\App\Comment::$valences),
        'body' => $faker->text(200),
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime()
    ];

});

$factory->define(App\QuestionAssignment::class, function (Faker\Generator $faker)
{

    return [
        'question_id' => factory(Question::class)->create()->id,
        'exam_id' => 1,
        'user_id' => 1,
        'question_number' => 1
        ];
//            $exam = Exam::all()->random();
//    $question = Question::all()->random();
//    $questionAssignment = new QuestionAssignment();
//    $questionAssignment->exam_id = $exam->id;
//    $questionAssignment->question_id = $question->id;
//    $questionAssignment->question_number = 10;
//    return [
////        'question_id' => Question::all()->random()->id,
//        'question_id' => factory(Question::class)->create()->id,
////        'exam_id' => factory(Exam::class)->create()->id,
//        'exam_id' => 1,
//        'user_id' => 1,
//        'question_number' => $faker->randomNumber(1)
//    ];
});
//
//$factory->defineAs('App\QuestionAssignment', 'mock2', function (Faker\Generator $faker)
//{
//    $questionAssignment = \Mockery::mock('App\QuestionAssignment');
//    $questionAssignment->shouldReceive('getQuestionAssignmentId')->andReturn(2);
//    $questionAssignment->shouldReceive('getQuestionId')->andReturn(2);
//    $questionAssignment->shouldReceive('getQuestionName')->andReturn('questionName2');
//    $questionAssignment->shouldReceive('getQuestionNumber')->andReturn('2');
//
//    return $questionAssignment;
//});


$factory->define(App\QuestionScore::class, function (Faker\Generator $faker)
{
    return [
        'id' => $faker->unique()->randomNumber(3),
        'question_assignment_id' => $faker->randomNumber(3),
        'student_id' => $faker->randomNumber(9),
        'score' => $faker->randomFloat(2)
    ];
});

$factory->define(App\ElementScore::class, function (Faker\Generator $faker)
{
    return [
        'id' => $faker->unique()->randomNumber(3),
        'element_assignment_id' => $faker->randomNumber(3),
        'student_id' => $faker->randomNumber(9),
        'score' => $faker->randomFloat(2)
    ];
});