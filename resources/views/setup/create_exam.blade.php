<!-- create a new exam -->
@extends('layouts.master')
@section('pageTitle', 'Create Exam | gradeomatic')
@section('description', 'create an exam')
@section('cssLinks')
    <link rel="stylesheet" href="{{ asset('css/common-package.css') }}">
@endsection

@section('body')
    <div id="createExam">

        <form id="examForm" method="POST" action="{{url('exam')}}"
              accept-charset="UTF-8" role="form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <ul class="pager">
                <li class="previous">
                    <a href="{{ url('exam/') }}" id="prev-question" style="cursor:pointer;"> <span
                                class="glyphicon glyphicon-chevron-left"
                                aria-hidden="true"></span> Setup
                    </a>
                </li>
                <li class="next">
                    <a id="forwardNavButton" style="cursor:pointer;">
                        Add / Edit Questions <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    </a>


                    {{--<a onclick="submitForm('editQuestions')" id="saveExam" style="cursor:pointer;">--}}
                        {{--Add / Edit Questions <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>--}}
                    {{--</a>--}}
                </li>
            </ul>
            <h2>Create Exam</h2>
            @include('setup.partials.exam_form')
        </form>
    </div>
@endsection


@section('jsArea')
    <script type="text/javascript">
        //The tab to be set as active
        var activeTab = 'navSetup';
        var forwardNavTarget = 'editQuestions';
        var backNavTarget = '';
    </script>
    <script language="javascript" type="text/javascript" src="{{ asset('js/exam-setup-package.js') }}"></script>
    {{--<script language="javascript" type="text/javascript" src="{{ asset('inc/js/examForm.js') }}"></script>--}}

@endsection


