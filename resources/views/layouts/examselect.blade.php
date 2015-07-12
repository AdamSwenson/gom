<div class="examselector">
    <p>Current Exam: <br>
        <span class="currentExamString">{{$currentExamString or ''}}</span>
        <input type="hidden" readonly="readonly" value="{{$currentExamId or ''}}" id="currentExamID" name="examID"> <br>
        <select class="examSelect" id="examTarget">
            <option> Change exam</option>
            @if(isset($examOptions) && count($examOptions) > 0)
            @foreach($examOptions as $e)
                <option id="{{$e['optionId']}}" value="{{$e['optionValue']}}">{{$e['optionText']}}</option>
            @endforeach
                @endif
        </select>
        <input type="hidden" value="" id="examStatus">
    </p>
</div>