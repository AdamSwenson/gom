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
                            <a href="#" method="post">Done <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a>
                        </li>
                    </ul>
                </nav>
                <h2 id="examName">{{ $examName }}: Add / Edit Questions</h2>
                <h5>Add the questions that will appear on this exam. When you're finished, press "done".</h5>

                <!-- this Div will become the question template -->
                <div id="elementContainer">
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
        var original = document.getElementById('question1');

        function logDuplicates() {
            var nodes = document.querySelectorAll('[id]');
            var ids = {};
            var totalNodes = nodes.length;

            for (var i = 0; i < totalNodes; i++) {
                var currentId = nodes[i].id ? nodes[i].id : "undefined";
                if (isNaN(ids[currentId])) {
                    ids[currentId] = 0;
                }
                ids[currentId]++;
            }
            console.log(ids);
        }


        function duplicateQuestion() {
            /*
            var clone = original.cloneNode(true);
            clone.id = 'item' + ++i;
            original.parentNode.appendChild(clone);
            */

            var $div = $('div[id^="question"]:last');

// Read the Number from that DIV's ID (i.e: 3 from "klon3")
// And increment that number by 1
            var num = parseInt( $div.prop("id").match(/\d+/g), 10 ) +1;

// Clone it and assign the new ID (i.e: from num 4 to ID "klon4")
            var newNum = 'question'+num;
            var $klon = $div.clone().prop('id', newNum );
//
            var $clone = $klon;
            //var $clone = $(id).clone();    // Create your clone

            // Get the number at the end of the ID, increment it, and replace the old id
            $clone.attr('id',$clone.attr('id').replace(/\d+$/, function(str) { return parseInt(str) + 1; }) );

            // Find all elements in $clone that have an ID, and iterate using each()
            $clone.find('[id]').each(function() {

                //Perform the same replace as above
                var $th = $(this);
                var newID = $th.attr('id').replace(/\d+$/, function(str) { return parseInt(str) + 1; });
                $th.attr('id', newID);
            });
            $("#elementContainer").append($klon);

            var qName = 'questionNumber' + newNum;
            // set the question number field
            $('#' + qName).text("CHECK");
            $('#questionName3').val("");
            $('#questionText3').val("");




            logDuplicates();

        }

        function deleteQuestion(elementId) {

            // send delete request to server

            // remove from page
            var element = document.getElementById(elementId);
            element.parentNode.removeChild(element);

            // loop through remaining and rename as needed
            var elements = document.querySelectorAll('[id^=question]');

            for(var i = 0; i < elements.length; i++) {
                //document.write(elements[i].toString());
            }
        }
    </script>

@endsection


