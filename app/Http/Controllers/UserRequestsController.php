<?php

namespace App\Http\Controllers;

use App\Models\Userspace;
use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserRequestsController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'workspaceUUID' => 'required|uuid',
        ]);

        // Find the workspace by UUID
        $workspace = Workspace::where('uuid', $request->workspaceUUID)->first();

        if (!$workspace) {
            return redirect()->back()->withErrors(['workspaceUUID' => 'Workspace not found.']);
        }

        // Create a new userspace entry
        Userspace::create([
            'user_id' => Auth::id(),
            'workspace_id' => $workspace->id,
            'is_admin' => false, // Default to false
            'request' => true, // Default to true for requests
        ]);

        // Redirect with success message
        return redirect()->intended('main')->with('success', 'User request sent!');
    }

    public function update($userId, $workspaceId)
    {
        // Find the userspace record
        $userspace = Userspace::where('user_id', $userId)
            ->where('workspace_id', $workspaceId)
            ->first();

        if ($userspace) {
            // Update the request field to false
            DB::table('userspaces')
                ->where('user_id', $userspace->user_id)
                ->where('workspace_id', $userspace->workspace_id)
                ->update(['request' => false]);

            // Redirect or return response
            return redirect()->back()->with('success', 'Request accepted successfully.');
        }

        // Handle the case where the userspace was not found
        return redirect()->back()->with('error', 'Request not found.');
    }

    public function destroy($userId, $workspaceId)
    {
        // Find the userspace record and delete it
        $userspace = Userspace::where('user_id', $userId)
            ->where('workspace_id', $workspaceId)
            ->first();

        if ($userspace) {
            DB::table('userspaces')
                ->where('user_id', $userspace->user_id)
                ->where('workspace_id', $userspace->workspace_id)
                ->delete();

            // Redirect or return response
            return redirect()->back()->with('success', 'Removed successfully.');
        }

        // Handle the case where the userspace was not found
        return redirect()->back()->with('error', 'Request not found.');
    }
}