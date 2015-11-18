<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 10/3/15
 * Time: 1:39 PM
 */ ?>
@extends('help.help_base')

@section('title')
    Video tutorials
@endsection

@section('description')
    Video tutorials
@endsection


@section('sideNav')
    @include('help.navs.video_navbar')
@endsection


@section('mainText')

    <h3>Please excuse the quality for now. These are very rough. We'll make nicer ones later</h3>

    <section id="{{\App\ViewTools\HelpLinks::$videoAllSetup['id']}}" class="group">
        <div class="panel panel-default">

            <div class="panel-heading">
                <h2>Setting up the questions, elements, and other exam components</h2>
            </div>

            <div class="panel-body">
                <section id="{{\App\ViewTools\HelpLinks::$videoExamSetup['id']}}">
                    <h4>Setting up the exam</h4>

                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item"
                                src="//www.screencast.com/users/gradeomatic/folders/Camtasia/media/1fea769f-0420-4902-8cdc-20249285642b/embed"></iframe>
                    </div>
                </section>

                <section id="{{\App\ViewTools\HelpLinks::$videoRosterUpload['id']}}">
                    <h4>Uploading roster</h4>

                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item"
                                src="//www.screencast.com/users/gradeomatic/folders/Camtasia/media/698ec7a7-4005-4800-9b00-4a423d2d2310/embed"></iframe>
                    </div>
                </section>
            </div>
        </div>
    </section>


    <section id="{{\App\ViewTools\HelpLinks::$videoAllGrade['id']}}" class="group">
        <div class="panel panel-default">

            <div class="panel-heading">
                <h2>Grade</h2>
            </div>

            <div class="panel-body">
                <section id="{{\App\ViewTools\HelpLinks::$videoGrading['id']}}}}">
                    <h4>Grading the exam</h4>

                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item"
                                src="//www.screencast.com/users/gradeomatic/folders/Camtasia/media/1d7af15f-f9ec-4b2f-9054-8ad9cb27583c/embed"></iframe>
                    </div>
                </section>
            </div>
        </div>
    </section>


    <section id="{{\App\ViewTools\HelpLinks::$videoAllReport['id']}}" class="group">
        <div class="panel panel-default">

            <div class="panel-heading">
                <h2>Report</h2>
            </div>
            <div class="panel-body">
                <p>No videos yet</p>
            </div>
        </div>
    </section>


    <section id="{{\App\ViewTools\HelpLinks::$videoAllOther['id']}}" class="group">
        <div class="panel panel-default">

            <div class="panel-heading">
                <h2>Other</h2>
            </div>

            <div class="panel-body">
                <p>No videos yet</p>
            </div>
        </div>
    </section>
@endsection