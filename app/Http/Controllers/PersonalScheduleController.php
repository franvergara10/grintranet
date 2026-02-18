<?php

namespace App\Http\Controllers;

use App\Models\ScheduleTemplate;
use App\Models\UserSchedule;
use App\Models\ScheduleSelection;
use App\Models\TimeSlot;
use App\Models\Guardia;
use App\Models\Ausencia;
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

    public function show(UserSchedule $personal_schedule)
    {
        if ($personal_schedule->user_id !== Auth::id()) {
            abort(403);
        }

        $personal_schedule->load(['scheduleTemplate.timeSlots', 'selections.guardia']);
        $template = $personal_schedule->scheduleTemplate;
        $slots = $template->timeSlots;
        // Determine today's day indicator (both name and numeric index 1-7 starting Monday)
        $todayEnglish = strtolower(now()->format('l'));
        $daysMap = [
            'monday' => 'lunes',
            'tuesday' => 'martes',
            'wednesday' => 'miércoles',
            'thursday' => 'jueves',
            'friday' => 'viernes',
            'saturday' => 'sábado',
            'sunday' => 'domingo'
        ];
        $todaySpanish = $daysMap[$todayEnglish];
        
        // now()->dayOfWeekIso returns 1 (Monday) through 7 (Sunday)
        $todayIndex = (string) now()->dayOfWeekIso; 

        // Map selections for TODAY ONLY for easier view access
        $todaySelections = $personal_schedule->selections->filter(function ($s) use ($todaySpanish, $todayIndex) {
            $day = strtolower(trim($s->day));
            return $day == $todaySpanish || $day == $todayIndex;
        })->keyBy('time_slot_id');

        // Map absences for TODAY (Excluding the user themselves)
        $todayStr = now()->toDateString();
        $absences = Ausencia::where('fecha', $todayStr)
            ->where('user_id', '!=', Auth::id())
            ->with(['user', 'timeSlot'])
            ->get()
            ->groupBy('time_slot_id');

        return view('personal_schedules.show', compact('personal_schedule', 'template', 'slots', 'todaySpanish', 'todaySelections', 'absences'));
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

        $guardias = Guardia::all();

        return view('personal_schedules.edit', compact('personal_schedule', 'template', 'slots', 'days', 'selections', 'guardias'));
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

                        $data = [];
                        if (str_starts_with($value, 'guardia_')) {
                            $data['guardia_id'] = str_replace('guardia_', '', $value);
                            $data['value'] = 'Guardia';
                        } else {
                            $data['guardia_id'] = null;
                            $data['value'] = $value;
                        }

                        ScheduleSelection::updateOrCreate(
                            [
                                'user_schedule_id' => $personal_schedule->id,
                                'time_slot_id' => $slotId,
                                'day' => $day,
                            ],
                            $data
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
