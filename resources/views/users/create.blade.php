@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Crear Usuario</h1>
        <a href="{{ route('users.index') }}" class="btn" style="background: rgba(255, 255, 255, 0.1);">Volver</a>
    </div>

    <div class="card" style="max-width: 600px;">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required>
                @error('name') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="last_name">Apellidos</label>
                <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}">
                @error('last_name') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                @error('email') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group" id="student-only-fields" style="display: none;">
                <label for="group_id">Asignar a Grupo</label>
                <select name="group_id" id="group_id">
                    <option value="">Seleccionar Grupo</option>
                    @foreach($groups as $group)
                        <option value="{{ $group->id }}" {{ old('group_id') == $group->id ? 'selected' : '' }}>
                            {{ $group->course }} - {{ $group->name }} (Tutor: {{ $group->tutor->name ?? 'Sin asignar' }})
                        </option>
                    @endforeach
                </select>
                @error('group_id') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const roleSelect = document.getElementById('role');
                    const courseGroup = document.getElementById('course-group');

                    function toggleCourse() {
                        if (roleSelect.value === 'alumno') {
                            document.getElementById('student-only-fields').style.display = 'block';
                        } else {
                            document.getElementById('student-only-fields').style.display = 'none';
                        }
                    }

                    roleSelect.addEventListener('change', toggleCourse);
                    toggleCourse(); // Initial state
                });
            </script>

            <div class="form-group">
                <label for="role">Rol</label>
                <select name="role" id="role" required>
                    <option value="">Seleccionar Rol</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>
                @error('role') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" required>
                @error('password') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required>
            </div>

            <div style="margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">Guardar Usuario</button>
            </div>
        </form>
    </div>
@endsection