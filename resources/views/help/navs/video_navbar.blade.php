<li class="">
    <a href="#setupVideos">Setup</a>
    <ul class="nav nav-stacked">
        @include('help.partials.simple_links', ['links' => [
         ['id' => 'videoExamSetup', 'text' => 'Setting up the exam1'],
         ['id' => 'videoRosterUpload', 'text' => 'Importing students from file']
        ]])
    </ul>
</li>

<li class="">
    <a href="#gradeVideos">Grade</a>
    <ul class="nav nav-stacked">
        @include('help.partials.simple_links', ['links' =>
        [
          ['id' => 'videoGrading', 'text' => 'Grading exams'],
      ]])
    </ul>
</li>

<li class="">
    <a href="#reportVideos">Report</a>
    <ul class="nav nav-stacked">
        {{--@include('help.partials.simple_links', ['links' => [--}}
        {{--]])--}}
    </ul>
</li>

<li class="">
    <a href="#otherVideos">Other</a>
    <ul class="nav nav-stacked">
{{--        @include('help.partials.simple_links', ['links' => [--}}
{{--            ['id' => 'faqSecureData', 'text' => 'Student data security'],--}}
{{--            ['id' => 'faqCreator', 'text' => 'Who created this?'],--}}
{{--            ['id' => 'faqSupportGom', 'text' => 'How can I contribute?']--}}
      {{--]])--}}
    </ul>
</li>