<!-- Edit_roster manages student creation, editing and file imports -->
@extends('layouts.master')

@section('pageTitle', 'Edit Roster | gradeomatic')
@section('description', 'Upload and modify student roster')

@section('cssLinks')

@endsection

@section('body')
        <!-- styling to change file button into bootstrap style and hide the file name -->
<style>
    .btn-file {
        position: relative;
        overflow: hidden;
    }

    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }

    .form-control:hover {
        background-color: #E3E3E3;
    }

    .glyphicon-remove {
        font-size: 1.2em;
        color: #d9534f;
    }

    .glyphicon-remove:hover {
        cursor: pointer;
        font-size: 1.2em;
        color: #d43f3a;
    }
</style>

<div class="section">
    <div class="container">
        <nav>
            <ul class="pager">
                <li class="next">
                    <a onclick="submitAndNavigateTo('editExam')" style="cursor:pointer;"><span
                                class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Save & Finish</a>
                </li>
                <li class="previous">
                    <a onclick="submitAndNavigateTo('{{ $prevAction }}')" style="cursor:pointer;"><span
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
            <a onclick="showImportHelp()" class="btn btn-info">
                <span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>
                Import Help
            </a>

        <h2>Edit Roster</h2>

        @include('errors.list')

        <div class="container">
            <form id="rosterData" method="post" role="form"
                  action="{{ url('exam/'.$exam->getId().'/student/updateAll') }}">
                {!! csrf_field() !!}
                <table class="table">
                    <thead>
                    <!-- table headers -->
                    <tr>
                        <th class="col-md-3" style="cursor: pointer;" onclick="sortRosterBy('lastName')">Last
                            Name
                        </th>
                        <th class="col-md-3" style="cursor: pointer;" onclick="sortRosterBy('firstName')">First
                            Name
                        </th>
                        <th class="col-md-2" style="cursor: pointer;"
                            onclick="sortRosterBy('studentIdentifier')">Student ID
                        </th>
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
                <input type="hidden" name="navigateTo" value="selectExam"/>
            </form>
        </div>
        <!-- add student button -->
        <a class="btn btn-primary" onclick="addStudent()" id="addStudent"><span
                    class="glyphicon glyphicon-plus"
                    aria-hidden="true"></span>
            Add Student
        </a>
        <!-- delete roster button -->
        <a class="btn btn-danger" onclick="deleteRoster()" id="deleteRoster"><span
                    class="glyphicon glyphicon-minus"
                    aria-hidden="true"></span>
            Delete Roster
        </a>
    </div>
</div>


<div style="display: none">
    <table>
        <tbody>
        <?php $s = null; $row = 0; ?>
                <!-- this hidden field is duplicated and appended to the roster table when adding a new student -->
        @include('setup.roster_form')
        </tbody>
    </table>
</div>


@endsection


@section('jsArea')

    <script language="javascript" type="text/javascript" src="{{ asset('inc/js/rosterTable.js') }}"></script>
    <script language="javascript" type="text/javascript" src="{{ asset('inc/js/rosterFileImport.js') }}"></script>
    <script type="text/javascript">

        /*
         THINGS TODO:
         - column swapping
         - XLS / XLSX support
         */

        function showImportHelp() {
            bootbox.dialog({
                message: "Student roster files should be formatted as a .CSV file type.<br/>" +
                "Each row holds one student's data, with the following information:<br/>" +
                "Last name, first name, ID (optional), email (optional)<br/>" +
                "Using these 4 fields as the first row of the file, though not required,<br/>" +
                "will make it more likely that the data can be imported correctly.",
                title: "Import Help",
                buttons: {
                    success: {
                        label: "Ok",
                        className: "btn-primary",
                        callback: function () {
                        }
                    }
                }
            });
        }

        function submitAndNavigateTo(target) {
            var $table = $('#studentRosterBody');
            var valid = true;

            // check that first and last names have values
            $table.find('[id$="Name"]').each(function () {
                if ($(this).val() == '') {
                    valid = false;
                }
            });

            if (valid) {
                $('[name="navigateTo"]').val(target);
                $('#rosterData').submit();
            } else {
                bootbox.alert("Name missing! Make sure all students have a first and last name before proceeding.",
                        function () {
                        });
            }
        }

        $(document).ready(function () {
            // 'upload file' listener
            $('#fileInput').change(function () {
                startRead();
                $(this).val(null);
            });
            return false;
        });
    </script>
@endsection


