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

@section('pageTitle', 'Empty')
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
                        <a href="#">Done <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a>
                    </li>
                </ul>
            </nav>
            <h2 id="examName">Exam Name: Add / Edit Questions</h2>
            <h5>Add the questions that will appear on this exam. When you're finished, press "done".</h5>

            <!-- this Div will become the question template -->
            @include('setup.question_form')
            <br>
            <button class="btn btn-primary" id="addQuestion"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
             Add Question</button>
            <button class="btn btn-primary" id="importQuestion"><span class="glyphicon glyphicon-import" aria-hidden="true"></span>
             Import Question</button>
        </div>
    </div>
 </div>

 @include('errors.list')

@endsection


@section('jsArea')


@endsection


