<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\Task;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\Employer;
use App\Models\VacationRequest;

class EmployerController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('employer')->check()) {
            return redirect('/dashboard');
        }
        return view('employees.login');
    }

    public function login(Request $request)
{
    $request->validate([
        'matricul_employer' => 'required|string',
        'password' => 'required|string',
    ]);

    // Debugging - log the input
    \Log::info('Login attempt:', [
        'matricule' => $request->matricul_employer,
        'password' => $request->password
    ]);

    $employer = Employer::where('matricul_employer', $request->matricul_employer)->first();

    // Debugging - log the query result
    \Log::info('Employer found:', [$employer]);

    if (!$employer) {
        \Log::warning('No employer found with matricule: ' . $request->matricul_employer);
        return back()->withErrors([
            'matricul_employer' => 'The provided credentials do not match our records.',
        ])->onlyInput('matricul_employer');
    }

    // Debugging - log password verification
    \Log::info('Password verification:', [
        'input' => $request->password,
        'stored_hash' => $employer->passwordE,
        'matches' => Hash::check($request->password, $employer->passwordE)
    ]);

    if (!Hash::check($request->password, $employer->passwordE)) {
        \Log::warning('Password mismatch for matricule: ' . $request->matricul_employer);
        return back()->withErrors([
            'password' => 'The provided password is incorrect.',
        ])->onlyInput('matricul_employer');
    }

    if (Auth::guard('employer')->attempt([
        'matricul_employer' => $request->matricul_employer,
        'password' => $request->password
    ], $request->remember)) {
        $request->session()->regenerate();
        \Log::info('Login successful for: ' . $request->matricul_employer);
        return redirect()->intended('/dashboard');
    }

    \Log::error('Unexpected login failure for: ' . $request->matricul_employer);
    return back()->withErrors([
        'matricul_employer' => 'Login failed unexpectedly.',
    ]);
}



public function logout(Request $request)
    {
        Auth::guard('employer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function dashboard()
    {
        $employer = Auth::guard('employer')->user();
        
        $tasks = $employer->tasks()
            ->orderBy('deadline')
            ->get();

        $todayAttendance = $employer->attendances()
            ->whereDate('date', now()->toDateString())
            ->first();

        $attendanceHistory = $employer->attendances()
            ->whereDate('date', '!=', now()->toDateString())
            ->orderBy('date', 'desc')
            ->take(7)
            ->get();

        $vacations = $employer->vacationRequests()
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            $allowEdit = session('edit_mode', false);
        return view('employees.dashboard', compact(
            'employer', 
            'tasks', 
            'todayAttendance', 
            'vacations',
            'attendanceHistory','allowEdit'
        ));
    }

    public function updateTask(Request $request, $task)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in progress,done'
        ]);

        $task = Task::where('matricul_employer', Auth::guard('employer')->user()->matricul_employer)
                    ->findOrFail($task);
        
        $task->update($validated);

        return back()->with('success', 'Task status updated successfully');
    }

    public function recordAttendance(Request $request)
{
    $request->validate([
        'arrival_time' => 'nullable|date_format:H:i',
        'departure_time' => 'nullable|date_format:H:i|after:arrival_time'
    ]);

    $employer = Auth::guard('employer')->user();
    $today = now()->toDateString();

    // Check if attendance already exists for today
    $attendance = $employer->attendances()
        ->whereDate('date', $today)
        ->first();

    if (!$attendance && $request->arrival_time) {
        // Create new attendance record
        $employer->attendances()->create([
            'date' => $today,
            'arrival_time' => $request->arrival_time,
            'status' => 'present'
        ]);
        return back()->with('success', 'Arrival time recorded successfully');
    }

    if ($attendance && $request->departure_time && !$attendance->departure_time) {
        // Update existing record with departure time
        $attendance->update([
            'departure_time' => $request->departure_time,
            'status' => 'completed'
        ]);
        return back()->with('success', 'Departure time recorded successfully');
    }

    return back()->with('error', 'No valid changes made to attendance record');
}

public function getAttendanceHistory(Request $request)
{
    $employer = Auth::guard('employer')->user();
    $daysToShow = $request->input('days', 30);
    
    $startDate = Carbon::now()->subDays($daysToShow);
    $endDate = Carbon::now();
    
    $allDates = [];
    for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
        $allDates[$date->format('Y-m-d')] = [
            'date' => $date->format('Y-m-d'),
            'status' => $date->isWeekend() ? 'weekend' : 'absent',
            'arrival' => null,
            'departure' => null,
            'is_weekend' => $date->isWeekend()
        ];
    }
    
    $attendanceRecords = $employer->attendances()
        ->whereBetween('date', [$startDate, $endDate])
        ->get()
        ->keyBy(function ($item) {
            return Carbon::parse($item->date)->format('Y-m-d');
        });
    
    foreach ($allDates as $date => &$data) {
        if (isset($attendanceRecords[$date])) {
            $record = $attendanceRecords[$date];
            $data['status'] = $record->status;
            $data['arrival'] = $record->arrival_time 
                ? Carbon::parse($record->arrival_time)->format('H:i') 
                : null;
            $data['departure'] = $record->departure_time 
                ? Carbon::parse($record->departure_time)->format('H:i') 
                : null;
        }
    }
    
    return view('employees.attendance_history', [
        'attendance' => $allDates,
        'employer' => $employer,
        'daysToShow' => $daysToShow
    ]);
}

public function showVacationRequestForm()
{
    $employer = Auth::guard('employer')->user();
    return view('employees.vacation', compact('employer'));
}

public function storeVacationRequest(Request $request)
{
    $validated = $request->validate([
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'required|date|after_or_equal:start_date',
        'reason' => 'required|string|max:500',
    ]);

    $employer = Auth::guard('employer')->user();

    VacationRequest::create([
        'matricul_employer' => $employer->matricul_employer,
        'start_date' => $validated['start_date'],
        'end_date' => $validated['end_date'],
        'reason' => $validated['reason'],
        'status' => 'pending',
    ]);

    return redirect()->route('dashboard')->with('success', 'Vacation request submitted successfully!');
}


    // ... [keep all other methods exactly as they were] ...
}