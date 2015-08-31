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
    <input type="text" class="form-control input-lg" name="name" default="" value="{{ isset($exam) ?
            $exam->getName() : '' }}"
           placeholder="Enter a descriptive name for this test (i.e. English 101 Exam #1)"
           aria-describedby="basic-addon1">
</div>
<p></p>
<input name="examTerm" type="hidden" id="hiddenTerm" value="{{ isset($exam) ? $exam->getTerm() : '' }}"/>
<div class="btn-group btn-group">
    <button class="btn btn-primary dropdown-toggle" id="term" title="Choose Exam Term"
            data-toggle="dropdown">{{ isset($exam) ? $exam->getTerm() : 'Term' }} <span class="glyphicon glyphicon-menu-down"></span></button>
    <ul class="dropdown-menu" id="termList" role="menu" style="cursor:pointer;">
        <li><a>Winter</a></li>
        <li><a>Spring</a></li>
        <li><a>Summer</a></li>
        <li><a>Fall</a></li>
    </ul>
</div>
<input name="examYear" type="hidden" id="hiddenYear" value="{{ isset($exam) ? $exam->getYear() : '' }}"/>
<div class="btn-group btn-group">
    <button class="btn btn-primary dropdown-toggle" id="year" title="Choose Exam Year"
            data-toggle="dropdown">{{ isset($exam) ? $exam->getYear() : 'Year' }}
        <span class="glyphicon glyphicon-menu-down"></span></button>
    <ul class="dropdown-menu" id="yearList" role="menu" style="cursor:pointer;">
        <li><a>2015</a></li>
        <li><a>2016</a></li>
    </ul>
</div>
<p>
<?php isset($exam) ? $examId = $exam->getId() : $examId = 0; ?>
<div style="display: {{ isset($exam) ? 'visible' : 'none' }}" >
    <a href="{{ url('exam/'.$examId.'/student/edit') }}" class="btn btn-info" title="Edit Student Roster"
       style="cursor:pointer;"><span
                class="glyphicon glyphicon-tasks"
                aria-hidden="true"></span>
        Edit Student Roster</a>
</div>
</p>
