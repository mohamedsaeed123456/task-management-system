<?php

namespace App\Contracts\Tasks;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

interface TaskServiceInterface
{
    /**
     * Get all tasks with filtering
     */
    public function getAllTasks(Request $request, User $user): array;

    /**
     * Create a new task
     */
    public function createTask(array $data, User $user): Task;

    /**
     * Get task by ID
     */
    public function getTaskById(Task $task, User $user): Task;

    /**
     * Update task
     */
    public function updateTask(Task $task, array $data, User $user): Task;

    /**
     * Add dependencies to task
     */
    public function addDependencies(Task $task, array $dependencies, User $user): Task;

    /**
     * Assign user to task
     */
    public function assignUser(Task $task, int $userId, User $user): Task;
}
