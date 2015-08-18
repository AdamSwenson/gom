<!-- holds the student roster listing within Grade Exam -->
<style>
    .table-fixed thead {
        width: 97%;
    }

    .table-fixed tbody {
        height: 270px;
        overflow-y: auto;
        width: 100%;
    }

    .table-fixed thead, .table-fixed tbody, .table-fixed tr, .table-fixed td, .table-fixed th {
        display: block;
    }

    .table-fixed tbody td, .table-fixed thead > tr > th {
        float: left;
        border-bottom-width: 0;
    }
</style>
<div class="panel panel-default">
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
            <tr id="studentListItem{{ $student->getId() }}" data-index="<?= $count++; ?>">
                <td class="col-md-6">{{ $student->getStudentLName() }},
                    {{ $student->getStudentFName() }} </td>
                <td class="col-md-4">{{ $student->getStudentId() }}</td>
                <td class="col-md-2">75</td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>


