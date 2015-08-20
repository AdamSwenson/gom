@foreach($scores as $s)
    <div id="q{{ $s->questionNumber }}-panel" class="tab-pane fade in">
        <question-score question-number="{{ $s->questionNumber }}"
                        question-score="{{ $s->questionScore }}"
                        question-assignment-id="{{ $s->questionAssignmentId }}"></question-score>
        <ul class="list-group">
            @foreach($s->elementScores as $e)
                <element-slider element-name="{{ $e->elementName }}"
                                element-assignment-id="{{ $e->elementAssignmentId }}"
                                element-score="{{ $e->elementScore }}"></element-slider>
            @endforeach
        </ul>
    </div>
@endforeach