<div class="form-group">
    <div class="col-md-2"></div>
    <label class="col-md-2" for="gradeGroup{{ $key }}" >{{ $gradeType }}</label>
    <div class="col-md-6">
        <input class="form-control" id="gradeGroup{{ $key }}" name="gradeGroup{{ $key }}"
               type="number" onchange="updateChartColors()"
               min="0" value="{{ $gradeCutoffs[$key] or '' }}">
    </div>
    <div class="col-md-2"></div>
</div>