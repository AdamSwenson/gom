<?php

/* 
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
  * 
 */

/**
 * this is a dummy api for javascript unit tests
 */

if(isset($_GET)){
    $request = $_GET['questionNumber'];
    if ($request == 'examInfo'){
//                        echo json_encode(array('data' => array('pages' => 10, 'notecard' => 0, 'completionOrder' => 10)));
            echo json_encode(array('pages' => 10, 'notecard' => 10, 'completionOrder' => 10));
    }else{
        echo json_encode(array("elements" => array("elementID" => 2, "elementAbbr" => "testElement1", 
            "subtask"=>2, "elementEnglish" => "Text of the element number 2", "elementScore" => 2.2, "questionNumber" => 2), 
        "question" => array("questionID" => 2, "questionName" => "NameOfQuestion2", "questionScore" => 2.2, "questionNumber" => 2, "questionTitle" => "Title of Question 2")));
    }
}