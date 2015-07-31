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


@endsection


