<div class="row">
    <div class="col-lg-3"></div>
    <div class="col-lg-6">
        <div class="figure">
            <p class="picture">
                <img
                        src="{{ asset('images/question_edit_wide.png') }}"
                        class="img-responsive"
                        alt="Question editing window"/>
            </p>

            <p class="pictureCaption">The page for creating and editing a question"</p>
        </div>
    </div>
    <div class="col-lg-3"></div>
</div>

<section id="{{\App\ViewTools\HelpLinks::$questionWhat['id']}}" class="group">
    <h4 class="text-center">What questions are</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">We called these items 'questions' because that's what they'll be for many uses of the
                gradeomatic.</p>

            <p class="answer">However, the system is designed to be extremely flexible. 'Questions' are really just
                whatever items a student's grade depends upon.</p>

            <p class="answer">For example, if you were using the gradeomatic to grade long form essays, you could
                have 'questions' like <em>Organization</em> or <em>Grammar</em> and set the point values
                accordingly. </p>
            @include('help.partials.related_links', ['relatedLinks' =>
            [
                ['id' => 'questionAltUses', 'text' => 'Alternative uses of questions'],
                ['id' => 'questionFeedbackOnly', 'text' => 'Giving feedback only']
            ]])
        </div>
        <div class="col-lg-6">
            @include('help.partials.field_table', ['fields' => [
            ['name' => 'Question name', 'required' => true],
            ['name' => 'Question text', 'required' => false],
            ['name' => 'Max score', 'required' => true]
            ]])
        </div>
    </div>
</section>


<section id="{{\App\ViewTools\HelpLinks::$questionCreate['id']}}" class="group">
    <h4 class="text-center">Creating and editing questions</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">In setting up the exam, you create a <i>question</i> by giving it a brief
                name (to use as a reminder while grading) and, optionally, the full question text.</p>

            <p class="answer">The question presented to the student 'Explain the skeptical method
                Descartes uses in the Meditations' has been entered into <em>Question Text</em>. The
                question has been named 'Explain skeptical method'</p>
        </div>

        <div class="col-lg-6">
            <div class="figure">
                <p class="picture">
                    <img src="{{ asset('images/question_edit_text_entered.png') }}"
                         class="img-responsive"
                         alt="Example of text entered into the question name and text boxes"/>
                </p>

                <p class="pictureCaption">Enter question name and (optionally) its text</p>
            </div>
        </div>
    </div>
</section>

<section id="{{\App\ViewTools\HelpLinks::$questionMaxPoints['id']}}" class="group">
    <h4 class="text-center">Maximum points possible</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">Assign the maximum points possible for each question.</p>

            <p class="answer">If you do not intend to assign grades with the gradeomatic, set the max score to
                0.</p>

            <p class="answer">If you want to give each question a letter grade and then have the overall exam grade
                reflect all questions equally,
                simply assign each question the same number of points. The gradeomatic will translate the letter
                grade into a fixed percentage of the total possible points.</p>

            <p class="answer">If all questions count equally, we recommend assigning each question 100 points.</p>
        </div>

        <div class="col-lg-6">
            <div class="figure">
                <p class="picture">
                    <img src="{{ asset('images/question_edit_score_highlighted.jpg') }}"
                         class="img-responsive"
                         alt="Question edit page with max score field highlighted"/>
                </p>

                <p class="pictureCaption">Enter max possible points</p>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-6">
            <p class="answer">If you want some questions to count more toward the final grade than others,
                adjust the maximum scores accordingly.</p>

            <p class="answer">For example, if Question 1 and Question 2 are each worth
                25% of the grade, and Question 3 is worth 50%, you could set the maximum scores for Question 1
                and Question 2 to 100, and the maximum score for Question 3 to 200 points.
            </p>
        </div>
        <div class="col-lg-6">
            <div class="figure">
                <p class="picture">
                    <img src="{{ asset('images/question_edit_3_questions_same_value.png')}}"
                         class="img-responsive"
                         alt="Three questions, each with 100 points as the maximum score"/>
                </p>

                <p class="pictureCaption">Three questions, each worth the same amount</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6"></div>

        <div class="col-lg-6">
            <div class="figure">
                <p class="picture">
                    <img src="{{ asset('images/question_edit_3_questions_diff_values.png')}}"
                         class="img-responsive"
                         alt="Three questions, questions 1 and 2 worth 100 points each, and question 3 worth 200 points"/>
                </p>

                <p class="pictureCaption">Three questions with different point values</p>
            </div>
        </div>
    </div>
</section>


