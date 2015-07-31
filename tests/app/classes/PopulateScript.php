<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/16/15
 * Time: 5:27 PM
 */


$username = putenv("DB_USERNAME=testuser4");
$password = putenv("DB_PASSWORD=testpass4");
$host = putenv("DB_HOST=localhost");
$database = putenv("DB_DATABASE=gom_propel");

require_once '/Users/adam/Dropbox/gom3/vendor/autoload.php';
require_once '/Users/adam/Dropbox/gom3/app/propel_config/config.php';
require ('DbTestAids.php');

\App\classes\DbTestAids::populate_all();
echo 'Populate ran';
   //
//        DbTestAids::populate_item_assignments2();
//        DbTestAids::populate_restrictors();
//        DbTestAids::populate_students();
//        DbTestAids::populate_classes();
//\classes\DbTestAids::populate_scores();
//        DbTestAids::populate_element_scores();
//        DbTestAids::populate_question_scores();
//        DbTestAids::populate_pseudoids();
//        DbTestAids::populate_times();

//\classes\DbTestAids::populate_tags();
