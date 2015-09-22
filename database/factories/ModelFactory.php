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
        'term' => $faker->text,
        'name' => $faker->text,
        'year' => $faker->year,
        'released' => 0,
        'locked' => 0
    ];
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