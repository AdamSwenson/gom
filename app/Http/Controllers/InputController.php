<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/11/15
 * Time: 10:46 PM
 */

namespace App\Http\Controllers;


class InputController extends Controller
{

    public function showInputPage($numberOfQuestions=5)
    {
//        return 'input';
        return view('input.main_input', [
            'numberOfQuestions' => $numberOfQuestions]);
    }

    public function showExamManager()
    {
        return "exam manager page here";
    }
}