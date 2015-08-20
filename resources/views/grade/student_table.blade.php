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
        @if(! isset($students))
            <?php for($counter = 0; $counter < 20; $counter++)
            { $val = 1000000 + $counter; ?>
            <tr>
                <td class="col-md-6"><span class="glyphicon glyphicon-ok"></span> Adams, Adam</td>
                <td class="col-md-4"><?php echo "$val"; ?></td>
                <td class="col-md-2">75</td>
            </tr>
            <?php } ?>
        @else
            @foreach($students as $s)
            <tr data-student-id="{{ $s->id }}" v-on="click: selectStudentToGrade({{$s->id}})">
                <td class="col-md-6"><span class="glyphicon glyphicon-ok"></span>{{ $s->last_name }}, {{ $s->first_name }}</td>
                <td class="col-md-4">{{ $s->student_identifier }}</td>
                <td class="col-md-2">75</td>
            </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>


