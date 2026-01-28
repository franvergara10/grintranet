<?php

namespace App\Http\Controllers;

   use App\Models\User;
   use Exception;
   use Illuminate\Support\Facades\Auth;
   use Illuminate\Support\Facades\Hash;
   use Illuminate\Support\Str;
   use Laravel\Socialite\Facades\Socialite;

   class SocialAuthController extends Controller
   {
       public function redirectToGoogle()
       {
           return Socialite::driver('google')->redirect();
       }

       public function handleGoogleCallback()
       {
           try {
               $googleUser = Socialite::driver('google')->user();
               
               $user = User::where('google_id', $googleUser->id)
                           ->orWhere('email', $googleUser->email)
                           ->first();

               if ($user) {
                   // Si el usuario existe, actualizamos su google_id si no lo tiene
                   if (!$user->google_id) {
                       $user->update([
                           'google_id' => $googleUser->id,
                           'last_name' => $googleUser->user['family_name'] ?? null,
                           'avatar' => $googleUser->avatar,
                       ]);
                   }
                   Auth::login($user);
               } else {
                   // Si no existe, lo creamos
                   $newUser = User::create([
                       'name' => $googleUser->user['given_name'] ?? $googleUser->name,
                       'last_name' => $googleUser->user['family_name'] ?? null,
                       'email' => $googleUser->email,
                       'google_id' => $googleUser->id,
                       'avatar' => $googleUser->avatar,
                       'password' => Hash::make(Str::random(24)), // Password aleatorio
                   ]);

                   // Asignar rol por defecto (ej. alumno)
                   $newUser->assignRole('alumno');

                   Auth::login($newUser);
               }

               return redirect()->intended('dashboard');

           } catch (Exception $e) {
               return redirect()->route('login')->with('error', 'Algo salió mal al iniciar sesión con Google.');
           }
       }
   }
