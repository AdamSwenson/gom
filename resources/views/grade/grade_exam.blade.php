@extends('layouts.master')

@section('pageTitle', 'Grade Exam')
@section('description', 'Grade the exam')
@section('cssLinks')
    {!! \HTML::style(asset('/css/grade.css')) !!}
@endsection

@section('body')
    <div id="grade-app" class="container">
        @if(!empty($currentStudent))
        <input type="hidden"
               name="studentId"
               v-model="current-student-id"
               value="{{ $currentStudent->id}}"/>
        <input type="hidden"
               v-model="current-student-name"
               value="{{ ($currentStudent->last_name . ', ' . $currentStudent->first_name)}}"/>
        <input type="hidden"
               v-model="current-student-identifier"
               value="{{ $currentStudent->student_identifier}}"/>
@endif
        <div class="row">
            <!-- Left column holds questions and sliders -->
            <div class="col-md-8">
                <h3 v-show="currentQuestion">@{{ currentQuestion }}</h3>
                <!-- Centered Question Pills -->
                <ul class="nav nav-pills nav-justified">
                    @foreach($scores as $s)
                        <li role="presentation">
                            <a href="#q{{ $s->questionNumber }}-panel"
                               v-on="click: currentQuestion = '{{ $s->questionName }}'"
                               data-toggle="tab">Q{{$s->questionNumber}}
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="tab-content">
                            @include('grade.element_slider')
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right column holds Roster and Time info -->
            <div class="col-md-4">
                <!-- student name and / or ID -->
                <div class="row">
                    <current-student current-student-id="{{ $currentStudent->id or '' }}"
                                     current-student-identifier="{{ $currentStudent->identifier or '' }}"
                                     current-student-first-name="{{ $currentStudent->first_name or '' }}"
                                     current-student-last-name="{{ $currentStudent->last_name or '' }}">
                    </current-student>

                    {{--<div class="col-md-6">--}}
                    {{--<h4 id="student-name"><span class="glyphicon glyphicon-pencil"> </span> John Doe</h4>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-6">--}}
                    {{--<h4 id="student-id">ID 123456789</h4>--}}
                    {{--</div>--}}
                </div>

                <graded-remaining
                        number-exams-graded="{{ $stats[0]->totalGraded or 'N/A' }}"
                        number-exams-remaining="{{ $stats[0]->remainingExams or 'N/A' }}">
                </graded-remaining>

                <!-- student table -->
                @include('grade.student_table')

                        <!-- timing and data -->
                @include('grade.statistics_table')

            </div>
        </div>
        <br/>
        <pre>@{{$data | json  }}</pre>

    </div>

    @endsection


    @section('jsArea')

            <!-- bootstrap sliders -->
    {{--<link href="{{// asset('inc/css/slider.css') }}" rel="stylesheet">--}}
    {{--<script type='text/javascript' src="{{// asset('inc/js/bootstrap-slider.js') }}"></script>--}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/0.12.10/vue.js"></script>
    {!! \Html::script(asset('/js/grade-package.js')) !!}
    <script type="text/javascript">

        $(document).ready(function () {
//            var mySlider = $("input.slider").slider();

            // Call a method on the slider
            //var value = mySlider.bootstrapSlider('getValue');
        });
    </script>
@endsection
