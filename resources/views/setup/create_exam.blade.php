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
                        <li class="previous">
                            <a href="{{ url('exam/') }}" id="prev-question" style="cursor:pointer;"> <span
                                        class="glyphicon glyphicon-chevron-left"
                                        aria-hidden="true"></span>
                                Setup</a>
                        </li>
                        <li class="next">
                        <a id="submitLink" style="cursor:pointer;">Add / Edit Questions <span class="glyphicon glyphicon-chevron-right"
                                                           aria-hidden="true"></span></a>

                        </li>
                    </ul>
                    <h2>Create Exam</h2>
                    @include('setup.exam_form')
                </form>
            </div>
        </div>
    </div>

    @include('errors.list')

@endsection


@section('jsArea')
    <script type="text/javascript">

        // set 'Setup' tab as active
        $('[id^="nav"]').attr('class', '');
        $('#navSetup').attr('class', 'active');
        
        $(document).ready(function() {

            $('#termList li').on('click', function () {
                $('#hiddenTerm').val($(this).text());

                var $icon = $('#term').find('span');
                $('#term').html($(this).text());
                $('#term').append(" ");
                $('#term').append($icon);


            });

            $('#yearList li').on('click', function () {
                $('#hiddenYear').val($(this).text());

                var $icon = $('#year').find('span');
                $('#year').text($(this).text());
                $('#year').append(" ");
                $('#year').append($icon);
            });

            var btnDone = document.getElementById("submitLink");

            btnDone.onclick = function () {
                document.getElementById("examForm").submit();
            }

            return false;
        });
    </script>
@endsection


