@extends('layouts.master')

@section('pageTitle', 'Edit Roster')
@section('description', 'Upload or modify student roster')

@section('cssLinks')
@endsection

@section('body')
    <div id="editRoster">
        <div class="section">
            <div class="container">
                <nav>
                    <ul class="pager">
                        <li class="next">
                            <a href="#" onclick="document.getElementById('formFileData').submit();">Done <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a>
                        </li>
                        <li class="previous">
                            <a href="{{url('exam/'. $exam->getId() . '/edit')}}"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>Edit Exam</a>
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


