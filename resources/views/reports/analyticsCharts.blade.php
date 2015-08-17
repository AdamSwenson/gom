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

            </div>
        </div>
    </div>

    @include('errors.list')

@endsection


@section('jsArea')


@endsection


