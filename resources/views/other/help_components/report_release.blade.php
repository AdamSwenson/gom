<div class="row">
    <div class="col-lg-3"></div>
    <div class="col-lg-6">
        @include('other.help_components.picture_container',
     ['imageFile' => 'report_release/report_select_page_annotated.jpg',
     'altText' =>"The selection page for reports with text indicating that the Release Exams button releases exams, the lock button hides feedback from students, the analytics button displays analytics for the exam, the export button downloads scores and grades to a spreadsheet, and the view feedback button allows you to see the feedback that an individual student will receive.",
     'caption' => 'What the buttons do'])
    </div>
    <div class="col-lg-3"></div>
    </div>

<h4 id="releaseExams" class="text-center">Releasing exams</h4>
<div class="row">
    <div class="col-lg-6">
        <p class="answer">
            "Release Exam" will officially release
            the exam, emailing all students you have graded and who have valid email addresses a link where they
            can view their grade and compiled feedback.
        </p>


        <p class="answer"> The lock is the reverse, cutting off all access to all
            students for that exam. Once an exam is locked, it must be re-released, which will email students with
            new links to their results. The old links will not work.</p>

    </div>
    <div class="col-lg-6">
        @include('other.help_components.picture_container',
        ['imageFile' => 'grade/grade_question_2_circled.jpg',
        'altText' =>"Circle around the Q2 tab in the input area to indicate what to click in order to grade question two.",
        'caption' => 'Grade next question'])
    </div>
</div>

<h4 class="text-center">Miscellaneous</h4>

<h6>Saving grades</h6>


