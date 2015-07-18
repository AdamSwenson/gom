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

@section('cssLinks')

@endsection

@section('body')
 <div id="editElement">
  <div class="section">
   <div class="container">
    <nav>
     <ul class="pager">
      <li class="previous">
       <a href="#"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Previous Question</a>
      </li>
      <li class="next">
       <a href="#">Next Question <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a>
      </li>
     </ul>
    </nav>
    <h2>Question #1: Add / Edit Elements</h2>
    <h5>Each question is composed of one or more elements, representing individual items that the student should address.</h5>

    <!-- this Div will become the element template -->
    <div id="elementPane">
     <h4>Element #1</h4>
     <div class="input-group">
      <span class="input-group-addon" id="elementLabel">Element Name</span>
      <input id="elementName" type="text" class="form-control input-lg"
             placeholder="(Optional) Enter a short reminder for this element, i.e. &quot;Economic causes of the Civil War&quot; "
             aria-describedby="basic-addon1">
     </div>
     <h5>Element Response</h5>
     <div class="form-group">
      <textarea class="form-control" rows="4" id="questionText" placeholder="Explain in detail what needed to be done in order to fully answer this element. This will form the basis for the response seen by the student."></textarea>
     </div>
     <button class="btn btn-default" id="moveUp"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>
     </button>
     <button class="btn btn-default" id="moveDown"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>
     </button>
     <button class="btn btn-info" id="customizeElement" data-toggle="modal" data-target="#customizeResponse">
      <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
      Customize Responses</button>

     <!-- this Modal should be broken out into a template to handle custom responses -->
     <!-- Modal -->
     <div class="modal fade" id="customizeResponse" role="dialog">
      <div class="modal-dialog">

       <!-- Modal content-->
       <div class="modal-content">
        <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h2 class="modal-title">Customize Responses</h2>
         Modify the feedback students receive based on their performance
        </div>
        <!-- tabbed area for responses -->
        <div class="modal-body">
         <ul class="nav nav-pills">
          <li role="presentation" class="active"><a href="#">Missing</a></li>
          <li role="presentation"><a href="#">Poor</a></li>
          <li role="presentation"><a href="#">Fair</a></li>
          <li role="presentation"><a href="#">Good</a></li>
         </ul>
         <div id="customResponse">
          <textarea class="form-control" rows="4" id="questionText" placeholder="You forgot to include this part in your response."></textarea>
         </div>
        </div>
        <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal">Save</button>
        </div>
       </div>
      </div>
     </div>

     <button class="btn btn-warning" id="deleteElement"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
      Delete</button>
     <br>
    </div>
    <!-- Add element button will sit below all current elements-->
    <button class="btn btn-primary" id="addElement"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
     Add Element</button>
   </div>
  </div>
 </div>

@endsection


@section('jsArea')


@endsection


