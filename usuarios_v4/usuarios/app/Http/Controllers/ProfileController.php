<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        $isAlumno = $user->hasRole('alumno');
        
        return view('profile.edit', compact('user', 'isAlumno'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $isAlumno = $user->hasRole('alumno');

        if ($isAlumno) {
            // Alumnos can only change their password
            $request->validate([
                'password' => ['required', 'confirmed', Password::defaults()],
            ]);

            $user->update([
                'password' => Hash::make($request->password),
            ]);
        } else {
            // Other users can update more information
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'last_name' => ['nullable', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
                'password' => ['nullable', 'confirmed', Password::defaults()],
                'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            ]);

            $data = [
                'name' => $request->name,
                'last_name' => $request->last_name,
                'email' => $request->email,
            ];

            if ($request->hasFile('avatar')) {
                // Delete old avatar if exists
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }
                
                $path = $request->file('avatar')->store('avatars', 'public');
                $data['avatar'] = $path;
            }

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);
        }

        return back()->with('status', 'Perfil actualizado con éxito.');
    }
}
