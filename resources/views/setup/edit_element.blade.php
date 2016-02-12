<!-- 'edit_element' contains the controls for adding, editing and deleting elements  -->

@extends('layouts.master')
@section('pageTitle', 'Edit Elements | gradeomatic')
@section('description', 'Add or edit elements')
@section('cssLinks')
@endsection

@section('body')
    <nav>
        <ul class="pager">
            <li class="previous">
                <a onclick="submitForm('{{ $prevAction  }}')" id="prev-question" data-questionId="{{ $prevAction }}"
                   style="cursor:pointer;"> <span class="glyphicon glyphicon-chevron-left"
                                                  aria-hidden="true"></span>
                    <?php if ($prevAction == 'editQuestions') echo('Edit Questions'); else echo('Previous Question'); ?>
                </a>
            </li>
            <li class="next">
                <a onclick="submitForm('{{ $nextAction  }}')" id="next-question" data-questionId="{{ $nextAction }}"
                   style="cursor:pointer;">
                    <?php if ($nextAction == 'editStudents') echo('Edit Roster'); else echo('Next Question'); ?>
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a>
            </li>
        </ul>
    </nav>
    <h2>Add / Edit Elements: Question #{{ isset($qNumber) ? $qNumber : '1'}}
        "{{ isset($questionName) ? $questionName : '' }}"</h2>
    <h5>Each question is composed of elements. Each element is a concept or issue that a correct answer
        should address.</h5>



            <!-- form will update all given elements and create new ones where required -->
    <form id="elementForm" name="elementForm" method="post" role="form"
          action="{{ url('exam/'.$examId.'/question/'.$questionId.'/element/updateAll') }}"
          accept-charset="UTF-8">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <ul class="form-group" id="elementList">
            <!-- display all elements passed from the server. If 0, display one element -->
            <?php $counter = 1; ?>
            @if( !empty($elements) )
                @foreach($elements as $e)
                    @include('setup.partials.element_form')
                    <?php $counter++; ?>
                @endforeach
            @else
                @include('setup.partials.element_form')
            @endif
        </ul>
        <input type="hidden" id="nextAction" name="nextAction" value="0"/>
    </form>
    <a class="btn btn-primary" id="addElement">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        Add Element
    </a>

    <ul style="display: none" id="hiddenElementList">
        <!-- this blank element is duplicated and appended to the page when creating a new element -->
        <?php $counter = 0;
        $e = NULL; ?>
        @include('setup.partials.element_form')
    </ul>

@endsection


@section('jsArea')
{{--    <script src="{{ asset("inc/js/Sortable.js") }}"></script>--}}
<script type="text/javascript">
    var activeTab = 'navSetup';
