@extends('layouts.master')

@section('pageTitle', 'Create and setup tasks')

@section('cssLinks')
    <link href="<?php echo asset('inc/css/navMenuStyles.css');?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo asset("inc/css/standardStyles.css");?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo asset("inc/css/commentsetup_new.css");?>" type="text/css" rel="stylesheet"/>
@endsection

@section('body')
    @include("layouts.topbar")
    <div class="pageComponent">

        @for ($qnum = 1; $qnum <= $numberOfQuestions; $qnum++)
            <div class="accordion">
                <h3><a href="#">Q{{$qnum}} No title for now</a></h3>
                <div id='q{{$qnum}}_setup_area' class='commentSetupArea' data="{{$qnum}}">
                    @for($subnum = 1; $subnum <= $numberOfSubtasks; $subnum++)
                        <div id='q{{$qnum}}_sub{{$subnum}}_area' data-questionNumber='{{$qnum}}' data-subtask='{{$subnum}}' class='subtaskArea'>
                            <div class='taskNum'>
                                {{$subnum}} <br/>
                                <div id="s{{$qnum}}_{{$subnum}}_status" class="updateStatus"></div>
                            </div>

                            <div data-elementid="" class="subtask draggable ui-draggable ui-draggable-handle"
                                 id="s{{$qnum}}_{{$subnum}}" style="position: relative;">
                                <div class="subtaskPart elementInfo">
                                    <div class="elementNamesArea">
                                        <div class="elementTextHolder">
                                            <label for="s{{$qnum}}_{{$subnum}}_displayText">Text to display while
                                                grading</label><br>
                                            <input type="text" id="s{{$qnum}}_{{$subnum}}_displayText"
                                                   class="displayText">
                                        </div>
                                        <div class="elementNicknameHolder">
                                            <label for="s{{$qnum}}_{{$subnum}}_element">Task Nickname</label> <br>
                                            <input type="text" class="elementName" id="s{{$qnum}}_{{$subnum}}_element">
                                            <input type="hidden" id="s{{$qnum}}_{{$subnum}}_elementID" value="">
                                        </div>
                                    </div>
                                    <div class="elementSelectArea">
                                        <select data="s{{$qnum}}_{{$subnum}}" id="s{{$qnum}}_{{$subnum}}_element_select"
                                                class="elementSelect">
                                            <option>--past exam subtasks--</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="s{{$qnum}}_{{$subnum}}_commentArea" class="centralComment subtaskPart">
                                    <label for="s{{$qnum}}_{{$subnum}}_commentID">What students needed to do</label><br>
                                    <input type="hidden" class="commentID" id="s{{$qnum}}_{{$subnum}}_commentID"
                                           value="1">
                                    <textarea id="s{{$qnum}}_{{$subnum}}_comment" class="centralComment commentText"
                                              cols="80" rows="6"></textarea>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        @endfor
    </div>

    <div class="errorArea"></div>
    <div class="pageComponent buttonArea">
        <input type="button" class="prettyButton ui-button ui-widget ui-state-default ui-corner-all" value="Record"
               id="commentsCreate" role="button">
    </div>
    <div class="notes">
        <p>
            Nickname is optional to help reuse questions. If left blank, question will get default nickname
            (exam#question#)
        </p>
    </div>

@endsection

@section('jsArea')
    <script type="text/javascript">var API = 'api';
        var COOKIE_PAGENAME = 'examcreate'; </script>
    <script type="text/javascript" src="{{asset("inc/js/common.js")}}"></script>
    <script type="text/javascript" src="{{asset("inc/js/examchoicebutton.js")}}"></script>
    <script type="text/javascript" src="{{asset("inc/js/commentSetup.js")}}"></script>


    <div id="scriptTemplates">
        <script type="text/x-jQuery-tmpl" id="ExamKumiOptionTemplate">
        &lt;option data='${classID}${examID}' value='${classID}${examID}'&gt;${year}  ${term}  ${course}  ${section}  ${examTopic}&lt;/option&gt;
    




        </script>

        <script type="text/x-jQuery-tmpl" id="ExamKumiListTemplate">
        &lt;li data='${classID}${examID}'&gt;${year}  ${term}  ${course}  ${section}  ${examTopic}&lt;/li&gt;
    




        </script>

        <script type="text/x-jQuery-tmpl" id="restrictorOptionTemplate">
        &lt;option data='${type}' value='${value}' class='${type}'&gt;${value}&lt;/option&gt;
    




        </script>

        <script type="text/x-jQuery-tmpl" id="restrictorListTemplate">
        &lt;li class='${type} restrictorListItem' data='${value}'&gt;
            ${value} &lt;input type='button' class='restrictorDelete prettyButton' value='Delete' data='${value}' /&gt;
        &lt;/li&gt;
    




        </script>

        <script type="text/x-jQuery-tmpl" id="lockedRestrictorListTemplate">
        &lt;li class='${type} restrictorListItem' data='${value}'&gt;
            ${value} &lt;span class="ui-icon ui-icon-locked" style="display: inline-block"&gt;&lt;/span&gt;
        &lt;/li&gt;
    




        </script>
    </div>
    <!--templates-->
    <script type="text/javascript">
        var comments = <?php echo json_encode($allComments,  \JSON_FORCE_OBJECT);?>;
        var currentExamComments = <?php echo json_encode($currentComments, \JSON_FORCE_OBJECT);?>;

    </script>
    <script type="text/javascript">


        </script>

    <script type="text/javascript">
        $(document).ready(function () {
            var scripts = [
                "inc/js/common.js",
                "inc/js/commentSetup.js",
                "inc/js/examchoicebutton.js"
            ];

            /**
             * Do any styling or activities required by the page
             * @returns {undefined}
             */
            function onLoad() {
                $('.navMenuItem').menu();
                $(".accordion").accordion();
                $('.prettyButton').button();
                $(".spinner").spinner({
                    min: 0,
                    max: 10,
                    numberFormat: "n",
                    step: 0.25
                });

                $(".draggable").draggable({opacity: 0.35});
//                                        $(".draggable").draggable({snap: '.subtaskArea'});
                $(".subtaskArea").droppable({
                    accept: '.draggable',
                    drop: function (event, ui) {
                        $(event.target).append($(ui.draggable).detach());
                    }
                });

                console.log(comments.length);
                if (!comments) {
                    console.log('no comments');
                    $.post("api", {'task': 'getAllComments'}, function (response) {
                        console.log(response.data);
                    }, "JSON");
                }
                addComments(comments);
                if (currentExamComments.length != 0) {
                    var elements = processElementJson(currentExamComments);
                    $.each(elements, function () {
                        displayExisting(this);
                    });
                } else {
                    $.post("api", {'task': 'getCurrentExamComments'}, function (response) {
                        console.log('from server', response.data);
                        var elements = processElementJson(response.data);
                        if (elements.length != 1) {
                            $.each(elements, function () {
                                displayExisting(this);
                            });
                        } else {
                            $(".errorArea").append("Please assign some questions to the exam first. ");
                        }
                    }, "JSON");
                }
                bindListeners();
                bindExamEventListeners();
                console.log('onload fired');
            }

            onLoad();
            //  scriptLoader(scripts, scripts.length, onLoad, 0);
        });
    </script>
@endsection