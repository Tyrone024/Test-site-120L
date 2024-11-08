<div class="main p-3">
    @foreach($workspaces as $workspace)
        <div id="workspace{{ $workspace->id }}Content" class="d-none">
            <h2>{{ $workspace->name }} Tasks</h2>
            <table id="workspace{{ $workspace->id }}TasksTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th style="width: 15%">Task Name</th>
                        <th style="width: 40%">Details</th>
                        <th style="width: 10%">Completed</th>
                        <th style="width: 15%">Date Created</th>
                        <th style="width: 20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($workspace->tasks as $task)
                        <tr>
                            <td>{{ $task->name }}</td>
                            <td>{{ $task->detail }}</td>
                            <td>{{ $task->is_completed ? 'Yes' : 'No' }}</td>
                            <td>{{ \Carbon\Carbon::parse($task->created_at)->format('M d, Y')}}</td>
                            <td>
                                <button class="btn btn-dark btn-sm" onclick="showChatInterface({{ $task->id }}, '{{ $task->name }}', '{{ $task->detail }}')">Chat</button>
                                <button class="btn btn-dark btn-sm" onclick="showModifyForm({{ $task->id }}, '{{ $task->name }}', '{{ $task->detail }}', {{ $task->is_completed ? 'true' : 'false' }});">Modify</button>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this task?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button class="btn btn-primary btn-lg" onclick="showAddTaskForm({{ $workspace->id }}); return false;">Add Task</button>
            <h2>Workspace Statistics</h2>
            <table class="table table-striped table-bordered" style="width:25%">
                <tbody>
                    <tr>
                        <td style="width: 80%"><strong>Total Tasks</strong></td>
                        <td style="width: 20%">{{ $workspace->tasks->count() }}</td>
                    </tr>
                    <tr>
                        <td><strong>Completed Tasks</strong></td>
                        <td>{{ $workspace->tasks->where('is_completed', true)->count() }}</td>
                    </tr>
                    <tr>
                        <td><strong>Remaining Tasks</strong></td>
                        <td>{{ $workspace->tasks->where('is_completed', false)->count() }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total Users</strong></td>
                        <td>{{ collect($userspaces)->where('workspace_id', $workspace->id)->where('request', false)->count() + 1}}</td>
                    </tr>
                </tbody>
            </table>
            <h2>Other Users</h2>
            <table id="userTable" class="table table-striped table-bordered" style="width:25%">
                <thead>
                    <tr>
                        <th style="width: 75%">User Name</th>
                        <th style="width: 25%"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($userspaces as $userspace)
                        @if ($userspace['workspace_id'] == $workspace->id and $userspace['request'] == false)  <!-- Check if request is true -->
                            <tr>
                                <td>{{ $userspace['user_name'] }}</td> <!-- Include user name -->
                                <td>
                                    <!-- Form for rejecting the request -->
                                    <form action="{{ route('requests.delete', [$userspace['user_id'], $userspace['workspace_id']]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE') <!-- Specify the DELETE method -->
                                        <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
    <div id="createContent" class="d-none">
        <h2>Create Workspace</h2>
        <form id="createWorkspaceForm" method="POST" action="{{ route('workspaces.store') }}">
            @csrf <!-- Add CSRF token for security -->
            <div class="form-group">
                <label for="workspaceName">Workspace Name</label>
                <input type="text" class="form-control" name="name" id="workspaceName" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="detail" id="description" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-lg">Create</button>
        </form>
    </div>

    <div id="manageContent" class="d-none">
        <h2>Manage Workspaces</h2>
        <table id="workspace{{ $workspace->id }}TasksTable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th style="width: 15%">Workspace Name</th>
                    <th style="width: 50%">UUID</th>
                    <th style="width: 20%">
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($workspaces as $workspace)
                <tr>
                    <td>{{ $workspace->name }}</td>
                    <td>{{ $workspace->uuid }}</td>
                    <td>
                        <button class="btn btn-dark btn-sm" onclick="showModifyWorkspaceForm({{ $workspace->id }}, '{{ $workspace->name }}', '{{ $workspace->detail }}');">Modify</button>
                        <form action="{{ route('workspaces.destroy', $workspace->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this workspace?');">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="joinContent" class="d-none">
        <h2>Join Workspace</h2>
        <form action="{{ route('requests.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="workspaceUUID">Workspace UUID</label>
                <input type="text" class="form-control" id="workspaceUUID" name="workspaceUUID" required>
            </div>
            <button type="submit" class="btn btn-primary btn-lg">Join</button>
        </form>
    </div>

    <div id="requestsContent" class="d-none">
        <h2>Requests</h2>
        <table id="requestsTable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th style="width: 30%">Workspace Name</th>
                    <th style="width: 50%">User Name</th>
                    <th style="width: 20%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($userspaces as $userspace)
                    @if ($userspace['request'] == true)  <!-- Check if request is true -->
                        <tr>
                            <td>{{ $userspace['workspace_name'] }}</td> <!-- Include workspace name -->
                            <td>{{ $userspace['user_name'] }}</td> <!-- Include user name -->
                            <td>
                                <!-- Form for accepting the request -->
                                <form action="{{ route('requests.update', [$userspace['user_id'], $userspace['workspace_id']]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT') <!-- Specify the PUT method for updating -->
                                    <button type="submit" class="btn btn-dark btn-sm">Accept</button>
                                </form>

                                <!-- Form for rejecting the request -->
                                <form action="{{ route('requests.delete', [$userspace['user_id'], $userspace['workspace_id']]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE') <!-- Specify the DELETE method -->
                                    <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                </form>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <div id="modifyTaskContent" class="d-none">
        <h2>Edit Task</h2>
        <form id="modifyTaskForm" method="POST" action="{{ route('tasks.update', 'taskId') }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="taskName">Task Name</label>
                <input type="text" class="form-control" name="name" id="taskName" required>
            </div>
            <div class="form-group">
                <label for="taskDetailsUpdate">Details</label>
                <textarea class="form-control" name="detail" id="taskDetailsUpdate" required></textarea>
            </div>
            <div class="form-group">
                <label for="isCompleted">Completed</label>
                <input type="checkbox" name="is_completed" id="isCompleted">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <div id="addTaskContent" class="d-none">
        <h2>Add Task</h2>
        <form id="addTaskForm" method="POST" action="{{ route('tasks.store') }}">
            @csrf
            <div class="form-group">
                <label for="taskName">Task Name</label>
                <input type="text" class="form-control" name="name" id="taskName" required>
            </div>
            <div class="form-group">
                <label for="taskDetails">Details</label>
                <textarea class="form-control" name="detail" required></textarea>
            </div>
            <input type="hidden" name="workspace_id" id="workspaceId" value="">
            <button type="submit" class="btn btn-primary btn-lg">Add</button>
        </form>
    </div>

    <div id="modifyWorkspaceContent" class="d-none">
        <h2>Edit Workspace</h2>
        <form id="modifyWorkspaceForm" method="POST" action="{{ route('workspaces.update', 'workspaceId') }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                    <label for="workspaceNameChange">Workspace Name</label>
                    <input type="text" class="form-control" name="name" id="workspaceNameChange" required>
                </div>
            <div class="form-group">
                <label for="workspaceDetails">Description</label>
                <textarea class="form-control" name="detail" id="workspaceDetails" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

   <div id="chatInterface" class="d-none">
       <h2>Chat with AI</h2>
       <div class="form-group">
           <textarea id="userPrompt" class="form-control" placeholder="Type your message here..."></textarea>
        </div>
        <div class="form-group">
           <button class="btn btn-primary btn-lg" id="sendChatButton">Send</button>
           <div id="chatResponses"></div>
           <textarea id="aiResponse" class="form-control" rows="8" readonly placeholder="AI response will appear here..."></textarea>
       </div>
   </div>
   @if(session('success'))
       <div class="alert alert-success">{{ session('success') }}</div>
   @endif
</div>