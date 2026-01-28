@extends('layouts.app')

@section('title', 'Gestión de Roles')

@section('content')
<div class="page-header">
    <h1 class="page-title">Roles</h1>
    <a href="{{ route('roles.create') }}" class="btn btn-primary">Nuevo Rol</a>
</div>

@if(session('success'))
    <div class="alert" style="background: rgba(34, 197, 94, 0.1); color: var(--success); border: 1px solid rgba(34, 197, 94, 0.2);">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-error">
        {{ $errors->first() }}
    </div>
@endif

<!-- Search Bar -->
<div class="card" style="padding: 1.5rem; margin-bottom: 2rem;">
    <form action="{{ route('roles.index') }}" method="GET" style="display: flex; gap: 1rem;">
        @if(request('sort_by')) <input type="hidden" name="sort_by" value="{{ request('sort_by') }}"> @endif
        @if(request('sort_order')) <input type="hidden" name="sort_order" value="{{ request('sort_order') }}"> @endif
        
        <div style="flex: 1;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre..." style="width: 100%;">
        </div>
        <button type="submit" class="btn btn-primary">Buscar</button>
        @if(request('search'))
            <a href="{{ route('roles.index') }}" class="btn" style="background: rgba(255, 255, 255, 0.1);">Limpiar</a>
        @endif
    </form>
</div>

<div class="card table-container">
    <table>
        <thead>
            <tr>
                <th><x-sort-header column="name" label="Nombre Rol" route="roles.index" /></th>
                <th>Permisos</th>
                <th>Usuarios Asignados</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
            <tr>
                <td style="font-weight: 500;">
                    <span class="badge badge-role">{{ ucfirst($role->name) }}</span>
                </td>
                <td>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.25rem;">
                        @forelse($role->permissions as $permission)
                            <span class="badge" style="background: rgba(255, 255, 255, 0.05); color: var(--text-muted); font-size: 0.7rem;">{{ $permission->name }}</span>
                        @empty
                            <span style="color: var(--text-muted); font-size: 0.8rem;">Sin permisos</span>
                        @endforelse
                    </div>
                </td>
                <td style="color: var(--text-muted);">
                    {{ $role->users()->count() }}
                </td>
                <td>
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('roles.edit', $role) }}" class="btn" style="background: rgba(255, 255, 255, 0.1); padding: 0.4rem 0.8rem; font-size: 0.8rem;">Editar</a>
                        
                        @if($role->name !== 'admin')
                            <form action="{{ route('roles.destroy', $role) }}" method="POST" onsubmit="return confirm('¿Estás seguro? Esto quitará el rol a todos los usuarios que lo tengan.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 0.4rem 0.8rem; font-size: 0.8rem;">Eliminar</button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="margin-top: 1rem;">
        {{ $roles->appends(request()->query())->links() }}
    </div>
</div>
@endsection
