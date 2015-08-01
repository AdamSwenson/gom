<!-- EDIT QUESTION -->

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
                        <a id="prev-question" data-prevQ="{{ $prevqId }}" style="cursor:pointer;"> <span
                                    class="glyphicon glyphicon-chevron-left"
                                    aria-hidden="true"></span>
                            Previous Question</a>
                    </li>
                    <li class="next">
                        <a id="next-question" data-nextQ="{{ $nextqId }}" style="cursor:pointer;">Next Question <span
                                    class="glyphicon glyphicon-chevron-right"
                                    aria-hidden="true"></span></a>
                    </li>
                </ul>
            </nav>
            <h2>Add / Edit Elements: Question #{{ isset($qNumber) ? $qNumber : '1'}} "{{ isset($questionName) ? $questionName : '' }}"</h2>
            <h5>Each question is composed of one or more elements, representing individual items that the student
                should address.</h5>
            <!-- form will update all given questions and create new ones where required -->
            <form id="elementForm" name="elementForm" method="post" role="form"
                  action="{{ url('exam/'.$examId.'/question/'.$qId.'/element/updateAll') }}"
                  accept-charset="UTF-8">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <ul class="form-group" id="questionList">
                    @if( isset($elements) )
                        <?php $counter = 1; ?>
                        @foreach($elements as $q)
                            @include('setup.question_form')
                            <?php $counter++; ?>
                        @endforeach
                    @else
                        @include('setup.element_form')
                    @endif
                </ul>
                <input type="hidden" id="questionDirection" name="questionDirection" value="0"/>
            </form>
            <a class="btn btn-primary" id="addQuestion"><span
                        class="glyphicon glyphicon-plus"
                        aria-hidden="true"></span>
                Add Element</a>
        </div>
    </div>
    @include('setup.element_form_empty')
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
                    // handle deletion - items will be deleted once the form is submitted
                    var el = editableList.closest(evt.item); // get dragged item
                    // TODO: on delete confirmation
                    if (el && el.parentNode.removeChild(el))
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
                $(item).find('#displayNumber').text('Element #' + (order));
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

            // Previous Question button
            var btnPrevious = document.getElementById('prev-question');
            var prevQuestion = parseInt(btnPrevious.getAttribute('data-prevQ'));
            if ((prevQuestion === 0)) {
                // set text to "Edit Questions"
                $('#prev-question').text('Edit Questions');
            }

            btnPrevious.onclick = function () {
                if (prevQuestion === 0) {
                    // set the hidden field to either the questionId to view next, or 'back'
                    $('#questionDirection').attr('value', 'back');
                } else {
                    $('#questionDirection').attr('value', prevQuestion);
                }
                submitForm();
            }

            // Next Question button
            var btnNext = document.getElementById('next-question');
            var nextQuestion = parseInt(btnNext.getAttribute('data-nextQ'));
            // If we're at the last question, set text to "done"
            if ((nextQuestion === 0)) {
                $('#next-question').text('Done');
            }

            btnNext.onclick = function () {
                if (nextQuestion === 0) {
                    // set the hidden field to either the questionId to view next, or 'previous'
                    $('#questionDirection').attr('value', 'forward');
                } else {
                    $('#questionDirection').attr('value', nextQuestion);
                }
                submitForm();
            }

            function submitForm() {
                document.getElementById("elementForm").submit();
            }

            $('#elementForm').on('keyup keypress', function(e) {
                var code = e.keyCode || e.which;
                if (code == 13) {
                    e.preventDefault();
                    return false;
                }
            });

            return false;
        });


    </script>
@endsection



