<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Ausencia;
use App\Models\Group;
use App\Models\TimeSlot;
use App\Models\Zona;
use Illuminate\Support\Facades\Auth;

class AusenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        
        $ausencias = Ausencia::whereDate('fecha', $date)
            ->where('user_id', Auth::id())
            ->with(['user', 'timeSlot', 'group', 'zona'])
            ->get()
            ->groupBy('time_slot_id');

        $timeSlots = TimeSlot::orderBy('start_time')->get();

        return view('ausencias.index', compact('ausencias', 'timeSlots', 'date'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $tramos = TimeSlot::orderBy('start_time')->get();
        $grupos = Group::all();
        $zonas = Zona::all();
        
        // Pre-selection from query params
        $selectedTimeSlot = $request->input('time_slot_id');
        $selectedDate = $request->input('date', date('Y-m-d'));

        return view('ausencias.create', compact('tramos', 'grupos', 'zonas', 'selectedTimeSlot', 'selectedDate'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'time_slot_id' => 'required|exists:time_slots,id',
            'group_id' => 'required|exists:groups,id',
            'zona_id' => 'required|exists:zonas,id',
            'tarea' => 'required|string',
        ]);

        Ausencia::create([
            'user_id' => Auth::id(),
            'fecha' => $request->fecha,
            'time_slot_id' => $request->time_slot_id,
            'group_id' => $request->group_id,
            'zona_id' => $request->zona_id,
            'tarea' => $request->tarea,
        ]);

        return redirect()->route('ausencias.index')->with('success', 'Ausencia creada correctamente.');
    }
}
