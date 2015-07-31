<!--
/**
 * Created by PhpStorm.
 * User: Brian
 * Date: 7/17/2015
 * Time: 4:59 PM
 */
 -->

@extends('layouts.master')

@section('pageTitle', 'Edit Roster')
@section('description', 'Upload or modify student roster')

@section('cssLinks')
    <script src="{{asset("inc/js/rosterTable.js")}}">
    </script>
@endsection

@section('body')
    <div id="editRoster">
        <div class="section">
            <div class="container">
                <form >
                <nav>
                    <ul class="pager">
                        <li class="next">

                            <a href="#">Done <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a>

                        </li>
                    </ul>
                </nav>
                <h2>Import Roster</h2>
                <p>
                    Student rosters should be a text or .csv file with each student's information on a single row in the
                    following format:</p>
                <p>Last Name, First Name, Student ID, Email</p>

                <input type="file" name="file" style="visibility:hidden;" id="file" onchange='handleFileSelect();' /><br/>

                <button class="btn btn-primary" onclick="$('#file').click();"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        Select File
                </button>

                <label>File Name:</label><input name="fileName" id="fileName" type="text" disabled value="">
                </form>

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
                        <!--javascript populates table here -->

                        </tbody>
                    </table>
                </div>
                <button class="btn btn-warning" onclick="deleteRoster()" id="deleteRoster"><span class="glyphicon glyphicon-minus"
                                                                       aria-hidden="true"></span>
                    Delete Roster
                </button>


            </div>
        </div>
    </div>

    @include('errors.list')

@endsection


@section('jsArea')


@endsection


