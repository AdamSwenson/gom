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
                    <li class="previous">
                        <a onclick="submitForm('editExam')" style="cursor:pointer;"> <span
                                    class="glyphicon glyphicon-chevron-left"
                                    aria-hidden="true"></span>
                            Edit Exam</a>
                    </li>
                    <li class="next">
                        <a onclick="submitForm('editElements')" style="cursor:pointer;">Add / Edit Elements <span
                                    class="glyphicon glyphicon-chevron-right"
                                    aria-hidden="true"></span></a>
                    </li>
                </ul>
            </nav>
            <h2 id="examName">Add / Edit Questions: "{{ $examName }}" </h2>
            <h5>Add the questions that will appear on this exam. When you're finished, press "Add / Edit Elements" to
                move to the next step.</h5>

            @include('errors.list')

            <!-- form will update all given questions and create new ones where required -->
            <form id="questionForm" name="questionForm" method="post" role="form"
                  action="{{ url('exam/'.$examId.'/question/updateAll') }}"
                  accept-charset="UTF-8">
                <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
                <ul class="form-group" id="questionList">
                    <?php $counter = 1; ?>
                    @if (!empty($questions))
                        @foreach($questions as $q)
                            @include('setup.question_form')
                            <?php $counter++; ?>
                        @endforeach
                    @else
                        @include('setup.question_form')
                    @endif
                </ul>
                <input type="hidden" id="nextAction" name="nextAction" value="editQuestions"/>
            </form>
            <a class="btn btn-primary" id="addQuestion"><span class="glyphicon glyphicon-plus"
                                                              aria-hidden="true"></span>
                Add Question</a>
            <a class="btn btn-primary" id="importQuestion"><span class="glyphicon glyphicon-import"
                                                                 aria-hidden="true"></span>Import Question
            </a>
        </div>
    </div>
    <!-- a blank question form to use for clones -->
    <ul style="display: none" id="hiddenQuestionList">
        <?php $counter = 0;
        $q = NULL; ?>
        @include('setup.question_form')
    </ul>

@endsection


@section('jsArea')
    <script type="text/javascript">

        function submitForm(target) {
            $('#nextAction').val(target);
            document.getElementById("questionForm").submit();
        }

        // Sortable is the lib for deag and drop elements
        // create an editable list and set up some filters to handle callbacks
        $(document).ready(function () {

                    localStorage.clear();
                    var qList = document.getElementById('questionList');
                    var editableList = Sortable.create(qList, {
                        filter: '.js-remove',
                        animation: 150,
                        handle: '.handle',
                        ghostClass: "sortable-ghost",
                        onFilter: function (evt) {
                            // handle deletion - items will be deleted once the form is submitted
                            var el = editableList.closest(evt.item); // get dragged item

                            bootbox.dialog({
                                message: "Warning: This will delete all elements and scores associated with the question",
                                title: "Delete Question",
                                buttons: {
                                    success: {
                                        label: 'Cancel',
                                        className: "btn-sm",
                                        callback: function() {
                                        }
                                    },
                                    danger: {
                                        label: '<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Delete',
                                        className: "btn-danger btn-sm",
                                        callback: function() {
                                            if (el && el.parentNode.removeChild(el))
                                                updateNumbers();
                                        }
                                    }
                                }
                            });

                        },
                        store: {
                            // store the ordering to localStorage
                            get: function (sortable) {
                                var order = localStorage.getItem(sortable.options.group);
                                //window.console.log(localStorage.getItem(sortable.options.group));
                                return order ? order.split('|') : [];
                            },


                            set: function (sortable) {
                                var order = sortable.toArray();
                                localStorage.setItem(sortable.options.group, order.join('|'));
                                updateNumbers();
                            }
                        }
                    });

                    // handle addQuestion button
                    document.getElementById("addQuestion").onclick = function () {
                        // copy empty form
                        var order = getQuestionCount() + 1;
                        var myClone = $('#questionItem0').clone();

                        // add to editableList and refresh
                        myClone.appendTo($("#questionList"));
                        updateListItemData(myClone, order);
                        updateNumbers();
                    };

                    // update all questions
                    function updateNumbers() {

                        $('#questionForm').find("[id^='questionItem']").each(function (index, el) {
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
                        return $("[id^='questionItem']").length;
                    }

                    return false;
                }
        );
    </script>
@endsection


