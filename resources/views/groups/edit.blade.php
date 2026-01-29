@extends('layouts.app')

@section('title', 'Editar Grupo - Gestor de Usuarios')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Editar Grupo</h1>
        <a href="{{ route('groups.index') }}" class="btn" style="background: rgba(255, 255, 255, 0.1);">Volver</a>
    </div>

    <div class="card" style="max-width: 600px;">
        <form action="{{ route('groups.update', $group) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="course">Curso</label>
                <input type="text" name="course" id="course" value="{{ old('course', $group->course) }}" required
                    placeholder="Ej: ESO, Bachillerato, DAW...">
                @error('course') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="name">Nombre del Grupo</label>
                <input type="text" name="name" id="name" value="{{ old('name', $group->name) }}" required
                    placeholder="Ej: 1º A, 2º B...">
                @error('name') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="tutor_id">Tutor Asignado</label>
                <select name="tutor_id" id="tutor_id">
                    <option value="">Sin tutor asignado</option>
                    @foreach($tutors as $tutor)
                        <option value="{{ $tutor->id }}" {{ old('tutor_id', $group->tutor_id) == $tutor->id ? 'selected' : '' }}>
                            {{ $tutor->name }} {{ $tutor->last_name }} ({{ $tutor->email }})
                        </option>
                    @endforeach
                </select>
                @error('tutor_id') <span style="color: var(--danger); font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">Actualizar Grupo</button>
            </div>
        </form>
    </div>
@endsection