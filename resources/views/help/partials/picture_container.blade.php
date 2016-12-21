<?php
$imageFile = asset('img/' . $imageFile)
?>
<figure class="figure">

    {{--<p class="text-right clickNote">Click to enlarge</p>--}}

    <p class="picture">
        <img src="{{ $imageFile }}"
             class="img-responsive"
             alt="{{  $altText }}">
    </p>
    <figcaption class="pictureCaption">{{ $caption }}</figcaption>
</figure>
