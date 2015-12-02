<div class="row">
    <div class="col-lg-3"></div>
    <div class="col-lg-6">
        @include('help.partials.picture_container',
     ['imageFile' => 'report_release/report_select_page_annotated.jpg',
     'altText' =>"The selection page for reports with text indicating that the Release Exams button releases exams, the lock button hides feedback from students, the analytics button displays analytics for the exam, the export button downloads scores and grades to a spreadsheet, and the view feedback button allows you to see the feedback that an individual student will receive.",
     'caption' => 'What the buttons do'])
    </div>
    <div class="col-lg-3"></div>
</div>

<section id="{{\App\ViewTools\HelpLinks::$reportRelease['id']}}" class="group">
    <h4 class="text-center">Releasing exams</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">
                Clicking "Release Exam" officially releases the exam. This involves emailing unique links to all students who have been graded and who have valid email addresses. This link will all them to view their grade and feedback.
            </p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'report_release/report_release_warning.jpg',
            'altText' =>"Warning message that all students will be emailed which requires confirmation to complete the release.",
            'caption' => 'Confirm release'])
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6"></div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'report_release/report_release_success.jpg',
            'altText' =>"Warning message that all students will be emailed which requires confirmation to complete the release.",
            'caption' => 'Successful release'])
        </div>
    </div>
</section>


<section id="{{\App\ViewTools\HelpLinks::$reportLock['id']}}" class="group">

    <h4 class="text-center">Lock exam</h4>
    <div class="row">
        <div class="col-lg-6">
            <p class="answer"> The lock is the reverse. Clicking Lock cuts off all access to all students for that exam. Once an
                exam is locked, it must be released again. If a locked exam is re-released, students will receive a new email with a new link.</p>

            <p class="answer">Once an exam has been locked, any links that have been sent to students will not work. This can be
                confusing, so it is best to use the commands for <a href="#{{\App\ViewTools\HelpLinks::$studentControlEmail['id']}}">resending</a> links to individual students if the need
                arises (e.g., if a student loses their email).</p>

            <p class="answer">Once the exam is released, the release button changes color to green. This indicates that
                students have access to their feedback. The lock button changes to blue. This indicates that it may be
                clicked to remove student access to feedback </p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'report_release/report_released_green_lock_active.jpg',
            'altText' =>"The release button has changed colors to green. The lock button is now blue to indicate that it may be clicked. ",
            'caption' => 'Lock exam'])
        </div>
    </div>


    <div class="row">
        <div class="col-lg-6"></div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'report_release/report_confirm_lock.jpg',
            'altText' =>"Warning message confirming that you want to remove access to feedback from students.",
            'caption' => 'Lock exam confirmation'])
        </div>
    </div>
</section>
