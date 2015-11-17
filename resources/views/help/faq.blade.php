@extends('help.help_base')

@section('sideNav')
    @include('help.navs.faq_navbar')
@endsection

@section('mainText')
    <h3><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Gradeomatic FAQ</h3>

    <div class="infoItem">
        <p class="lead"><b>Q.</b> Where can I get help?</p>

        <p>Check the <a href="#help">help section</a> for basic information on how to use the site.</p>

        <p>Our growing library of <a href="{{ url('/tutorials') }}">tutorial videos</a> may also help.</p>
    </div>


    <div class="panel panel-default">
        <section id="setupFaq" class="group">
            <div class="panel-heading">
                <h3>Setting up the questions, elements, and other exam components</h3>
            </div>
        </section>
        <div class="panel-body">
            @include('help.components_faq.faq_setup')
        </div>
    </div>


    <div class="panel panel-default">
        <section id="gradeFaq" class="group">
            <div class="panel-heading">
                <h3>Grade</h3>
            </div>
        </section>
        <div class="panel-body">
            @include('help.components_faq.faq_grade')
        </div>
    </div>


    <div class="panel panel-default">
        <section id="reportFaq" class="group">
            <div class="panel-heading">
                <h3>Report</h3>
            </div>
        </section>
        <div class="panel-body">
            @include('help.components_faq.faq_report')
        </div>
    </div>


    <div class="panel panel-default">
        <section id="otherFaq" class="group">
            <div class="panel-heading">
                <h3>Other</h3>
            </div>
        </section>
        <div class="panel-body">
            @include('help.components_faq.faq_other')
        </div>
    </div>

@endsection