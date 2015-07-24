<!--
/**
* Created by PhpStorm.
* User: Brian
* Date: 7/20/2015
* Time: 12:37 AM
*/
-->


<div class="input-group">
    <span class="input-group-addon" id="basic-addon1">Exam Name</span>
    <input type="text" class="form-control input-lg" name="examName" default="" value="{{ isset($exam['examName']) ?
            $exam['examName'] : '' }}"
           placeholder="Enter a descriptive name for this test (i.e. English 101 Exam #1)"
           aria-describedby="basic-addon1">
</div>
<p></p>
<div class="btn-group btn-group">
    <a class="btn btn-primary dropdown-toggle" id="term" name="term" data-toggle="dropdown">{{ isset($exam['examTerm']) ?
            $exam['examTerm'].' ' : 'Term' }}<span class="glyphicon glyphicon-menu-down"></span></a>
    <ul class="dropdown-menu" id="termList" role="menu">
        <li>
            <a >Winter</a>
        </li>
        <li>
            <a >Spring</a>
        </li>
        <li>
            <a >Summer</a>
        </li>
        <li>
            <a >Fall</a>
        </li>
    </ul>
</div>
<div class="btn-group btn-group">
    <a class="btn btn-primary dropdown-toggle" id="year" name="year" data-toggle="dropdown">{{ isset($exam['examTerm']) ?
            $exam['examYear'].' ' : 'Year' }}<span class="glyphicon glyphicon-menu-down"></span></a>
    <ul class="dropdown-menu" id="yearList" role="menu">
        <li>
            <a >2015</a>
        </li>
        <li>
            <a >2016</a>
        </li>
    </ul>
</div>
