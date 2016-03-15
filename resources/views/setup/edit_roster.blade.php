<!-- Edit_roster manages student creation, editing and file imports -->
@extends('layouts.master')

@section('pageTitle', 'Edit Roster | gradeomatic')
@section('description', 'Upload and modify student roster')

@section('otherCss')
        <!-- styling to change file button into bootstrap style and hide the file name -->
<link rel="stylesheet" href="{{ asset('css/edit-roster-package.css') }}">

@endsection

@section('body')
    <nav>
        <ul class="pager">
            <li class="next">
                <a id="backNavButton" style="cursor:pointer;"><span
                            class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Save & Finish</a>
            </li>
            <li class="previous">
                <a id="forwardNavButton" style="cursor:pointer;"><span
                            class="glyphicon glyphicon-chevron-left"
                            aria-hidden="true"></span> {{ $prevActionLabel }}</a>
            </li>
        </ul>
    </nav>

    <h2>Import Roster</h2>

    <p>Roster files can be any CSV file having each student's information on a single row in the following
        format: Last Name, First Name, Student ID (optional), Email (optional)</p>

    <!-- file import button -->
    <span class="btn btn-primary btn-file">
                <input type="file" id="fileInput" name="file" accept=".csv, text/plain"/>
                <span class="glyphicon glyphicon-upload" aria-hidden="true"></span>
                Import Roster
            </span>
    <!-- import help -->
    <a id="importHelpButton" class="btn btn-info">
        <span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>
        Import Help
    </a>

    <h2>Edit Roster</h2>

    <form id="rosterData" method="post" role="form"
          action="{{ url('exam/'.$exam->getId().'/student/updateAll') }}">
        {!! csrf_field() !!}
        <table class="table">
            <thead>
            <!-- table headers -->
            <tr>
                <th id="sortByLastName"
                    class="col-md-3"
                    style="cursor: pointer;"
                    >Last Name
                </th>
                <th id="sortByFirstName"
                    class="col-md-3"
                    style="cursor: pointer;"
                    >First Name
                </th>
                <th id="sortByStudentIdentifier"
                    class="col-md-2"
                    style="cursor: pointer;"
                    >Student ID
                </th>
                <th id="sortByEmail"
                    class="col-md-3"
                    style="cursor: pointer;"
                    >
                    Email
                </th>
                <th class="col-md-1"></th>
            </tr>
            </thead>
            <!-- Student roster -->
            <tbody id="studentRosterBody">
            @if(isset($students) && (count($students) > 0))
                <?php $row = 1; ?>
                @foreach($students as $s)
                    @include('setup.partials.roster_form')
                    <?php $row++ ?>
                @endforeach
            @endif
            </tbody>
        </table>
        <input type="hidden" name="navigateTo" value="selectExam"/>
    </form>

    <!-- add student button -->
    <a class="btn btn-primary"
       id="addStudent"><span
                class="glyphicon glyphicon-plus"
                aria-hidden="true"></span>
        Add Student
    </a>
    <!-- delete roster button -->
    <a class="btn btn-danger"
       id="deleteRoster"><span
                class="glyphicon glyphicon-minus"
                aria-hidden="true"></span>
        Delete Roster
    </a>

    <div style="display: none">
        <table>
            <tbody>
            <?php $s = null; $row = 0; ?>
                    <!-- this hidden field is duplicated and appended to the roster table when adding a new student -->
            @include('setup.partials.roster_form')
            </tbody>
        </table>
    </div>

@endsection


@section('jsArea')

    <script type="text/javascript">
        //The tab to be set as active
        var activeTab = 'navSetup';
        var forwardNavTarget = 'editExam';
        var backNavTarget = '{{ $prevAction }}';
    </script>
    <script language="javascript" type="text/javascript" src="{{ asset('js/roster-edit-package.js') }}"></script>

@endsection


