<div class="figure">
    <p class="picture">
        <img src="{{ asset('images/question_edit_wide.png') }}" style="height:200px"
             alt="Question editing window">
    </p>

    <p class="pictureCaption">The page for creating and editing a question"</p>
    <h4>What they are</h4>

    <p class="answer">We called these items 'questions' because that's what they'll be for many uses of the
        gradeomatic. However, the system is designed to be extremely flexible. 'Questions' are really just
        whatever items a student's grade depends upon.</p>

    <p class="answer">For example, if you were using the gradeomatic to grade long form essays, you could
        have 'questions' like <samp>Organization</samp> or <samp>Grammar</samp> and set the point values
        accordingly. </p>

    <h4>Creating and editing questions</h4>

    <p class="answer">In setting up the exam, you create a <i>question</i> by giving it a brief question
        name (to use as a reminder while grading) and, optionally, the full question text.</p>

    <div class="figure">
        <p class="picture">
            <img src="{{ asset('images/question_edit_text_entered.png') }}"
                 style="height:200px"
                 alt="Example of text entered into the question name and text boxes">
        </p>

        <p class="pictureCaption">The question presented to the student 'Explain the skeptical method
            Descartes uses in the Meditations' has been entered into <em>Question Text</em>. The
            question has been named 'Explain skeptical method'
        </p>
    </div>

    <h4>Maximum points possible</h4>

    <p class="answer">You also assign the maximum points possible for each question.</p>

    <div class="figure">
        <p class="picture">
            <img src="{{ asset('images/question_edit_score_highlighted.jpg') }}"
                 style="height:200px"
                 alt="Question edit page with max score field highlighted">
        </p>

        <p class="pictureCaption">Enter the maximum points possible for the question in the circled
            box
        </p>
    </div>

    <p class="answer">You also assign the maximum points possible for each question. If you want to give
        each question a letter grade and then have the overall exam grade reflect all questions equally,
        simply assign each question the same number of points. The gradeomatic will translate the letter
        grade into a fixed percentage of the total possible points. If all questions count equally, we
        recommend assigning each question 100 points.</p>

    <div class="figure">
        <p class="picture">
            <img src="{{ asset('images/question_edit_3_questions_same_value.png')}}"
                 alt="Three questions, each with 100 points as the maximum score"
                 style="height:200px">
        </p>

        <p class="pictureCaption">Three questions, each worth the same amount</p>
    </div>

    <p class="answer">If you want some questions to count more toward the final grade than others,
        adjust the maximum scores accordingly. For example, if Question 1 and Question 2 are each worth
        25% of the grade, and Question 3 is worth 50%, you could set the maximum scores for Question 1
        and Question 2 to 100, and the maximum score for Question 3 to 200 points.
    </p>

    <div class="figure">
        <p class="picture">
            <img src="{{ asset('images/question_edit_3_questions_diff_values.png')}}"
                 alt="Three questions, questions 1 and 2 worth 100 points each, and question 3 worth 200 points"
                 style="height:200px">
        </p>

        <p class="pictureCaption">Three questions with different point values</p>
    </div>

    <h4>Reordering questions</h4>

    <p class="answer">Changing the order of questions is easy. Click on the 'Move' button for the question
        whose
        position you want to change. While holding the button down, drag the question to the position you
        want.</p>

    <div class="figure">
        <p class="picture">
            <img src="{{ asset('images/question_edit_reordering.png')}}"
                 alt="Question 2 being dragged to become Question 1" style="height:200px">
        </p>

        <p class="pictureCaption">Dragging Question 2 to become Question 1</p>
    </div>

    <p class="answer">Once in position, release the button. The other questions will update their numbers
        accordingly.</p>

    <div class="figure">
        <p class="picture">
            <img src="{{ asset('images/question_edit_post_reorder.png')}}"
                 alt="Question 2 has now become Question 1" style="height:200px">
        </p>

        <p class="pictureCaption">The former Question 2 is now Question 1</p>
    </div>

    <h4>Saving question edits</h4>

    <p class="answer">No changes to the questions are saved to the database until you click 'Add/Edit
        Elements'.
    </p>

    <div class="figure">
        <p class="picture">
            <img src="{{ asset('images/question_edit_save.png')}}"
                 alt="Circle around the Add Edit Elements button" style="height:200px">
        </p>

        <p class="pictureCaption">Click the 'Add/Edit Elements' button to save</p>
    </div>

    <h4>Removing questions</h4>

    <p class="answer">To remove a question, click its 'Delete' button.</p>

    <div class="figure">
        <p class="picture">
            <img src="{{ asset('images/question_edit_delete.png')}}"
                 alt="Circle around question 2's delete button" style="height:200px">
        </p>

        <p class="pictureCaption">Click the Delete button to remove a question</p>
    </div>

    <p class="answer">When you click the button, a dialog will pop up asking you to confirm the
        deletion.</p>

    <div class="figure">
        <p class="picture">
            <img src="{{ asset('images/question_edit_delete_confirm.png')}}"
                 alt="Confirmation dialog for deleting question 2" style="height:200px">
        </p>

        <p class="pictureCaption">Confirmation dialog for deleting question 2</p>
    </div>

    <p class="answer">Once you confirm by clicking 'Delete' in the pop up, the question will disappear from
        the screen.
        However, the question is not deleted from the database until you click 'Add/Edit Elements'</p>

    <p class="answer">Please be very careful with deleting questions. If a question is deleted, all student
        scores for that
        question are removed from the database. Any elements associated with the question are also deleted,
        along with any
        student scores for those elements. <strong>There is no way to undo the deletion</strong></p>

    <h4>Miscellaneous: alternative uses of questions</h4>

    <p class="answer">We mentioned earlier that while an exam must have at least one question, there is no
        need for the
        questions to be 'questions' in the traditional sense. Suppose you have an exam with four questions
        each worth 20%
        and want the student's grammar on all questions to count for 20%. Simply add an extra question
        called 'Grammar', and
        set the number of points that portion is worth.</p>

    <div class="figure">
        <p class="picture">
            <img src="{{ asset('images/question_edit_misc_grammar.png')}}"
                 alt="Fourth question named grammar added " style="height:200px">
        </p>

        <p class="pictureCaption">Adding a question called 'Grammar' worth 20%</p>
    </div>

    <h4>Miscellaneous: Feedback only </h4>

    <p class="answer">Finally, while each question must have a maximum score, the maximum score can be 0.
        This might be
        helpful if you want to use the gradeomatic to create feedback for students but don't want to assign
        a grade.</p>

    <p class="answer">For example, suppose you are going to grade a rough draft of an essay credit/no
        credit, and then give
        actual grades for the final draft. You would create the questions and elements as usual. For the
        rough draft you set
        the points for each question to 0. After grading, you would generate the feedback as usual. Students
        would see all
        the feedback but without a grade.</p>

    <p class="answer">Then, when the final draft is turned in, simply clone the 'exam' you used for the
        rough draft and
        change the points for each question to their actual values.</p>
</div>
