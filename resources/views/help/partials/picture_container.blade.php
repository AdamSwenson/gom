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