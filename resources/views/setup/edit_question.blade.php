<!--
/**
 * Created by PhpStorm.
 * User: Brian
 * Date: 7/17/2015
 * Time: 4:59 PM
 */

    Handles editing, adding, importing, deleting and reordering questions

 -->

@extends('layouts.master')

@section('pageTitle', 'Edit Questions')
@section('description', 'Add or edit questions')

@section('cssLinks')

@endsection

@section('body')

    <div id="editQuestion">
        <div class="section">
            <div class="container">
                <nav>
                    <ul class="pager">
                        <li class="next">
                            <a href="#">Done <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a>
                        </li>
                    </ul>
                </nav>
                <h2 id="examName">{{ $examName }}: Add / Edit Questions</h2>
                <h5>Add the questions that will appear on this exam. When you're finished, press "done".</h5>

                <!-- this Div will become the question template -->
                <div id="container">
                     @foreach($questions as $q)
                        @include('setup.question_form')
                     @endforeach
                </div>
                <br>
                <button class="btn btn-primary" id="addQuestion" onclick="duplicateQuestion()"><span class="glyphicon glyphicon-plus"
                                                                       aria-hidden="true"></span>
                    Add Question
                </button>
                <button class="btn btn-primary" id="importQuestion"><span class="glyphicon glyphicon-import"
                                                                          aria-hidden="true"></span>
                    Import Question
                </button>
            </div>
        </div>
    </div>

    @include('errors.list')

@endsection


@section('jsArea')
    <script type="text/javascript">
        // i should be set to # of elements passed in
        var i = 0;
        var original = document.getElementById('questionForm');


        function duplicateQuestion() {
            var clone = original.cloneNode(true);
            clone.id = 'addQuestion' + ++i;
            original.parentNode.appendChild(clone);
            clone.querySelector('questionNumber').style.display = 14;

        }

        function deleteQuestion(elementId) {
            var element = document.getElementById(elementId);
            element.parentNode.removeChild(element);
        }
    </script>

@endsection


