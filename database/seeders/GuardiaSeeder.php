<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuardiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guardias = [
            ['name' => 'Guardia de Recreo'],
            ['name' => 'Guardia de Pasillo'],
            ['name' => 'Guardia de Biblioteca'],
            ['name' => 'Guardia de Entrada/Salida'],
        ];

        foreach ($guardias as $guardia) {
            \App\Models\Guardia::updateOrCreate(['name' => $guardia['name']], $guardia);
        }
    }
}
