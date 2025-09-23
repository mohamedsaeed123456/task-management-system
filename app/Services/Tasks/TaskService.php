<?php

namespace App\Services\Tasks;

use App\Contracts\Tasks\TaskServiceInterface;
use App\Models\Task;
use App\Models\User;
use App\Services\Tasks\Filters\TaskFilterHandler;
use Illuminate\Http\Request;

class TaskService implements TaskServiceInterface
{
    protected $filterHandler;

    /**
     * Constructor - Dependency Injection
     */
    public function __construct(TaskFilterHandler $filterHandler)
    {
        $this->filterHandler = $filterHandler;
    }
    /**
     * Get all tasks with filtering
     */
    public function getAllTasks(Request $request, User $user): array
    {
        $query = Task::with(['assignedTo', 'createdBy']);

        // Role-based access: Users can only see tasks assigned to them
        if ($user->role === 'user') {
            $query->where('assigned_to', $user->id);
        }
        // Managers can see all tasks and use all filters

        // Apply filters using filter handler (may throw exception for unauthorized filters)
        try {
            $query = $this->filterHandler->applyFilters($query, $request);
        } catch (\Exception $e) {
            // Re-throw filter exceptions (like unauthorized assigned_to filter)
            throw $e;
        }

        // Fetch tasks
        $tasks = $query->get()->map(function ($task) {
            return [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'status' => $task->status,
                'due_date' => $task->due_date,
                'assigned_user' => $task->assignedTo ? [
                    'id' => $task->assigned_to,
                    'name' => $task->assignedTo->name,
                    'profile_image' => $task->assignedTo->profile_image,
                ] : null,
                'created_by' => $task->createdBy ? [
                    'id' => $task->created_by,
                    'name' => $task->createdBy->name,
                    'profile_image' => $task->createdBy->profile_image,
                ] : null,
                'created_at' => $task->created_at,
            ];
        });

        return $tasks->toArray();
    }

    /**
     * Create a new task
     */
    public function createTask(array $data, User $user): Task
    {
        return Task::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'assigned_to' => $data['assigned_to'],
            'created_by' => $user->id,
            'due_date' => $data['due_date'] ?? null,
            'status' => 'pending',
        ]);
    }

    /**
     * Get task by ID
     */
    public function getTaskById(Task $task, User $user): Task
    {
        $task->load('dependencies');
        return $task;
    }

    /**
     * Update task
     */
    public function updateTask(Task $task, array $data, User $user): Task
    {
        // Check if trying to complete task
        if (isset($data['status']) && $data['status'] === 'completed') {
            // Check if all dependencies are completed
            $incompleteDependencies = $task->dependencies()
                ->where('status', '!=', 'completed')
                ->count();

            if ($incompleteDependencies > 0) {
                throw new \Exception('Cannot complete task. All dependencies must be completed first.', 422);
            }
        }

        $updateData = $data;
        
        // Set is_completed based on status
        if (isset($data['status'])) {
            if ($data['status'] === 'completed') {
                $updateData['is_completed'] = true;
            } elseif ($data['status'] !== 'completed') {
                $updateData['is_completed'] = false;
            }
        }

        $task->update($updateData);
        
        // Add success message based on user role
        if ($user->role === 'user') {
            $task->success_message = 'Status updated successfully';
        } else {
            $task->success_message = 'Task updated successfully';
        }
        
        return $task;
    }

    /**
     * Add dependencies to task
     */
    public function addDependencies(Task $task, array $dependencies, User $user): Task
    {
        $task->dependencies()->sync($dependencies);
        return $task->load('dependencies');
    }

    /**
     * Assign user to task
     */
    public function assignUser(Task $task, int $userId, User $user): Task
    {
        $task->update(['assigned_to' => $userId]);
        return $task;
    }

}
