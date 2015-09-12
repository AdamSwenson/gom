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
    }

    .table-fixed tbody td, .table-fixed thead > tr > th {
        float: left;
        cursor: pointer;
    }
</style>
<div class="panel panel-default">
    <table class="table table-fixed" id="studentRoster">
        <thead>
        <tr>
            <th class="col-md-6" id="nameHeader" onclick="sortRosterBy('studentName')">Name</th>
            <th class="col-md-4" id="idHeader" onclick="sortRosterBy('studentIdentifier')">ID</th>
            <th class="col-md-2" id="gradeHeader" onclick="sortRosterBy('examGrade')">Grade</th>
        </tr>
        </thead>
        <tbody id="studentRosterBody">
        <?php $count = 0; ?>
        @foreach($students as $student)
            <tr id="studentListItem{{ $count }}" data-index="{{ $count }}"
                data-fName="{{ $student->getStudentFName() }}"
                data-lName="{{ $student->getStudentLName() }}"
                data-sid="{{ $student->id }}"
                data-student-identifier="{{ $student->getStudentId() }}">
                <td class="col-md-6" id="studentName{{ $count }}">{{ $student->getStudentLName() }},
                    {{ $student->getStudentFName() }}</td>
                <td class="col-md-4" id="studentIdentifier{{ $count }}">{{ $student->getStudentId() }}</td>
                <td class="col-md-2" id="examGrade<?= $count++; ?>">--</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>


