<?php
/**
 * Handles css inclusion
 * User: adam
 * Date: 7/11/15
 * Time: 4:08 PM
 */
?>

@foreach($cssFiles as $css)
    {!! HTML::css($css)!!}
@endforeach
