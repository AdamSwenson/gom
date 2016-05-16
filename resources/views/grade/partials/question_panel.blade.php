<div id="questionPanel"
     class="panel panel-default questionPanel">
    <div class="panel-body">
        <div class="tab-content">
            <?php $elementIndex = 0; ?>
            @foreach($questionAssignments as $qAssignment)
                <?php $qNumber = $qAssignment->getQuestionNumber(); ?>
                <div id="panelQuestion{{ $qNumber }}"
                     data-question-number="{{ $qNumber }}"
                     class="tab-pane
                                     @if( $qNumber === 1 )
                             fadein active
                     @else
                             fade
                        @endif
                             ">
                    {{--
                    <div class="form-horizontal" role="form">--}}
                    <div class="row">
                        <div class="col-xs-7">
                            <!-- question Name -->
                            <h4 id="questionName">Question #{{ $qNumber }}:
                                "{{ $qAssignment->getQuestionName() }}"</h4>
                        </div>

                        <!-- question Score -->
                        <div class="col-xs-2">
                            @include('grade.partials.letter_grade_button')
                        </div>
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-xs-1 control-label questionScoreLabel"
                                       {{--style="padding-right: 2px; padding-left: 0px;"--}}
                                       for="questionScore{{ $qNumber }}">
                                    Score:</label>

                                <div class="col-xs-1" style="padding: 0px;">
                                    <input id="questionScore{{ $qNumber }}"
                                           class="form-control pull-right questionScore"
                                           type="number"
                                           min="0"
                                           max="{{ $maxQuestionScores[$qNumber] }}"
                                           {{--style="width: 4.5em; padding-right: 2px;"--}}
                                           data-number="{{ $qNumber }}"
                                           data-question-assignment-id="{{ $qAssignment->getId() }}"
                                    />
                                </div>
                                <div class="col-xs-1 control-label maxScore"
                                        {{--style="text-align: left;">--}}
                                >
                                    <b>/ {{ $maxQuestionScores[$qNumber] }}</b>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- element area holds all sliders and comments for this question -->
                    <div class="list-group">

                        {{-- add element panels --}}
                        <?php $elements = $allElements[ $qNumber - 1 ];
                        $eNumber = 1;
                        while ($eNumber <= count($elements) ) { ?>
                        @include('grade.partials.element_panel')
                        <?php $elementIndex++; $eNumber++; } ?>

                        {{-- add some text if no elements for this question --}}
                        @if( count($elements) == 0 )
                            <div class="list-group-item noElementsDiv"
                                    {{--style="background-color: #DDDDDD;"--}}
                            >
                                <i>No elements for this question</i>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
