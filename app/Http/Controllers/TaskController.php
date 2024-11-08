<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Workspace;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('workspace')->get();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'detail' => 'nullable|string',
            'is_completed' => 'boolean',
            'workspace_id' => 'required|exists:workspaces,id',
        ]);

        $task = Task::create($request->all());
        return redirect()->intended('main')->with('success', 'Task created successfully!');
    }

    public function show($id)
    {
        $task = Task::findOrFail($id);
        return response()->json($task);
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'detail' => 'nullable|string',
            'is_completed' => 'string',
        ]);

        $task->update([
            'name' => $request->name,
            'detail' => $request->detail,
            'is_completed' => $request->is_completed ? true : false, // Convert string to boolean
        ]);
        return redirect()->intended('main')->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->intended('main')->with('success', 'Task deleted successfully!');
    }
}
