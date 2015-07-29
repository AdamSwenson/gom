@extends('layouts.primalMaster')

@section('pageTitle', 'Create exam')

@section('cssLinks')
  <link rel="stylesheet" type="text/css" href="<?php echo asset("inc/css/navMenuStyles.css");?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo asset("inc/css/standardStyles.css");?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo asset("inc/css/examCreateStyles.css");?>" />
@endsection

@section('body')
    <div class="pageComponent" id="examSetupArea">
        <div id="submitStatus"></div>
        <div class="examCreationArea">
            <div class="examCreationDiv"><label class="creationSelectorLabel" for="term">Term</label>
                <input id="term" name="term" class="term termSelect" type="text">
                <select id="term_select" data="term" class="newExamSelect term termSelect">
                    <option data="alias" value="alias">alias</option>
                </select>
            </div>
            <div class="examCreationDiv">
                <label class="creationSelectorLabel" for="year">Year</label>
                <input id="year" name="year" class="year yearTopicSelect" type="text">
                <select id="year_select" data="year" class="newExamSelect year yearTopicSelect">
                </select>
            </div>

            <div class="examCreationDiv"><label class="creationSelectorLabel" for="examTopic">Topic</label>
                <input id="examTopic" name="examTopic" class="examTopic examTopicSelect" type="text">
                <select id="examTopic_select" data="examTopic" class="newExamSelect examTopic examTopicSelect">
                </select>
            </div>
        </div>

        <div class="examCreateButtonArea">
            <input role="button" id="createExam" class="prettyButton" value="Create" type="button">
        </div>
    </div>
@endsection

@section('jsArea')
    <script type="text/javascript" src="<?php echo asset("inc/js/common.js");?>"></script>
    <script type="text/javascript" src="<?php echo asset("inc/js/examSetup.js");?>"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var scripts = [
                "inc/js/common.js",
                "inc/js/examSetup.js"
            ];

            /**
             * Do any styling or activities required by the page
             * @returns {undefined}
             */
            function onLoad() {
                $('.navMenuItem').menu();
                $('.prettyButton').button();
                bindListeners();
                console.log('onload fired');
            }
//$(".newExamSelect").bind("change", function(){
//
//    var target = $(this).attr('data');
//    var toSet = $(this).val();
//    window.console.log(target, toSet);
//        $('#' + target).val(toSet);
//});
//$( "#year_select" ).selectmenu({
//select: function( event, ui ) {
////    var yr = $(ui).val();
//    window.console.log(ui);
//}
//}).selectmenu( "menuWidget" )
//.addClass( "overflow" );;

            //                        $(".examSelect").selectmenu();
            //        $(".examSelect").selectmenu({appendTo:"#examXclassExams"});
            //$('#examXclassExams').selectmenu();

           // scriptLoader(scripts, scripts.length, onLoad, 0);
onLoad();
//                    scriptLoader(scripts.length, 0);
        });
    </script>

@endsection