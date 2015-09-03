@extends('layouts.master')

@section('pageTitle', 'Edit Roster')
@section('description', 'Upload and modify student roster')

@section('cssLinks')

@endsection

@section('body')
    <div id="editRoster">
        <div class="section">
            <div class="container">
                {{--<form id="formFileData" method="GET" action="{{url('exam/'. $exam->getId() . '/student/store')}}" accept-charset="UTF-8" enctype="multipart/form-data">--}}
                {{--<form id="formFileData" method="GET" action="{{url('exam/'. $exam->getId() . '/student/update')}}" accept-charset="UTF-8">--}}
                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                {{--<input type="text"  hidden id="filedata" name="filedata"><br>--}}
                {{--</form>--}}

                <nav>
                    <ul class="pager">
                        <li class="next">
                            <a href="" onclick="document.getElementById('rosterData').submit();"><span
                                        class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Save & Finish</a>
                        </li>
                        <li class="previous">
                            <a href=""><span
                                        class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Edit
                                Exam</a>
                        </li>
                    </ul>
                </nav>
                <!-- File Import -->
                <h2>Import Roster</h2>

                <p>Student rosters should be a csv file with each student's information on a single row in the following
                    format:
                    Last Name, First Name, Student ID, Email</p>
                <form>
                    <input type="file" id="fileInput" name="file" accept=".csv, text/plain" onchange="startRead()">
                </form>

{{--
                <form enctype="multipart/form-data" method="post"
                      action='{{url('exam/'. $exam->getId() . '/student/store')}}' role="form">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <div id="fileSelection" class="formArea"> --}}
                            {{--<button class="btn btn-primary" name="studentsFile" id="studentsFile"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>--}}
                            {{--Select File--}}
                            {{--</button>--}}

                          <!--  <label for="studentsFile">Select file to upload</label><br/>
                            <input type="file" name="studentsFile" id="studentsFile" size="150">
                        </div>
                        <div id="buttonArea" class="formArea">
                            <button type="submit" class="btn btn-success" name="Import" value="Import">Upload</button>
                        </div>
                    </div>

                </form> -->
                {{--<form id="formFileData" method="POST" action="{{url('exam/'. $exam->getId() . '/student/store')}}" accept-charset="UTF-8" enctype="multipart/form-data">--}}
                {{--<form id="formFileData" method="GET" action="{{url('exam/'. $exam->getId() . '/student/update')}}" accept-charset="UTF-8">--}}
                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                {{--<input type="text"  hidden id="filedata" name="filedata"><br>--}}

                {{--<input type="file" name="file" style="visibility:hidden;" id="file"  /><br/>--}}
                {{--<input type="file" name="file" style="visibility:hidden;" id="file" onchange='handleFileSelect();' /><br/>--}}

                {{--<button class="btn btn-primary"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>--}}
                {{--Select File--}}
                {{--</button>--}}

                {{--<button class="btn btn-primary" onclick="$('#file').click();"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>--}}
                {{--Select File--}}
                {{--</button>--}}

                {{--<label>File Name:</label><input name="fileName" id="fileName" type="text" disabled value="">--}}
                {{--<input class="btn btn-default" value="Upload" type="submit">--}}
                {{--</form>--}}

                <h2>Edit Roster</h2>

                <div class="container">
                    <form id="rosterData" method="post" role="form" action="{{ url('exam/'.$exam->getId().'/student/updateAll') }}">
                        {!! csrf_field() !!}
                        <table class="table table-striped">
                            <thead>
                            <!-- table headers -->
                            <tr>
                                <th class="col-md-3" style="cursor: pointer;" onclick="sortRosterBy('lastName')">Last Name</th>
                                <th class="col-md-3" style="cursor: pointer;" onclick="sortRosterBy('firstName')">First Name</th>
                                <th class="col-md-2" style="cursor: pointer;" onclick="sortRosterBy('studentIdentifier')">Student ID</th>
                                <th class="col-md-3" style="cursor: pointer;" onclick="sortRosterBy('email')">Email</th>
                                <th class="col-md-1"></th>
                            </tr>
                            </thead>
                            <!-- Student roster -->
                            <tbody id="studentRosterBody">
                            @if(isset($students) && (count($students) > 0))
                                <?php $row = 1; ?>
                                @foreach($students as $s)
                                    @include('setup.roster_form')
                                    <?php $row++ ?>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </form>
                </div>
                <a class="btn btn-primary" onclick="addStudent()" id="deleteRoster"><span
                            class="glyphicon glyphicon-plus"
                            aria-hidden="true"></span>
                    Add Student
                </a>
                <a class="btn btn-danger" onclick="deleteRoster()" id="deleteRoster"><span
                            class="glyphicon glyphicon-minus"
                            aria-hidden="true"></span>
                    Delete Roster
                </a>
            </div>
        </div>
    </div>
    <div style="display: none">
        <?php $s = null; $row = 0; ?>
        @include('setup.roster_form')
    </div>

    @include('errors.list')

@endsection


@section('jsArea')

    <script language="javascript" type="text/javascript" src="{{ asset('inc/js/rosterTable.js') }}"></script>
    <script type="text/javascript">

        /*
        THINGS TODO:
            1-Add import button / feature
            2-parse file
            2a-add lines to table
            4-allow column swapping (?)
            5-upload form to server
            6-process data in controller
         */

       $(document).ready(function () {
            return false;
        });
    </script>
@endsection


