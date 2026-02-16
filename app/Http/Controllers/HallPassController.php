<?php

namespace App\Http\Controllers;

use App\Models\HallPass;
use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;

class HallPassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Teacher Dashboard
        // Get all groups
        $groups = Group::orderBy('name')->get();

        // Get students (Users with role 'alumno') ordered by Group then Name
        // We need to eager load groupRel (from User model)
        $students = User::role('alumno')
            ->with('groupRel')
            ->get()
            ->sortBy([
                ['groupRel.course', 'asc'],
                ['groupRel.name', 'asc'],
                ['name', 'asc']
            ]);

        // Active passes
        $activePasses = HallPass::whereNull('end_time')->with(['student.groupRel'])->get();

        // Statistics
        $stats = [
            'active_count' => $activePasses->count(),
            'today_count' => HallPass::whereDate('date', now()->toDateString())->count(),
        ];

        return view('aula.dashboard', compact('students', 'activePasses', 'groups', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id', // 'student_id' comes from frontend but maps to 'user_id'
            'reason' => 'required|string|max:255',
        ]);

        // Check active pass
        $activePass = HallPass::where('user_id', $request->student_id)
            ->whereNull('end_time')
            ->first();

        if ($activePass) {
            return response()->json(['error' => 'El alumno ya tiene un pase activo.'], 400);
        }

        $pass = HallPass::create([
            'user_id' => $request->student_id,
            'teacher_id' => auth()->id(),
            'reason' => $request->reason,
            'date' => now()->format('Y-m-d'),
            'start_time' => now(),
        ]);

        return response()->json($pass->load('student'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HallPass $hallPass)
    {
        $hallPass->update([
            'end_time' => now(),
        ]);

        return response()->json($hallPass);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
    }

    public function monitor()
    {
        // Conserje View
        $activePasses = HallPass::whereNull('end_time')
            ->with(['student.groupRel', 'teacher'])
            ->orderBy('start_time', 'desc')
            ->get();
            
        return view('aula.monitor', compact('activePasses'));
    }

    public function returnAll(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
        ]);

        $affected = HallPass::whereNull('end_time')
            ->whereHas('student', function($q) use ($request) {
                $q->where('group_id', $request->group_id);
            })
            ->update(['end_time' => now()]);
            
        return response()->json(['message' => "Finalizados $affected pases."]);
    }

    public function history()
    {
        $passes = HallPass::with(['student.groupRel', 'teacher'])
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(20);
            
        return view('aula.history', compact('passes'));
    }
}
