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
                            <li class="next">
                                <a id="submitLink" style="cursor:pointer;">Next <span class="glyphicon glyphicon-chevron-right"
                                                                   aria-hidden="true"></span></a>
                            </li>
                        </ul>
                    </nav>
                    <h2>Edit Exam</h2>
                    @include('setup.exam_form')
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
                window.console.log('hiddenTerm:'+$(this).text());
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


