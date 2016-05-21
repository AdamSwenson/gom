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
                </span>
        <!-- comment area -->
                <span class="col-lg-7 commentContainer Q{{ $qNumber }}E{{ $eNumber }}"
                      {{--style="background-color: #DDDDDD; padding-left: 0px; padding-right:0px;"--}}
                >
                    <textarea id="commentQ{{ $qNumber }}E{{ $eNumber }}"
                              class="form-control"
                              rows="4"
                              name="commentQ{{ $qNumber }}E{{ $eNumber }}"
                              placeholder="No score for this element"
                    ></textarea>
                </span>
    </div>
</div>

