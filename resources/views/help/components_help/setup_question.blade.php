@include('help.partials.section_top_picture', [
'imageFile' => 'question/question_edit_wide.jpg',
'altText' => "Question editing window",
'caption' => "Create and edit questions"])

<section id="{{\App\ViewTools\HelpLinks::$questionWhat['id']}}" class="group">
    <h4 class="text-center">What questions are</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">Every exam has at least one question. Again, the system is designed to be extremely
                flexible. 'Questions' are really just whatever items a student's grade depends upon.</p>

            <p class="answer">For example, if you were using the gradeomatic to grade long form essays, you could
                have 'questions' like <em>Organization</em> or <em>Grammar</em> in addition to the prompt and set the
                point values
                accordingly. See <a href="#{{ \App\ViewTools\HelpLinks::$questionAltUses['id'] }}">alternative uses of
                    questions</a> for an example.</p>
        </div>
        <div class="col-lg-6">
            <p class="answer">The following table summarizes the fields that comprise a question. If a field is <em>Required</em>,
                you must enter a value in order to create the question. If a field is <em>Optional</em>, you may choose
                to leave it blank. The <em>Visible to Students</em> column indicates whether the content of the field
                will be shown to your students.</p>
            @include('help.partials.field_table', ['fields' => [
            ['name' => 'Question name', 'required' => true, 'visible' => true],
            ['name' => 'Question text', 'required' => false, 'visible' => false],
            ['name' => 'Max score', 'required' => true, 'visible' => true]
            ],
              'caption' => 'Components of a question'])
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            @include('help.partials.related_links', ['relatedLinks' =>
            [
                ['id' => 'questionAltUses', 'text' => 'Alternative uses of questions'],
                ['id' => 'questionFeedbackOnly', 'text' => 'Giving feedback only']
            ]])
        </div>
        <div class="col-lg-6"></div>
    </div>

</section>


<section id="{{\App\ViewTools\HelpLinks::$questionCreate['id']}}" class="group">
    <h4 class="text-center">Creating and editing questions</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">In setting up the exam, you create a <i>question</i> by giving it a brief
                <code>Question Name</code> (to use as a reminder while grading) and, optionally, the full <code>Question Text</code> that was presented to the student.</p>

            <blockquote>
                <h6>Example</h6>

                <p>Students were asked to answer the question:</p>
                <blockquote>Explain the skeptical method Descartes uses in the Meditations</blockquote>
                <p>Thus:</p>

                <p><em>Question Name</em>:
                    <mark>Explain skeptical method</mark>
                </p>
                <p><em>Question Text</em>:
                    <mark>Explain the skeptical method Descartes uses in the Meditations</mark>.</p>

            </blockquote>
        </div>

        <div class="col-lg-6">
            @include('help.partials.picture_container',
                     ['imageFile' => 'question/question_edit_text_entered.jpg',
                     'altText' =>"Example of text entered into the question name and text boxes",
                     'caption' => 'Enter question name and (optionally) its text'])
        </div>
    </div>
</section>

<section id="{{\App\ViewTools\HelpLinks::$questionMaxPoints['id']}}" class="group">
    <h4 class="text-center">Maximum points possible</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">Enter the maximum number of points a student can achieve on a question in the box marked <code>Max Score</code>.</p>

            <p class="answer">If you will not assign grades with the gradeomatic (and don't need question data for assessment), set the max score to 0.</p>

            <p class="answer">If you want all questions to count equally toward the overall exam grade, assign each question the same number of points. If all questions count equally, we recommend assigning each question 100 points.</p>
        </div>

        <div class="col-lg-6">
            @include('help.partials.picture_container',
         ['imageFile' => 'question/question_edit_score_highlighted.jpg',
         'altText' =>"Question edit page with max score field highlighted",
         'caption' => 'Enter max possible points'])

        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">If you want some questions to count more toward the final grade than others,
                adjust the maximum scores accordingly.</p>

            <p class="answer">For example, if Question 1 and Question 2 are each worth
                25% of the grade, and Question 3 is worth 50%, you could set the maximum scores for Question 1
                and Question 2 to 100, and the maximum score for Question 3 to 200 points (alternatively: Q1 = 25
                points, Q2 = 25 points, and Q3 = 50 points).
            </p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
['imageFile' => 'question/question_edit_3_questions_same_value.jpg',
'altText' =>"Three questions, each with 100 points as the maximum score",
'caption' => 'Three questions, each worth the same amount'])
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6"></div>

        <div class="col-lg-6">
            @include('help.partials.picture_container',
['imageFile' => 'question/question_edit_3_questions_diff_values.jpg',
'altText' =>"Three questions, questions 1 and 2 worth 100 points each, and question 3 worth 200 points",
'caption' => 'Three questions with different point values'])
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            @include('help.partials.related_links', ['relatedLinks' =>
          [
              ['id' => 'questionFeedbackOnly', 'right' => 'Giving feedback only']
          ]])
        </div>
        <div class="col-lg-6"></div>
    </div>
