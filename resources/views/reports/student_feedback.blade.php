@extends('layouts.master')

@section('pageTitle', 'Feedback | gradeomatic')
@section('description', "Review student feedback")

@section('cssLinks')
    <link href="{{ asset('inc/jqplot/jquery.jqplot.min.css')}}" />
    {!! \HTML::style(asset('/css/output.css')) !!}
@endsection

@section('body')

    <div class="container">


        <h3>
            <div class="row">
                <div class="col-md-3">
                <span class="glyphicon glyphicon-user" aria-hidden="true"></span> {{ $student->last_name }},
                {{ $student->first_name }}
                </div>
                <div class="col-md-3">
                ID {{ $student->getStudentId() }}
                </div>
                <div class="col-md-6"></div>
            </div>
        </h3>
        <h4>{{ $exam->getTerm() }} {{ $exam->getYear() }} "{{ $exam->getName() }}"</h4>
        <hr>
        <!-- student feedback copypasta from feedback.blade -->
        <?php $h = '400px'; $w = '800px'; ?>
        <div>
            <div id="studentInfo">
                <ul>
                    <li>
                        <label for='grade' class="studentInfoLabel">Grade: </label>
                        <input type="text" readonly="readonly" id="grade" class="grade"
                               value="{{ $data['grade'] or ''}}"/>
                    </li>
                    <li>
                        <span class="studentInfoLabel">Entry Code:</span> <span class="pseudoID"> {{ $data->access_key }}</span>
                    </li>
                </ul>
            </div> <!--//close studentInfo-->

            <div id="overall">
                <p class="small">Here's how you did on each question in comparison to the class average. <br/>
                    The blue bar is you (on an arbitrary scale); the gold bar is the average
                </p>

                <div id="allQuestionsChart" style="height:{{$h}};width:{{$w}}; "></div>
            </div> <!--overall-->

            <div id="questionResultsHere">
                @foreach($data['content'] as $question)
                    @include('feedback.question')
                @endforeach
            </div>
            <div id="elementCharts"></div>
        </div>
    </div>
    @include('errors.list')

@endsection

@section('jsArea')
    <!-- copied from feedback.blade until we have a better idea of what the presentation should be -->
    <script type="text/javascript">
        var data = {!! ($data ? json_encode($data['content'], JSON_FORCE_OBJECT) : '') !!};
        //console.log(data);
    </script>

    <script language="javascript" type="text/javascript" src="{{ asset('inc/js/jqplot/jquery.jqplot.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('inc/js/jqplot/plugins/jqplot.json2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('inc/js/jqplot/plugins/jqplot.barRenderer.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('inc/js/jqplot/plugins/jqplot.categoryAxisRenderer.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('inc/js/jqplot/plugins/jqplot.pointLabels.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('inc/js/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('inc/js/jqplot/plugins/jqplot.canvasTextRenderer.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('inc/js/jqplot/plugins/jqplot.enhancedLegendRenderer.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('inc/js/outputScripts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('inc/js/chartScripts.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            var questionHolder = new QuestionHolder();
            questionHolder.loadScores(data);
            questionHolder.loadAverages(data);
            questionHolder.setAnsweredQuestions();
            var elementHolder = new ElementHolder();
            var elScores = consolidateElementScores(data);
            elementHolder.loadScores(data);
            //elementHolder.loadAverages(data);
            //divMaker(questionHolder);
            //Make charts
            makeOverallChart(questionHolder);
            makeElementCharts(elementHolder, questionHolder);

        });
    </script>

    <script type="text/javascript">
        // set 'Reports' tab as active
        $('[id^="nav"]').attr('class', '');
        $('#navReport').attr('class', 'active');
    </script>

@endsection


