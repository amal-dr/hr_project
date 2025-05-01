<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<div class="container">
    <h2>Manager Dashboard</h2>
    
    <!-- Employees Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h4>My Employees</h4>
            <a href="{{ route('manager.employees.create') }}" class="btn btn-primary">Add Employee</a>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Matricule</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $employee)
                    <tr>
                        <td>{{ $employee->matricul_employer }}</td>
                        <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>
                            <a href="{{ route('manager.employees.edit', $employee->id) }}" class="btn btn-sm btn-info">Edit</a>
                            <form action="{{ route('manager.employees.destroy', $employee->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Vacation Requests Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h4>Pending Vacation Requests</h4>
        </div>
        <div class="card-body">
            @if($vacationRequests->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Dates</th>
                        <th>Reason</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vacationRequests as $request)
                    <tr>
                        <td>{{ $request->employer->first_name }} {{ $request->employer->last_name }}</td>
                        <td>{{ $request->start_date->format('m/d/Y') }} to {{ $request->end_date->format('m/d/Y') }}</td>
                        <td>{{ Str::limit($request->reason, 50) }}</td>
                        <td>
                            <form action="{{ route('manager.vacation.approve', $request->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Approve</button>
                            </form>
                            <form action="{{ route('manager.vacation.reject', $request->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p>No pending vacation requests</p>
            @endif
        </div>
    </div>
    
    <!-- Tasks Section -->
    <div class="card">
        <div class="card-header">
            <h4>Department Tasks</h4>
            <a href="{{ route('manager.tasks.create') }}" class="btn btn-primary">Add Task</a>
        </div>
        <div class="card-body">
            <!-- Task listing similar to employee dashboard -->
        </div>
    </div>
</div>

</body>
</html>