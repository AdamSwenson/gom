<li class="">

    <a href="#{{\App\ViewTools\HelpLinks::$instructSectionSetup['id']}}">Setup</a>
    <ul class="nav nav-stacked">
        <li>
            <a href="{{\App\ViewTools\HelpLinks::$instructSectionExamSetup['id'] }}">Exams</a>
            <ul class="nav nav-stacked">
                @include('help.partials.simple_links', ['links' => [
                \App\ViewTools\HelpLinks::$examWhat,
                \App\ViewTools\HelpLinks::$examCreate,
                \App\ViewTools\HelpLinks::$examClone
                ]])
            </ul>
        </li>


        <li>
            <a href="#{{\App\ViewTools\HelpLinks::$instructSectionQuestionSetup['id']}}">Questions</a>
            <ul class="nav nav-stacked">
                @include('help.partials.simple_links', ['links' => [
                \App\ViewTools\HelpLinks::$questionWhat,
                \App\ViewTools\HelpLinks::$questionCreate,
                \App\ViewTools\HelpLinks::$questionEdit,
                \App\ViewTools\HelpLinks::$questionMaxPoints,
                \App\ViewTools\HelpLinks::$questionReorder,
                \App\ViewTools\HelpLinks::$questionSave,
                \App\ViewTools\HelpLinks::$questionDelete,
                \App\ViewTools\HelpLinks::$questionAltUses,
                \App\ViewTools\HelpLinks::$questionFeedbackOnly
                ]])
            </ul>
        </li>

        <li>
            <a href="#{{\App\ViewTools\HelpLinks::$instructSectionElementSetup['id']}}">Elements</a>
            <ul class="nav nav-stacked">
                @include('help.partials.simple_links', ['links' => [
                \App\ViewTools\HelpLinks::$elementWhat,
                \App\ViewTools\HelpLinks::$elementCreate,
                \App\ViewTools\HelpLinks::$elementEdit,
                \App\ViewTools\HelpLinks::$elementCustomize,
                \App\ViewTools\HelpLinks::$elementAdd,
                \App\ViewTools\HelpLinks::$elementSave
                ]])
            </ul>
        </li>

        <li>
            <a href="#{{\App\ViewTools\HelpLinks::$instructSectionRosterSetup['id']}}">Rosters</a>
            <ul class="nav nav-stacked">
                @include('help.partials.simple_links', ['links' => [
                ['id' => 'rosterIntro', 'text' => 'Introduction'],
                ['id' => 'rosterPrep', 'text' => 'Preparing the file'],
                ['id' => 'rosterImport', 'text' => 'Importing file'],
                ['id' => 'rosterManual', 'text' => 'Manually adding students'],
                ['id' => 'rosterManual', 'text' => 'Manually editing students'],
                ['id' => 'rosterDelete', 'text' => 'Removing students'],
                ['id' => 'rosterSave', 'text' => 'Saving students']
                ]])
            </ul>
        </li>
    </ul>
</li>

<li class="">
    <a href="#{{\App\ViewTools\HelpLinks::$instructSectionGrade['id']}}">Grade</a>
    <ul class="nav nav-stacked">
        <li class="">
            <a href="#{{\App\ViewTools\HelpLinks::$instructSectionGradeGrading['id']}}">Grading</a>
            <ul class="nav nav-stacked">
                @include('help.partials.simple_links', ['links' => [
                \App\ViewTools\HelpLinks::$gradeExamSelect,
                \App\ViewTools\HelpLinks::$gradeStudentSelect,
                \App\ViewTools\HelpLinks::$gradeDashboard,
                \App\ViewTools\HelpLinks::$gradeStart,
                \App\ViewTools\HelpLinks::$gradeSelectQuestion,
                \App\ViewTools\HelpLinks::$gradeScoreQuestion,
                \App\ViewTools\HelpLinks::$gradeScoreElement,
                \App\ViewTools\HelpLinks::$gradeCustomizeFeedback,
                \App\ViewTools\HelpLinks::$gradeSave
                ]])
            </ul>
        </li>
        <li class="">
            <a href="#{{\App\ViewTools\HelpLinks::$instructSectionGradeAssign['id']}}">Grade distribution</a>
            <ul class="nav nav-stacked">
                @include('help.partials.simple_links', ['links' => [
                \App\ViewTools\HelpLinks::$assignSetCutoffs,
                \App\ViewTools\HelpLinks::$assignSave,
                \App\ViewTools\HelpLinks::$assignVisualize
                ]])
            </ul>
        </li>
    </ul>
</li>

<li class="">
    <a href="#{{\App\ViewTools\HelpLinks::$instructSectionReport['id']}}">Report</a>
    <ul class="nav nav-stacked">
        <li class="">
            <a href="#{{\App\ViewTools\HelpLinks::$instructSectionReportFeedbackRelease['id']}}">Release feedback</a>
            <ul class="nav nav-stacked">
                @include('help.partials.simple_links', ['links' => [
                \App\ViewTools\HelpLinks::$reportRelease,
                \App\ViewTools\HelpLinks::$reportLock
                ]])
            </ul>
        </li>

        <li class="">
            <a href="#{{\App\ViewTools\HelpLinks::$instructSectionReportAnalytics['id']}}">Analytics</a>
            <ul class="nav nav-stacked">
                @include('help.partials.simple_links', ['links' => [
                \App\ViewTools\HelpLinks::$analyticsOverview,
                \App\ViewTools\HelpLinks::$analyticsBoxPlots
                ]])
            </ul>
        </li>

        <li class="">
            <a href="#{{\App\ViewTools\HelpLinks::$instructSectionReportExport['id']}}">Export</a>
            <ul class="nav nav-stacked">
                @include('help.partials.simple_links', ['links' => [
                \App\ViewTools\HelpLinks::$exportHow
                ]])
            </ul>
        </li>

        <li class=""><a href="#{{\App\ViewTools\HelpLinks::$instructSectionReportStudentControls['id']}}">Student
                controls</a>
            <ul class="nav nav-stacked">
                @include('help.partials.simple_links', ['links' => [
                \App\ViewTools\HelpLinks::$studentControlEmail,
                \App\ViewTools\HelpLinks::$studentControlReview
                ]])
            </ul>
        </li>

    </ul>
</li>
