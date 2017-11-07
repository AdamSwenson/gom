<?php 
//we no longer process csv on the server, so this is unnecessary

//$I = new FunctionalTester($scenario);
//$I->wantTo('Upload students from a csv file and see them in the database');
//
//\Illuminate\Support\Facades\Auth::loginUsingId(1);
//
//$I->disableMiddleware();
//
////Create new exam1 so have blank slate of students
//$exam1 = new App\Exam();
//$exam1->setYear(\Faker\Factory::create()->year);
//$exam1->setTerm('Fall');
//$exam1->save();
//
///* --------------------------------------- Open the page */
//$I->amOnPage('/exam1/' . $exam1->id .  '/question/edit');
//
////Upload
//// file is stored in 'tests/_data/roster_valid_w_headers.csv'
//$I->attachFile('Import Roster', 'roster_valid_w_headers.csv');
////$I->attachFile('input[id="fileInput"]', 'roster_valid_w_headers.csv');
////$I->attachFile('input[ * `type="file"]',`  'roster_valid_w_headers.csv')
//
//
//$I->click("Save & Finish");
//
////Make sure stored in database
//$I->seeInDatabase('students', ['student_identifier' => 434685611, 'last_name' => 'Wolf', 'first_name' => 'Aileen', 'email' => 'michael18@gmail.com']);
//$I->seeInDatabase('students', ['student_identifier' => 43804619, 'last_name' => 'Hodkiewicz', 'first_name' => 'Orrin', 'email' => 'randy.barrows@fritsch.com']);
//$I->seeInDatabase('students', ['student_identifier' => 577004546, 'last_name' => 'Goodwin', 'first_name' => 'Matilde', 'email' => 'christiansen.estrella@yahoo.com']);
//$I->seeInDatabase('students', ['student_identifier' => 461462449 , 'last_name' => 'Smitham', 'first_name' => 'Tessie', 'email' => 'cpowlowski@cartwright.com']);
//$I->seeInDatabase('students', ['student_identifier' => 966030664 , 'last_name' => 'Wisoky' , 'first_name' => 'Cathy' , 'email' => 'isom06@leuschke.info']);
//$I->seeInDatabase('students', ['student_identifier' => 633680355, 'last_name' => 'Pagac', 'first_name' => 'Antoinette' , 'email' => 'kiehn.jammie@yahoo.com']);
//$I->seeInDatabase('students', ['student_identifier' => 24853902, 'last_name' => 'Johnson', 'first_name' => 'Wilbert' , 'email' => 'genoveva83@gmail.com']);
//$I->seeInDatabase('students', ['student_identifier' => 385991747, 'last_name' => 'Monahan', 'first_name' => 'Newton', 'email' => 'sabryna69@hotmail.com' ]);
//
////Go back to the page and make sure see everyone
//$I->amOnPage('/exam1/' . $exam1->id .  '/question/edit');
//$I->seeNumberOfElements('tr', 8); //studentRosterBody
