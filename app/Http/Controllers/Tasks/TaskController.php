<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Contracts\Tasks\TaskServiceInterface;
use App\Http\Requests\Tasks\CreateTaskRequest;
use App\Http\Requests\Tasks\UpdateTaskRequest;
use App\Http\Requests\Tasks\AddDependenciesRequest;
use App\Http\Requests\Tasks\AssignUserRequest;
use App\Helpers\ApiResponse;

class TaskController extends Controller
{
    protected $taskService;

    /**
     * Constructor - Dependency Injection
     */
    public function __construct(TaskServiceInterface $taskService)
    {
        $this->taskService = $taskService;
    }
    /**
     * Get all tasks with filtering
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            $tasks = $this->taskService->getAllTasks($request, $user);
            return ApiResponse::success('Tasks retrieved successfully', $tasks);
            
        } catch (\Exception $e) {
            // Handle specific authorization errors from filters
            if ($e->getCode() === 403 || $e->getCode() === 422) {
                return ApiResponse::error($e->getMessage(), null, 403);
            }
            return ApiResponse::error('Failed to retrieve tasks', null, 500);
        }
    }
    /**
     * Create a new task
     */
    public function store(CreateTaskRequest $request)
    {
        try {
            $user = $request->user();

            // Only managers can create tasks
            if ($user->role !== 'manager') {
                return ApiResponse::error('Forbidden: You do not have permission to perform this action', null, 403);
            }

            $validated = $request->validated();
            $task = $this->taskService->createTask($validated, $user);

            return ApiResponse::created('Task created successfully', $task);
            
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to create task', null, 500);
        }
    }

    /**
     * Get task details by ID
     */
    public function show(Task $task, Request $request)
    {
        try {
            $user = $request->user();

            // Users can only access tasks assigned to them
            if ($user->role === 'user' && $task->assigned_to !== $user->id) {
                return ApiResponse::error(
                    'Forbidden: You are not allowed to access this task because it is not assigned to you',
                    null,
                    403
                );
            }

            $task = $this->taskService->getTaskById($task, $user);

            return ApiResponse::success('Task retrieved successfully', $task);
            
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to retrieve task', null, 500);
        }
    }

    /**
     * Update task
     */
    public function update(Task $task, UpdateTaskRequest $request)
    {
        try {
            $user = $request->user();
            
            // Users can only update status
            if ($user->role === 'user') {
                if ($task->assigned_to !== $user->id) {
                    return ApiResponse::error('Forbidden: You are not allowed to update this task because it is not assigned to you', null, 403);
                }
            } elseif ($user->role !== 'manager') {
                return ApiResponse::error('Forbidden: You do not have permission to perform this action', null, 403);
            }

            $validated = $request->validated();
            $task = $this->taskService->updateTask($task, $validated, $user);

            return ApiResponse::success($task->success_message, $task);
            
        } catch (\Exception $e) {
            if ($e->getCode() === 422) {
                return ApiResponse::error($e->getMessage(), null, 422);
            }
            return ApiResponse::error('Failed to update task', null, 500);
        }
    }
    /**
     * Add dependencies to task
     */
    public function addDependencies(Task $task, AddDependenciesRequest $request)
    {
        try {
            $user = $request->user();

            if ($user->role !== 'manager') {
                return ApiResponse::error('Forbidden: You do not have permission to perform this action', null, 403);
            }

            $validated = $request->validated();
            $task = $this->taskService->addDependencies($task, $validated['dependencies'], $user);

            return ApiResponse::created('Dependencies added successfully', $task);
            
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to add dependencies', null, 500);
        }
    }

    /**
     * Assign user to task
     */
    public function assignUser(Task $task, AssignUserRequest $request)
    {
        try {
            $user = $request->user();

            if ($user->role !== 'manager') {
                return ApiResponse::error('Forbidden: You do not have permission to perform this action', null, 403);
            }

            $validated = $request->validated();
            $task = $this->taskService->assignUser($task, $validated['assigned_to'], $user);

            return ApiResponse::success('Task assigned successfully', $task);
            
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to assign user', null, 500);
        }
    }
}
