@if(!empty($question['score'] && !empty($question['elements'])))
    <div id='q{{ $question['questionNumber'] }}' class="questionFeedbackArea">
        <div class="row">
            <div class="col-sm-12">
                <h2 class='mainHeading'>Q{{ $question['questionNumber'] }}: {{ $question['questionName'] }}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-1"></div>
            <div id='q{{ $question['questionNumber'] }}Comments' class="col-sm-5 commentsArea">
                @foreach($question['elements'] as $element)
                    @include('feedback.comment')
                @endforeach
            </div>
            <div class="col-sm-6 questionChartContainer">
                <div class="elementChartDiv" id="s{{$data->getAccessKey()}}_q{{$question['questionNumber']}}"></div>
            </div>
        </div>
    </div>
@endif