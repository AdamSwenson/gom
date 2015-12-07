@extends('help.help_base')

@section('sideNav')
    @include('help.navs.faq_navbar')
@endsection

@section('mainText')
    <h2><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Gradeomatic FAQ</h2>

    <section class="group">
        <div class="panel panel-default">


            <div class="infoItem">
                <p class="lead"><b>Q.</b> Where can I get help?</p>

                <p>Check the <a href="{{url('info/instructions')}}">instructions page</a> for basic information on how
                    to use the site.</p>

                <p>Our growing library of <a href="{{ url('info/tutorials') }}">tutorial videos</a> may also help.</p>

                <p>You may also contact us at {{ env('CONTACT_EMAIL') }}. We will make every effort to reply as quickly
                    as we can. But please be aware that, right now, we have no employees. So it is unlikely that we will be able to
                    reply right away. </p>
            </div>
        </div>
    </section>
    <section id="{{\App\ViewTools\HelpLinks::$faqSectionSetup['id']}}" class="group">
        <div class="panel panel-default">

            <div class="panel-heading">
                <h3>Setting up the questions, elements, and other exam components</h3>
            </div>

            <div class="panel-body">
                @include('help.components_faq.faq_setup')
            </div>
        </div>
    </section>


    <section id="{{\App\ViewTools\HelpLinks::$faqSectionGrade['id']}}" class="group">
        <div class="panel panel-default">

            <div class="panel-heading">
                <h3>Grade</h3>
            </div>

            <div class="panel-body">
                @include('help.components_faq.faq_grade')
            </div>
        </div>
    </section>


    <section id="{{\App\ViewTools\HelpLinks::$faqSectionReport['id']}}" class="group">
        <div class="panel panel-default">

            <div class="panel-heading">
                <h3>Report</h3>
            </div>
            <div class="panel-body">
                @include('help.components_faq.faq_report')
            </div>
        </div>
    </section>


    <section id="{{\App\ViewTools\HelpLinks::$faqSectionOther['id']}}" class="group">
        <div class="panel panel-default">

            <div class="panel-heading">
                <h3>Other</h3>
            </div>
            <div class="panel-body">
                @include('help.components_faq.faq_other')
            </div>
        </div>
    </section>
@endsection