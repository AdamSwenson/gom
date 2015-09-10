@extends('layouts.master')

@section('pageTitle', 'Edit Exam')
@section('description', 'Edit an exam')

@section('cssLinks')

@endsection

@section('body')

    <div id="editExam">
        <div class="section">
            <div class="container">
                <form id="examForm" method="post" action="{{ url('exam/'.$exam->getId()) }}"
                      accept-charset="UTF-8">
                    <input type="hidden" name="_method" value="patch">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <nav>
                        <ul class="pager">
                            <li class="previous">
                                <a onclick="submitForm('selectExam')"
                                   style="cursor:pointer;"> <span
                                            class="glyphicon glyphicon-chevron-left"
                                            aria-hidden="true"></span>
                                    Setup</a>
                            </li>
                            <li class="next">
                                <a onclick="submitForm('editQuestions')" style="cursor:pointer;">Add / Edit Questions
                                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a>
                            </li>
                        </ul>
                    </nav>
                    <h2>Edit Exam</h2>
                    @include('setup.exam_form')
                    <input type="hidden" id="nextAction" name="nextAction" value="editQuestions"/>
                </form>

            </div>
        </div>
    </div>

    @include('errors.list')

@endsection


@section('jsArea')
    <script language="javascript" type="text/javascript" src="{{ asset('inc/js/examForm.js') }}"></script>
    <script type="text/javascript">
    </script>
@endsection


