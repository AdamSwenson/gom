<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/28/15
 * Time: 7:28 AM
 */ ?>

@if(!empty($element['score']))
    <p class='subtask commentParagraph' id="q{{$element['questionNumber']}}e{{$element['subtask']}}">
        {{ $element['comment'] }}
    </p>
@endif