<section id="{{\App\ViewTools\HelpLinks::$questionReorder['id']}}" class="group">
    <h4 class="text-center">Reordering questions</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">Changing the order of questions is easy. Click on the 'Move' button for the question
                whose
                position you want to change.</p>

            <p class="answer">While holding the button down, drag the question to its new position.</p>
        </div>
        <div class="col-lg-6">
            <div class="figure">
                <p class="picture">
                    <img src="{{ asset('images/question_edit_reordering.png')}}"
                         class="img-responsive"
                         alt="Question 2 being dragged to become Question 1"/>
                </p>

                <p class="pictureCaption">Dragging Question 2 to become Question 1</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">Once in position, release the button. The other questions will update their numbers
                accordingly.</p>
        </div>
        <div class="col-lg-6">
            <div class="figure">
                <p class="picture">
                    <img src="{{ asset('images/question_edit_post_reorder.png')}}"
                         class="img-responsive"
                         alt="Question 2 has now become Question 1"/>
                </p>

                <p class="pictureCaption">The Question-formerly-known-as-2 is now Question 1</p>
            </div>
        </div>
    </div>
</section>


<section id="{{\App\ViewTools\HelpLinks::$questionSave['id']}}" class="group">
    <h4 class="text-center">Saving question edits</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">No changes to the questions are saved to the database until you click 'Add/Edit
                elements'.</p>
        </div>
        <div class="col-lg-6">
            <div class="figure">
                <p class="picture">
                    <img src="{{ asset('images/question_edit_save.png')}}"
                         class="img-responsive"
                         alt="Circle around the Add Edit Elements button"/>
                </p>

                <p class="pictureCaption">Click the 'Add/Edit Elements' button to save</p>
            </div>
        </div>
    </div>
</section>

<section id="{{\App\ViewTools\HelpLinks::$questionDelete['id']}}" class="group">
    <h4 class="text-center">Removing questions</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">To remove a question, click its 'Delete' button.</p>
        </div>
        <div class="col-lg-6">
            <div class="figure">
                <p class="picture">
                    <img src="{{ asset('images/question_edit_delete.png')}}"
                         class="img-responsive"
                         alt="Circle around question 2's delete button"/>
                </p>

                <p class="pictureCaption">Click the Delete button to remove a question</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">When you click the button, a dialog will pop up asking you to confirm the
                deletion.</p>

            <p class="answer">Once you confirm by clicking 'Delete' in the pop up, the question will disappear from
                the screen. However, the question is not deleted from the database until you click 'Add/Edit
                Elements'</p>

            <p class="answer">Please be very careful with deleting questions. If a question is deleted, all student
                scores
                for that
                question are removed from the database. Any elements associated with the question are also deleted,
                along
                with any
                student scores for those elements.</p>

            <p class="answer text-danger"><strong>There is no way to undo the deletion</strong></p>
        </div>
        <div class="col-lg-6">
            <div class="figure">
                <p class="picture">
                    <img src="{{ asset('images/question_edit_delete_confirm.png')}}"
                         class="img-responsive"
                         alt="Confirmation dialog for deleting question 2"/>
                </p>

                <p class="pictureCaption">Confirmation dialog for deleting question 2</p>
            </div>
        </div>
    </div>
</section>


<section id="{{\App\ViewTools\HelpLinks::$questionAltUses['id']}}" class="group">

    <h4 class="text-center">Miscellaneous: alternative uses of questions</h4>

    <div class="row">
        <div class="col-lg-6">

            <p class="answer">We mentioned earlier that while an exam must have at least one question, there is
                no
                need for the
                questions to be 'questions' in the traditional sense.</p>

            <p class="answer">Suppose you have an exam with four
                questions
                each worth 20%
                and want the student's grammar on all questions to count for 20%. Simply add an extra question
                called 'Grammar', and
                set the number of points that portion is worth.</p>
        </div>
        <div class="col-lg-6">
            <div class="figure">
                <p class="picture">
                    <img src="{{ asset('images/question_edit_misc_grammar.png')}}"
                         class="img-responsive"
                         alt="Fourth question named grammar added "/>
                </p>

                <p class="pictureCaption">Adding a question called 'Grammar' worth 20%</p>
            </div>
        </div>
    </div>
</section>


<section id="{{\App\ViewTools\HelpLinks::$questionFeedbackOnly['id']}}" class="group">
    <h4 class="text-center">Miscellaneous: Feedback only </h4>
    <div class="row">
        <div class="col-lg-6">
            <p class="answer">Finally, while each question must have a maximum score, the maximum score can be
                0.
                This might be
                helpful if you want to use the gradeomatic to create feedback for students but don't want to
                assign
                a grade.</p>

            <p class="answer">For example, suppose you are going to grade a rough draft of an essay credit/no
                credit, and then give
                actual grades for the final draft. You would create the questions and elements as usual.</p>

            <p class="answer">For the
                rough draft you set
                the points for each question to 0. After grading, you would generate the feedback as usual.
                Students
                would see all
                the feedback but without a grade.</p>

            <p class="answer">Then, when the final draft is turned in, simply clone the 'exam' you used for the
                rough draft and
                change the points for each question to their actual values.</p>
        </div>
    </div>
</section>