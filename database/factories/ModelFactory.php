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

use Carbon\Carbon;
use Faker\Generator;

$factory->define(App\User::class, function (Faker\Generator $faker)
{
    return [
        'name' => $faker->name,
        'emails' => $faker->email,
        'password' => str_random(10),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Exam::class, function ($faker)
{
    return [
        'term' => $faker->text(10),
        'name' => $faker->text(10),
        'year' => $faker->year()
    ];
});

$factory->define('App\Question', function ($faker)
{
    return [
//        'user_id' => 1,
        'question_name' => str_random(20),
        'question_text' => str_random(200),
        'created_at' => new Carbon,
        'updated_at' => new Carbon
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

$factory->defineAs(App\QuestionAssignment::class, 'mock1', function (Faker\Generator $faker)
{
    return [
        'question_id' => 1,
        'question_assignment_id' => 1,
        'question_name' => 'questionName1',
        'question_number' => 1
    ];
//    $questionAssignment1 = \Mockery::mock('App\QuestionAssignment');
//    $questionAssignment1->shouldReceive('getQuestionAssignmentId')->andReturn(1);
//    $questionAssignment1->shouldReceive('getQuestionId')->andReturn(1);
//    $questionAssignment1->shouldReceive('getQuestionName')->andReturn('questionName1');
//    $questionAssignment1->shouldReceive('getQuestionNumber')->andReturn('1');
//    return $questionAssignment1;
});

$factory->defineAs('App\QuestionAssignment', 'mock2', function (Faker\Generator $faker)
{
    $questionAssignment = \Mockery::mock('App\QuestionAssignment');
    $questionAssignment->shouldReceive('getQuestionAssignmentId')->andReturn(2);
    $questionAssignment->shouldReceive('getQuestionId')->andReturn(2);
    $questionAssignment->shouldReceive('getQuestionName')->andReturn('questionName2');
    $questionAssignment->shouldReceive('getQuestionNumber')->andReturn('2');

    return $questionAssignment;
});


$factory->define(App\Student::class, function (Faker\Generator $faker)
{
    return [
        'id' => $faker->unique()->randomNumber(3),
        'user_id' => 1,
        'student_identifier' => $faker->unique()->randomNumber(9),
        'last_name' => $faker->lastName(),
        'first_name' => $faker->firstName(),
        'email' => $faker->email()
    ];
});

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