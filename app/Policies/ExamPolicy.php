<?php

namespace App\Policies;

use App\Exam;
use App\User;

/**
 * Policies for exam objects.
 *
 * NOT YET USED.
 *
 * @package App\Policies
 */
class ExamPolicy
{
    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Permissions for viewing an exam
     * @param User $user
     * @param Exam $exam
     * @return bool
     */
    public function show(User $user, Exam $exam)
    {
        return $this->checkOwner($user, $exam);
    }

    /**
     * Permissions for updating an exam's properties
     * @param User $user
     * @param Exam $exam
     * @return bool
     */
    public function update(User $user, Exam $exam)
    {
        return $this->checkOwner($user, $exam);
    }

    /**
     * Permissions for deleting an exam
     * @param User $user
     * @param Exam $exam
     * @return bool
     */
    public function destroy(User $user, Exam $exam)
    {
     return $this->checkOwner($user, $exam);
    }

    protected function checkOwner(User $user, Exam $exam)
    {
        return $user->owns($exam);
    }
}
