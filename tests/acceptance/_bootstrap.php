<?php
// Here you can initialize variables that will be available to your tests
//shell_exec('APP_ENV=codeceptWorld php artisan serve');
//codecept_debug(shell_exec('APP_ENV=codeceptWorld php artisan serve'));

$examWith5QuestionsId = 1;
$examWithNoQuestionsId = 4;

//$this->config['paths.log'] = 'tests/_output/report';
require 'bootstrap/autoload.php';
$app = require 'bootstrap/app.php';
$app->loadEnvironmentFrom('.env.testing');
$app->instance('request', new \Illuminate\Http\Request);
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();