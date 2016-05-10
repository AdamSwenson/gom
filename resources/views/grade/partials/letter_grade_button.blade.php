<?php
$letterGrades = App\Repositories\Grade\GradeFactory::$grades;
?>

<!-- Single button -->
<div id="letterGradeArea"
     class="btn-group">
    <button id="letterGradeButton{{$qNumber}}"
            type="button"
            class="btn btn-default dropdown-toggle"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false">
        <span id="letterGradeForQuestion{{ $qNumber }}">Letter grade</span> <span class="caret"></span>
    </button>

    <ul id="letterGradeList"
        class="dropdown-menu">
        @foreach($letterGrades as $g)
        <li><a class="letterGradeButton"
               data-letter-grade-button-id="letterGradeForQuestion{{ $qNumber }}"
               data-target-id="questionScore{{ $qNumber }}"
               data-display-value="{{ $g['display_value'] }}"
               data-calc-value="{{ $g['calc_value'] }}"
               href="#">{{ $g['display_value'] }}</a>
        </li>
        @endforeach
    </ul>

</div>
