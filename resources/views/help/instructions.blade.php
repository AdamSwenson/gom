@extends('help.help_base')

@section('sideNav')
    <li class="">
        <ul class="nav nav-stacked">
            <li class="">
                <a href="#setup">Setup</a>
                <ul class="nav nav-stacked">
                    <li><a href="#questionSetup">Questions</a></li>
                    <li><a href="#elementSetup">Elements</a></li>
                    <li><a href="#rosterSetup">Rosters</a></li>
                </ul>
            </li>

            <li class="">
                <a href="#grade">Grade</a>
                <ul class="nav nav-stacked">
                    <li class=""><a href="#grading">Grading</a></li>
                    <li class=""><a href="#gradeAssign">Grade distribution</a></li>
                </ul>
            </li>
            <li class="">
                <a href="#report">Report</a>
                <ul class="nav nav-stacked">
                    <li class=""><a href="#releaseFeedback">Release feedback</a></li>
                    <li class=""><a href="#analytics">Analytics </a></li>
                    <li class=""><a href="#exportGrades">Export </a></li>
                    <li class=""><a href="#studentControls">Student controls</a></li>
                </ul>
            </li>
        </ul>
    </li>
@endsection

@section('mainText')
    <div class="well">
        <div class="infoItem">
            <h4 id="intro">Introduction</h4>

            <p class="answer">
                The gradeomatic separates the grading process into three components
            </p>
            <ul>
                <li><a href="#how_it_works">Exam setup</a>: Preparing the questions, adding the raw material for
                    comments,
                    and
                    uploading students
                </li>
                <li><a href="#grading">Grading</a>: Evaluating student work and tweaking the grade distribution</li>
                <li><a href="#reports">Reporting</a>: Reviewing student performance and releasing feedback to students
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
        </div>

        <div class="infoItem">
            <h4 id="how_it_works">Exam setup</h4>

            <p class="answer">Let's start with how things fit together.</p>

            <p class="answer">An <i>exam</i> is the most basic unit of organization. Note that we just chose to call it
                an
                'exam'. It could be a quiz, an assignment, a paper, or virtually any other activity for which you want
                to
                assess
                a bunch of students on the same criteria and at approximately the same time.</p>

            <p class="answer">An exam is identified by its name, and the year and term in which it is given. An exam is
                associated with a <a href="#rosters">roster</a> of students. Every exam contains at least one <a
                        href="#questions">question</a>. Each question usually contains at least one task which students
                need
                to
                complete in order to receive full credit for the question. These tasks are <a
                        href="#elements">elements</a>.
            </p>

            <p class="answer">During <a href="#grading">grading</a>, you enter a grade or score for each question and
                rate
                how
                well the student performed on each element. You may also choose to further customize the feedback each
                student
                will receive.</p>

            <p class="answer">Once you're finished grading, helpful statistics and visualizations of student performance
                will
                help you <a href="assignments">adjust the grade distribution</a> if necessary.</p>

            <p class="answer">Then with two clicks you can email each student a unique link. This link will allow them
                to
                securely view your feedback along with charts indicating how well they performed on each question and
                element.
                Once they've had enough time to review the feedback, another click <a href="#releasing">hides</a> the
                feedback.
                It is also possible to print out the feedback and hand it back to students. Finally, one more click <a
                        href="#exporting">exports</a> your students' scores and grades to a spreadsheet. A quick copy
                and
                paste
                into your grade book, and you're ready for a celebratory beverage.</p>
        </div>
    </div>


    <div class="well">
        <section id="setup" class="group">
            <h2>Setup</h2>

            <div class="infoItem">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <section id="questionSetup" class="group">
                            <h3 class="panel-title">Questions</h3>
                        </section>
                    </div>
                    <div class="panel-body">
                        @include('other.help_components.setup_question')
                    </div>
                </div>
            </div>

            <div class="infoItem">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <section id="elementSetup" class="group">
                            <h3 class="panel-title">Elements</h3>
                        </section>
                    </div>
                    <div class="panel-body">
                        @include('other.help_components.setup_element')
                    </div>
                </div>
            </div>


            <div class="infoItem">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <section id="rosterSetup" class="group">
                            <h3 class="panel-title">Student Rosters</h3>
                        </section>
                    </div>
                    <div class="panel-body">
                        @include('other.help_components.setup_rosters')
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="well">
        <section id="grade" class="group">
            <h2>Grade</h2>

            <div class="infoItem">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <section id="grading" class="group">
                            <h3 class="panel-title">Grading</h3>
                        </section>
                    </div>
                    <div class="panel-body">
                        @include('other.help_components.grade_grading')
                    </div>
                </div>
            </div>

            <div class="infoItem">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <section id="gradeAssign" class="group">
                            <h3 class="panel-title">Assigning Grades</h3>
                        </section>
                    </div>
                    <div class="panel-body">
                        @include('other.help_components.grade_gradeassign')
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="well">
        <section id="report" class="group">
            <h2>Report</h2>

            <div class="infoItem">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <section id="releaseFeedback" class="group">
                            <h3 class="panel-title">Releasing and hiding student
                                feedback</h3>
                        </section>
                    </div>
                    <div class="panel-body">
                        @include('other.help_components.report_release')
                    </div>
                </div>
            </div>

            <div class="infoItem">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <section id="exportGrades" class="group">
                            <h3 class="panel-title">Exporting scores and grades</h3>
                        </section>
                    </div>
                    <div class="panel-body">
                        @include('other.help_components.report_export')
                    </div>
                </div>
            </div>

            <div class="infoItem">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <section id="analytics" class="group">
                            <h3 class="panel-title">Analytics</h3>
                        </section>
                    </div>
                    <div class="panel-body">
                        @include('other.help_components.report_analytics')
                    </div>
                </div>
            </div>

            <div class="infoItem">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <section id="studentControls" class="group">
                            <h3 class="panel-title">Individual student controls</h3>
                        </section>
                    </div>
                    <div class="panel-body">
                        @include('other.help_components.report_student_controls')
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection