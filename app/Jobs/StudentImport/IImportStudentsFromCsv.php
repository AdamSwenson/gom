<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/9/15
 * Time: 11:01 AM
 */
namespace App\Jobs\StudentImport;

use App\Http\Requests\StudentRequest;

interface IImportStudentsFromCsv
{
    /**
     * Execute the job.
     *
     * @param StudentRequest $request
     * @return array
     */
    public function handle(StudentRequest $request);
}