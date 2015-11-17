<li class="">
    <a href="#setup">Setup</a>
    <ul class="nav nav-stacked">
        <li>
            <a href="#questionSetup">Questions</a>
            <ul class="nav nav-stacked">
                <li><a href="#questionCreateEdit">Create new questions</a></li>
                <li><a href="#questionCreateEdit">Edit existing questions</a></li>
                <li><a href="#questionMaxPoints">Set point value</a></li>
                <li><a href="#questionReorder">Reorder questions</a></li>
                <li><a href="#questionSave">Save questions</a></li>
                <li><a href="#questionDelete">Delete questions</a></li>
                <li><a href="#questionAltUses">Alternative uses of questions</a></li>
                <li><a href="#questionFeedbackOnly">Giving feedback only</a></li>
            </ul>
        </li>
        <li>
            <a href="#elementSetup">Elements</a>
            <ul class="nav nav-stacked">
                <li><a href="#elementWhat">What elements are</a></li>
                <li><a href="#elementCreateEdit">Create new elements</a></li>
                <li><a href="#elementCreateEdit">Edit existing elements</a></li>
                <li><a href="#elementAdd">Add additional elements</a></li>
                <li><a href="#elementSave">Save elements</a></li>
            </ul>
        </li>
        <li>
            <a href="#rosterSetup">Rosters</a>
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
    <a href="#grade">Grade</a>
    <ul class="nav nav-stacked">
        <li class="">
            <a href="#grading">Grading</a>
            <ul class="nav nav-stacked">
                @include('help.partials.simple_links', ['links' => [
                ['id' => 'gradeExamSelect', 'text' => 'Choose exam to grade'],
                ['id' => 'gradeSelectStudent', 'text' => 'Choose student to grade'],
                ['id' => 'gradeDashboard', 'text' => 'Timers and grading statistics'],
                ['id' => 'gradeStart', 'text' => 'Start grading'],
                ['id' => 'gradeSelectQuestion', 'text' => 'Select question to grade'],
                ['id' => 'gradeScoreElement', 'text' => 'Enter element scores'],
                ['id' => 'gradeScoreElement', 'text' => 'Personalize feedback'],
                ['id' => 'gradeScoreQuestion', 'text' => 'Enter question scores'],
                ['id' => 'gradeSave', 'text' => 'Saving scores']
                ]])
            </ul>
        </li>
        <li class="">
            <a href="#gradeAssign">Grade distribution</a>
            <ul class="nav nav-stacked">
                @include('help.partials.simple_links', ['links' => [
                ['id' => 'assignSetCutoffs', 'text' => 'Set cutoffs for letter grades'],
               ['id' => 'assignSave', 'text' => 'Save grade assignments'],
                ['id' => 'assignVisualize', 'text' => 'Visualizing distributions']
                ]])
            </ul>
        </li>
    </ul>
</li>

<li class="">
    <a href="#report">Report</a>
    <ul class="nav nav-stacked">
        <li class="">
            <a href="#releaseFeedback">Release feedback</a>
            <ul class="nav nav-stacked">
                @include('help.partials.simple_links', ['links' => [
                ['id' => 'reportRelease', 'text' => 'Send feedback to students'],
                ['id' => 'reportLock', 'text' => 'Hide feedback from students']
                ]])
            </ul>
        </li>

        <li class="">
            <a href="#analytics">Analytics</a>
            <ul class="nav nav-stacked">
                @include('help.partials.simple_links', ['links' => [
                ['id' => 'analyticsOverview', 'text' => 'Overview'],
                ['id' => 'analyticsBoxPlots', 'text' => 'Score box plots']
                ]])
            </ul>
        </li>

        <li class="">
            <a href="#exportGrades">Export</a>
            <ul class="nav nav-stacked">
                @include('help.partials.simple_links', ['links' => [
                ['id' => 'exportWhere', 'text' => 'How to export scores'],
                //['id' => 'reportLock', 'text' => 'Hide feedback from students']
                ]])
            </ul>
        </li>

        <li class=""><a href="#studentControls">Student controls</a>
            <ul class="nav nav-stacked">
                @include('help.partials.simple_links', ['links' => [
                ['id' => 'studentControlEmail', 'text' => 'Send feedback to individual student'],
                ['id' => 'studentControlReview', 'text' => 'Review feedback for a student']
                ]])
            </ul>
        </li>

    </ul>
</li>
