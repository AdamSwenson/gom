<div class="row">
    <div class="col-lg-6">
        <p class="answer">
            The students button takes you to a page with individual student controls for emailing a student (useful to
            notify only one student that their grade has changed) and to review the feedback that the student can see.
        </p>
    </div>
    <div class="col-lg-6">
        @include('other.help_components.picture_container',
     ['imageFile' => 'student_controls/report_student_controls.jpg',
     'altText' =>"The student controls page with buttons for emailing individual students and for reviewing their feedback",
     'caption' => 'Student controls'])
    </div>
</div>

<h4 id="individualEmail" class="text-center">Individual email</h4>

<div class="row">
    <div class="col-lg-6">
        <p class="answer">Clicking the Email button will send a new email to the selected student.</p>

        <p class="answer">This is often useful for students who lose the initial email.
        </p>

        <p class="answer">
            This can also be helpful if you discover an error and want to update a student's scores and feedback after
            the exam has been released.
        </p>

    </div>
    <div class="col-lg-6">
        @include('other.help_components.picture_container',
        ['imageFile' => 'student_controls/report_individual_email_confirm.jpg',
        'altText' =>"Confirmation message asking if you want to send the selected student an email with feedback link.",
        'caption' => 'Individual email confirmation'])
    </div>
</div>

<h4 id="individualReview" class="text-center">Review individual feedback</h4>

<div class="row">
    <div class="col-lg-6"></div>
    <div class="col-lg-6"></div>
</div>