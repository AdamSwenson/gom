<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/6/15
 * Time: 10:21 PM
 */

//
//define("DSN","mysql:host=localhost;dbname=gom_propel");
//define("DB_HOST", "localhost");
//define("DB_NAME", "gom_propel");
//define("DB_USERNAME","root");
//define("DB_PASS", "");

putenv("DB_HOST=localhost");
putenv("DB_NAME=gom_propel");
putenv("DB_USERNAME=testuser3");
putenv("DB_PASS=testpass3");

putenv("LOCATION=local");
putenv("RUNTYPE=testing");
putenv("DEVSTATE=development");

putenv("APP_PUBLIC_PATH=src/www");
putenv("APP_VENDOR_PATH=vendor");
putenv("APP_SRC_PATH=src");

require_once 'vendor/autoload.php';


# initialize propel
require_once("src/lib/generated-conf/config.php");
require_once('vendor/propel/propel/tests/bootstrap.php');

//building
$originalinclude = ini_get('include_path');

ini_set('include_path', '../vendor/');

ini_set('include_path', '/Users/adam/.composer/vendor');

ini_set('include_path', $originalinclude);


\classes\DbTestAids::populate_item_assignments2();
\classes\DbTestAids::populate_restrictors();
\classes\DbTestAids::populate_students();
\classes\DbTestAids::populate_classes();
//\classes\DbTestAids::populate_scores();
\classes\DbTestAids::populate_element_scores();
\classes\DbTestAids::populate_question_scores();
\classes\DbTestAids::populate_pseudoids();
\classes\DbTestAids::populate_times();

\classes\DbTestAids::populate_tags();

