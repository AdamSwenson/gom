<!-- Used by 'edit_exam' and 'create_exam' to display the fields for exam1 name, term, year -->
<div class="row container">
    <div class="col-lg-10">
        <!-- name input -->
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">Exam Name</span>
            <input type="text"
                   class="form-control input-lg"
                   id="name"
                   name="name"
                   value="{{ isset($exam1) ? $exam1->getName() : '' }}"
                   placeholder="Enter a descriptive name for this test (e.g., English 101 Exam #1)"
                   aria-describedby="basic-addon1">
        </div>
        <br/>
        <!-- term selector -->
        <input name="examTerm" type="hidden" id="hiddenTerm" value="{{ isset($exam1) ? $exam1->getTerm() : '' }}"/>

        <div class="btn-group btn-group">
            <button class="btn btn-primary dropdown-toggle" id="term" title="Choose Exam Term"
                    data-toggle="dropdown">{{ isset($exam1) ? $exam1->getTerm() : 'Term' }} <span
                        class="glyphicon glyphicon-menu-down"></span></button>
            <ul class="dropdown-menu" id="termList" role="menu" style="cursor:pointer;">
                @foreach($terms as $term)
                    <li><a class="termItem">{{ $term }}</a></li>
                @endforeach
            </ul>
        </div>
        <!-- year selector -->
        <input name="examYear"
               type="hidden"
               id="hiddenYear"
               value="{{ isset($exam1) ? $exam1->getYear() : '' }}"/>

        <div class="btn-group btn-group">
            <button class="btn btn-primary dropdown-toggle"
                    id="year"
                    title="Choose Exam Year"
                    data-toggle="dropdown">{{ isset($exam1) ? $exam1->getYear() : 'Year' }}
                <span class="glyphicon glyphicon-menu-down"></span></button>
            <ul class="dropdown-menu"
                id="yearList"
                role="menu"
                style="cursor:pointer;">
                @foreach($years as $year)
                    <li><a class="yearItem">{{ $year }}</a></li>
                @endforeach
            </ul>
        </div>
        <p>
        <?php isset($exam1) ? $examId = $exam1->getId() : $examId = 0; ?>
        <div style="display: {{ isset($exam1) ? 'visible' : 'none' }}">
            <a href="{{ url('exam1/'.$examId.'/student/edit') }}"
               class="btn btn-info"
               title="Edit Student Roster"
               style="cursor:pointer;"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>
                 Edit Student Roster</a>
        </div>
        </p>
    </div>
    <div class="col-lg-2">
    </div>
</div>
