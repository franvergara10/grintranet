<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = Group::with('tutor')->withCount('students');

        if ($user->hasRole('profesor')) {
            $query->where('tutor_id', $user->id);
        }

        $groups = $query->get();
        return view('groups.index', compact('groups'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        $tutors = User::role(['admin', 'profesor'])->get();
        if ($tutors->isEmpty()) {
            $tutors = User::all();
        }
        return view('groups.create', compact('tutors'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();
        $request->validate([
            'course' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'tutor_id' => 'nullable|exists:users,id',
        ]);

        Group::create($request->all());

        return redirect()->route('groups.index')->with('success', 'Grupo creado correctamente.');
    }

    public function show(Group $group)
    {
        $user = auth()->user();
        
        // Authorization: Admin or the actual tutor
        if (!$user->hasRole('admin') && $group->tutor_id !== $user->id) {
            abort(403, 'No tienes permiso para ver este grupo.');
        }

        $group->load(['tutor', 'students']);
        return view('groups.show', compact('group'));
    }

    public function edit(Group $group)
    {
        $this->authorizeAdmin();
        $tutors = User::role(['admin', 'profesor'])->get();
        if ($tutors->isEmpty()) {
            $tutors = User::all();
        }
        return view('groups.edit', compact('group', 'tutors'));
    }

    public function update(Request $request, Group $group)
    {
        $this->authorizeAdmin();
        $request->validate([
            'course' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'tutor_id' => 'nullable|exists:users,id',
        ]);

        $group->update($request->all());

        return redirect()->route('groups.index')->with('success', 'Grupo actualizado correctamente.');
    }

    public function destroy(Group $group)
    {
        $this->authorizeAdmin();
        $group->delete();
        return redirect()->route('groups.index')->with('success', 'Grupo eliminado correctamente.');
    }

    private function authorizeAdmin()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Acción no autorizada.');
        }
    }
}
