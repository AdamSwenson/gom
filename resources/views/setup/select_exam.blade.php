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
        <!-- style exam names with year and term -->
<style type="text/css">
    .exam-name {
        display: inline-block;
        width: 110px;
    }
</style>

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
            <h2>Exam Setup</h2>

            <div class="row">
                <div class="col-md-12">
                    <div class="list-group">

                        <!-- create exam -->
                        <a id="createExamLink" href="{{url('exam/create')}}" class="list-group-item">
                            <h4><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create Exam</h4>
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
                                        <form method="GET" action="{{url('exam/'. $exam->getId() . '/edit')}}"
                                              accept-charset="UTF-8">
                                            <button type="submit"
                                                    class="list-group-item"><span class="exam-name">{{ $exam->getYear() }}
                                                    , {{ $exam->getTerm() }}
                                                     </span>| {{ $exam->getName() }}</button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- clone exam -->
                        <a id="cloneExamLink" class="list-group-item" data-toggle="collapse"
                           data-target="#examListClone" data-parent="#examAction" style="cursor:pointer;">
                            <h4><span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span> Clone Exam</h4>
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
                                                        class="list-group-item"><span class="exam-name">{{ $exam->getYear() }}
                                                        , {{ $exam->getTerm() }}
                                                     </span>| {{ $exam->getName() }}</button>
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
                                                        class="list-group-item"><span class="exam-name">{{ $exam->getYear() }}
                                                        , {{ $exam->getTerm() }}
                                                     </span>| {{ $exam->getName() }}</button>
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

        // set 'Setup' tab as active
        $('[id^="nav"]').attr('class', '');
        $('#navSetup').attr('class', 'active');

        $(document).ready(function () {
            return false;
        });
    </script>

@endsection


