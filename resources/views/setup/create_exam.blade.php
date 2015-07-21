<!--
/**
 * Created by PhpStorm.
 * User: Brian
 * Date: 7/20/2015
 * Time: 5:05 PM
 */
 -->

<!--
/**
 * Created by PhpStorm.
 * User: Brian
 * Date: 7/17/2015
 * Time: 4:59 PM
 */
 -->

@extends('layouts.master')

@section('pageTitle', 'Create Exam')
@section('description', 'create an exam')

@section('cssLinks')

@endsection

@section('body')

    <div id="editExam">
        <div class="section">
            <div class="container">
                <nav>
                    <ul class="pager">
                        <li class="next">
                            <a href="#">Next <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a>
                        </li>
                    </ul>
                </nav>
                <h2>Create Exam</h2>

                @include('setup.exam_form')
            </div>
        </div>
    </div>

    @include('errors.list')

@endsection


@section('jsArea')


@endsection


