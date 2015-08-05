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
    </script>
    <div id="editRoster">
        <div class="section">
            <div class="container">
                <nav>
                    <ul class="pager">
                        <li class="previous">
                            <a href="{{url('report')}}"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>Exam List</a>
                        </li>
                    </ul>
                </nav>


                <a style="width: 82%;" id="editExamLink" class="list-group-item">
                    <h4><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>Students</h4>
                </a>

                <div id="examListEdit" class="sublinks">
                    <div class="container">
                        @foreach($students as $student)
                            <div class="row" >
                                <div style="width: 80%;">
                                <!--<form method="GET" action="{url('exam/'. $exam->getId() . '/edit')}}" accept-charset="UTF-8">
                                    <button type="submit" class="list-group-item">{ $exam->getName() }}</button>
                               <!-- </form> -->
                                    <div class="well well-sm">
                                        <div class="row" >
                                        <div  class="col-sm-4">

                                        </div>
                                        <div  class="col-sm-6">
                                          <p> <span style="font-weight:bold;">STUDENT ID:</span>{{ $student->getStudentId() }} </p>
                                            <p><span style="font-weight:bold;">Name:</span> {{ $student->getStudentFName() }}
                                            {{ $student->getStudentLName() }} </p>
                                        </div>

                                        <div  class="col-sm-2">

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


