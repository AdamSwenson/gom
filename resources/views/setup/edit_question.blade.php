<!--
/**
 * Created by PhpStorm.
 * User: Brian
 * Date: 7/17/2015
 * Time: 4:59 PM
 */

    Handles editing, adding, importing, deleting and reordering questions

 -->

@extends('layouts.master')

@section('pageTitle', 'Empty')

@section('cssLinks')

@endsection

@section('body')

 <div id="editQuestion">
  <div class="section">
   <div class="container">
    <nav>
     <ul class="pager">
      <li class="next">
       <a href="#">Done <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a>
      </li>
     </ul>
    </nav>
    <h2 id="examName">Exam Name: Add / Edit Questions</h2>
    <h5>Add the questions that will appear on this exam. Press "done" when you're finished.</h5>
    <!-- this Div will become the question template -->
    <div id="questionPane">
     <h4>Question #1</h4>
     <div class="input-group">
      <span class="input-group-addon" id="questionLabel">Question Name</span>
      <input id="questionName" type="text" class="form-control input-lg" placeholder="Enter a brief description of the question, i.e. &quot;Causes of the Civil War&quot;"
             aria-describedby="basic-addon1">
     </div>
     <h5>Question Text</h5>
     <div class="form-group">
      <textarea class="form-control" rows="4" id="questionText" placeholder="Enter the full question text(optional)"></textarea>
     </div>
    </div>
    <p></p>
    <button class="btn btn-default" id="moveUp"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>
    </button>
    <button class="btn btn-default" id="moveDown"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>
    </button>
    <button class="btn btn-warning" id="deleteQuestion"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
     Delete</button>
    <br>
    <button class="btn btn-primary" id="addQuestion"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
     Add Question</button>
    <button class="btn btn-primary" id="importQuestion"><span class="glyphicon glyphicon-import" aria-hidden="true"></span>
     Import Question</button>
   </div>
  </div>
 </div>
@endsection


@section('jsArea')


@endsection


