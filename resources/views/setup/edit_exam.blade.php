<!--
/**
 * Created by PhpStorm.
 * User: Brian
 * Date: 7/17/2015
 * Time: 4:59 PM
 */
 -->

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
    <script type="text/javascript">

        // set 'Setup' tab as active
        $('[id^="nav"]').attr('class', '');
        $('#navSetup').attr('class', 'active');

        function submitForm(target) {
            $('#nextAction').val(target);
            document.getElementById("examForm").submit();
        }

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

            return false;
        });
    </script>


@endsection


