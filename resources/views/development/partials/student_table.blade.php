{{--<!-- Used by 'grade_exam'. holds the student roster listing -->--}}
<div class="panel panel-default">
    <table class="table table-fixed table-hover" id="studentRoster">
        <thead>
        <tr>
            <th class="col-xs-6"
                id="nameHeader"
                title="Sort by name"
            >Name
            </th>
            <th class="col-xs-4"
                id="idHeader"
                title="Sort by ID">ID
            </th>
            <th class="col-xs-2"
                id="gradeHeader"
                title="Sort by grade"
            >Grade
            </th>
        </tr>

        </thead>

        <tbody id="studentRosterBody">
        <?php $studentIndex = 0; ?>
        @foreach($students as $student)
            <tr is="student-list-item"
            :student-index="{{ $studentIndex }}"
            first-name="{{ $student->getStudentFName() }}"
            last-name="{{ $student->getStudentLName() }}"
            student-identifier="{{ $student->getStudentId() }}"
            student-id="{{ $student->id }}"
            ></tr>
            <?php $studentIndex++; ?>
        @endforeach
        </tbody>
    </table>
</div>


