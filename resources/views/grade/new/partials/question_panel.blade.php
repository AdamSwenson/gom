<div id="questionPanel"
     class="panel panel-default questionPanel">
    <div class="panel-body">
        <div class="tab-content">
            @foreach($questionAssignments as $qAssignment)
                <?php $qNumber = $qAssignment->getQuestionNumber(); ?>
                <?php $qIndex = $qNumber - 1; ?>
                <?php $elementIndex = 0; ?>

                <div id="panelQuestion{{ $qNumber }}"
                     data-question-number="{{ $qNumber }}"
                     class="tab-pane {{ $qNumber === 1 ? 'fadein active' : 'fade' }}">

                    <div class="row">
                        <div class="col-xs-7">
                            <!-- question Name -->
                            <h4 id="questionName">Question #{{ $qNumber }}:
                                "{{ $qAssignment->getQuestionName() }}"</h4>
                        </div>

                        <!-- question Score -->
                        <div class="col-xs-2">
                            <letter-grade-button
                                    :question-index="{{$qIndex}}"
                                    :grades="{{ $grades }}"></letter-grade-button>
                        </div>

                        <question-score :question-index="{{$qIndex}}"></question-score>

                    </div>

                    <!-- element area holds all sliders and comments for this question -->
                    <div class="list-group">
                        {{-- add element panels --}}
                        <?php $elements = $allElements[ $qIndex ];
                        $eNumber = 1;
                        while ($eNumber <= count($elements) ) {?>
                        <element-input :element-number="{{$eNumber}}"
                                       :element-index="{{$elementIndex}}"
                                       element-id="{{ $elements[$elementIndex]->getId() }}"
                                       element-name="{{ $elements[$elementIndex]->getElementName() }}"
                                       :question-number="{{ $qNumber }}"></element-input>
                        <?php $elementIndex++; $eNumber++; } ?>

                        {{-- add some text if no elements for this question --}}
                        @if( count($elements) == 0 )
                            <div class="list-group-item noElementsDiv">
                                <i>No elements for this question</i>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
