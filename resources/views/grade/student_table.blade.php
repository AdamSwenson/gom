<!-- holds the student roster listing within Grade Exam -->
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
<div class="panel panel-default" id="studentRoster">
    <table class="table table-fixed">
        <thead>
        <tr>
            <th class="col-md-6">Name</th>
            <th class="col-md-4">ID</th>
            <th class="col-md-2">Grade</th>
        </tr>
        </thead>
        <tbody>
        <?php $count = 0; ?>
        @foreach($students as $student)
            <tr id="studentListItem{{ $count }}" data-index="{{ $count }}">
                <td class="col-md-6" id="studentName{{ $count }}">{{ $student->getStudentLName() }},
                    {{ $student->getStudentFName() }}</td>
                <td class="col-md-4" id="studentId{{ $count }}">{{ $student->getStudentId() }}</td>
                <td class="col-md-2" id="examGrade<?= $count++; ?>">--</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>


