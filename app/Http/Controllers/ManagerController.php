<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Models\Employer;
use App\Models\VacationRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    public function showLoginForm()
    {
        return view('managers.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'matricul_manager' => 'required',
            'password' => 'required',
        ]);

        $manager = Manager::where('matricul_manager', $request->matricul_manager)->first();

        if (!$manager || !Hash::check($request->password, $manager->passwordM)) {
            return back()->withErrors([
                'matricul_manager' => 'Invalid credentials',
            ])->withInput($request->only('matricul_manager'));
        }

        Auth::guard('manager')->login($manager);
        return redirect()->route('manager.dashboard');
    }

    public function dashboard()
    {
        $manager = Auth::guard('manager')->user();
        
        // Get all employees in same apartment
        $employees = Employer::where('apartment_id', $manager->apartment_id)->get();
        
        // Get pending vacation requests
        $vacationRequests = VacationRequest::with('employer')
            ->whereIn('matricul_employer', $employees->pluck('matricul_employer'))
            ->where('status', 'pending')
            ->get();
        
        // Get all tasks for the department
        $tasks = Task::where('matricul_manager', $manager->matricul_manager)
            ->orderBy('deadline')
            ->get();

        return view('managers.dashboard', compact(
            'manager', 
            'employees',
            'vacationRequests',
            'tasks'
        ));
    }

    public function approveVacation($id)
    {
        $vacation = VacationRequest::findOrFail($id);
        $vacation->update(['status' => 'approved']);
        return back()->with('success', 'Vacation request approved');
    }

    public function rejectVacation($id)
    {
        $vacation = VacationRequest::findOrFail($id);
        $vacation->update(['status' => 'rejected']);
        return back()->with('success', 'Vacation request rejected');
    }

    public function logout(Request $request)
    {
        Auth::guard('manager')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/manager/login');
    }
}