</script>

    <script type="text/javascript" src="{{ asset('js/element-edit-package.js') }}"></script>

        {{--// validate and submit form. Currently, questions are valid with 0 elements.--}}
        {{--function submitForm(target) {--}}
            {{--if (formFieldsValid()) {--}}
                {{--$('#nextAction').val(target);--}}
                {{--$('#elementForm').submit();--}}
            {{--} else {--}}
                {{--bootbox.alert('One or more elements is missing a name.');--}}
            {{--}--}}
        {{--}--}}

        {{--function numberOfElements() {--}}
            {{--return $('#elementForm').find('[id^="elementName"]').length;--}}
        {{--}--}}

        {{--function formFieldsValid() {--}}
            {{--var valid = true;--}}
            {{--var $names = $('#elementForm').find('[id^="elementName"]');--}}
            {{--$names.each(function () {--}}
                {{--if ($(this).val() == '') {--}}
                    {{--valid = false;--}}
                {{--}--}}
            {{--});--}}
            {{--return valid;--}}
        {{--}--}}

        {{--$(document).ready(function () {--}}
            {{--// clear local storage to dump Sortable data - or it may display items out of order--}}
            {{--localStorage.clear();--}}
            {{--// magic 4 for now... this could change if given as an option--}}
            {{--var numValences = 4;--}}
            {{--// set up Sortable list--}}
            {{--var eList = document.getElementById('elementList');--}}
            {{--var editableList = Sortable.create(eList, {--}}
                {{--filter: '.js-remove',--}}
                {{--animation: 150,--}}
                {{--handle: '.handle',--}}
                {{--ghostClass: 'sortable-ghost',--}}
                {{--onFilter: function (evt) {--}}
                    {{--var el = editableList.closest(evt.item); // get dragged item--}}

                    {{--// show warning message on delete--}}
                    {{--bootbox.dialog({--}}
                        {{--message: "<span class='glyphicon glyphicon-warning-sign'></span> " +--}}
                        {{--"Warning: This will delete any scores associated with this element",--}}
                        {{--title: "Delete Element",--}}
                        {{--buttons: {--}}
                            {{--success: {--}}
                                {{--label: 'Cancel',--}}
                                {{--className: "btn-sm",--}}
                                {{--callback: function () {--}}
                                {{--}--}}
                            {{--},--}}
                            {{--danger: {--}}
                                {{--label: '<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Delete',--}}
                                {{--className: "btn-danger btn-sm",--}}
                                {{--callback: function () {--}}
                                    {{--deleteElement(el);--}}
                                {{--}--}}
                            {{--}--}}
                        {{--}--}}
                    {{--});--}}
                {{--},--}}
                {{--store: {--}}
                    {{--// store the ordering to localStorage--}}
                    {{--get: function (sortable) {--}}
                        {{--var order = localStorage.getItem(sortable.options.group);--}}
                        {{--return order ? order.split('|') : [];--}}
                    {{--},--}}
                    {{--set: function (sortable) {--}}
                        {{--var order = sortable.toArray();--}}
                        {{--localStorage.setItem(sortable.options.group, order.join('|'));--}}
                        {{--updateNumbers();--}}
                    {{--}--}}
                {{--}--}}
            {{--});--}}

            {{--// 'Customize responses': Copy base response into empty comments--}}
            {{--function registerCustomtizeHandlers() {--}}
                {{--$("[id^='commentForm']").on('shown.bs.modal', function () {--}}
                    {{--// find closest elementText and copy to all blank valences--}}
                    {{--var parent = $(this).closest("[id^='elementItem']");--}}
                    {{--var elementText = $(parent).find("[id^='elementText']").val();--}}

                    {{--for (var i = 0; i < numValences; i++) {--}}
                        {{--var valenceText = $(parent).find("[name$='valence" + i + "']");--}}
                        {{--if (valenceText.val() == '') {--}}
                            {{--valenceText.val(elementText);--}}
                        {{--}--}}
                    {{--}--}}
                {{--});--}}
            {{--}--}}

            {{--registerCustomtizeHandlers();--}}

            {{--// handle add element button--}}
            {{--document.getElementById("addElement").onclick = function () {--}}
                {{--// copy empty form--}}
                {{--var order = getElementCount() + 1;--}}
                {{--var myClone = $('#elementItem0').clone();--}}
                {{--// set values--}}

                {{--// add to editableList and refresh--}}
                {{--myClone.appendTo($("#elementList"));--}}
                {{--updateListItemData(myClone, order);--}}
                {{--updateNumbers();--}}
                {{--registerCustomtizeHandlers();--}}
            {{--};--}}

            {{--// update all elements--}}
            {{--function updateNumbers() {--}}

                {{--$('#elementForm').find("[id^='elementItem']").each(function (index, el) {--}}
                    {{--updateListItemData(el, (index + 1));--}}
                {{--});--}}
            {{--}--}}

            {{--// set all relevant names and ids of [item] to value [order]--}}
            {{--function updateListItemData(item, order) {--}}
                {{--$(item).attr('id', 'elementItem' + order);--}}
                {{--$(item).find('#displayNumber').text('Element #' + (order));--}}
                {{--$(item).find("[id^='elementName']").attr('id', 'elementName' + order);--}}
                {{--$(item).find("[id^='elementName']").attr('name', 'elementName' + order);--}}
                {{--$(item).find("[id^='elementText']").attr('id', 'elementText' + order);--}}
                {{--$(item).find("[id^='elementText']").attr('name', 'elementText' + order);--}}
                {{--$(item).find('#elementId').attr('name', 'elementId' + order);--}}

                {{--// update customizeResponse button and set which modal it opens--}}
                {{--$(item).find("[id^='btnCustomizeResponse']").attr('id', 'btnCustomizeResponse' + order);--}}
                {{--$(item).find("[id^='btnCustomizeResponse']").attr('data-target', '#commentForm' + order);--}}

                {{--// update items within comment_form--}}
                {{--$(item).find("[id^='commentForm']").attr('id', 'commentForm' + order);--}}

                {{--for (var i = 0; i < numValences; i++) {--}}
                    {{--$(item).find('#tab' + i).attr('href', '#e' + order + "area" + i);--}}
                    {{--var toFind = 'valence' + i;--}}
                    {{--$(item).find("[id$='area" + i + "']").attr('id', 'e' + order + 'area' + i);--}}
                    {{--$(item).find("[name$='" + toFind + "']").attr('name', "e" + order + toFind);--}}
                {{--}--}}
            {{--}--}}

            {{--function getElementCount() {--}}
                {{--return $('elementForm').find("[id^='elementItem']").length;--}}
            {{--}--}}

            {{--function deleteElement(el) {--}}
                {{--if (el && el.parentNode.removeChild(el))--}}
                    {{--updateNumbers();--}}
                {{--if (!numberOfElements())--}}
                    {{--bootbox.alert('A question can have no elements, however, students will not ' +--}}
                            {{--'receive written feedback');--}}
            {{--}--}}

            {{--return false;--}}
        {{--});--}}
    {{--</script>--}}
@endsection



