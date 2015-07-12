<?php
/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */
?>
<div id='questionAssigning'>
    <h1>Question Assigning</h1>
    <p>Assign questions for this exam
        <select id='examTarget' class='examSelect'>
            <option> --select exam-- </option>
            <?php
            $ex = new \ExaminationClasses\service\GetAllExams($user, 'unlocked', 'all');
            $ex->print_selector();
            ?>
        </select>
    </p>
    <p>Make this question <select id='qToAssign' class='questionSelect taggedSelect'></select></p>
    <p>question number
        <select id='qNumberToAssign'>
            <?php
            $op = new \DisplayClasses\GenerateSelectOptions(array('number_of_options' => $_SESSION['num_question_options'],
                'prepend' => 'Q', 'addToValue' => false));
            ?>
        </select>
    </p>
    <p>
        <input type='button' id='recordQuestionAssign' class='prettyButton' value='Record Question Assignment' />
    </p>
    <hr />
</div>

<div id='elementAssigning'>
    <p>Assign this element
        <select id='eToAssign' class='elementSelect taggedSelect'></select>
    </p>
    <p>
        To Question <span class='currQuestionNumber'> </span>
        <input type='hidden' id='hiddenQID' />
        <select id='currQN'>

        </select>
    </p>

    <p>As subtask number
        <select id='subToAssign' class='subtaskSelect'>
<?php $op = new \DisplayClasses\GenerateSelectOptions(array('number_of_options' => $_SESSION['num_subtask_options'])); ?>
        </select>
    </p>
    <p>
        <input type='button' id='recordElementAssign' class='prettyButton' value='Record Element Assignment'
    </p>
    <hr />
</div>
<div id='currExamDisplay'><p>Current Exam: <input type='text' id='currentExamID' class='currExamID' /></p>
    <input type='button' id='examComplete' class='prettyButton' value='Done setting up questions' /></div>
<div id='currExamQuestionList'></div>
