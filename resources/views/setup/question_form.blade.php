<!-- this form describes the input form and buttons for an individual question -->
<div id="question{{ $q['qOrder'] }}">
    <hr/>
    <h4>Question #<span id="questionNumber{{  $q['qOrder'] }}">{{ $q['qOrder'] }}</span></h4>

    <div class="input-group">
        <span class="input-group-addon" id="questionLabel">Question Name</span>
        <input id="questionName{{$q['qOrder']}}" type="text" class="form-control input" value="{{ $q['qName'] }}"
               placeholder="Enter a brief description of the question, i.e. &quot;Causes of the Civil War&quot;"
               aria-describedby="basic-addon1">

    </div>
    <h5>Question Text</h5>

    <div class="form-group">
        <textarea class="form-control" rows="4" id="questionText{{$q['qOrder']}}"
                  placeholder="Enter the full question text(optional)">{{ $q['qDesc'] }}
        </textarea>
    </div>

    <button class="btn btn-sm" id="moveUp{{$q['qOrder']}}"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>
    </button>

    <button class="btn btn-sm" id="moveDown{{$q['qOrder']}}"><span class="glyphicon glyphicon-arrow-down"
                                                        aria-hidden="true"></span>
    </button>

    <button class="btn btn-warning btn-sm" id="deleteQuestion{{$q['qOrder']}}" onclick="deleteQuestion(this.parentNode.id)"><span
                class="glyphicon glyphicon-minus" aria-hidden="true"></span>
        Delete
    </button>

</div>