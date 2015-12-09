@extends('layouts.master')

@section('otherCss')
    <link href="{{ asset('inc/css/bootstrap-slider.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/grading-styles.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('body')

    <?php
    $qNumber = 1;
    $questionName = "Descartes Cogito argument";
    $elements = [
            "Explain Descartes' goal",
            'Explain role of doubt',
            'Explain the dreaming doubt'
    ];
    ?>
    <div class="row">
        <div class="col-md-5">
            <h1 class="text-center">Do this</h1>
        </div>
        <div class="col-md-6">
            <h1 class="text-center">Give your students this</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5">
            <div class="row">
                <div class="col-md-12">
                    <!-- question panel -->
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="tab-content">
                                <div id="panelQuestion1" data-question-number="1" class="">
                                    <div class="row">
                                        <div class="col-xs-7">
                                            <!-- question Name -->
                                            <h4 id="questionName">Question #1:
                                                "{{ $questionName }}"</h4>
                                        </div>
                                        <!-- question Score -->

                                        <form class="form-horizontal" role="form">
                                            <div class="form-group">
                                                <label class="col-xs-2 control-label"
                                                       {{--style="padding-right: 2px; padding-left: 0px;"--}}
                                                       for="questionScore1">
                                                    Score: </label>

                                                <div class="col-xs-1" style="padding: 0px;">
                                                    <input class="form-control pull-right"
                                                           {{--style="width: 4.5em; padding-right: 2px;"--}}
                                                           id="questionScore"/>
                                                </div>
                                                <div class="col-xs-2 control-label" style="text-align: left;">
                                                    <b>/ 100</b>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- element area holds all sliders and comments for this question -->
                                    <div class="list-group">
                                        <div class="list-group-item" style="background-color: #DDDDDD;">
                                            <h5>Element #1: "{{ $elements[0] }}"</h5>

                                            <div class="row">
                                                <span class="col-md-12" style="padding-right: 0px;">
                                                    <label for="slider1"></label>
                                                    <input class="slider" id="slider1" type="text"/>
                                                </span>
                                                {{--<div class="row">--}}
                                                    <!-- comment area -->
                                        {{--<span class="col-md-12" style="background-color: #DDDDDD; padding-left: 0;">--}}
                                            {{--<textarea class="form-control"--}}
                                                      {{--rows="4"--}}
                                                      {{--id="comment1"--}}
                                                      {{--placeholder="No score for this element">--}}
                                            {{--</textarea>--}}
                                        {{--</span>--}}
                                                {{--</div>--}}

                                            </div>
                                        </div>

                                        <div class="list-group-item" style="background-color: #DDDDDD;">
                                            <h5>Element #2: "{{ $elements[1] }}"</h5>

                                            <div class="row">
                                                <span class="col-md-12" style="padding-right: 0px;">
                                                    <label for="slider2"></label>
                                                    <input class="slider" id="slider2" type="text"/>
                                                </span>
                                                <!-- comment area -->
                                                {{--<span class="col-lg-7"--}}
                                                      {{--style="background-color: #DDDDDD; padding-left: 0;">--}}
                                                    {{--<textarea class="form-control"--}}
                                                              {{--rows="4"--}}
                                                              {{--id="comment2"--}}
                                                              {{--placeholder="No score for this element">--}}
                                                    {{--</textarea>--}}
                                                {{--</span>--}}
                                            </div>
                                        </div>

                                        <div class="list-group-item"
                                             style="background-color: #DDDDDD;">
                                            <h5>Element #3: "{{ $elements[2] }}"</h5>

                                            <div class="row">
                                                <span class="col-md-12" style="padding-right: 0px;">
                                                    <label for="slider3"></label>
                                                    <input class="slider" id="slider3" type="text"/>
                                                </span>
                                                {{--<span class="col-lg-7"--}}
                                                      {{--style="background-color: #DDDDDD; padding-left: 0;">--}}
                                                    {{--<textarea class="form-control"--}}
                                                              {{--rows="4"--}}
                                                              {{--id="comment3"--}}
                                                              {{--placeholder="No score for this element">--}}
                                                    {{--</textarea>--}}
                                                {{--</span>--}}
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{--Comments side--}}
        <div class="col-md-7">
            <div class="row">
                <div class="col-md-12">
                    <p class="text-left"><strong>Student name:</strong> <mark>Smith, Jane</mark></p>

                    <p class="text-left"><strong>Grade:</strong> <mark><span id="gradeSpot"></span></mark></p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <h3>{{ $questionName }}</h3>

                    <p id="commentPara1"></p>
                </div>
                <div class="col-md-6">
                    <div id="chart1"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <p id="commentPara2"></p>
                </div>
                <div class="col-md-6">
                    <div id="chart2"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <p id="commentPara3"></p>
                </div>
                <div class="col-md-6">
                    <div id="chart3"></div>
                </div>
            </div>

        </div>

    </div>


@endsection

