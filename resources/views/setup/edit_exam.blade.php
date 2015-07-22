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

    <form method="GET" action="{{url('exam/' .$examid.'/question/edit')}}" accept-charset="UTF-8" class="col-xs-8">
    <nav>
     <ul class="pager">
      <li class="next">
       <button type="submit" value="{{$examid}}"> Next
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      </li>
     </ul>
    </nav>
    <h2>Edit Exam</h2>

    @include('setup.exam_form')
    </form>

   </div>
  </div>
 </div>

 @include('errors.list')

@endsection


@section('jsArea')


@endsection


