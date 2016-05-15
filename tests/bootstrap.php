<?php
if ( getenv("IS_JENKINS") && getenv("IS_JENKINS") == 'yep' )
{
    try
    {
          require_once 'vendor/autoload.php';
//        $path = base_path();
//        require_once $path . '/vendor/autoload.php';
    } catch ( Exception $e )
    {
        //  require_once 'vendor/autoload.php';
        require_once '../../vendor/autoload.php';
    }


}
//        $path = base_path();
//        require_once $path . '/vendor/autoload.php';

///**
// * Created by PhpStorm.
// * User: adam
// * Date: 4/6/15
// * Time: 10:21 PM
// */
//
////it likes this if running test individually
////require_once '../../vendor/autoload.php';
//try
//{
////it likes this if it is running normally
////    require_once 'vendor/autoload.php';
//
//   // require_once '../../vendor/autoload.php';
//    $path = base_path();
//    require_once $path . '/vendor/autoload.php';
//}catch(Exception $e)
//{
//    //  require_once 'vendor/autoload.php';
////    require_once '../../vendor/autoload.php';
//}
//
//
////
////$username = putenv("DB_USERNAME=testuser4");
////$password = putenv("DB_PASSWORD=testpass4");
////$host = putenv("DB_HOST=localhost");
////$database = putenv("DB_DATABASE=gom_lar");
////
//
////require_once 'app/propel_config/config.php';
////
////DbTestAids::populate_item_assignments2();
////DbTestAids::populate_restrictors();
////DbTestAids::populate_students();
////DbTestAids::populate_classes();
//////\classes\DbTestAids::populate_scores();
////DbTestAids::populate_element_scores();
////DbTestAids::populate_question_scores();
////DbTestAids::populate_pseudoids();
////DbTestAids::populate_times();
//
//
//////\classes\DbTestAids::populate_tags();
//
//
//
//
//
//# initialize propel
////require_once("bootstrap/app.php");
////require_once("src/lib/generated-conf/config.php");
////require_once('vendor/propel/propel/tests/bootstrap.php');
//
////building
////$originalinclude = ini_get('include_path');
//
////ini_set('include_path', '../vendor/');
//
////ini_set('include_path', '/Users/adam/.composer/vendor');
//
////ini_set('include_path', $originalinclude);
//
//
//
