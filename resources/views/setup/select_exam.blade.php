<!--
/**
* Created by PhpStorm.
* User: Brian
* Date: 7/17/2015
* Time: 4:59 PM
*/


-->

@extends('layouts.master')

@section('pageTitle', 'Select Exam')

@section('description', 'edit, create or clone an exam')

@section('cssLinks')

@endsection

@section('body')
    <div id="selectExam">
        <div class="section">
            <div class="container">
                <nav>
                    <ul class="pager" style="visibility:hidden">
                        <li class="next">
                            <a href="#">Next <span aria-hidden="true">?</span></a>
                        </li>
                    </ul>
                </nav>
                <p></p>
                <h2>Exam Setup</h2>
                <p></p>
                <div class="list-group">
                    <a id="createExamLink" href="{{url('exam/create')}}" class="list-group-item"  >
                        <h4><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create Exam</h4>
                    </a>
                    <a id="editExamLink" href="#" class="list-group-item" data-toggle="collapse"
                       data-target="#examListEdit" data-parent="#examAction">
                        <h4><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit Exam </h4></a>
                    <!-- this div should be replaced by real exams or a "No exams found" error popup -->
                    <div id="examListEdit" class="sublinks collapse">

                        <div class="container">
                            <!-- add the data from exams here -->

                            @foreach($exams as $exam)
                                <div class="row">
                                    <form method="GET" action="{{url('exam/'. $exam['examId'] . '/edit')}}" accept-charset="UTF-8"
                                          class="col-xs-4">
                                        <div class="row">
                                            <button type="submit"
                                                    class="list-group-item small">{{ $exam['examName'] }}</button>
                                        </div>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <a id="cloneExamLink" href="#" class="list-group-item" data-toggle="collapse"
                       data-target="#examListClone" data-parent="#examAction">
                        <h4><span class="glyphicon glyphicon-copy" aria-hidden="true"></span> Clone Exam</h4></a>
                    <!-- this div should be replaced by real exams or a "No exams found" error popup -->
                    <div id="examListClone" class="sublinks collapse">
                        <div class="container">
                            @foreach($exams as $exam)
                                <div class="row">
                                    <!-- pass in examId so it can be cloned -->
                                    <form method="GET" action="{{url('exam/'. $exam['examId'] . '/edit')}}" accept-charset="UTF-8"
                                          class="col-xs-4">
                                        <div class="col-lg-12">
                                            <button type="submit" name="cloneExamName"
                                                    class="list-group-item small">{{ $exam['examName'] }}</button>
                                        </div>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <a id="deleteExamLink" href="#" class="list-group-item" data-toggle="collapse"
                       data-target="#examListDelete" data-parent="#examAction">
                        <h4><span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Delete Exam</h4></a>
                    <!-- this div should be replaced by real exams or a "No exams found" error popup -->
                    <div id="examListDelete" class="sublinks collapse">
                        <div class="container">
                            @foreach($exams as $exam)
                                <div class="row">
                                    <form method="POST" action="{{url('exam/'. $exam['examId'] )}}" accept-charset="UTF-8"
                                          class="col-xs-4">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="col-lg-22">
                                            <button type="submit" name="deleteExamName"
                                                    class="list-group-item small">{{ $exam['examName'] }}</button>
                                        </div>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('errors.list')

@endsection


@section('jsArea')


@endsection


