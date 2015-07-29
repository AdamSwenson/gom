@extends('layouts.primalMaster')

@section('pageTitle', 'Create and setup questions')

@section('cssLinks')
    <link rel="stylesheet" type="text/css" href="<?php echo asset("inc/css/navMenuStyles.css");?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo asset("inc/css/standardStyles.css");?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo asset("inc/css/examCreateStyles.css");?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo asset("inc/css/questionmanagerStyles.css");?>"/>
@endsection

@section('body')
    @include("layouts.topbar")
    <div class="pageComponent">

        @for ($qnum = 1; $qnum <= $numberOfQuestions; $qnum++)
            <div id='q{{$qnum}}_area' class='questionArea'>
                <div class='{{$qnum}}_class questionSetupPart'>Q{{$qnum}}</div>
                <div class="questionText questionSetupPart">
                    <label for="{{$qnum}}" class="questionTextLabel">Question text</label><br/>
                    <textarea cols=50 rows=5 id="q{{$qnum}}_text" class="questionTextArea"></textarea>
                </div>
                <div class='questionTitle questionSetupPart'>
                    <label for='q{{$qnum}}_name' class='questionNameLabel'>Question Nickname</label> <br/>
                    <input type='text' id='q{{$qnum}}_name' class='questionName'/>
                    <input type="hidden" id='q{{$qnum}}_questionID' data='{{$qnum}}' value=''/> <br/>
                    <select id='q{{$qnum}}_select' class='questionSelect' data='{{$qnum}}'>
                        <option>---questions used on past exams---</option>
                    </select>
                </div>
            </div>
        @endfor

    </div>
    <div id="statusArea"></div>
    <div class="pageComponent buttonArea">
        <input id="questionCreate" value="Create questions" class="prettyButton" type="button">
    </div>
@endsection


