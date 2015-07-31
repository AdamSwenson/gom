<!--
/**
 * Created by PhpStorm.
 * User: Brian
 * Date: 7/17/2015
 * Time: 4:59 PM
 */


 -->

@extends('layouts.master')

@section('pageTitle', 'Edit Elements')
@section('description', 'create or edit elements')

@section('cssLinks')

@endsection

@section('body')
    <div id="editElement">
        <div class="section">
            <div class="container">
                <nav>
                    <ul class="pager">
                        <li class="previous">
                            <a href="#"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                Previous Question</a>
                        </li>
                        <li class="next">
                            <a href="#">Next Question <span class="glyphicon glyphicon-chevron-right"
                                                            aria-hidden="true"></span></a>
                        </li>
                    </ul>
                </nav>
                <h2>Question #<span id="questionNumber">1</span>: Add / Edit Elements</h2>
                <h5>Each question is composed of one or more elements, representing individual items that the student
                    should address.</h5>
                <div id="container">
                @include('setup.element_form')
                </div>

                        <!-- Add element button will sit below all current elements-->
                <br>
                <button class="btn btn-primary" id="addElement" onclick="duplicateElement()"><span
                            class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    Add Element
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
        var original = document.getElementById('elementForm');

        function duplicateElement() {
            var clone = original.cloneNode(true);
            var newId = 'addElement' + ++i;
            clone.id = newId;
            original.parentNode.appendChild(clone);
            clone.querySelector('elementNumber').style.display = 14;

        }

        function deleteElement(elementId) {
            var element = document.getElementById(elementId);
            element.parentNode.removeChild(element);
        }
    </script>

@endsection


