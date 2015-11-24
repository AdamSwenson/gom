<div class="row">
    <div class="col-lg-6">
        <section id="{{\App\ViewTools\HelpLinks::$overviewProcess['id']}}" class="group">
            <p class="answer">
                The gradeomatic separates the grading process into three components
            </p>

            <ul>
                <li><a href="#{{\App\ViewTools\HelpLinks::$instructSectionSetup['id']}}">Setup</a>: Create the
                    exam, prepare the questions, add raw material for
                    feedback,
                    and
                    upload students
                </li>
                <li><a href="#{{\App\ViewTools\HelpLinks::$instructSectionGrade['id']}}">Grade</a>: Evaluate student
                    work and adjust the grade distribution
                </li>
                <li><a href="#{{\App\ViewTools\HelpLinks::$instructSectionReport['id']}}">Report</a>: Review student
                    performance and release feedback to students
                </li>
            </ul>

            <p class="answer">That said, grading is a complex and organic process. Thus you can generally jump around
                between
                the
                stages. There's no need to be tortured by a typo which you didn't notice until 5
                exams
                in.
                It is easy to add additional items for assessment and feedback mid-grading when your students discover a novel way to misunderstand a concept.
            </p>

            <p class="answer">During <a
                        href="#{{\App\ViewTools\HelpLinks::$instructSectionGradeGrading['id']}}">grading</a>, you enter
                scores for each question and its subsidiary tasks. In doing so, you
                automatically build individualized feedback for each student. You may also further customize the feedback each student will receive.</p>

            <p class="answer">Once you're finished grading, use helpful statistics and visualizations of student
                performance make any necessary <a
                        href="{{\App\ViewTools\HelpLinks::$instructSectionGradeAssign['id']}}">adjustments to the grade
                    distribution</a></p>

            <p class="answer">With two clicks you can <a
                        href="{{\App\ViewTools\HelpLinks::$instructSectionReportFeedbackRelease['id']}}">release</a> the
                feedback by emailing each student a unique link. This link allows a student
                to securely view their grade and individual feedback along with charts indicating how well they
                performed versus class averages on each question and
                element.</p>

            <p class="answer">Once they've had enough time to review the feedback, another click <a
                        href="#{{\App\ViewTools\HelpLinks::$instructSectionReportFeedbackRelease['id']}}">hides</a>
                the
                feedback from students. You may also print out the feedback and hand it back to students. </p>

            <p class="answer">Finally, one more click <a
                        href="#{{\App\ViewTools\HelpLinks::$instructSectionReportExport['id']}}">exports</a> your
                students' scores and grades
                to a spreadsheet. A quick copy and paste into your grade book, and you're ready for a celebratory
                beverage.
            </p>
        </section>

    </div>
    <div class="col-lg-6">
        @include('help.partials.picture_container',
        ['imageFile' => 'feedback/partial_example_of_feedback.jpg',
        'altText' =>"Partial example of some sample feedback given to students",
        'caption' => "Part of a student's feedback"])
        <p class="answer"><a href="{{asset('images/feedback/feedback_sample.pdf')}}">Sample feedback for student (.pdf)</a></p>
    </div>
</div>