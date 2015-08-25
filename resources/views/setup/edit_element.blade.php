<!-- EDIT element -->

<!--
/**
 * Created by PhpStorm.
 * User: Brian
 * Date: 7/17/2015
 * Time: 4:59 PM
 */
 -->

@extends('layouts.master')
@section('pageTitle', 'Edit elements')
@section('description', 'Add or edit elements')
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
            <h2>Add / Edit Elements: Question #{{ isset($qNumber) ? $qNumber : '1'}}
                "{{ isset($questionName) ? $questionName : '' }}"</h2>
            <h5>Each element is composed of one or more elements, representing individual items that the student
                should address.</h5>
            <!-- form will update all given elements and create new ones where required -->
            <form id="elementForm" name="elementForm" method="post" role="form"
                  action="{{ url('exam/'.$examId.'/question/'.$questionId.'/element/updateAll') }}"
                  accept-charset="UTF-8">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <ul class="form-group" id="elementList">
                    <?php $counter = 1; ?>
                    @if( !empty($elements) )
                        @foreach($elements as $e)
                            @include('setup.element_form')
                            <?php $counter++; ?>
                        @endforeach
                    @else
                        @include('setup.element_form')
                    @endif
                </ul>
                <input type="hidden" id="questionDirection" name="questionDirection" value="0"/>
            </form>
            <a class="btn btn-primary" id="addElement">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                Add Element
            </a>
        </div>
    </div>
    <ul style="display: none" id="hiddenElementList">
        <?php $counter = 0;
        $e = NULL; ?>
        @include('setup.element_form')
    </ul>
    @include('errors.list')
@endsection


@section('jsArea')
    <script type="text/javascript">

        $(document).ready(function () {
            // clear local storage to dump Sortable data - or it may display items out of order
            localStorage.clear();
            // magic 4 for now...
            // TODO:
            var numValences = 4;
            // set up Sortable list
            var eList = document.getElementById('elementList');
            var editableList = Sortable.create(eList, {
                filter: '.js-remove',
                animation: 150,
                handle: '.handle',
                ghostClass: "sortable-ghost",
                onFilter: function (evt) {
                    // TODO: on delete confirmation
                    var el = editableList.closest(evt.item); // get dragged item
                    if (el && el.parentNode.removeChild(el))
                        updateNumbers();
                },
                store: {
                    // store the ordering to localStorage
                    get: function (sortable) {
                        var order = localStorage.getItem(sortable.options.group);
                        return order ? order.split('|') : [];
                    },
                    set: function (sortable) {
                        var order = sortable.toArray();
                        localStorage.setItem(sortable.options.group, order.join('|'));
                        updateNumbers();
                    }
                }
            });

            // 'Customize responses': Copy base response into empty comments
            function registerCustomtizeHandlers() {
                $("[id^='commentForm']").on('shown.bs.modal', function () {
                    // find closest elementText and copy to all blank valences
                    var parent = $(this).closest("[id^='elementItem']");
                    var elementText = $(parent).find("[id^='elementText']").val();

                    for (var i = 0; i < numValences; i++) {
                        var valenceText = $(parent).find("[name$='valence" + i + "']");
                        if (valenceText.val() == '') {
                            valenceText.val(elementText);
                        }
                    }
                });
            }
            registerCustomtizeHandlers();

            // handle addelement button
            document.getElementById("addElement").onclick = function () {
                // copy empty form
                var order = getElementCount() + 1;
                var myClone = $('#elementItem0').clone();
                // set values

                // add to editableList and refresh
                myClone.appendTo($("#elementList"));
                updateListItemData(myClone, order);
                updateNumbers();
                registerCustomtizeHandlers();
            };

            // update all elements
            function updateNumbers() {

                $('#elementForm').find("[id^='elementItem']").each(function (index, el) {
                    updateListItemData(el, (index + 1));
                });
            }

            // set all relevant names and ids of [item] to value [order]
            function updateListItemData(item, order) {
                $(item).attr('id', 'elementItem' + order);
                $(item).find('#displayNumber').text('Element #' + (order));
                $(item).find("[id^='elementName']").attr('id', 'elementName' + order);
                $(item).find("[id^='elementName']").attr('name', 'elementName' + order);
                $(item).find("[id^='elementText']").attr('id', 'elementText' + order);
                $(item).find("[id^='elementText']").attr('name', 'elementText' + order);
                $(item).find('#elementId').attr('name', 'elementId' + order);

                // update customizeResponse button and set which modal it opens
                $(item).find("[id^='btnCustomizeResponse']").attr('id', 'btnCustomizeResponse' + order);
                $(item).find("[id^='btnCustomizeResponse']").attr('data-target', '#commentForm' + order);

                // update items within comment_form
                $(item).find("[id^='commentForm']").attr('id', 'commentForm' + order);

                for (var i = 0; i < numValences; i++) {
                    $(item).find('#tab' + i).attr('href', '#e' + order + "area" + i);
                    var toFind = 'valence' + i;
                    $(item).find("[id$='area" + i + "']").attr('id', 'e' + order + 'area' + i);
                    $(item).find("[name$='" + toFind + "']").attr('name', "e" + order + toFind);
                }
            }

            function getElementCount() {
                return $('elementForm').find("[id^='elementItem']").length;
            }

            // Previous Question button
            var btnPrevious = document.getElementById('prev-question');
            var prevQuestion = parseInt(btnPrevious.getAttribute('data-prevQ'));
            if ((prevQuestion === 0)) {
                // set text to "Edit questions"
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

            // "Next Question" button
            var btnNext = document.getElementById('next-question');
            var nextQuestion = parseInt(btnNext.getAttribute('data-nextQ'));
            // If we're at the last element, set text to "done"
            if ((nextQuestion === 0)) {
                $('#next-question').text('Done');
            }

            btnNext.onclick = function () {
                if (nextQuestion === 0) {
                    // set the hidden field to either the elementId to view next, or 'previous' to return to edit question
                    $('#questionDirection').attr('value', 'forward');
                } else {
                    $('#questionDirection').attr('value', nextQuestion);
                }
                submitForm();
            }

            function submitForm() {
                document.getElementById("elementForm").submit();
            }

            $("input[type='submit']").click(function (e) {
                e.preventDefault();
            });

            return false;
        });
    </script>
@endsection



