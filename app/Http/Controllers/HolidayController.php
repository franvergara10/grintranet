<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HolidayController extends Controller
{
    public function index(Request $request)
    {
        $view = $request->get('view', 'academic');
        $dateParam = $request->get('date', date('Y-m-d'));
        $currentDate = Carbon::parse($dateParam);
        $holidays = Holiday::all();
        
        $months = [];

        if ($view === 'academic') {
            // Logic for academic year (Sept to June)
            $academicStart = Carbon::create($currentDate->year, 9, 1);
            if ($currentDate->month <= 6) {
                $academicStart->subYear();
            }

            for ($i = 0; $i < 10; $i++) {
                $month = clone $academicStart;
                $months[] = [
                    'name' => $month->translatedFormat('F Y'),
                    'month' => $month->month,
                    'year' => $month->year,
                    'days' => $this->generateCalendarDays($month, $holidays),
                ];
                $academicStart->addMonth();
            }
        } elseif ($view === 'monthly') {
            $month = clone $currentDate->startOfMonth();
            $months[] = [
                'name' => $month->translatedFormat('F Y'),
                'month' => $month->month,
                'year' => $month->year,
                'days' => $this->generateCalendarDays($month, $holidays),
            ];
        } elseif ($view === 'weekly') {
            $startOfWeek = clone $currentDate->startOfWeek(Carbon::MONDAY);
            $days = [];
            for ($i = 0; $i < 7; $i++) {
                $dayDate = clone $startOfWeek;
                $isHoliday = $holidays->contains(function ($holiday) use ($dayDate) {
                    return Carbon::parse($holiday->date)->isSameDay($dayDate);
                });
                
                $holidayData = $isHoliday ? $holidays->first(function ($holiday) use ($dayDate) {
                    return Carbon::parse($holiday->date)->isSameDay($dayDate);
                }) : null;

                $days[] = [
                    'day' => $dayDate->day,
                    'date' => $dayDate->toDateString(),
                    'is_holiday' => $isHoliday,
                    'holiday_name' => $holidayData ? $holidayData->name : null,
                    'description' => $holidayData ? $holidayData->description : null,
                    'id' => $holidayData ? $holidayData->id : null,
                    'is_weekend' => $dayDate->isWeekend(),
                    'is_today' => $dayDate->isToday(),
                    'full_name' => $dayDate->translatedFormat('l d'),
                ];
                $startOfWeek->addDay();
            }
            $months[] = [
                'name' => 'Semana del ' . $currentDate->startOfWeek(Carbon::MONDAY)->format('d/m/Y'),
                'days' => $days,
                'is_weekly' => true
            ];
        }

        return view('calendar.index', compact('months', 'holidays', 'view', 'dateParam'));
    }

    private function generateCalendarDays($date, $holidays)
    {
        // ... (existing helper remains essentially the same, but let's make sure it's clean)
        $daysInMonth = $date->daysInMonth;
        $tempDate = $date->copy()->startOfMonth();
        $firstDayOfWeek = $tempDate->dayOfWeek; // 0 (Sun) to 6 (Sat)
        
        // Adjust for Monday start
        $firstDayOfWeek = ($firstDayOfWeek + 6) % 7; 

        $days = [];
        for ($i = 0; $i < $firstDayOfWeek; $i++) {
            $days[] = null;
        }

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $currentDay = $date->copy()->day($i);
            $isHoliday = $holidays->contains(function ($holiday) use ($currentDay) {
                return Carbon::parse($holiday->date)->isSameDay($currentDay);
            });
            
            $holidayData = $isHoliday ? $holidays->first(function ($holiday) use ($currentDay) {
                return Carbon::parse($holiday->date)->isSameDay($currentDay);
            }) : null;

            $days[] = [
                'day' => $i,
                'date' => $currentDay->toDateString(),
                'is_holiday' => $isHoliday,
                'holiday_name' => $holidayData ? $holidayData->name : null,
                'description' => $holidayData ? $holidayData->description : null,
                'id' => $holidayData ? $holidayData->id : null,
                'is_weekend' => $currentDay->isWeekend(),
                'is_today' => $currentDay->isToday(),
            ];
        }

        return $days;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        Holiday::updateOrCreate(
            ['date' => $request->date],
            [
                'name' => $request->name,
                'description' => $request->description,
            ]
        );

        return redirect()->route('calendar.index', [
            'view' => $request->get('view', 'academic'),
            'date' => $request->get('active_date', date('Y-m-d'))
        ])->with('success', 'Festivo guardado correctamente.');
    }

    public function destroy(Request $request, Holiday $holiday)
    {
        $holiday->delete();

        return redirect()->route('calendar.index', [
            'view' => $request->get('view', 'academic'),
            'date' => $request->get('active_date', date('Y-m-d'))
        ])->with('success', 'Festivo eliminado correctamente.');
    }
}
