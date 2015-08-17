@extends('layouts.master')

@section('pageTitle', 'Edit Roster')
@section('description', 'Upload or modify student roster')

@section('cssLinks')
@endsection

@section('body')
    <script>
        //these elements exist in the nav_bar_main.blade.php
        document.getElementById('setupHead').setAttribute('class',"");
        document.getElementById('gradeHead').setAttribute('class',"");
        document.getElementById('reportHead').setAttribute('class',"active");
        document.getElementById('accountHead').setAttribute('class',"");

       function  Release(id){
           document.getElementById( "lockExam" + id ).className = "btn btn-danger";
           document.getElementById("releaseExam" + id).className = "btn btn-success disabled";
           document.getElementById("examState" + id).innerHTML = "(Released)";

        }
        function Lock(id){
            document.getElementById( "lockExam" + id ).className = "btn btn-danger disabled";
            document.getElementById("releaseExam" + id).className = "btn btn-success";
            document.getElementById("examState" + id).innerHTML = "(Locked)";

        }

    </script>
    <div id="editRoster">
        <div class="section">
            <div class="container">
                <nav>
                    <ul class="pager">
                        <li class="previous">
                            <a href="{{url('setup')}}"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>Exam Setup</a>
                        </li>
                    </ul>
                </nav>


                <a style="width: 82%;" id="editExamLink" class="list-group-item">
                    <h4><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>Exams</h4>
                </a>

                <div id="examListEdit" class="sublinks">
                    <div class="container">
                        @foreach($exams as $exam)
                            <div class="row" >
                                <div style="width: 80%;">
                                <!--<form method="GET" action="{url('exam/'. $exam->getId() . '/edit')}}" accept-charset="UTF-8">
                                    <button type="submit" class="list-group-item">{ $exam->getName() }}</button>
                               <!-- </form> -->
                                    <div class="well well-sm">
                                        <div class="row" >
                                        <div  class="col-sm-2">
                                            <a class="btn btn-primary" href="{{url('report/' . $exam->getId() . '/analytics')}}" ><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
                                            <a class="btn btn-default" href="{{url('report/' . $exam->getId() . '/students')}}" ><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></a>
                                        </div>
                                        <div  class="col-sm-8">
                                            {{ $exam->getName() }}
                                            {{ $exam->getTerm() }}
                                            {{ $exam->getYear() }}
                                            <span id="{{'examState' . $exam->getId()}}">(Locked)</span>
                                        </div>

                                        <div  class="col-sm-2">
                                            <a id="{{'lockExam' . $exam->getId()}}" class="btn btn-danger disabled" onclick="Lock({{$exam->getId()}})"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></a>
                                            <a id="{{'releaseExam' . $exam->getId()}}" class="btn btn-success" onclick="Release({{$exam->getId()}})" ><span class="glyphicon glyphicon-send" aria-hidden="true"></span></a>
                                        </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


            </div>
        </div>
    </div>

    @include('errors.list')

@endsection


@section('jsArea')


@endsection


