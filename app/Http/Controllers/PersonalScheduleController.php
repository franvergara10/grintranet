<?php

namespace App\Http\Controllers;

use App\Models\ScheduleTemplate;
use App\Models\UserSchedule;
use App\Models\ScheduleSelection;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PersonalScheduleController extends Controller
{
    public function index()
    {
        $schedules = UserSchedule::where('user_id', Auth::id())
            ->with('scheduleTemplate')
            ->get();

        return view('personal_schedules.index', compact('schedules'));
    }

    public function create()
    {
        $templates = ScheduleTemplate::all();
        return view('personal_schedules.create', compact('templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'schedule_template_id' => 'required|exists:schedule_templates,id',
        ]);

        $personalSchedule = UserSchedule::firstOrCreate([
            'user_id' => Auth::id(),
            'schedule_template_id' => $request->schedule_template_id,
        ]);

        return redirect()->route('personal-schedules.edit', $personalSchedule)
            ->with('success', 'Horario personal creado. ¡Ahora puedes rellenarlo!');
    }

    public function edit(UserSchedule $personal_schedule)
    {
        // Enforce ownership
        if ($personal_schedule->user_id !== Auth::id()) {
            abort(403);
        }

        $personal_schedule->load(['scheduleTemplate.timeSlots', 'selections']);
        $template = $personal_schedule->scheduleTemplate;
        $slots = $template->timeSlots;
        $days = $template->active_days ?? ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
        
        $selections = $personal_schedule->selections->groupBy(function($item) {
            return $item->time_slot_id . '-' . $item->day;
        })->map->first();

        // Possible values for the dropdown
        $options = [
            '' => 'Vacío',
            'Guardia' => 'Guardia',
        ];

        return view('personal_schedules.edit', compact('personal_schedule', 'template', 'slots', 'days', 'selections', 'options'));
    }

    public function update(Request $request, UserSchedule $personal_schedule)
    {
        if ($personal_schedule->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'selections' => 'nullable|array',
            'selections.*.*' => 'nullable|string|max:255', // slot_id => day => value
        ]);

        try {
            DB::beginTransaction();

            if ($request->has('selections')) {
                foreach ($request->selections as $slotId => $days) {
                    foreach ($days as $day => $value) {
                        if (empty($value)) {
                            ScheduleSelection::where('user_schedule_id', $personal_schedule->id)
                                ->where('time_slot_id', $slotId)
                                ->where('day', $day)
                                ->delete();
                            continue;
                        }

                        ScheduleSelection::updateOrCreate(
                            [
                                'user_schedule_id' => $personal_schedule->id,
                                'time_slot_id' => $slotId,
                                'day' => $day,
                            ],
                            ['value' => $value]
                        );
                    }
                }
            }

            DB::commit();

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Horario actualizado correctamente.']);
            }

            return redirect()->route('personal-schedules.index')
                ->with('success', 'Horario actualizado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return back()->with('error', 'Error al guardar: ' . $e->getMessage());
        }
    }

    public function destroy(UserSchedule $personal_schedule)
    {
        if ($personal_schedule->user_id !== Auth::id()) {
            abort(403);
        }

        $personal_schedule->delete();

        return redirect()->route('personal-schedules.index')
            ->with('success', 'Horario personal eliminado.');
    }
}
