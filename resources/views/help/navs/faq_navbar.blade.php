<li class="">
    <a href="#setup">Setup</a>
    <ul class="nav nav-stacked">
        @include('help.partials.simple_links', ['links' => [
         ['id' => 'faqCsvWhat', 'text' => '.csv files? What?'],
         ['id' => 'faqRosterBad', 'text' => 'Roster import errors']
        ]])
    </ul>
</li>

<li class="">
    <a href="#setupFaq">Grade</a>
    <ul class="nav nav-stacked">
        @include('help.partials.simple_links', ['links' =>
        [
          ['id' => 'faqHideStudents', 'text' => 'Can I grade blind?'],
      ]])
    </ul>
</li>

<li class="">
    <a href="#setupFaq">Report</a>
    <ul class="nav nav-stacked">
        {{--@include('help.partials.simple_links', ['links' => [--}}
        {{--]])--}}
    </ul>
</li>

<li class="">
    <a href="#setupFaq">Other</a>
    <ul class="nav nav-stacked">
        @include('help.partials.simple_links', ['links' => [
            ['id' => 'faqSecureData', 'text' => 'Student data security'],
            ['id' => 'faqCreator', 'text' => 'Who created this?'],
            ['id' => 'faqSupportGom', 'text' => 'How can I contribute?']
      ]])
    </ul>
</li>