@section('jsArea')
    <script type='text/javascript' src="{{ asset('inc/js/bootstrap-slider.js') }}"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load('visualization', '1', {'packages': ['corechart']});
    </script>
    <script type="text/javascript">
        $(document).ready(function () {

            var elements = [
                "Explain Descartes' goal",
                'Explain role of doubt',
                'Explain the dreaming doubt'
            ];

            var valenceCutoffs = [0, 3.25, 6.75, 10];
            var valenceLabels = ["Missing", "Poor", "Fair", "Excellent"];
            var valenceLabelPositions = [0, 33, 67, 100];
            var sliderStep = .25;

            /* initialize Sliders with valenceCutoffs */
            $('input.slider').slider({
                tooltip: 'show',
                value: 0,
                step: sliderStep,
                ticks: valenceCutoffs,
                ticks_labels: valenceLabels,
                ticks_position: valenceLabels
            });


            var e1 = [[1.3, "In order to say why Descartes has adopted the skeptical method of the Meditations, you need to tell the reader what Descartes is hoping to achieve. However, you didn't do this. This leaves it up to your reader to figure out that Descartes is trying to discover what kinds of beliefs can be the completely certain foundations upon which the rest of our knowledge can be built. That is, the idea is to find some beliefs which he can't be wrong about. Then he can work backwards to explaining why and when, for example, scientific beliefs count as certain knowledge.  As you can see, this is pretty complicated. So you can't just assume that the reader will figure it out."],

                [3, "In order to say why Descartes has adopted the skeptical method of the Meditations, you need to tell the reader what Descartes is hoping to achieve. You tried to do this. But it was not clear from your answer that his goal is to discover what kinds of beliefs can be the completely certain foundations upon which the rest of our knowledge can be built. That is, the idea is to find some beliefs which he can't be wrong about. Then he can work backwards to explaining why and when, for example, scientific beliefs count as certain knowledge."],

                [6, "You correctly recognized that in order to say why Descartes has adopted the skeptical method of the Meditations, reader needed to be told what Descartes is hoping to achieve. You did a pretty good job here. But it wasn't as clear as it could have been that he is trying to discover what kinds of beliefs can be the completely certain foundations upon which the rest of our knowledge can be built. That is, the idea is to find some beliefs which he can't be wrong about. Then he can work backwards to explaining why and when, for example, scientific beliefs count as certain knowledge."],

                [9, "You did a good job recognizing that in order to say why Descartes has adopted the skeptical method of the Meditations, the reader needed to be told what Descartes is hoping to achieve. It was completely clear from your answer that he is trying to discover what kinds of beliefs can be the completely certain foundations upon which the rest of our knowledge can be built. From your explanation I think a reader would have been able to see that the idea is to find some beliefs which Descartes can't be wrong about. Then he can work backwards to explaining why and when, for example, scientific beliefs count as certain knowledge."]

            ];

            var e2 = [[0.5, "You needed to explain the role doubt plays in Descartes method. But you forgot to do it. The reader needed to be shown that Descartes is using a principle like 'If I can find grounds for doubting that a kind of belief is true, then no beliefs of that sort count as knowledge'. So, for example, if we're talking about beliefs based on seeing things in the distance, I might believe that I see a plane. But then someone points out that birds are often confused with faraway planes. Now I can't say that I know that object in the distance is a plane until I can be sure that it is not a bird."],

                [4, "You remembered that you needed to explain the role doubt plays in Descartes method. However, from what you said, I don't think a reader would've understood that Descartes is using a principle like 'If I can find grounds for doubting that a kind of belief is true, then no beliefs of that sort count as knowledge'. I don't think a reader would've understood that, for example, if we're talking about beliefs based on seeing things in the distance, I might believe that I see a plane. But suppose someone points out that birds are often confused with faraway planes. Now I can't say that I know that object in the distance is a plane until I can be sure that it is not a bird."],

                [5, "You did a pretty good job explaining the role doubt plays in Descartes method. I think a reader would've basically understood that he is using a principle like 'If I can find grounds for doubting that a kind of belief is true, then no beliefs of that sort count as knowledge'. From your answer, a reader probably would've understood that, for example, if we're talking about beliefs based on seeing things in the distance, I might believe that I see a plane. But suppose someone points out that birds are often confused with faraway planes. Now I can't say that I know that object in the distance is a plane until I can be sure that it is not a bird."],

                [8, "You did a great job explaining the role doubt plays in Descartes method. A reader definitely would've understood that he is using a principle like 'If I can find grounds for doubting that a kind of belief is true, then no beliefs of that sort count as knowledge'. So, for example, if we're talking about beliefs based on seeing things in the distance, I might believe that I see a plane. But suppose someone points out that birds are often confused with faraway planes. Now I can't say that I know that object in the distance is a plane until I can be sure that it is not a bird."]
            ];

            var e3 = [[1, "It was extremely important to go through Descartes argument that when you are dreaming, things look just the way they do when you are awake. More importantly, in a dream you can't tell that you are dreaming. So, if Descartes were dreaming right now, he would not know that he was dreaming. Yet all of his beliefs about what is around him would be false ---he thinks he is in front of the fire, but actually he is snuggled up in bed. Since many beliefs based on his senses would be false if he were dreaming, he has found a reason to doubt all such beliefs. Unfortunately, you didn't really explain this at all. That will make it very difficult for your reader to understand the reset of your answer."],

                [4.5, "You remembered to do the crucial task of explaining Descartes' argument that when you are dreaming, things look just the way they do when you are awake. Unfortunately, I don't think you said enough for the reader to understand how this argument works. It needed to be clear that in a dream you can't tell that you are dreaming. So, if Descartes were dreaming right now, he would not know that he was dreaming. Yet all of his beliefs about what is around him would be false ---he thinks he is in front of the fire, but actually he is snuggled up in bed. Since many beliefs based on his senses would be false if he were dreaming, he has found a reason to doubt all such beliefs."],

                [7, "You did a pretty good job explaining Descartes' argument that when you are dreaming, things just the way they do when you are awake. It would've been mostly clear to a reader that in a dream you can't tell that you are dreaming. So, if Descartes were dreaming right now, he would not know that he was dreaming. Yet all of his beliefs about what is around him would be false ---he thinks he is in front of the fire, but actually he is snuggled up in bed. Since many beliefs based on his senses would be false if he were dreaming, he has found a reason to doubt all such beliefs."],

                [10, "From your excellent answer, I think any reader would've been able to understand why Descartes points out that when you are dreaming, things just the way they do when you are awake. It was completely clear that this matters because when you are dreaming you can't tell that you are dreaming. So, if Descartes were dreaming right now, he would not know that he was dreaming. Yet all of his beliefs about what is around him would be false ---he thinks he is in front of the fire, but actually he is snuggled up in bed. As was clear from your answer, since many beliefs based on his senses would be false if he were dreaming, he has found a reason to doubt all such beliefs."]

            ];


            function imposeContent(num, textArray, valence) {
              //  $('#comment' + num).empty().append(textArray[valence][1]);
                $('#commentPara' + num).empty().append(textArray[valence][1]);
                $('#slider' + num).slider('setValue', textArray[valence][0]);
            }

            function setGrade(index)
            {
                var scores = [
                    [55, 'F'],
                    [78, 'C+'],
                    [82, 'B-'],
                    [92, 'A-'],
                    [95, 'A']
                ];

                $('#questionScore').empty().val(scores[index][0]);
                $('#gradeSpot').empty().append(scores[index][1]);
            }

function drawChart(elementNumber, title, score, average)
{
    var options = {
        title: "How you did versus class average ",
        width: 300,
        height: 200,
        bar: {groupWidth: "65%"},
        legend: {position: "top"},
        vAxis: {
            viewWindowMode:'explicit',
            viewWindow: {
                max:10,
                min:0
            }
        }
    };

    //Prepare the data
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'question');
    data.addColumn('number', 'Your Score');
    data.addColumn('number', 'Class Average');

    data.addRow([title, score, average]);
    var chartTarget = 'chart' + elementNumber;
    var chart = new google.visualization.ColumnChart(document.getElementById(chartTarget));
    chart.draw(data, options);

}

            const SPEED = 3000;

            var i = 0;
//            var start = function() {
                var timer = setInterval(function () {
                    imposeContent(1, e1, i);
                    drawChart(1, elements[0], e1[i][0], 4.5);

                    imposeContent(2, e2, i);
                    drawChart(2, elements[1], e2[i][0], 6.5);

                    imposeContent(3, e3, i);
                    drawChart(3, elements[2], e3[i][0], 2.5);

                    setGrade(i);

                    if (i < 3) {
                        i += 1;
                    } else {
                        i = 0;
                    }
                }, SPEED);
//            }

//            google.setOnLoadCallback(start);


//            imposeContent(1, e1, 0);
//            imposeContent(2, e2, 0);
//            imposeContent(3, e3, 0);
//
//            setGrade(0);

//        /* When an element slider stops movement,
//         update element score and text (if necessary),
//         then save score, text and time
//         *  */
//        $('input.slider').on('slideStop', function (slideEvt) {
//
//            // update the element's score visually and in elementScores[]
//            var elementNumber = $(this).closest('[id^="element"]').attr('data-element-index');
//            var oldScore = elementScores[activeStudent][elementNumber];
//            var newScore = slideEvt.value;
//
//            elementScores[activeStudent][elementNumber] = newScore;
//
//            // update comment text -- only replace text if the score has changed valence regions
//            var $parent = $(this).parents('[id^="element"]');
//            var $elementComment = $parent.find('textArea');
//            if (getValence(newScore) != getValence(oldScore)) {
//                // Score is in a new valence region.
//                // plug in the appropriate comment text and save to DB
//                var stockResponse = stockComments[elementNumber][getValence(newScore)];
//                $elementComment.val(stockResponse);
//                updateAndSaveComment($elementComment);
//            } else {
//                // Score is in the same valence region.
//                // Jump straight to saving without changing the elementComment
//                var elementId = $(this).closest('[id^="element"]').attr('data-element-id');
//                createGradeRequest('element_id', elementId, newScore, null);
//            }
//
//            // If using bell curve (standardScoring), element score affects the total question score, so update
//            if (standardScoring) {
//                updateStandardScores();
//            }
//
//                   });

        });
    </script>

    <script type="text/javascript">

    </script>
@endsection