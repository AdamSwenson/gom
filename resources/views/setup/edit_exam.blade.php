<!-- 'edit_exam' houses controls for exam1 name, term, and year -->
@extends('layouts.master')

@section('pageTitle', 'Edit Exam | gradeomatic')
@section('description', 'Edit an exam1')

@section('otherCss')
    <link rel="stylesheet" href="{{ asset('css/common-package.css') }}">
@endsection

@section('body')
    <div class="section mainBodyLocator" id="editExamPage">
        <form id="examForm" method="post" action="{{ url('exam1/'.$exam1->getId()) }}"
              accept-charset="UTF-8">
            <input type="hidden" name="_method" value="patch">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <nav>
                <ul class="pager">
                    <li class="previous">
                        <a id="backNavButton"
                           style="cursor:pointer;"> <span
                                    class="glyphicon glyphicon-chevron-left"
                                    aria-hidden="true"></span>
                            Setup</a>
                    </li>
                    <li class="next">
                        <a id="forwardNavButton" style="cursor:pointer;">Add / Edit Questions
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a>
                    </li>
                </ul>
            </nav>
            <h2>Edit Exam</h2>
            @include('setup.partials.exam_form')
            <input type="hidden" id="nextAction" name="nextAction" value="editQuestions"/>
        </form>
    </div>
@endsection


@section('jsArea')
    <script type="text/javascript">
    var activeTab = 'navSetup';
    var forwardNavTarget = 'editQuestions';
    var backNavTarget = 'selectExam';
    </script>
    <script language="javascript" type="text/javascript" src="{{ asset('js/exam1-setup-package.js') }}"></script>
    {{--<script language="javascript" type="text/javascript" src="{{ asset('inc/js/examForm.js') }}"></script>--}}

@endsection


