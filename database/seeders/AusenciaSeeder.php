<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AusenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = \App\Models\User::limit(5)->get();
        $slots = \App\Models\TimeSlot::limit(5)->get();
        $today = now()->toDateString();

        if ($users->isEmpty() || $slots->isEmpty()) {
            return;
        }

        $tareas = [
            'Repaso examen matemáticas',
            'Lectura silenciosa',
            'Ejercicios tema 4',
            'Ver documental historia',
            'Práctica de laboratorio',
        ];

        foreach ($slots as $index => $slot) {
            // Create 1-2 absences per slot for testing
            $absentUser = $users[$index % $users->count()];
            
            \App\Models\Ausencia::updateOrCreate(
                [
                    'user_id' => $absentUser->id,
                    'fecha' => $today,
                    'time_slot_id' => $slot->id,
                ],
                [
                    'tarea' => $tareas[$index % count($tareas)],
                ]
            );
        }
    }
}
