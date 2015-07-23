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
                            <a href="#" method="post">Done <span class="glyphicon glyphicon-chevron-right"
                                                                 aria-hidden="true"></span></a>
                        </li>
                    </ul>
                </nav>
                <h2 id="examName">{{ $examName }}: Add / Edit Questions</h2>
                <h5>Add the questions that will appear on this exam. When you're finished, press "done".</h5>


            <nav>
                <ul class="pager">
                    <li class="next">
                            <form method="GET" action="{{url('/element')}}" accept-charset="UTF-8" class="col-xs-8">
                            <div class="col-sm-11">
                            </div>

                            <div class="col-sm-1">
                                    <!-- <input type="submit" name="examid" value="$examid}}"> -->
                                <button type="submit" name="examid" value="{{$examid}}" class="btn btn-default btn-lg"> Next
                                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                </button>
                            </div>
                            </form>
                    </li>
                </ul>
            </nav>
            <div>
            <h2 id="examName"> {{ $examid}}  : Add / Edit Questions</h2>
            <h5>Add the questions that will appear on this exam. When you're finished, press "done".</h5>
            </div>
            <!-- this Div will become the question template -->
            <?php $num = 1; ?>
            @foreach($questions as $q)
                @include('setup.question_form')
                <?php $num += 1; ?>
            @endforeach
            <br>
            <a class="btn btn-primary" id="addQuestion"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
             Add Question</a>

            <button class="btn btn-primary" id="importQuestion"><span class="glyphicon glyphicon-import" aria-hidden="true"></span>
             Import Question</button>
        </div>
    </div>
 </div>

    @include('errors.list')

@endsection


@section('jsArea')
    <script type="text/javascript">

        /*
         *   Build javascript structure to hold objects.
         *   1. walk document to fill structure
         *
         *   constructor:
         *   element(int id, int order)
         *
         *   element.moveUp
         *   Create ajax requests when creating new elements
         *   later: create requests when re-ordering elements
         *
         */

        // i should be set to # of elements passed in
        var elements = [];
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
            var num = parseInt($div.prop("id").match(/\d+/g), 10) + 1;

            // Clone it and assign the new ID (i.e: from num 4 to ID "klon4")
            var newNum = 'question' + num;
            var $klon = $div.clone().prop('id', newNum);
//
            var $clone = $klon;
            //var $clone = $(id).clone();    // Create your clone

            // Get the number at the end of the ID, increment it, and replace the old id
            $clone.attr('id', $clone.attr('id').replace(/\d+$/, function (str) {
                return parseInt(str) + 1;
            }));

            // Find all elements in $clone that have an ID, and iterate using each()
            $clone.find('[id]').each(function () {

                //Perform the same replace as above
                var $th = $(this);
                var newID = $th.attr('id').replace(/\d+$/, function (str) {
                    return parseInt(str) + 1;
                });
                $th.attr('id', newID);
            });
            $("#elementContainer").append($klon);

            var qName = 'questionNumber' + newNum;
            // set the question number field
            $('#' + qName).text("CHECK");
            $('#questionName3').val("");
            $('#questionText3').val("");

            /*
             Create:
             Build new element object
             Build new div, set position to +1
             attach div to view
             */

            logDuplicates();

        }

        function deleteQuestion(elementId) {

            // send delete request to server

            // remove from page
            var element = document.getElementById(elementId);
            element.parentNode.removeChild(element);

            // loop through remaining and rename as needed
            var elements = document.querySelectorAll('[id^=question]');

            for (var i = 0; i < elements.length; i++) {
                //document.write(elements[i].toString());
            }
        }

        function addNew() {
            elements.push(new Element(elements.length+1));
            // set HTML tags for item and append to div
        }

        function remove(index) {
            elements.splice(index, 1);
            // remove item from display
            // set all tags to new values
        }

        // moves an element towards beginning of list
        function moveUp(index) {
            if (index == 0) return;
            swap(index, index-1);
            // update all ids
            // refresh view with new layout
        }

        // moves an element down towards the bottom of the list
        function moveDown(index) {
            if (index+1 >= elements.length ) return;
            swap(index, index+1);
            // update all ids
            // refresh view with new layout
        }

        function swap(a, b){
            var hold = elements[a].getPos();
            elements[a].setPos(elements[b].getPos());
            elements[b].setPos(hold);
            var temp = a;
            elements[a] = elements[b];
            elements[b] = temp;
        }
        // class to facilitate questions
        class Element {
            function Element(passedPos) {
                var id;
                var pos = passedPos;
                var name = '';
                var desc = '';
            }

            function getId() {
                return this.id;
            }

            function setId(newId) {
                this.id = newId;
            }

            function getPos() {
                return this.pos;
            }

            function setPos(position) {
                this.pos = position;
            }

            function getName() {
                return this.name;
            }

            function setName(newName) {
                this.name = newName;
            }

            function getDesc() {
                return this.desc;
            }

            function setDesc(newDesc) {
                this.desc = setDesc;
            }
        }

        function onLoad() {
            // create some test elements
            for (var i = 0; i < 2; i++) {
                elements.push(new Element((i+1), (i+1)));
                elements[i].setDesc = "test desc #" + (i+1);
                elements[i].setName = "test name #" + (i+1);
            }
        }
        onLoad();
    </script>

@endsection


