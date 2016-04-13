<?php
namespace Helper;
// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Acceptance extends \Codeception\Module
{


public static $examWith5QuestionsId = 1;
public static $examWithNoQuestionsId = 4;


    public function examIdWithQuestions(){
        return self::$examWith5QuestionsId;
    }

    public function examIdNoQuestions(){
        return self::$examWithNoQuestionsId;
    }

}
