<!-- Used by 'grade_exam'. Displays the exam timers -->
<h4 class="row">
    <span class="col-xs-7" style="vertical-align:middle">
        <span class="glyphicon glyphicon-time" aria-hidden="true" ></span>
        Statistics
    </span>
    <span class="col-xs-5">
        <a
                class="btn btn-warning"
                id="btnTimer"
                title="Toggle timer"
                {{--href="javascript:toggleTimer()">--}}
        >
            <span id="btnTimerIcon" class="glyphicon glyphicon-pause" aria-hidden="true"></span>
            <span id="btnTimerLabel">Paused</span>
        </a>
    </span>
</h4>

<div class="panel panel-default">

    <div class="panel-body">
        <span class="col-xs-6">Time This Exam</span>
        <span class="col-xs-6" id="thisExamTime">00:00</span>

        <span class="col-xs-6">Average Time</span>
        <span class="col-xs-6" id="avgTime">00:00</span>

        <span class="col-xs-6">Total Time</span>
        <span class="col-xs-6" id="totalTime">00:00:00</span>

        <span class="col-xs-6">Time Remaining</span>
        <span class="col-xs-6" id="timeRemaining">00:00:00</span>
    </div>
</div>
