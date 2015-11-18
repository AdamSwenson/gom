<section id="{{\App\ViewTools\HelpLinks::$gradeExamSelect['id'] }}" class="group">
    <h4 class="text-center">Choose the exam to grade</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">When you are done setting up the exam and ready to grade, click 'Grade' in the navigation
                bar
                at the top of the page.</p>

            <div class="col-lg-6">
                @include('help.partials.picture_container',
                ['imageFile' => 'grade/grade_select_page_grade_circled.jpg',
                'altText' =>'The grade select page with the Grade button circled',
                'caption' => 'Click Grade'])
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">That will take you to the grade selection page</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'grade/grade_select_page.jpg',
            'altText' =>'The grade select page',
            'caption' => 'Select exam to grade'])
        </div>

    </div>


    <div class="row">
        <div class="col-lg-6">
            <p class="answer">Click Grade to start grading the exam</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'grade/grade_select_page_grade_circled.jpg',
            'altText' =>'The grade select page with the Grade button circled',
            'caption' => 'Click Grade'])
        </div>
    </div>
</section>

<h4 class="text-center">Grading page tools</h4>


<section id="{{\App\ViewTools\HelpLinks::$gradeStudentSelect['id']}}" class="group">
    <h6>Student selection area</h6>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">The student selection area allows you to choose which exam to grade.</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'grade/grade_student_area_annotated.jpg',
            'altText' =>"The student selection area of the grading page with notes explaining that clicking the pencil icon hides student names, that clicking name or id sorts the list of students by name or id, and that clicking on a student's row selects them for grading.",
            'caption' => 'Select student to grade'])
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">If you prefer to grade exams without knowing the students' names, click the pencil
                icon. </p>

            <p class="answer">The student names will be replaced by 'Name Hidden'</p>

            <p class="answer">It will help to click 'ID' to sort the students by student id.</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'grade/grade_student_area_names_hidden.jpg',
            'altText' =>"The student selection area of with the student names replaced by Name Hidden after clicking the pencil icon",
            'caption' => 'Hide student names'])
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">You may also search for a student by clicking on the name or id display boxes at the top
                and
                start typing. An autocomplete box will appear and allow you to select the appropriate student</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'grade/grade_autocomplete_id.jpg',
            'altText' =>"The student selection area with typing in the current student id field to show autocomplete dropdown with matching student ids",
            'caption' => 'Search student by id'])
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6"></div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'grade/grade_autocomplete_name.jpg',
            'altText' =>"The student selection area with typing in the current student name field to show autocomplete dropdown with matching student names",
            'caption' => 'Search student by name'])
        </div>
    </div>
</section>


<section id="{{\App\ViewTools\HelpLinks::$gradeDashboard['id']}}" class="group">
    <h6>Dashboard</h6>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">The dashboard displays statistics to keep you motivated and grading quickly.</p>

            <p class="answer">The button marked 'Pause' or 'Start' manually starts and stops the timer. When you take a
                break, it's a good idea to click pause. Otherwise the timer will keep running for the last exam you
                graded.
                This will throw off the average time and reduce the accuracy of the estimated remaining time.</p>

            <p class="answer">The current exam time is how long the present exam has taken.</p>

            <p class="answer">The total time is the time grading all students so far.</p>

            <p class="answer">The average time is the average amount of time spent grading an exam.</p>

            <p class="answer">The remaining time is the estimated amount of time until you are done grading. It is
                calculated by multiplying the average exam time with the number of ungraded students</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'grade/grade_statistics_area_annotated.jpg',
            'altText' =>"The statistics area of the grading page with notes explaining that the button manually starts and stops the timer, that the current exam time is how long the present exam has taken, total time is the time grading all exams, average time is the average amount of time spent grading an exam, and remaining time is the estimated amount of time until you are done grading.",
            'caption' => 'Dashboard statistics'])
        </div>
    </div>
</section>


