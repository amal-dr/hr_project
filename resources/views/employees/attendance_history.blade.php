<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Attendance History - {{ $employer->prenom }} {{ $employer->nom }}</span>
                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary">
                        Back to Dashboard
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Day</th>
                                    <th>Status</th>
                                    <th>Arrival Time</th>
                                    <th>Departure Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendance as $record)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($record['date'])->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($record['date'])->englishDayOfWeek }}</td>
                                    <td>
                                        <span class="badge bg-{{ $record['status'] == 'present' ? 'success' : 'danger' }}">
                                            {{ ucfirst($record['status']) }}
                                        </span>
                                    </td>
                                    <td>{{ $record['arrival'] ?? '--:--' }}</td>
                                    <td>{{ $record['departure'] ?? '--:--' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>