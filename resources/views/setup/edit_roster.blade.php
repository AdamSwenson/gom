@extends('layouts.master')

@section('pageTitle', 'Edit Roster')
@section('description', 'Upload or modify student roster')

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
                            <a href="#" onclick="document.getElementById('formFileData').submit();"><span
                                        class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Save & Finish</a>
                        </li>
                        <li class="previous">
                            <a href="{{url('exam/'. $exam->getId() . '/edit')}}"><span
                                        class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Edit Exam</a>
                        </li>
                    </ul>
                </nav>

                <h2>Import Roster</h2>

                <p>Student rosters should be a csv file with each student's information on a single row in the following format:
                    Last Name, First Name, Student ID, Email</p>

                <form enctype="multipart/form-data" method="post"
                      action='{{url('exam/'. $exam->getId() . '/student/store')}}' role="form">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <div id="fileSelection" class="formArea">
                            {{--<button class="btn btn-primary" name="studentsFile" id="studentsFile"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>--}}
                            {{--Select File--}}
                            {{--</button>--}}

                            <label for="studentsFile">Select file to upload</label><br/>
                            <input type="file" name="studentsFile" id="studentsFile" size="150">
                        </div>
                        <div id="buttonArea" class="formArea">
                            <button type="submit" class="btn btn-success" name="Import" value="Import">Upload</button>
                        </div>
                    </div>

                </form>
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

                <div>

                </div>

                <h2>Edit Roster</h2>

                <div class="container">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th class="col-md-3">Last Name</th>
                            <th class="col-md-3">First Name</th>
                            <th class="col-md-2">Student ID</th>
                            <th class="col-md-3">Email</th>
                            <th class="col-md-1"></th>
                        </tr>
                        </thead>
                        <!-- temp data to give a sense of a short roster -->
                        <tbody id="roster">
                        @if(isset($students) && (count($students) > 0))
                            @foreach($students as $s)
                                <tr class="dataRow" id="{{ $s['id'] }}">
                                    <td><input class="form-control" type="text" name="lname" value="{{ $s['last_name'] }}"
                                               style="border:none;">
                                    </td>
                                    <td><input class="form-control" type="text" name="fname" value="{{ $s['first_name'] }}"
                                                style="border:none;">
                                    </td>
                                    <td><input class="form-control" type="text" name="sIdentifier" value="{{ $s['student_identifier'] }}"
                                               style="border:none;">
                                    </td>
                                    <td><input class="form-control" type="text" name="email" value="{{ $s['email'] }}"
                                               style="border:none;">
                                    </td>
                                    <td align="center" style="vertical-align: middle;"> <a id="deleteButton">
                                            <span class="glyphicon glyphicon-remove-sign" aria-hidden="true" ></span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                        @endif
                        </tbody>
                    </table>
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

    @include('errors.list')

@endsection


@section('jsArea')

    <script language="javascript" type="text/javascript" src="{{ asset('inc/js/rosterTable.js') }}"></script>
    <script type="text/javascript">

    </script>
@endsection


