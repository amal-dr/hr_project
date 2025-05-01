<!DOCTYPE html>
<html>
<head>
    <title>Employee Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .task-item:hover {
            background-color: #f8f9fa;
            cursor: pointer;
        }
        .attendance-history {
            max-height: 300px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Employee Portal</a>
            <div class="navbar-nav">
                <a class="nav-link" href="{{ route('profile') }}">Profile</a>
                <a class="nav-link" href="{{ route('logout') }}" 
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
   Logout
</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Welcome, {{ $employer->prenom }} {{ $employer->nom }}</h2>
        
        <div class="row mt-4">
            <!-- Tasks Section -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Your Tasks</span>
                    </div>
                    <div class="card-body">
                        @if($tasks->count() > 0)
                            <ul class="list-group">
                                @foreach($tasks as $task)
                                <li class="list-group-item task-item" data-bs-toggle="modal" data-bs-target="#taskModal-{{ $task->id }}">
                                    <h5>{{ $task->description }}</h5>
                                    <p>Status: <span class="badge bg-{{ $task->status == 'done' ? 'success' : ($task->status == 'in progress' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($task->status) }}
                                    </span></p>
                                    <p>Deadline: {{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') : 'Not set' }}</p>
                                </li>

                                <!-- Task Modal -->
                                <div class="modal fade" id="taskModal-{{ $task->id }}" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="taskModalLabel">Update Task Status</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="POST" action="{{ route('task.update', $task->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <h6>{{ $task->description }}</h6>
                                                    <p>Deadline: {{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') : 'Not set' }}</p>
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label">Status</label>
                                                        <select class="form-select" name="status">
    <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
    <option value="in progress" {{ $task->status == 'in progress' ? 'selected' : '' }}>In Progress</option>
    <option value="done" {{ $task->status == 'done' ? 'selected' : '' }}>Done</option>
</select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Update Status</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </ul>
                        @else
                            <p>No tasks assigned</p>
                        @endif
                    </div>
                </div>
            </div>

          <!-- Attendance Card -->
<!-- Attendance Card -->
<!-- Attendance Card -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Today's Attendance - {{ \Carbon\Carbon::now()->format('l, F j, Y') }}</span>
        <a href="{{ route('attendance.history') }}" class="btn btn-sm btn-outline-primary">
            View History
        </a>
    </div>
    <div class="card-body">
        <!-- Current Status Display -->
        @if($todayAttendance)
            <div class="mb-3">
                <p><strong>Arrival Time:</strong> 
                    @if($todayAttendance->arrival_time)
                        <span class="text-success">{{ \Carbon\Carbon::parse($todayAttendance->arrival_time)->format('g:i A') }}</span>
                    @else
                        <span class="text-danger">Not recorded</span>
                    @endif
                </p>
                <p><strong>Leave Time:</strong> 
                    @if($todayAttendance->leave_time)
                        <span class="text-success">{{ \Carbon\Carbon::parse($todayAttendance->leave_time)->format('g:i A') }}</span>
                    @else
                        <span class="text-danger">Not recorded</span>
                    @endif
                </p>
                <p><strong>Status:</strong> 
                    <span class="badge bg-{{ $todayAttendance->status == 'present' ? 'success' : ($todayAttendance->status == 'absent' ? 'danger' : 'warning') }}">
                        {{ ucfirst($todayAttendance->status) }}
                    </span>
                </p>
            </div>
        @else
            <p class="text-muted">No attendance recorded for today</p>
        @endif

        <!-- Attendance Recording Form -->
        <form method="POST" action="{{ route('attendance.record') }}" id="attendanceForm">
            @csrf
            
            <div class="row g-3 mb-3">
                <!-- Arrival Time Field -->
                <div class="col-md-6">
                    <label for="arrival_time" class="form-label">Arrival Time</label>
                    @if($todayAttendance && $todayAttendance->arrival_time)
                        <input type="time" class="form-control" 
                               value="{{ \Carbon\Carbon::parse($todayAttendance->arrival_time)->format('H:i') }}" 
                               disabled>
                    @else
                        <div class="input-group">
                            <input type="time" class="form-control" id="arrival_time" name="arrival_time" 
                                   value="{{ old('arrival_time') }}">
                            <button class="btn btn-outline-secondary" type="button" onclick="setCurrentTime('arrival_time')">
                                <i class="bi bi-clock"></i> Now
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Leave Time Field (renamed from departure_time) -->
                <div class="col-md-6">
                    <label for="leave_time" class="form-label">Leave Time</label>
                    @if($todayAttendance && $todayAttendance->leave_time)
                        <div class="input-group">
                            <input type="time" class="form-control" 
                                   value="{{ \Carbon\Carbon::parse($todayAttendance->leave_time)->format('H:i') }}" 
                                   disabled>
                            <button class="btn btn-outline-secondary" type="button" onclick="enableEdit(this, 'leave_time')">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                        </div>
                        <input type="hidden" name="leave_time" 
                               value="{{ \Carbon\Carbon::parse($todayAttendance->leave_time)->format('H:i') }}">
                    @else
                        <div class="input-group">
                            <input type="time" class="form-control" id="leave_time" name="leave_time" 
                                   value="{{ old('leave_time') }}">
                            <button class="btn btn-outline-secondary" type="button" onclick="setCurrentTime('leave_time')">
                                <i class="bi bi-clock"></i> Now
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Save Attendance
                </button>
                
                @if(!$todayAttendance)
                <button type="button" class="btn btn-success" onclick="recordBothTimes()">
                    <i class="bi bi-check-circle"></i> Record Both Now
                </button>
                @endif
            </div>
        </form>
    </div>
</div>

<script>
// Set current time to specified field
function setCurrentTime(fieldId) {
    const now = new Date();
    const timeString = now.getHours().toString().padStart(2, '0') + ':' + 
                       now.getMinutes().toString().padStart(2, '0');
    
    document.getElementById(fieldId).value = timeString;
}

// Enable editing of leave time
function enableEdit(button, fieldName) {
    const inputGroup = button.closest('.input-group');
    const timeInput = inputGroup.querySelector('input[type="time"]');
    const hiddenInput = inputGroup.nextElementSibling;
    
    // Create new editable input
    const newInput = document.createElement('input');
    newInput.type = 'time';
    newInput.className = 'form-control';
    newInput.id = fieldName;
    newInput.name = fieldName;
    newInput.value = timeInput.value;
    
    // Create new "Now" button
    const nowButton = document.createElement('button');
    nowButton.className = 'btn btn-outline-secondary';
    nowButton.type = 'button';
    nowButton.innerHTML = '<i class="bi bi-clock"></i> Now';
    nowButton.onclick = function() { setCurrentTime(fieldName); };
    
    // Replace the elements
    inputGroup.innerHTML = '';
    inputGroup.appendChild(newInput);
    inputGroup.appendChild(nowButton);
    if (hiddenInput) hiddenInput.remove();
    
    newInput.focus();
}

// Record both arrival and leave with current time
function recordBothTimes() {
    setCurrentTime('arrival_time');
    setCurrentTime('leave_time');
    document.getElementById('attendanceForm').submit();
}
</script>

<script>
// Set current time to specified field
function setCurrentTime(fieldId) {
    const now = new Date();
    const timeString = now.getHours().toString().padStart(2, '0') + ':' + 
                       now.getMinutes().toString().padStart(2, '0');
    
    document.getElementById(fieldId).value = timeString;
}

// Enable editing of departure time
function enableEdit(button, fieldName) {
    const inputGroup = button.closest('.input-group');
    const timeInput = inputGroup.querySelector('input[type="time"]');
    const hiddenInput = inputGroup.nextElementSibling;
    
    // Create new editable input
    const newInput = document.createElement('input');
    newInput.type = 'time';
    newInput.className = 'form-control';
    newInput.id = fieldName;
    newInput.name = fieldName;
    newInput.value = timeInput.value;
    
    // Create new "Now" button
    const nowButton = document.createElement('button');
    nowButton.className = 'btn btn-outline-secondary';
    nowButton.type = 'button';
    nowButton.innerHTML = '<i class="bi bi-clock"></i> Now';
    nowButton.onclick = function() { setCurrentTime(fieldName); };
    
    // Replace the elements
    inputGroup.innerHTML = '';
    inputGroup.appendChild(newInput);
    inputGroup.appendChild(nowButton);
    if (hiddenInput) hiddenInput.remove();
    
    newInput.focus();
}

// Record both arrival and departure with current time
function recordBothTimes() {
    setCurrentTime('arrival_time');
    setCurrentTime('departure_time');
    document.getElementById('attendanceForm').submit();
}
</script>
                <!-- Vacation Requests Card -->
                <div class="card mt-4">
                    <div class="card-header">Your Vacation Requests</div>
                    <div class="card-body">
                        <a href="{{ route('vacation.request') }}" class="btn btn-success mb-3">Request Vacation</a>
                        @if($vacations->count() > 0)
                            <ul class="list-group">
                                @foreach($vacations as $vacation)
                                <li class="list-group-item">
                                    <p>
                                        {{ \Carbon\Carbon::parse($vacation->start_date)->format('d/m/Y') }} to 
                                        {{ \Carbon\Carbon::parse($vacation->end_date)->format('d/m/Y') }}
                                    </p>
                                    <p>Status: 
                                        <span class="badge bg-{{ $vacation->status == 'approved' ? 'success' : ($vacation->status == 'rejected' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($vacation->status) }}
                                        </span>
                                    </p>
                                </li>
                                @endforeach
                            </ul>
                        @else
                            <p>No vacation requests</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>