</section>


<section id="{{\App\ViewTools\HelpLinks::$questionReorder['id']}}" class="group">
    <h4 class="text-center">Reordering questions</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">To change the order of questions click and hold the <span class="btn btn-info btn-sm"><span class="glyphicon glyphicon-move" aria-hidden="true"></span>Move</span> button for the question whose position you want to change.</p>

            <p class="answer">While holding the button down, drag the question to its new position.</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
['imageFile' => 'question/question_edit_reordering.jpg',
'altText' =>"Question 2 being dragged to become Question 1",
'caption' => 'Dragging Question 2 to become Question 1'])
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">Once in position, release the button. The other questions will update their numbers
                accordingly.</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
['imageFile' => 'question/question_edit_post_reorder.jpg',
'altText' =>"Question 2 has now become Question 1",
'caption' => 'The Question-formerly-known-as-2 is now Question 1'])

        </div>
    </div>
</section>


<section id="{{\App\ViewTools\HelpLinks::$questionSave['id']}}" class="group">
    <h4 class="text-center">Saving question edits</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">No changes to the questions are saved until you click <code>Add/Edit elements</code>.</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
['imageFile' => 'question/question_edit_save.jpg',
'altText' =>"Circle around the Add Edit Elements button",
'caption' => "Click the 'Add/Edit Elements' button to save"])

        </div>
    </div>
</section>

<section id="{{\App\ViewTools\HelpLinks::$questionDelete['id']}}" class="group">
    <h4 class="text-center">Removing questions</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">To remove a question, click its <span class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span>Delete</span> button.</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
['imageFile' => 'question/question_edit_delete.jpg',
'altText' =>"Circle around question 2's delete button",
'caption' => 'Click the Delete button to remove a question'])

        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">When you click the button, a confirmation dialog will pop up.</p>

            <p class="answer">Once you confirm by clicking <code>Delete</code> in the pop up, the question will disappear from
                the screen. However, the question will not actually be deleted from the database until you click <code>Add/Edit
                Elements</code></p>

            <p class="answer">Please be very careful with deleting questions. If a question is deleted, all student scores for that question are permanently removed. Any elements associated with the question are also deleted, along with any student scores for those elements.</p>

            <p class="answer text-danger"><strong>There is no way to undo the deletion or to recover the lost data</strong></p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
['imageFile' => 'question/question_edit_delete_confirm.jpg',
'altText' =>"Confirmation dialog for deleting question 2",
'caption' => 'Confirmation dialog for deleting question 2'])

        </div>
    </div>
</section>


<section id="{{\App\ViewTools\HelpLinks::$questionAltUses['id']}}" class="group">

    <h4 class="text-center">Miscellaneous: alternative uses of questions</h4>

    <div class="row">
        <div class="col-lg-6">

            <p class="answer">We mentioned earlier that while an exam must have at least one question, there is
                no need for the questions to be 'questions' in the traditional sense.</p>

            <p class="answer">For example, suppose you have an exam with four
                questions
                each worth 20%
                and want the student's grammar on all questions to count for 20%. Simply add an extra question
                called 'Grammar', and
                set the number of points that portion is worth.</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
['imageFile' => 'question/question_edit_misc_grammar.jpg',
'altText' =>"Fourth question named grammar added",
'caption' => "Adding a question called 'Grammar' worth 20%"])

        </div>
    </div>
</section>


<section id="{{\App\ViewTools\HelpLinks::$questionFeedbackOnly['id']}}" class="group">
    <h4 class="text-center">Miscellaneous: Feedback only </h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">While each question must have a maximum score, the maximum score can be
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