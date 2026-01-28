@extends('layouts.app')

@section('title', 'Crear Rol')

@section('content')
<div class="page-header">
    <h1 class="page-title">Crear Rol</h1>
    <a href="{{ route('roles.index') }}" class="btn" style="background: rgba(255, 255, 255, 0.1);">Volver</a>
</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="name">Nombre del Rol</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Ej: editor, moderador...">
            @error('name') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label style="margin-bottom: 1rem;">Permisos</label>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 0.5rem; background: rgba(0,0,0,0.1); padding: 1rem; border-radius: 0.5rem;">
                @foreach($permissions as $permission)
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" style="width: auto;">
                        <span>{{ $permission->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">Guardar Rol</button>
        </div>
    </form>
</div>
@endsection
