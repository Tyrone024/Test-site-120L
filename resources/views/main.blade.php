<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPA</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
</head>

<body>
    <div class="wrapper">
        <x-sidebar :workspaces="$workspaces" />
        <x-body-content :workspaces="$workspaces" :userspaces="$userspaces" />
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="{{ asset('js/sidebar.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTables
            @foreach($workspaces as $workspace)
                $('#workspace{{ $workspace->id }}TasksTable').DataTable({
                    paging: true,
                    searching: true,
                    columnDefs: [
                        {
                            targets: [0, 1, 2, 3],
                            orderable: true
                        },
                        {
                            targets: [4],
                            orderable: false
                        }
                    ]
                });
            @endforeach
            $('#requestsTable').DataTable();

            // Event listener for showing content
            $('.nav-link').on('click', function() {
                const contentId = $(this).data('content');
                showContent(contentId);
            });
        });

        // Function to show specific content and hide others
        function showContent(contentId) {
            // Hide all content divs
            $('.main > div').addClass('d-none');

            // Show the selected content
            $('#' + contentId).removeClass('d-none');
        }

        // Function to show the Add Task form
        function showAddTaskForm(workspaceId) {
            document.getElementById('workspaceId').value = workspaceId; // Set the workspace ID in the hidden input
            showContent('addTaskContent'); // Show the Add Task form
        }

        // Function to show the Modify Task form
        function showModifyForm(taskId, taskName, taskDetailsUpdate, isCompleted) {
            const form = document.getElementById('modifyTaskForm');
            form.action = form.action.replace('taskId', taskId);
            document.getElementById('taskName').value = taskName;
            document.getElementById('taskDetailsUpdate').value = taskDetailsUpdate;
            document.getElementById('isCompleted').checked = isCompleted;
            showContent('modifyTaskContent'); // Show the Modify Task form
        }

        function showModifyWorkspaceForm(workspaceId, workspaceName, workspaceDetails) {
            const form = document.getElementById('modifyWorkspaceForm');
            form.action = form.action.replace('workspaceId', workspaceId);
            document.getElementById('workspaceNameChange').value = workspaceName;
            document.getElementById('workspaceDetails').value = workspaceDetails;
            showContent('modifyWorkspaceContent');
        }

        function deleteWorkspace(workspaceId) {
            if (confirm('Are you sure you want to delete this workspace?')) {
                $.ajax({
                    url: '/workspace/' + workspaceId, // Replace with your actual route
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Laravel CSRF token
                    },
                    success: function() {
                        location.reload(); // Reload the page to reflect changes
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error:', textStatus, errorThrown);
                        alert('Failed to delete the workspace.');
                    }
                });
            }
        }

        // Function to show the Chat interface
        function showChatInterface(taskId, taskName, taskDetails) {
            currentTaskId = taskId;
            currentTaskName = taskName;
            currentTaskDetails = taskDetails;
            showContent('chatInterface'); // Show the Chat interface
            document.getElementById('chatResponses').innerHTML = ''; // Clear previous responses
            document.getElementById('userPrompt').value = ''; // Clear the input
        }

        // Function to send chat message to the AI
        document.getElementById('sendChatButton').addEventListener('click', function() {
            const userPrompt = document.getElementById('userPrompt').value;

            if (!userPrompt.trim()) {
                alert('Please enter a message.');
                return;
            }

            $.ajax({
                url: '/chat', // Replace with your actual route
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    name: currentTaskName,
                    details: currentTaskDetails,
                    userPrompt: userPrompt
                }),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Laravel CSRF token
                },
                success: function(data) {
                    document.getElementById('aiResponse').value = data.response; // Display AI response
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error:', textStatus, errorThrown);
                    alert('Failed to get a response from the AI service.');
                }
            });
        });
    </script>
</body>
</html>