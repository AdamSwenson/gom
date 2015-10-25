<div class="form-group">
    <!--<div class="col-sm-1"></div>-->
    <label class="col-xs-2" for="gradeGroup{{ $key }}" >{{ $gradeType }}</label>
    <div class="col-xs-8" style="width: 110px;">
        <input class="form-control" id="gradeGroup{{ $key }}" name="gradeGroup{{ $key }}"
               type="number" max="{{ $examMaxScore }}"
               min="0" value="{{ $gradeCutoffs[$key] or '' }}">
    </div>
    <div class="col-xs-2"></div>
</div>