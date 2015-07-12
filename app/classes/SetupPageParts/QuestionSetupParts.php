<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace SetupPageParts;

/**
 * The parts of the question and element editing pages for use in questionmanager.php and wizard.php
 *
 * @author adam
 */
class QuestionSetupParts
{
    /**
     * Div containing fields for adding new questions and editing existing ones.
     * They start hidden. div id = questionEditFields
     */
    public static function new_question_fields()
    {
        echo "<div class='newArea'>
                <div id='newQuestionArea' class='startHidden' >
                    <p>
                        <label for='newQuestionName'>Question Name</label><br />
                        <input type='text' id='newQuestionName' data='' class='newQuestionFields' />
                    </p>
                    <p>
                        <label for='newQuestionTitle'>Question Title</label><br />
                        <input type='text' id='newQuestionTitle' data='' class='newQuestionFields'/>
                    </p>
                    <p>
                        <input type='button' id='recordNewQuestion' class='submitButton prettyButton' value='Record new question' />
                        <input type='button' id='resetNewQuestion' class='resetButton prettyButton' data='newQuestionFields' value='Clear new question fields' />
                    </p>
                </div>
                <div class='buttonArea'>
                    <input type='button' id='newQuestion' class='prettyButton' value='New question'/>
                </div>
            </div>";
    }
    public static function new_comment_fields()
    {
        echo "<div class='newArea'>
                <div id='newCommentArea' class='startHidden' >
                    <p>
                        <label for='newCommentName'>Comment Name</label><br />
                        <input type='text' id='newCommentName' data='' class='newCommentFields' />
                    </p>
                    <p>
                        <label for='newCommentContent'>Content</label><br />
                        <input type='textarea' id='newCommentContent' data='' class='newCommentFields'/>
                    </p>
                    <p>
                        <input type='button' id='recordNewComment' class='submitButton prettyButton' value='Record new comment' />
                        <input type='button' id='resetNewComment' class='resetButton prettyButton' data='newCommentFields' value='Clear new comment fields' />
                    </p>
                </div>
                <div class='buttonArea'>
                    <input type='button' id='newComment' class='prettyButton' value='New comment'/>
                </div>
            </div>";
    }
        public static function new_element_fields()
        {
        echo "<div class='newArea'>
                <div id='newElementArea' class='startHidden'>
                    <p>
                        <label for='newElementAbbr'>Element Name</label><br />
                        <input type='text' id='newElementAbbr' data='' class='newElementFields' />
                    </p>
                    <p>
                        <label for='newElementEnglish'>Element Description</label><br />
                        <input type='text' id='newElementEnglish' data='' class='newElementFields'/>
                    </p>
                    <p>
                        <input type='button' id='recordNewElement' class='prettyButton' value='Record new element' />
                        <input type='button' id='resetNewElement' class='resetButton prettyButton' data='newElementFields' value='Clear new element fields' />
                    </p>
                </div>
                <div class='buttonArea'>
                    <input type='button' id='newElement' class='prettyButton' value='New element'/>
                </div>
            </div>";
    }

    public static function question_editing_instructions()
    {
        echo "<div id='questionEditing'>

                    <p class='instruction'> The question name may not contain any spaces. Length limit [xxxx]</p>
                    <p><table class='info'>
                    <tr>
                    <th>Field name</th>
                    <th>Description</th>
                    <th>Characters</th>
                    <th>Length</th>
                    <th>Restrictions</th>
                    </tr>
                    <tr>
                    <td>questionName</td>
                    <td>The name of the question as it is stored in the database. You will only use it here and when you export data
                    (it will be the column name for student scores). Thus it should be short and descriptive.
                    </td>
                    <td>Letters and numbers</td>
                    <td>Min: 1; Max: xxxx</td>
                    <td>No spaces</td>
                    </tr>
                    </table></p>
                    <p class='instruction'>The question number will be set separately. If you plan on using the question on more than one exam,
                    don't include reference to the question number in the name. For example, if you name the question 'povertyExamQuestion1',
                    things will get unnecessarily confusing when you use it at the second question on next year's exam). <br/>
                    Similarly, since one question can be associated with multiple examinations and topics, it is best to avoid referencing an
                    exam's name in the question title.</p>
                    <p>
                        <label for='questionForEditing'>Select unlocked question to edit or enter a new question in the fields below</label><br />
                        <select id='questionForEditing' class='editableQuestionSelect taggedSelect'></select>
                    </p>

                    <p class='instruction'>This will be the text you see when you are grading. The title should be short
                    (so it won't take up too much space on the screen). But it should be relatively descriptive (e.g., Addiction Definition).</p>
                          <p class='instruction'>The title may contain spaces. Limit [xxx] characters.</p>


                    <hr />
                </div>";
    }

    public static function delete_dialogs()
    {
        echo "<div id='elementDeleteDialog'>
                <h3>Are you sure you want to delete this element? <br /> This cannot be undone!</h3>
            </div>
            <div id='questionDeleteDialog'>
                <h3>Are you sure you want to delete this question? <br /> This cannot be undone!</h3>
            </div>
            <div id='commentDeleteDialog'>
                <h3>Are you sure you want to delete this comment? <br /> This cannot be undone!</h3>
            </div>";
    }

    public static function element_editing()
    {
        echo "<div id='elementEditing'>

                    <p>
                        <label for='elementForEditing'>Select element to edit or enter a new element in the fields below</label><br />
                        <select id='elementForEditing' class='editableElementSelect taggedSelect'></select>
                    </p>
                    <p>
                        <label for='editElementAbbr'>Element Name</label><br />
                        <input type='text' id='editElementAbbr' data='' class='editElementFields' />
                    </p>
                    <p>
                        <label for='editElementEnglish'>Element Description</label><br />
                        <input type='text' id='editElementEnglish' data='' class='editElementFields'/>
                    </p>
                    <p>
                        <input type='button' id='recordElementEdit' class='prettyButton' value='Record Element Changes' />
                        <input type='button' id='resetElementEdit' class='resetButton prettyButton' data='editElementFields' value='Clear Element Fields' />
                    </p>
                    <p>
                        <input type='button' id='deleteElement' class='deleteButton prettyButton' data='deleteElement' value='Completely Delete Element' />
                    </p>
                    <hr />
                </div>";
    }

    public static function locked_questions()
    {
        echo "<div id='lockedQuestions'>
              <p>Display the questions which are locked here along with the exam that has locked them. Note that have to unlock the entire exam.</p>
              </div>";
    }

    public static function locked_elements()
    {
        echo "<div id='lockedElements'>
                    <p>Display the elements which are locked here along with the exam that has locked them. Note that have to unlock the entire exam.</p>
                </div>";
    }

    public static function questionPrompt()
    {
        echo "
              <label for='newQuestionPrompt'>Prompt text (optional)</label>
                          <input type='textarea' id='newQuestionPrompt' rows='10' cols='30'/>
                          </p>

                          <p class='instruction'>This the prompt your students will be given on the exam. This is not mandatory.
                          But if you record it, you will have the ability to view the prompt on demand while grading when disoriented
                          by student digressions.</p>";
    }

}
