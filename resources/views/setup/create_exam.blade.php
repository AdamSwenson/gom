@extends('layouts.master')
@section('pageTitle', 'Create Exam')
@section('description', 'create an exam')
@section('cssLinks')
@endsection

@section('body')
    <div id="createExam">
        <div class="section">
            <div class="container">
                <form id="examForm" method="POST" action="{{url('exam')}}"
                      accept-charset="UTF-8" role="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <ul class="pager">
                        <li class="next">
                        <a id="submitLink" style="cursor:pointer;">Create <span class="glyphicon glyphicon-chevron-right"
                                                           aria-hidden="true"></span></a>

                        </li>
                    </ul>
                    <h2>Create Exam</h2>
                    @include('setup.exam_form')

                    <input type="text" name="year" value="2015"/>
                    <input type="text" name="term" value="fall"/>
                </form>
            </div>
        </div>
    </div>

    @include('errors.list')

@endsection


@section('jsArea')
    <script type="text/javascript">
        $(document).ready(function() {

            $('#termList li').on('click', function () {
                $('#hiddenTerm').val($(this).text());
                $('#term').text($(this).text());
            });

            $('#yearList li').on('click', function () {
                $('#hiddenYear').val($(this).text());
                $('#year').text($(this).text());
            });

            var btnDone = document.getElementById("submitLink");

            btnDone.onclick = function () {
                document.getElementById("examForm").submit();
            }

            return false;
        });
    </script>
@endsection


