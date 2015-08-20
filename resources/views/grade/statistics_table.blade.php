<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/14/15
 * Time: 5:37 PM
 */
//Integrate values from $stats
?>

<div id="statsArea">
    <h4><span class="glyphicon glyphicon-time"></span> Statistics</h4>

    <div class="panel panel-default">
        <div class="panel-body">
            <statistics-table current-exam="0"
                              average-exam="{{ $stats[0]->averageExamTime }}"
                              total-elapsed="{{ $stats[0]->gradeTimeElapsed }}"
                              total-remaining="{{ $stats[0]->gradeTimeRemaining }}"></statistics-table>
            {{--<span class="col-md-6">Time This Exam</span>--}}
            {{--<span class="col-md-6">00:35</span>--}}

            {{--<span class="col-md-6">Average Time</span>--}}
            {{--<span class="col-md-6">02:25</span>--}}

            {{--<span class="col-md-6">Total Time</span>--}}
            {{--<span class="col-md-6">00:45:55</span>--}}

            {{--<span class="col-md-6">Time Remaining</span>--}}
            {{--<span class="col-md-6">01:34:15</span>--}}
        </div>
    </div>
</div>
