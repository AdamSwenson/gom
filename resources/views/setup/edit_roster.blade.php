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
@section('description', 'Upload or modify student roster')

@section('cssLinks')

@endsection

@section('body')
 <div id="editRoster">
  <div class="section">
   <div class="container">
    <nav>
     <ul class="pager">
      <li class="next">
       <a href="#">Done <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a>
      </li>
     </ul>
    </nav>
    <h2>Import Roster</h2>
    <p>
     Student rosters should be a text or .csv file with each student's information on a single row in the following format:</p>
    <p>Last Name, First Name, Student ID, Email</p>
    <button class="btn btn-primary" id="addQuestion"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
     Select File</button>

    <!-- this div will hold the roster table and controls for editing students -->
    <div>

    </div>

    <h2>Edit Roster</h2>
    <div class="container">
     <table class="table table-striped">
      <thead>
      <tr>
       <th>Firstname</th>
       <th>Lastname</th>
       <th>Student ID</th>
       <th>Email</th>
      </tr>
      </thead>
      <!-- temp data to give a sense of a short roster -->
      <tbody>
      <tr>
       <td>John</td>
       <td>Doe</td>
       <td>123456789</td>
       <td>john@example.com</td>
      </tr>
      <tr>
       <td>Mary</td>
       <td>Moe</td>
       <td>123456789</td>
       <td>mary@example.com</td>
      </tr>
      <tr>
       <td>July</td>
       <td>Dooley</td>
       <td>123456789</td>
       <td>july@example.com</td>
      </tr>
      <tr>
       <td>James</td>
       <td>Corn</td>
       <td>123456789</td>
       <td>corneyJames@example.com</td>
      </tr>
      <tr>
       <td>Skip</td>
       <td>Johnson</td>
       <td>123456789</td>
       <td>weathermanSkip@example.com</td>
      </tr>
      </tbody>
     </table>
    </div>
    <button class="btn btn-warning" id="addQuestion"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
     Delete Roster</button>
   </div>
  </div>
 </div>

 @include('errors.list')

@endsection


@section('jsArea')


@endsection


