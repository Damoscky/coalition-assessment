<!DOCTYPE html>
<html>
<head>
    <title>Task Manager</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .draggable { cursor: move; }
    </style>
</head>
<body>
<div class="container">
    <h1>Task Manager</h1>

    <form action="{{ route('projects.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="project">New Project</label>
            <input type="text" required name="name" class="form-control" id="project" placeholder="Project Name">
        </div>
        <button type="submit" class="btn btn-primary">Add Project</button>
    </form>

    <br>

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="projectSelect">Select Project</label>
            <select class="form-control" id="projectSelect" name="project_id" onchange="window.location.href = '{{ route('tasks.index') }}?project_id=' + this.value;">
                <option value="">Select a project</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ $project_id == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                @endforeach
            </select>
        </div>
        @if($project_id)
            <div class="form-group">
                <label for="task">New Task</label>
                <input type="text" name="name" required class="form-control" id="task" placeholder="Task Name">
            </div>
            <button type="submit" class="btn btn-primary">Add Task</button>
        @endif
    </form>

    <br>

    <ul class="list-group" id="taskList">
        @foreach($tasks as $task)
            <li class="list-group-item draggable" data-id="{{ $task->id }}">
                {{ $task->name }}
                <button class="btn btn-secondary btn-sm float-right" onclick="editTask({{ $task->id }}, '{{ $task->name }}')">Edit</button>
                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm float-right mr-2">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>

    <!-- Edit Task Modal -->
    <div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editTaskForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editTaskName">Task Name</label>
                            <input type="text" name="name" class="form-control" id="editTaskName">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
$(function() {
    $("#taskList").sortable({
        update: function(event, ui) {
            var tasks = $(this).sortable('toArray', { attribute: 'data-id' });
            $.ajax({
                url: '{{ route("tasks.reorder") }}',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    tasks: tasks
                }
            });
        }
    });
});

function editTask(id, name) {
    $('#editTaskForm').attr('action', '/tasks/' + id);
    $('#editTaskName').val(name);
    $('#editTaskModal').modal('show');
}
</script>
</body>
</html>
