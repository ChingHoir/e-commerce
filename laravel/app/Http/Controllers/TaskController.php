<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks.
     */
    public function index()
    {
        $user = auth()->user();
        
        $query = Task::query();

        // Filter based on user role
        if ($user->hasRole('admin')) {
            // Admin can see all tasks
        } elseif ($user->hasRole('manager')) {
            // Manager can see tasks in their projects
            $query->whereHas('project', fn($q) => $q->where('created_by', $user->id));
        } elseif ($user->hasRole('staff')) {
            // Staff can see tasks assigned to them
            $query->where('assigned_to', $user->id);
        }

        return response()->json($query->get());
    }

    /**
     * Show the form for creating a new task.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Task::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
            'status' => 'in:pending,in_progress,completed',
        ]);

        // Ensure the project belongs to the user (for managers)
        $project = Project::findOrFail($validated['project_id']);
        $this->authorize('update', $project);

        $validated['created_by'] = auth()->id();

        $task = Task::create($validated);

        return response()->json($task, 201);
    }

    /**
     * Display the specified task.
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);

        return response()->json($task->load(['project', 'assignee', 'creator']));
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified task in storage.
     */
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
            'status' => 'in:pending,in_progress,completed',
        ]);

        $task->update($validated);

        return response()->json($task);
    }

    /**
     * Update the task status.
     */
    public function updateStatus(Request $request, Task $task)
    {
        $this->authorize('updateStatus', $task);

        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $task->update($validated);

        return response()->json($task);
    }

    /**
     * Delete the specified task from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return response()->json(null, 204);
    }
}
