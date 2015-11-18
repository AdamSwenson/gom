<h4 class="text-center">The grading process</h4>
<div class="row">
    <div class="col-lg-6">
        <section id="{{\App\ViewTools\HelpLinks::$overviewProcess['id']}}" class="group">
            <p class="answer">
                The gradeomatic separates the grading process into three components
            </p>

            <ul>
                <li><a href="#{{\App\ViewTools\HelpLinks::$instructSectionSetup['id']}}">Setup</a>: Create the
                    exam/assignment, prepare the questions, add raw material for
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

            <p class="answer">Of course, grading is a complex and organic process. So, you can generally jump around
                between
                the
                stages. We wouldn't let you be tortured by a typo in a question name which you didn't notice until 5
                exams
                in.
                Nor would we prevent you from adding an extra element after noticing that your students have discovered
                a
                brand
                new way to misunderstand a concept.
            </p>

            <p class="answer">During <a
                        href="#{{\App\ViewTools\HelpLinks::$instructSectionGradeGrading['id']}}">grading</a>, you enter
                a score for each question and
                record how well the student performed on each element. In recording performance on elements, you
                automatically build feedback for each student based on the stock text you entered when you created the
                elements. You may also further customize the feedback each student will receive.</p>

            <p class="answer">Once you're finished grading, you use helpful statistics and visualizations of student
                performance make any necessary <a
                        href="{{\App\ViewTools\HelpLinks::$instructSectionGradeAssign['id']}}">adjustments to the grade
                    distribution</a></p>

            <p class="answer">Then with two clicks you can <a
                        href="{{\App\ViewTools\HelpLinks::$instructSectionReportFeedbackRelease['id']}}">release</a> the
                feedback by emailing each student a unique link. This link will allow them
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

        {{--<section id="{{\App\ViewTools\HelpLinks::$overviewThings['id']}}" class="group">--}}
        {{--<h4>Overview: Things</h4>--}}

        {{--</section>--}}
    </div>
    <div class="col-lg-6">
        @include('help.partials.picture_container',
        ['imageFile' => 'feedback/partial_example_of_feedback.jpg',
        'altText' =>"Partial example of some sample feedback given to students",
        'caption' => "Part of a student's feedback"])
        <p class="answer"><a href="images/feedback/feedback_sample.pdf">Sample feedback for student (.pdf)</a></p>
    </div>
</div>