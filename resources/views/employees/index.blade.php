<!DOCTYPE html>
<html>
<head>
    <title>Employee Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Employee Portal</a>
            <div class="navbar-nav">
                <a class="nav-link" href="{{ route('employees.profile') }}">Profile</a>
                <a class="nav-link" href="{{ route('employees.logout') }}">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Welcome, {{ $employer->prenom }} {{ $employer->nom }}</h2>
        
        <div class="row mt-4">
            <!-- Tasks Section -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Your Tasks</div>
                    <div class="card-body">
                        @if($tasks->count() > 0)
                            <ul class="list-group">
                                @foreach($tasks as $task)
                                <li class="list-group-item">
                                    <h5>{{ $task->description }}</h5>
                                    <p>Status: {{ ucfirst($task->status) }}</p>
                                    <p>Deadline: {{ $task->deadline->format('d/m/Y') }}</p>
                                </li>
                                @endforeach
                            </ul>
                        @else
                            <p>No tasks assigned</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Attendance Section -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Today's Attendance</div>
                    <div class="card-body">
                        @if($todayAttendance)
                            <p>Arrival: {{ $todayAttendance->arrival_time->format('H:i') }}</p>
                            @if($todayAttendance->departure_time)
                                <p>Departure: {{ $todayAttendance->departure_time->format('H:i') }}</p>
                            @else
                                <form method="POST" action="{{ route('employees.record-attendance') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Record Departure</button>
                                </form>
                            @endif
                        @else
                            <form method="POST" action="{{ route('employees.record-attendance') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary">Record Arrival</button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Vacation Requests -->
                <div class="card mt-4">
                    <div class="card-header">Your Vacation Requests</div>
                    <div class="card-body">
                        <a href="{{ route('employees.vacation-request') }}" class="btn btn-success mb-3">Request Vacation</a>
                        @if($vacations->count() > 0)
                            <ul class="list-group">
                                @foreach($vacations as $vacation)
                                <li class="list-group-item">
                                    <p>{{ $vacation->start_date->format('d/m/Y') }} to {{ $vacation->end_date->format('d/m/Y') }}</p>
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
</body>
</html>