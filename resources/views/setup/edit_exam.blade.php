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
@section('description', 'Edit an exam')

@section('cssLinks')

@endsection

@section('body')

 <div id="editExam">
  <div class="section">
   <div class="container">
    <nav>
     <ul class="pager">
      <li class="next">
       <a href="#">Next <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a>
      </li>
     </ul>
    </nav>
    <h2>Create Exam</h2>
    <div class="input-group">
     <span class="input-group-addon" id="basic-addon1">Exam Name</span>
     <input type="text" class="form-control input-lg" placeholder="Enter a descriptive name for this test (i.e. English 101 Exam #1)"
            aria-describedby="basic-addon1">
    </div>
    <p></p>
    <div class="btn-group btn-group">
     <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Term <span class="glyphicon glyphicon-menu-down"></span></a>
     <ul class="dropdown-menu" role="menu">
      <li>
       <a href="#">Winter</a>
      </li>
      <li>
       <a href="#">Spring</a>
      </li>
      <li>
       <a href="#">Summer</a>
      </li>
      <li>
       <a href="#">Fall</a>
      </li>
     </ul>
    </div>
    <div class="btn-group btn-group">
     <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Year <span class="glyphicon glyphicon-menu-down"></span></a>
     <ul class="dropdown-menu" role="menu">
      <li>
       <a href="#">2015</a>
      </li>
      <li>
       <a href="#">2016</a>
      </li>
     </ul>
    </div>
   </div>
  </div>
 </div>

 @include('errors.list')

@endsection


@section('jsArea')


@endsection


