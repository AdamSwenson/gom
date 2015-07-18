<!--
/**
 * Created by PhpStorm.
 * User: Brian
 * Date: 7/17/2015
 * Time: 4:59 PM
 */

 
 -->

@extends('layouts.master')

@section('pageTitle', 'Empty')

@section('cssLinks')

@endsection

@section('body')
 <div id="selectExam">
  <div class="section">
   <div class="container">
    <nav>
     <ul class="pager" style="visibility:hidden" >
      <li class="next" >
       <a href="#">Next <span aria-hidden="true">?</span></a>
      </li>
     </ul>
    </nav>
    <p></p>
    <h2>Exam Setup</h2>
    <p></p>
    <div class="list-group">
     <a id="createExamLink" href="#" class="list-group-item">
      <h4><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create New Exam</h4>
     </a>
     <a id="editExamLink" href="#" class="list-group-item" data-toggle="collapse" data-target="#examListEdit" data-parent="#examAction">
      <h4><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit Existing Exam </h4></a>
     <!-- this div should be replaced by real exams or a "No exams found" error popup -->
     <div id="examListEdit" class="sublinks collapse">

      <div class="container">
       <a class="list-group-item small"> English 101 Exam #1 (Fall 2014)</a>
       <a class="list-group-item small"> English 101 Exam #2 (Fall 2014)</a>
      </div>
     </div>

     <a id="cloneExamLink" href="#" class="list-group-item" data-toggle="collapse" data-target="#examListClone" data-parent="#examAction">
      <h4><span class="glyphicon glyphicon-copy" aria-hidden="true"></span> Clone Exam</h4></a>
     <!-- this div should be replaced by real exams or a "No exams found" error popup -->
     <div id="examListClone" class="sublinks collapse">
      <div class="container">
       <a class="list-group-item small"> English 101 Exam #1 (Fall 2014)</a>
       <a class="list-group-item small"> English 101 Exam #2 (Fall 2014)</a>
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>
@endsection


@section('jsArea')


@endsection


