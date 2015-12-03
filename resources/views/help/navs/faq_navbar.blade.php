<li class="">
    <a href="#{{\App\ViewTools\HelpLinks::$faqSectionSetup['id']}}">Setup</a>
    <ul class="nav nav-stacked">
        @include('help.partials.simple_links', ['links' => [
           ['id' =>  \App\ViewTools\HelpLinks::$faqSetupGradeOnly['id'], 'text' => \App\ViewTools\HelpLinks::$faqSetupGradeOnly['text'] ],
         ['id' => 'faqCsvWhat', 'text' => '.csv files? What?'],
         ['id' => 'faqRosterBad', 'text' => 'Roster import errors'],
         ['id' => 'faqHowSave', 'text' => 'How do I save my edits?'],
         ['id' => 'faqHowSave', 'text' => 'Where is the save button?'],
        ]])
    </ul>
</li>

<li class="">
    <a href="#{{\App\ViewTools\HelpLinks::$faqSectionGrade['id']}}">Grade</a>
    <ul class="nav nav-stacked">
        @include('help.partials.simple_links', ['links' =>
        [
          ['id' => 'faqHideStudents', 'text' => 'Can I grade blind?'],
      ]])
    </ul>
</li>

<li class="">
    <a href="#{{\App\ViewTools\HelpLinks::$faqSectionReport['id']}}">Report</a>
    <ul class="nav nav-stacked">
        {{--@include('help.partials.simple_links', ['links' => [--}}
        {{--]])--}}
    </ul>
</li>

<li class="">
    <a href="#{{\App\ViewTools\HelpLinks::$faqSectionOther['id']}}">Other</a>
    <ul class="nav nav-stacked">
        @include('help.partials.simple_links', ['links' => [
            ['id' => 'faqSecureData', 'text' => 'Student data security'],
            ['id' => 'faqCreator', 'text' => 'Who created this?'],
            ['id' => 'faqSupportGom', 'text' => 'How can I contribute?']
      ]])
    </ul>
</li>
