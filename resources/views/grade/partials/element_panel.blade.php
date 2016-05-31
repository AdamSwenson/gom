<!-- template used by 'grade_exam' to host -->
<div id="element{{ $eNumber }}"
     class="list-group-item elementPanel"
     data-element-index="{{ $elementIndex }}"
     data-element-id="{{ $elements[$eNumber-1]->getId() }}"
     data-comment-area-id="commentQ{{ $qNumber }}E{{ $eNumber }}"
>
    <h5>Element #{{ $eNumber }}: "{{ $elements[$eNumber-1]->getElementName() }}"</h5>
    <div class="row">
                <span class="col-lg-5 sliderContainer Q{{ $qNumber }}E{{ $eNumber }}">
                    <!-- score slider -->
                    <label for="sliderQ{{ $qNumber }}E{{ $eNumber }}"></label>
                    <input id="sliderQ{{ $qNumber }}E{{ $eNumber }}"
                           type="text"
                           class="slider" />
                           {{--data-provide="slider"--}}
                           {{--data-slider-ticks="[1, 2, 3]"--}}
                           {{--data-slider-ticks-labels='["short", "medium", "long"]'--}}
                           {{--data-slider-min="1"--}}
                           {{--data-slider-max="3"--}}
                           {{--data-slider-step="1"--}}
                           {{--data-slider-value="3">--}}
                </span>
        <!-- comment area -->
                <span class="col-lg-7 commentContainer Q{{ $qNumber }}E{{ $eNumber }}">
                    <textarea id="commentQ{{ $qNumber }}E{{ $eNumber }}"
                              class="form-control"
                              rows="4"
                              name="commentQ{{ $qNumber }}E{{ $eNumber }}"
                              placeholder="No score for this element"
                    ></textarea>
                </span>
    </div>
</div>