<section id="{{\App\ViewTools\HelpLinks::$gradeStart['id']}}" class="group">
    <h4 class="text-center">Start grading</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">When you click on a student's row, the gradeomatic retrieves the student's record and
                highlights their row in blue to show that it is the exam currently being graded. This will reveal the
                questions for the exam and a slider for each element.</p>

        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'grade/grade_student_selected_no_input.jpg',
            'altText' =>"The first student has been selected. The row with her name is now blue. The input area is displayed.",
            'caption' => 'Select a student'])
        </div>
    </div>
</section>


<section id="{{\App\ViewTools\HelpLinks::$gradeScoreElement['id']}}" class="group">

    <h6>Enter element scores and customize feedback</h6>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">
                After reading the student's response, move the slider to a value that corresponds to the student's
                performance. This won't affect the question grade, but it will affect the written feedback.</p>

            <p class="answer">If you wish to tailor the student's feedback individually, modify the text box next to
                that
                element. The text you enter will be shown to that student alone.</p>

            <p class="answer">
                You will notice that the text in the box to the right of the slider updates to contain the text you had
                entered for that level of competence. If you did not customize the text for each degree of performance
                when
                you created the element, the text will not change as you move the slider. However, the score indicated
                by
                the slider will still be recorded so you can use it in assessing how students did overall.
            </p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'grade/grade_element_sliders_moved.jpg',
            'altText' =>"The element sliders for the first question have been moved revealing the text that was created for the respective levels of performance.",
            'caption' => 'Record element scores and customize feedback'])
        </div>
    </div>
</section>

<section id="{{\App\ViewTools\HelpLinks::$gradeSelectQuestion['id']}}" class="group">
    <div class="row">
        <div class="col-lg-6">
            <p class="answer">To continue to the next question, click the appropriate tab at the top of the input area.
            </p>

            <p class="answer">If the student didn't need to answer a question, simply leave the
                score area blank and they won't be graded.</p>

            <p class="answer">Once a grade is entered for at least one question, the student's exam is considered graded
                for
                timing and release purposes. This allows you to construct exams where students may choose among one or
                more
                questions to answer.</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'grade/grade_question_2_circled.jpg',
            'altText' =>"Circle around the Q2 tab in the input area to indicate what to click in order to grade question two.",
            'caption' => 'Grade next question'])
        </div>
    </div>
</section>


<section id="{{\App\ViewTools\HelpLinks::$gradeScoreQuestion['id']}}" class="group">
    <h6>Enter question score</h6>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">
                There are two ways to enter a score for the question.</p>

            <p class="answer">You may type a score in the Score box. Make sure it is a number and less than the maximum
                score.</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'grade/grade_question_score_entered.jpg',
            'altText' =>"A numeric question score has been typed in the Score box.",
            'caption' => 'Manually entering question score'])
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">
                Alternatively, you may select a letter grade from the dropdown menu. The gradeomatic will enter a
                percentage
                of the maximum possible score in the box for you.
            </p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'grade/grade_letter_grade_dropdown_exposed.jpg',
            'altText' =>"The Letter Grade button has been clicked and a dropdown menu listing letter grades from A+ to F has appeared below it.",
            'caption' => 'Giving the question a letter grade'])
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6"></div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'grade/grade_letter_grade_entered_popup_displayed.jpg',
            'altText' =>"A score corresponding to the letter grade selected has appeared in the Score box with a message indicating that a B+ is 88% and so 88% of the max possible 100 is 88, which is in the box.",
            'caption' => 'Message confirming letter grade entered'])
        </div>
    </div>
</section>




<h4 class="text-center">Miscellaneous</h4>
<section id="{{\App\ViewTools\HelpLinks::$gradeSave['id']}}" class="group">
    <h6>Saving scores</h6>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">
                You might be looking for a Save button or wondering when the scores are saved for an exam.</p>

            <p class="answer">
                Unlike the setup pages where no changes were saved until you moved to the next step, during grading,
                every
                time you move a slider, click a button, or type in a box and then click somewhere else, the gradeomatic
                sends all the data for the current exam to the server.
            </p>

            <p class="answer">You may thus see a message informing you that there was a problem. Simply repeat your last
                action and it should save properly.
            </p>
        </div>
        <div class="col-lg-6"></div>
    </div>
</section>