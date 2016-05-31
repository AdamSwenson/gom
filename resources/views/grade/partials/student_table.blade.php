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
                title="Sort by ID"
            >ID
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
            <tr id="studentListItem{{ $studentIndex }}"
                class="studentListItem unalteredStudentRow"
                data-index="{{ $studentIndex }}"
                data-fName="{{ $student->getStudentFName() }}"
                data-lName="{{ $student->getStudentLName() }}"
                data-sid="{{ $student->id }}"
                data-student-identifier="{{ $student->getStudentId() }}">
                <td class="col-xs-6"
                    id="studentName{{ $studentIndex }}">{{ $student->getStudentLName() }}, {{ $student->getStudentFName() }}</td>
                <td class="col-xs-4"
                    id="studentIdentifier{{ $studentIndex }}">{{ !empty($student['student_identifier']) ? $student['student_identifier'] : '--' }}</td>
                <td class="col-xs-2"
                    id="examGrade{{ $studentIndex }}">--</td>
            </tr>
            <?php $studentIndex++; ?>
        @endforeach
        </tbody>
    </table>
</div>


