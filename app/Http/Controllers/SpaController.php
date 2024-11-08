<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use App\Models\Userspace;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SpaController extends Controller
{
    public function index()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Get all workspace IDs associated with the user
        /** @var \App\Models\MyUserModel $user **/ 
        $workspaceIds = $user->workspaces()
            ->where('userspaces.request', false)
            ->pluck('id');

        // Retrieve all workspaces along with their tasks based on the IDs
        $workspaces = Workspace::with('tasks')->whereIn('id', $workspaceIds)->get();

        $userspaces = [];
        foreach ($workspaceIds as $workspaceId) {
            $relatedUserspaces = Userspace::where('workspace_id', $workspaceId)
                ->where('user_id', '!=', $user->id) // Exclude the current user
                ->get();

            foreach ($relatedUserspaces as $userspace) {
                $userspaces[] = [
                    'user_id' => $userspace->user_id,
                    'workspace_id' => $workspaceId,
                    'request' => $userspace->request,
                    'is_admin' => $userspace->is_admin,
                    'workspace_name' => $userspace->workspace->name,
                    'user_name' => $userspace->user->name,
                ];
            }
        }
        // Return the SPA view and pass the workspaces
        return view('main', compact('workspaces', 'userspaces'));
    }
}