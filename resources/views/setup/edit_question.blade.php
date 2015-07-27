<!--
/**
 * Created by PhpStorm.
 * User: Brian
 * Date: 7/17/2015
 * Time: 4:59 PM
 */
 -->

@extends('layouts.master')
@section('pageTitle', 'Edit Questions')
@section('description', 'Add or edit questions')
@section('cssLinks')
@endsection

@section('body')

    <div class="section">
        <div class="container">
            <nav>
                <ul class="pager">
                    <li class="next">
                        <a id="submit-span" style="cursor:pointer;">Done <span
                                    class="glyphicon glyphicon-chevron-right"
                                    aria-hidden="true"></span></a>
                    </li>
                </ul>
            </nav>
            <h2 id="examName">{{ $examName }}: Add / Edit Questions</h2>
            <h5>Add the questions that will appear on this exam. When you're finished, press "done".</h5>
            <!-- form will update all given questions and create new ones where required -->
            <form id="questionForm" name="questionForm" method="post" role="form"
                  action="{{ url('exam/'.$examId.'/question/updateAll') }}"
                  accept-charset="UTF-8">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <ul class="form-group" id="questionList">
                    @if (isset($questions))
                        @foreach($questions as $q)
                            @include('setup.question_form')
                        @endforeach
                    @else
                        @include('setup.question_form')
                    @endif

                </ul>
            </form>
            <a class="btn btn-primary" id="addQuestion"><span
                        class="glyphicon glyphicon-plus"
                        aria-hidden="true"></span>
                Add Question</a>
            <button class="btn btn-primary" id="importQuestion"><span class="glyphicon glyphicon-import"
                                                                      aria-hidden="true"></span>Import Question
            </button>
        </div>
    </div>

    <!-- a blank question form to use for clones -->
    <ul style="display: none" id="hiddenQuestionList">
        <li class="list-group-item" id="emptyQuestionItem">
            <h4 id="displayNumber">Question #0</h4>

            <div class="input-group">
                <span class="input-group-addon">Question Name</span>
                <input id="questionName0" name="questionName0" type="text" class="form-control input" value=""
                       placeholder="Enter a brief description of the question, i.e. &quot;Causes of the Civil War&quot;"
                       aria-describedby="basic-addon1">

            </div>
            <h5>Question Text</h5>

            <div class="form-group">
        <textarea class="form-control" rows="3" id="questionText0" name="questionText0"
                  placeholder="Enter the full question text(optional)"></textarea>
            </div>
            <div class="form-group">
        <span class="btn btn-info btn-sm"><span class="handle" aria-hidden="true">
                <span class="glyphicon glyphicon-move" aria-hidden="true"></span>
             Move</span>
                </span>
                <button class="btn btn-warning btn-sm"><span class="js-remove"><span
                                class="glyphicon glyphicon-minus" aria-hidden="true"></span> Delete</span>
                </button>
            </div>
            <input type="hidden" id="questionId" name="questionId0" value="0"/>
        </li>
    </ul>


    @include('errors.list')

@endsection


@section('jsArea')
    <script type="text/javascript">

        // Sortable is the lib for deag and drop elements
        // create an editable list and set up some filters to handle callbacks
        $(document).ready(function () {
            var qList = document.getElementById('questionList');
            var editableList = Sortable.create(qList, {
                filter: '.js-remove',
                animation: 150,
                handle: '.handle',
                ghostClass: "sortable-ghost",
                onFilter: function (evt) {
                    var el = editableList.closest(evt.item); // get dragged item
                    // TODO: on delete confirmation
                    deleteQuestionFromDB(el);
                    el && el.parentNode.removeChild(el);
                    updateNumbers();
                },
                store: {
                    // store the ordering to localStorage
                    get: function (sortable) {
                        var order = localStorage.getItem(sortable.options.group);
                        window.console.log(localStorage.getItem(sortable.options.group));
                        return order ? order.split('|') : [];
                    },


                    set: function (sortable) {
                        var order = sortable.toArray();
                        localStorage.setItem(sortable.options.group, order.join('|'));
                        updateNumbers();
                    }
                }
            });

            function deleteQuestionFromDB(el) {
                var id = $(el).find('#questionId').attr('value');
                // If question already exists in DB, remove from DB
                if (id > 0) {
                    $.ajax({
                        url: "{{ url('exam/'.$examId.'/question') }}" + "/" + id,
                        type: 'DELETE',
                        success: function (result) {
                            // Do something with the result
                            alert('Success!');
                        },
                        error: function (result) {
                            alert('failed to delete id:' + id);
                        }
                    });
                }
            }

            // handle addQuestion button
            document.getElementById("addQuestion").onclick = function () {
                // copy empty form
                var order = getQuestionCount() + 1;
                var myClone = $('#emptyQuestionItem').clone();
                // set values

                // add to editableList and refresh
                myClone.appendTo($("#questionList"));
                updateListItemData(myClone, order);
                updateNumbers();
            };

            // update all questions
            function updateNumbers() {

                $("[id^=questionItem]").each(function (index, el) {
                    updateListItemData(el, (index + 1));
                });
            }

            // set all relevant names and ids of [item] to value [order]
            function updateListItemData(item, order) {
                $(item).attr('id', 'questionItem' + order);
                $(item).find('#displayNumber').text('Question #' + (order));
                $(item).find("[id^='questionName']").attr('id', 'questionName' + order);
                $(item).find("[id^='questionName']").attr('name', 'questionName' + order);
                $(item).find('textarea').attr('id', 'questionText' + order);
                $(item).find('textarea').attr('name', 'questionText' + order);
                $(item).find('#questionId').attr('name', 'questionId' + order);
            }

            function getQuestionCount() {
                // return number of questions currently in the questionList
                return $("[id^=questionItem]").length;
            }

            // handle form submission
            var btnDone = document.getElementById('submit-span');

            btnDone.onclick = function () {
                document.getElementById("questionForm").submit();
            }

            return false;
        });


    </script>
@endsection


