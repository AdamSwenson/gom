<?php
$imageFile = asset('images/' . $imageFile)
?>

<div class="figure">
    <p class="picture">
        <img src="{{ $imageFile }}"
             class="img-responsive"
             alt="{{  $altText }}">
    </p>
    <p class="pictureCaption">{{ $caption }}</p>
</div>

{{--Consider updating to use--}}
{{--<figure>--}}
    {{--<img src="pic_mountain.jpg" alt="The Pulpit Rock" width="304" height="228">--}}
    {{--<figcaption>Fig1. - The Pulpit Rock, Norway.</figcaption>--}}
{{--</figure>--}}