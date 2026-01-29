<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class ImportController extends Controller
{
    public function index()
    {
        return view('users.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'import_file' => 'nullable|file|mimes:csv,txt',
            'import_list' => 'nullable|string',
        ]);

        $count = 0;

        // 1. Process Text List
        if ($request->filled('import_list')) {
            $lines = explode("\n", str_replace("\r", "", $request->import_list));
            foreach ($lines as $line) {
                if (empty(trim($line))) continue;
                $data = str_getcsv($line, ",");
                
                // Assuming format: Name, LastName, Email, Course (e.g. Bach), Group (e.g. 2º)
                if (count($data) >= 3) {
                    $this->processUser([
                        'name' => trim($data[0]),
                        'last_name' => trim($data[1] ?? ''),
                        'email' => trim($data[2] ?? ''),
                        'course' => trim($data[3] ?? 'Sin curso'),
                        'group' => trim($data[4] ?? 'A')
                    ]);
                    $count++;
                }
            }
        }

        // 2. Process CSV File
        if ($request->hasFile('import_file')) {
            if (($handle = fopen($request->file('import_file')->getRealPath(), "r")) !== FALSE) {
                fgetcsv($handle, 1000, ","); // Skip header
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if (count($data) >= 3) {
                        $this->processUser([
                            'name' => trim($data[0]),
                            'last_name' => trim($data[1] ?? ''),
                            'email' => trim($data[2] ?? ''),
                            'course' => trim($data[3] ?? 'Sin curso'),
                            'group' => trim($data[4] ?? 'A')
                        ]);
                        $count++;
                    }
                }
                fclose($handle);
            }
        }

        return redirect()->route('users.index')->with('success', "Se han importado/actualizado $count alumnos correctamente.");
    }

    private function processUser($data)
    {
        if (empty($data['email'])) return;

        // Find or create the group entity
        $group = Group::firstOrCreate([
            'course' => $data['course'],
            'name' => $data['group']
        ]);

        $user = User::updateOrCreate(
            ['email' => $data['email']],
            [
                'name' => $data['name'],
                'last_name' => $data['last_name'],
                'group_id' => $group->id,
                'password' => Hash::make(Str::random(16)), // Temp password
            ]
        );

        if (!$user->hasRole('alumno')) {
            $user->assignRole('alumno');
        }
    }
}
