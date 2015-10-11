<!-- Used by 'grade_exam'. holds the student roster listing -->
<style>
    .table-fixed thead {
        width: 97%;
    }

    .table-fixed tbody {
        height: 230px;
        overflow-y: auto;
        width: 100%;
    }

    .table-fixed thead, .table-fixed tbody, .table-fixed tr, .table-fixed td, .table-fixed th {
        display: block;
        border-collapse: collapse;
    }

    .table-fixed tbody td, .table-fixed thead > tr > th {
        float: left;
        cursor: pointer;
    }
</style>
<div class="panel panel-default">
    <table class="table table-fixed table-hover" id="studentRoster">
        <thead>
        <tr>
            <th class="col-md-6" id="nameHeader" title="Sort by name" onclick="sortRosterBy('studentName')">Name</th>
            <th class="col-md-4" id="idHeader" title="Sort by ID" onclick="sortRosterBy('studentIdentifier')">ID</th>
            <th class="col-md-2" id="gradeHeader" title="Sort by grade" onclick="sortRosterBy('examGrade')">Grade</th>
        </tr>
        </thead>
        <tbody id="studentRosterBody">
        <?php $studentIndex = 0; ?>
        @foreach($students as $student)
            <tr id="studentListItem{{ $studentIndex }}" data-index="{{ $studentIndex }}"
                data-fName="{{ $student->getStudentFName() }}"
                data-lName="{{ $student->getStudentLName() }}"
                data-sid="{{ $student->id }}"
                data-student-identifier="{{ $student->getStudentId() }}">
                <td class="col-md-6" id="studentName{{ $studentIndex }}">{{ $student->getStudentLName() }}, {{ $student->getStudentFName() }}</td>
                <td class="col-md-4" id="studentIdentifier{{ $studentIndex }}">{{ !empty($student['student_identifier']) ? $student['student_identifier'] : '--' }}</td>
                <td class="col-md-2" id="examGrade<?= $studentIndex++; ?>">--</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>


