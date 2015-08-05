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
        <?php for($counter = 0; $counter < 20; $counter++)
        { $val = 1000000 + $counter; ?>
        <tr>
            <td class="col-md-6"><span class="glyphicon glyphicon-ok"></span> Adams, Adam</td>
            <td class="col-md-4"><?php echo "$val"; ?></td>
            <td class="col-md-2">75</td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>


