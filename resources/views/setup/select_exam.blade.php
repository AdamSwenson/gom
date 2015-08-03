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
    <script>
        //these elements exist in the nav_bar_main.blade.php
        document.getElementById('setupHead').setAttribute('class',"active");
        document.getElementById('gradeHead').setAttribute('class',"");
        document.getElementById('reportHead').setAttribute('class',"");
        document.getElementById('accountHead').setAttribute('class',"");
    </script>
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

                <div class="row">
                    <div class="col-xs-12">
                        <div class="list-group">

                            <!-- create exam -->
                            <a id="createExamLink" href="{{url('exam/create')}}" class="list-group-item">
                                <h4><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Create Exam</h4>
                            </a>
                            <!-- edit exam -->
                            <a id="editExamLink" style="cursor:pointer;" class="list-group-item" data-toggle="collapse"
                               data-target="#examListEdit" data-parent="#examAction">
                                <h4><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit Exam </h4>
                            </a>

                            <div id="examListEdit" class="sublinks collapse">
                                <div class="container">
                                    @foreach($exams as $exam)
                                        <div class="row">
                                            <form method="GET" action="{{url('exam/'. $exam->getId() . '/edit')}}" accept-charset="UTF-8">
                                                <button type="submit"
                                                        class="list-group-item">{{ $exam->getName() }}</button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- clone exam -->
                            <a id="cloneExamLink" class="list-group-item" data-toggle="collapse"
                               data-target="#examListClone" data-parent="#examAction" style="cursor:pointer;">
                                <h4><span class="glyphicon glyphicon-copy" aria-hidden="true"></span> Clone Exam</h4>
                            </a>

                            <div id="examListClone" class="sublinks collapse">
                                <div class="container">
                                    @foreach($exams as $exam)
                                        <div class="row">
                                            <!-- pass in examId so it can be cloned -->
                                            <form method="GET" action="{{url('exam/'. $exam->getId() . '/edit')}}"
                                                  accept-charset="UTF-8">
                                                <div style="width:97%">
                                                    <button type="submit" name="cloneExamName"
                                                            class="list-group-item">{{ $exam->getName() }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- delete exam -->
                            <a id="deleteExamLink" class="list-group-item" data-toggle="collapse"
                               data-target="#examListDelete" data-parent="#examAction" style="cursor:pointer;">
                                <h4><span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Delete Exam</h4>
                            </a>
                            <!-- this div should be replaced by real exams or a "No exams found" error popup -->
                            <div id="examListDelete" class="sublinks collapse">
                                <div class="container">
                                    @foreach($exams as $exam)
                                        <div class="row">
                                            <form method="POST" action="{{url('exam/'. $exam->getId() )}}"
                                                  accept-charset="UTF-8">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                                <div style="width:97%">
                                                    <button type="submit" name="deleteExamName"
                                                            class="list-group-item">{{ $exam->getName() }}</button>
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
        </div>
    </div>
    @include('errors.list')

@endsection


@section('jsArea')
    <script type="text/javascript">
        $(document).ready(function () {
            return false;
        });
    </script>


@endsection


