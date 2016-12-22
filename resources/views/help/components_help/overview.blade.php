<section id="{{\App\ViewTools\HelpLinks::$overviewProcess['id']}}" class="group">
    <div class="row">
        <div class="col-lg-6">
            <p class="answer">
                The gradeomatic divides the grading process into three parts
            </p>

            <dl class="dl-horizontal">
                <dt><a href="#{{\App\ViewTools\HelpLinks::$instructSectionSetup['id']}}">Setup</a></dt>
                <dd>Create the exam, prepare the questions, add raw material for feedback, and upload students</dd>

                <dt><a href="#{{\App\ViewTools\HelpLinks::$instructSectionGrade['id']}}">Grade</a></dt>
                <dd>Evaluate student work and adjust the grade distribution</dd>

                <dt><a href="#{{\App\ViewTools\HelpLinks::$instructSectionReport['id']}}">Report</a></dt>
                <dd>Review student performance and release feedback to students</dd>
            </dl>

            <p class="answer">Of course, grading is a complex and organic process. So, you can generally jump around
                between
                the stages. There's no need to be tortured by a typo which you didn't notice until 5
                exams
                in.
                It's easy to add additional items for assessment and feedback mid-grading when your students discover a
                novel way to misunderstand a concept.
            </p>

            <p class="answer">While reviewing student
                work in the <a href="#{{\App\ViewTools\HelpLinks::$instructSectionGradeGrading['id']}}">grading</a> stage, you enter
                scores for each question and its subsidiary tasks. This automatically builds individualized feedback for
                each student. You may further customize each student's feedback by editing the compiled text on the fly.</p>

            <p class="answer">Once you're finished grading, you use helpful statistics and visualizations of student
                performance make any necessary <a
                        href="{{\App\ViewTools\HelpLinks::$instructSectionGradeAssign['id']}}">adjustments to the grade
                    distribution</a></p>

            <p class="answer">With <a
                        href="{{\App\ViewTools\HelpLinks::$instructSectionReportFeedbackRelease['id']}}">two clicks</a>
                you can email each student a unique link to their feedback. This link allows each student
                to securely view their grade and individual feedback along with detailed charts indicating how well they
                performed vis-a-vis their peers.</p>

            <p class="answer">Once students have had enough time to review their feedback, you may <a
                        href="#{{\App\ViewTools\HelpLinks::$instructSectionReportFeedbackRelease['id']}}">remove access</a> with
                another click. You may also print out the feedback and hand it back to students. </p>

            <p class="answer">One last click <a href="#{{\App\ViewTools\HelpLinks::$instructSectionReportExport['id']}}">exports</a> your
                students' scores and grades to a spreadsheet. A quick copy and paste into your grade book, and you're ready for a celebratory
                beverage.</p>

        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'feedback/partial_example_of_feedback.jpg',
            'altText' =>"Partial example of some sample feedback given to students",
            'caption' => "Part of a student's feedback"])
            <p class="answer"><a href="{{asset('images')}}">Sample feedback for student (.pdf)</a></p>
        </div>

    </div>


</section>