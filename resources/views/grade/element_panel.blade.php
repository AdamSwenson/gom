<div class="list-group-item" style="background-color: #DDDDDD;" id="element{{ $count }}"
     data-element-id="{{ $elements[$eNumber]->getId() }}">
    <h5>Element #{{ $eNumber+1 }}: "{{ $elements[$eNumber]->getElementName() }}"</h5>
    <div class="row">
                <span class="col-md-5">
                    <!-- score slider -->
                    <input class="slider" id="sliderQ{{ $qNumber }}E{{ $eNumber+1 }}" type="text"
                           data-slider-ticks_positions="[0,33,67,100]" data-slider-value="0" data-slider-step=".25"
                           data-slider-ticks="[0,3.25,6.75,10]" data-slider-ticks-snap-bounds="0"
                            data-slider-ticks-labels='["Missing","Poor","Fair","Excellent"]'/>
                </span>
                    <!-- comment area -->
                <span class="col-md-7" style="background-color: #DDDDDD;">
                    <textarea class="form-control" rows="4" name="commentQ{{ $qNumber }}E{{ $eNumber+1 }}" placeholder=
                    "No grade given for this element"></textarea>
                </span>
    </div>
</div>

