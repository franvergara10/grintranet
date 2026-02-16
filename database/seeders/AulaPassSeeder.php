<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Group;

class AulaPassSeeder extends Seeder
{
    public function run()
    {
        $group = Group::first();
        
        if (!$group) {
            $group = Group::create([
                'course' => '1º ESO',
                'name' => 'A',
                // Add other required fields if any, checking Group model or migration
            ]);
        }

        Student::create([
            'name' => 'Alumno',
            'surnames' => 'Prueba',
            'grade' => $group->name, // Backward compatibility
            'group_id' => $group->id,
        ]);
        
        Student::create([
            'name' => 'Otro',
            'surnames' => 'Estudiante',
            'grade' => $group->name,
            'group_id' => $group->id,
        ]);

        $this->command->info('Created 2 students for group: ' . $group->course . ' ' . $group->name);
    }
}
