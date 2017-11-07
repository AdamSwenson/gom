<div class="row">

    <div class="col-lg-6">
        <p class="answer">
            The students button takes you to a page with individual student controls. On this page, you may review an individual student's feedback or send them a new email with the link to their feedback.
        </p>
    </div>
    <div class="col-lg-6">
        @include('help.partials.picture_container',
     ['imageFile' => 'student_controls/report_student_controls.jpg',
     'altText' =>"The student controls page with buttons for emailing individual students and for reviewing their feedback",
     'caption' => 'Student controls'])
    </div>
</div>


<section id="{{\App\ViewTools\HelpLinks::$studentControlEmail['id']}}" class="group">
    <h4 id="individualEmail" class="text-center">Individual email</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">Clicking the Email button will send a new notification email with a link to their feedback to the selected student. This is often used when a student loses the initial email. The feedback link will be the same link they were sent in the original email. </p>

            <p class="answer">
                This can also be helpful if you discover a grading error and want to update a few students' scores and feedback
                after
                the exam1 has been released. They will be sent the same link as in the original email (whereas, if you had <a href="#{{\App\ViewTools\HelpLinks::$reportLock['id']}}">locked</a> and then re-released the whole exam1, every student would need to receive a new link).
            </p>

        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'student_controls/report_individual_email_confirm.jpg',
            'altText' =>"Confirmation message asking if you want to send the selected student an email with feedback link.",
            'caption' => 'Individual email confirmation'])
        </div>
    </div>
</section>


<section id="{{\App\ViewTools\HelpLinks::$studentControlReview['id']}}" class="group">
    <h4 id="individualReview" class="text-center">Review individual feedback</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">By clicking the Review button, you can preview the feedback that the student will receive. </p>
            <p class="answer">This is often helpful in office hours when a student wants to talk about their exam1, but does not have a printed copy of their feedback.</p>
        </div>
        <div class="col-lg-6">
            <div class="col-lg-6">
                @include('help.partials.picture_container',
                ['imageFile' => 'feedback/partial_example_of_feedback.jpg',
                'altText' =>"Partial example of some sample feedback given to students",
                'caption' => "Part of a student's feedback"])
                <p class="answer"><a href="{{asset('images')}}">Sample feedback for student (.pdf)</a></p>
            </div>
        </div>
    </div>
</section>