@section('jsArea')
    <input id="formToken" name="formToken" data="questionsetup"
           value="efc3fcac85b0b326eb6b5f5dfc98b6a94be5888412b575cd8f275cf545a742e8" type="hidden">

    <div id="scriptTemplates">
        <script id="ExamKumiOptionTemplate" type="text/x-jQuery-tmpl">
        <option data='${classID}${examID}' value='${classID}${examID}'>${year}  ${term}  ${course}  ${section}  ${examTopic}</option>


        </script>

        <script id="ExamKumiListTemplate" type="text/x-jQuery-tmpl">
        <li data='${classID}${examID}'>${year}  ${term}  ${course}  ${section}  ${examTopic}</li>


        </script>

        <script id="restrictorOptionTemplate" type="text/x-jQuery-tmpl">
        <option data='${type}' value='${value}' class='${type}'>${value}</option>


        </script>

        <script id="restrictorListTemplate" type="text/x-jQuery-tmpl">
        <li class='${type} restrictorListItem' data='${value}'>
            ${value} <input type='button' class='restrictorDelete prettyButton' value='Delete' data='${value}' />
        </li>


        </script>

        <script id="lockedRestrictorListTemplate" type="text/x-jQuery-tmpl">
        <li class='${type} restrictorListItem' data='${value}'>
            ${value} <span class="ui-icon ui-icon-locked" style="display: inline-block"></span>
        </li>


        </script>
    </div>
    <!--templates-->
    <script type="text/javascript" src="<?php echo asset("inc/js/common.js");?>"></script>
   <script type="text/javascript" src="<?php echo asset("inc/js/examchoicebutton.js");?>"></script>
   <script type="text/javascript" src="<?php echo asset("inc/js/questionSetup.js");?>"></script>
    <script type="text/javascript">
        var questions;
        var currentExamQuestions;
        questions = {
            "0": {
                "questionID": 1,
                "questionName": "dolores",
                "questionText": "Quasi sequi et vero error porro corrupti."
            },
            "1": {
                "questionID": 2,
                "questionName": "voluptates",
                "questionText": "Ea eveniet voluptatem iure explicabo."
            },
            "2": {
                "questionID": 3,
                "questionName": "eligendi",
                "questionText": "Assumenda eos dolorem eius deserunt iure."
            },
            "3": {"questionID": 4, "questionName": "ea", "questionText": "Esse qui expedita beatae."},
            "4": {"questionID": 5, "questionName": "in", "questionText": "Officia quis repellat pariatur."},
            "5": {
                "questionID": 6,
                "questionName": "totam",
                "questionText": "Quam sint rem nam ducimus et est dolorem."
            },
            "6": {
                "questionID": 7,
                "questionName": "eos",
                "questionText": "Est placeat et vero veniam maxime doloremque cum."
            },
            "7": {"questionID": 8, "questionName": "at", "questionText": "Beatae sunt quidem placeat maiores."},
            "8": {
                "questionID": 9,
                "questionName": "eveniet",
                "questionText": "Vel qui corporis unde sed optio suscipit."
            },
            "9": {"questionID": 10, "questionName": "porro", "questionText": "Odit velit excepturi sunt vero."},
            "10": {
                "questionID": 11,
                "questionName": "libero",
                "questionText": "Voluptatem quo doloremque nesciunt non cumque."
            },
            "11": {
                "questionID": 12,
                "questionName": "officiis",
                "questionText": "Id error ipsa totam molestias molestias."
            },
            "12": {"questionID": 13, "questionName": "officia", "questionText": "Qui doloremque dolorem autem."},
            "13": {"questionID": 14, "questionName": "ipsa", "questionText": "Odio sed vitae repudiandae."},
            "14": {"questionID": 15, "questionName": "cumque", "questionText": "Sint fugiat est dolores."},
            "15": {"questionID": 16, "questionName": "nostrum", "questionText": "Quas quidem reprehenderit odit."},
            "16": {"questionID": 17, "questionName": "iure", "questionText": "Et ea alias distinctio."},
            "17": {
                "questionID": 18,
                "questionName": "ad",
                "questionText": "Reprehenderit quis voluptate ducimus sint."
            },
            "18": {
                "questionID": 19,
                "questionName": "quis",
                "questionText": "Officiis ut in odit et praesentium autem aut."
            },
            "19": {
                "questionID": 20,
                "questionName": "consequatur",
                "questionText": "Unde officiis atque ea voluptate."
            },
            "20": {
                "questionID": 21,
                "questionName": "corrupti",
                "questionText": "Perspiciatis quia voluptatem iusto."
            },
            "21": {
                "questionID": 22,
                "questionName": "voluptas",
                "questionText": "Aut similique accusantium optio perferendis."
            },
            "22": {
                "questionID": 23,
                "questionName": "sit",
                "questionText": "Est sed similique qui inventore quas officia."
            },
            "23": {"questionID": 24, "questionName": "quas", "questionText": "Voluptate rerum et id."},
            "24": {"questionID": 25, "questionName": "modi", "questionText": "Et dolor quasi qui quo dolor."},
            "25": {"questionID": 26, "questionName": "aut", "questionText": "Voluptas inventore ut voluptate ea."},
            "26": {
                "questionID": 27,
                "questionName": "eum",
                "questionText": "Voluptate sint porro provident aut sint."
            },
            "27": {
                "questionID": 28,
                "questionName": "velit",
                "questionText": "Nostrum eligendi et molestias in dolor ipsum."
            },
            "28": {
                "questionID": 29,
                "questionName": "impedit",
                "questionText": "In beatae magni et laboriosam dolorem."
            },
            "29": {"questionID": 30, "questionName": "veniam", "questionText": "Dolorem dicta cum quo accusamus."},
            "30": {"questionID": 31, "questionName": null, "questionText": "testquestiontext"}
        };
        currentExamQuestions = {
            "0": {
                "questionNumber": 1,
                "questionID": 2,
                "questionName": "voluptates",
                "questionText": "Ea eveniet voluptatem iure explicabo."
            },
            "1": {
                "questionNumber": 2,
                "questionID": 3,
                "questionName": "eligendi",
                "questionText": "Assumenda eos dolorem eius deserunt iure."
            },
            "2": {
                "questionNumber": 3,
                "questionID": 4,
                "questionName": "ea",
                "questionText": "Esse qui expedita beatae."
            },
            "3": {
                "questionNumber": 4,
                "questionID": 5,
                "questionName": "in",
                "questionText": "Officia quis repellat pariatur."
            },
            "4": {
                "questionNumber": 5,
                "questionID": 6,
                "questionName": "totam",
                "questionText": "Quam sint rem nam ducimus et est dolorem."
            }
        };
        $(document).ready(function () {
            var scripts = [
                "inc/js/common.js",
                "inc/js/examchoicebutton.js",
                "inc/js/questionSetup.js"
            ];

            /**
             * Do any styling or activities required by the page
             * @returns {undefined}
             */
            function onLoad() {
                $('.navMenuItem').menu();
                add_questions(questions);
                if (currentExamQuestions) {
                    $.each(currentExamQuestions, function () {
                        displayQuestion(this);
                    });
                }
                bindExamEventListeners();
                bindQuestionListeners();
                console.log('onload called');
            };
            onLoad();
         //   scriptLoader(scripts, scripts.length, onLoad, 0);
        });
    </script>
@endsection
