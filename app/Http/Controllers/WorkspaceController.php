<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use App\Models\Userspace;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class WorkspaceController extends Controller
{
    public function index()
    {
        $workspaces = Workspace::all();
        return response()->json($workspaces);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'detail' => 'required|string|max:255',
        ]);

        $workspace = Workspace::create($request->all());

        /** @var \App\Models\MyUserModel $user **/ 
        $userId = auth()->id(); // Get the currently authenticated user's ID

            // Assuming you have a Userspace model set up for the userspaces table
        Userspace::create([
            'user_id' => $userId,
            'workspace_id' => $workspace->id,
            'is_admin' => true, // Set the user as an admin
        ]);
        return redirect()->intended('main')->with('success', 'Workspace created successfully!');
    }

    public function show($id)
    {
        $workspace = Workspace::findOrFail($id);
        return response()->json($workspace);
    }

    public function update(Request $request, Workspace $workspace)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'detail' => 'required|string|max:255',
        ]);

        $workspace->update($request->all());
        return redirect()->intended('main')->with('success', 'Workspace updated successfully!');
    }

    public function destroy(Workspace $workspace)
    {
        $workspace->delete();
        return redirect()->intended('main')->with('success', 'Workspace deleted successfully!');
    }
}
