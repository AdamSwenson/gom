<div class="form-group">
    <div class="col-md-2"></div>
    <label class="col-md-2" for="grade{{ $key }}" >{{ $gradeType }}</label>
    <div class="col-md-6">
        <input class="form-control" id="grade{{ $key }}" name="grade{{ $key }}"
               type="number"
               min="0" value="{{ $gradeCutoffs[$key] or '' }}">
    </div>
    <div class="col-md-2"></div>
</div>