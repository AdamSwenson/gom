<!--
/**
 * Created by PhpStorm.
 * User: Brian
 * Date: 7/17/2015
 * Time: 4:59 PM
 */
 -->

@extends('layouts.master')

@section('pageTitle', 'Empty')
@section('description', 'Edit an exam')

@section('cssLinks')

@endsection

@section('body')

    <div id="editExam">
        <div class="section">
            <div class="container">
                <form id="examForm" method="GET" action=""
                      accept-charset="UTF-8">
                    <nav>
                        <ul class="pager">
                            <li class="next">
                                <a href="{{url('exam/' .$examId.'/question/edit')}}" id="submitLink">Done <span
                                            class="glyphicon glyphicon-chevron-right"
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
        window.onload = function () {
            var btnDone = document.getElementById("submitLink");

            btnDone.onclick = function () {
                document.getElementById("examForm").submit();
            }
        };

    </script>


@endsection


