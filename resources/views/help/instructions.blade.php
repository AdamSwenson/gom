@extends('help.help_base')

@section('sideNav')
    @include('help.navs.instructions_navbar')
@endsection

@section('mainText')
    <div class="row">
        <div class="col-lg-6">
            @include('help.components_help.intro_note')
        </div>
        <div class="col-lg-6"></div>
    </div>
    <section id="{{\App\ViewTools\HelpLinks::$instructSectionOverview['id']}}" class="group">
        <h2>Overview</h2>

        <div class="infoItem">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">The grading process</h3>
                </div>
                <div class="panel-body">
                    @include('help.components_help.overview')
                </div>
            </div>
        </div>
    </section>


    <section id="{{\App\ViewTools\HelpLinks::$instructSectionSetup['id']}}" class="group">
        <h2>Setup</h2>

        <div class="infoItem">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <section id="{{ \App\ViewTools\HelpLinks::$instructSectionExamSetup['id'] }}" class="group">
                        <h3 class="panel-title">Create and edit exams</h3>
                    </section>
                </div>
                <div class="panel-body">
                    @include('help.components_help.setup_exam')
                </div>
            </div>
        </div>

        <div class="infoItem">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <section id="{{ \App\ViewTools\HelpLinks::$instructSectionQuestionSetup['id'] }}" class="group">
                        <h3 class="panel-title">Create and edit questions</h3>
                    </section>
                </div>
                <div class="panel-body">
                    @include('help.components_help.setup_question')
                </div>
            </div>
        </div>

        <div class="infoItem">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <section id="{{\App\ViewTools\HelpLinks::$instructSectionElementSetup['id']}}" class="group">
                        <h3 class="panel-title">Create and edit elements</h3>
                    </section>
                </div>
                <div class="panel-body">
                    @include('help.components_help.setup_element')
                </div>
            </div>
        </div>

        <div class="infoItem">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <section id="{{\App\ViewTools\HelpLinks::$instructSectionRosterSetup['id']}}" class="group">
                        <h3 class="panel-title">Create and edit student rosters</h3>
                    </section>
                </div>
                <div class="panel-body">
                    @include('help.components_help.setup_rosters')
                </div>
            </div>
        </div>
    </section>


    <section id="{{ \App\ViewTools\HelpLinks::$instructSectionGrade['id'] }}" class="group">
        <h2>Grade</h2>

        <div class="panel panel-default">
            <div class="panel-heading">
                <section id="{{ \App\ViewTools\HelpLinks::$instructSectionGradeGrading['id'] }}" class="group">
                    <h3 class="panel-title">Grade student work</h3>
                </section>
            </div>
            <div class="panel-body">
                @include('help.components_help.grade_grading')
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <section id="{{ \App\ViewTools\HelpLinks::$instructSectionGradeAssign['id'] }}" class="group">
                    <h3 class="panel-title">Adjust grade distribution</h3>
                </section>
            </div>
            <div class="panel-body">
                @include('help.components_help.grade_gradeassign')
            </div>
        </div>
    </section>


    <section id="{{ \App\ViewTools\HelpLinks::$instructSectionReport['id'] }}" class="group">
        <h2>Report</h2>

        <div class="panel panel-default">
            <div class="panel-heading">
                <section id="{{ \App\ViewTools\HelpLinks::$instructSectionReportFeedbackRelease['id'] }}"
                         class="group">
                    <h3 class="panel-title">Release and hide feedback</h3>
                </section>
            </div>
            <div class="panel-body">
                @include('help.components_help.report_release')
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <section id="{{ \App\ViewTools\HelpLinks::$instructSectionReportExport['id'] }}" class="group">
                    <h3 class="panel-title">Export scores and grades</h3>
                </section>
            </div>
            <div class="panel-body">
                @include('help.components_help.report_export')
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <section id="{{ \App\ViewTools\HelpLinks::$instructSectionReportAnalytics['id'] }}"
                         class="group">
                    <h3 class="panel-title">Analytics</h3>
                </section>
            </div>
            <div class="panel-body">
                @include('help.components_help.report_analytics')
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <section id="{{ \App\ViewTools\HelpLinks::$instructSectionReportStudentControls['id'] }}"
                         class="group">
                    <h3 class="panel-title">Individual student controls</h3>
                </section>
            </div>
            <div class="panel-body">
                @include('help.components_help.report_student_controls')
            </div>
        </div>
    </section>

@endsection
