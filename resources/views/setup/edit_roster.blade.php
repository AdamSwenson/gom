<!-- Edit_roster manages student creation, editing and file imports -->
@extends('layouts.master')

@section('pageTitle', 'Edit Roster | gradeomatic')
@section('description', 'Upload and modify student roster')

@section('otherCss')
    @include('layouts.css.css_datatables')
    <!-- styling to change file button into bootstrap style and hide the file name -->
    <link rel="stylesheet" href="{{ asset('css/edit-roster-package.css') }}">

@endsection

@section('body')
    <div id="rosterEditPage" class="mainBodyLocator">
        <div id="app">
            <setup-navs forward-nav-target="editExam"
                        forward-nav-label="Save & Finish"
                        forward-nav-icon="disk"
                        back-nav-target="{{ $prevAction }}"
                        back-nav-label=" {{ $prevActionLabel }}"
                        back-nav-icon="left"></setup-navs>

            <h2>Import Roster</h2>

            <p>Roster files can be any CSV file having each student's information on a single row in the following
                format: Last Name, First Name, Student ID (optional), Email (optional)</p>

            <!-- file import button -->
            <import-roster-button></import-roster-button>

            <!-- import help -->
            <import-roster-help-button></import-roster-help-button>

            <h2>Edit Roster</h2>

            <form id="rosterData" method="post" role="form"
                  action="{{ url('exam/'.$exam1->getId().'/student/updateAll') }}">
                {!! csrf_field() !!}
                <table id="rosterTable"
                       class="table"
                       v-datatable
                >
                    <thead>
                    <!-- table headers -->
                    <tr>
                        <th id="sortByLastName"
                            class="col-md-3 sortableHeading"
                        >Last Name
                        </th>
                        <th id="sortByFirstName"
                            class="col-md-3 sortableHeading"
                        >First Name
                        </th>
                        <th id="sortByStudentIdentifier"
                            class="col-md-2 sortableHeading"
                        >Student ID
                        </th>
                        <th id="sortByEmail"
                            class="col-md-3 sortableHeading"
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
                            <tr is="student-row"
                                row-id="{{ $row }}"
                                student-record-id="{{ $s['id'] or 0 }}"
                                last-name="{{ $s['last_name'] or '' }}"
                                first-name="{{ $s['first_name'] or '' }}"
                                student-id="{{ $s['student_identifier'] or '' }}"
                                email="{{ $s['email'] or '' }}"
                            ></tr>
                            <?php $row++ ?>
                        @endforeach
                        <?php $maxRow = $row; ?>
                    @endif
                    </tbody>
                </table>
                <input type="hidden" name="navigateTo" value="selectExam"/>
            </form>

            <!-- add student button -->
            <add-empty-row-button></add-empty-row-button>

            <!-- delete roster button -->
            <delete-roster-button></delete-roster-button>


            <div style="display: none">
                <table>
                    <tbody>
                    <?php $s = null; $row = 0; ?>
                    <!-- this hidden field is duplicated and appended to the roster table when adding a new student -->
                    @include('setup.partials.roster_form')
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection


@section('jsArea')

    <script type="text/javascript">
        //The tab to be set as active
        var activeTab = 'navSetup';
        var baseUrl = '{{ url('') }}'; //duplicates the rootRoute set in master
        var maxRow = '{{ $maxRow or 0 }}';
    </script>


    {{--<script language="javascript" type="text/javascript" src="{{ asset('js/roster-edit-package.js') }}"></script>--}}

    <script language="javascript" type="text/javascript" src="{{ asset('Item') }}"></script>

@endsection

