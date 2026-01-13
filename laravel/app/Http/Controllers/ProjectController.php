<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the projects.
     */
    public function index()
    {
        $user = auth()->user();
        
        $query = Project::query();

        // Filter based on user role
        if ($user->hasRole('admin')) {
            // Admin can see all projects
        } elseif ($user->hasRole('manager')) {
            // Manager can see their own projects
            $query->where('created_by', $user->id);
        } elseif ($user->hasRole('staff')) {
            // Staff can see projects that contain tasks assigned to them
            $query->whereHas('tasks', fn($q) => $q->where('assigned_to', $user->id))->distinct();
        }

        return response()->json($query->with('tasks')->get());
    }

    /**
     * Show the form for creating a new project.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Project::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'in:active,completed,on_hold',
        ]);

        $validated['created_by'] = auth()->id();

        $project = Project::create($validated);

        return response()->json($project, 201);
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project)
    {
        $this->authorize('view', $project);

        return response()->json($project->load('tasks'));
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'status' => 'in:active,completed,on_hold',
        ]);

        $project->update($validated);

        return response()->json($project);
    }

    /**
     * Delete the specified project from storage.
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        $project->delete();

        return response()->json(null, 204);
    }
}
