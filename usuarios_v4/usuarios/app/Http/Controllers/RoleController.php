<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $query = Role::with('permissions');

        // Search
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', "%{$request->search}%");
        }

        // Sort
        if ($request->has('sort_by')) {
            $sortOrder = $request->input('sort_order', 'asc');
            $sortBy = $request->input('sort_by');
            
            if (in_array($sortBy, ['name', 'created_at'])) {
                $query->orderBy($sortBy, $sortOrder);
            }
        } else {
            $query->orderBy('name', 'asc'); // Default
        }

        $roles = $query->paginate(10);
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'array',
        ]);

        $role = Role::create(['name' => $request->name]);
        
        if($request->has('permissions')){
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Rol creado correctamente.');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => ['required', 'string', Rule::unique('roles', 'name')->ignore($role->id)],
            'permissions' => 'array',
        ]);

        $role->update(['name' => $request->name]);

        if($request->has('permissions')){
            $role->syncPermissions($request->permissions);
        } else {
            $role->syncPermissions([]); // Quitar todos si no se envía ninguno
        }

        return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente.');
    }

    public function destroy(Role $role)
    {
        if($role->name === 'admin') {
             return back()->withErrors(['error' => 'No puedes eliminar el rol Admin.']);
        }
        
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Rol eliminado correctamente.');
    }
}
