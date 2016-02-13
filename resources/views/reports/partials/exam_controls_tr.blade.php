<tr>
    <!-- width will override the column width setting for term info -->
    <td style="vertical-align:middle; width: 10%;">
        {{ $exam->term or '' }}
        {{ $exam->year or '' }}
    </td>
    <td style="vertical-align:middle; min-width: 200px;">
        {{ $exam->name or 'Name Not Found'}}
    </td>
    <!-- control buttons -- do not show if no exams -->
    <td style="text-align:right; min-width: 340px;">
        <a class="btn btn-primary confirmRelease"
           id="{{'exam'.$examId }}"
           style="width:140px;"
           title="Release Exam"
           data-released="{{ $examId }}"
           data-examid="{{ $examId }}"
        >
            <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
            Release Exam
        </a>
        <a class="btn btn-default disabled examLock"
           id="lock"
           title="Remove Access"
           data-examid="{{ $examId }}">
            <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
        </a>
        <a class="btn btn-info"
           title="Exam Analytics"
           href="{{url('report/' . $exam->id. '/analytics')}}"><span
                    class="glyphicon glyphicon-stats"
                    aria-hidden="true"></span> </a>
        <a class="btn btn-default" href="{{ url('backup/'.$exam->getId()) }}"
           title="Export Scores to Csv">
            <span class="glyphicon glyphicon glyphicon-save" aria-hidden="true"></span>
        </a>
        <a class="btn btn-info" title="Student Controls"
           href="{{url('report/' . $examId. '/students')}}"><span
                    class="glyphicon glyphicon-user" aria-hidden="true"></span> </a>
    </td>
</tr>