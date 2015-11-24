<div class="row">
    <div class="col-lg-3"></div>
    <div class="col-lg-6">
        @include('help.partials.picture_container',
                    ['imageFile' => $imageFile,
                    'altText' => $altText,
                    'caption' => $caption])
    </div>
    <div class="col-lg-3"></div>
</div>