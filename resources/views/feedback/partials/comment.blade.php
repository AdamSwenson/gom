@if(!empty($element['score']))
    <p class='subtask commentParagraph'
       id="q{{$element['questionNumber']}}e{{$element['subtask']}}">
        {{ $element['comment'] }}
    </p>
@endif

