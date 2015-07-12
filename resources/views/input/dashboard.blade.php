
<script id="completedTemp" type="text/x-jQuery-tmpl">
    <p>Graded: ${examsGraded}  ||  Remaining: ${examsUngraded}</p>
</script>
<script id="statsTemp" type="text/x-jQuery-tmpl">
    <table class="statsTable">
    <tr>
    <th></th>
    <th>Grading <br/>Hours</th>
    <th>Working <br/>Hours</th>
    </tr>
    <tr>
    <th>Elapsed</th>
    <td>${gradeElapsed}</td>
    <td>${workElapsed}</td>
    </tr>
    <tr>
    <th>Remaining</th>
    <td>${gradeRemaining}</td>
    <td>${workRemaining}</td>
    </tr>
    <tr>
    <td></td>
    </tr>
    <tr style="border-top:solid;">
    <th>Average Exam</th>
    <td>${avgExam}</td>
    <th>Average PPM </th>
    <td>${avgPPM}</td>
    </tr>
    <tr style="border-top:solid;">
    <th>Grading efficiency</th>
    <td>${pctGrading} % </td>
    </tr>
    </table>
</script>



<div id="dashboard">

    <div id="groupTimer" class="sideDiv">
        <p id="curGroupStatus" class="sidehead blank">current group</p>
        <p>
            <label for="groupNumber">Group#</label>
            <input type="tel" id="groupNumber" class="dashboard" style="width:3em;"/>
            <label for="groupTime">Time </label>
            <input type="text" readonly="readonly" id="currentGroupGaugeBox" class="dashboard noboard" style="width:10em;" />
            <!--<input type="text" id="groupTime" class="dashboard nobord"  /> seconds-->
        </p>
        <div id="groupTimeControls">
            <p>
                <input type="button" name="startGroup"  value="Start" id="startGroup" class="prettyButton dashboard timeControl"/>
                <input type="button" name="stopGroup" value="Stop" id="stopGroup" class="prettyButton dashboard timeControl"/>
            </p>
        </div> <!--close group time controls-->
    </div> <!--close groupTimer-->

    <div id="examTimer" class="sideDiv">
        <p id="curExStatus" class="sidehead blank">current exam</p>
        <!--<div id="cur" class="gauge"></div>-->
        <div id="examTimeControls">
            <p>
                <input type="button" name="startExam"  value="Start" id="startExam" class="prettyButton timeControl dashboard" />
                <input type="button" name="stopExam" value="Stop" id="stopExam" class="prettyButton timeControl dashboard" />
                <input type="text" readonly="readonly" id="currentTimeGaugeBox" class="dashboard noboard" style="width:100px;"/>
            </p>
        </div><!--examtime controls-->
    </div> <!--close examTimer div-->

    <div id="gauges" class="sideDiv">
        <div id="pctcomp" class="gauge">
            <!--<label for="pctCompleteHere">Percent Complete</label>-->
            <!--<div id="pctCompleteHere"></div>-->
            <div id="pctCompleteHere" style="height:125;width:200;"> </div>
            <div id="completedHere"></div>
            <!--<div id="speedGauge"></div>-->
        </div>
    </div> <!--div gauges-->
    <p></p>
    <div id="curgauges" class="sideDiv">
        <div id="currentTimeGauge" style="height:125;width:200;float: left;"></div>
        <div id="currentGroupGauge" style="height:125;width:200;float: left;"></div>
    </div>
    <p></p>

    <p></p>
    <div id="statisticsHere" class="sideDiv"></div>
    <div id="speedChart" class="sideDiv"></div>
</div> <!--close dashboard div-->