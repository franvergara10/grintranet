@extends('layouts.app')

@section('title', 'Nueva Ausencia')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Nueva Ausencia</h1>
        <a href="{{ route('ausencias.index') }}" class="btn" style="background: rgba(255, 255, 255, 0.1);">Volver</a>
    </div>

    <div class="card" style="max-width: 900px; margin: 0 auto;">
        <form action="{{ route('ausencias.store') }}" method="POST">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="fecha">Fecha</label>
                    <input type="date" name="fecha" id="fecha" class="form-control @error('fecha') is-invalid @enderror"
                        value="{{ old('fecha', $selectedDate) }}" required>
                    @error('fecha')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label for="time_slot_id">Tramo</label>
                    <select name="time_slot_id" id="time_slot_id"
                        class="form-control @error('time_slot_id') is-invalid @enderror" required>
                        <option value="">Selecciona un tramo</option>
                        @foreach($tramos as $tramo)
                            <option value="{{ $tramo->id }}" {{ old('time_slot_id', $selectedTimeSlot) == $tramo->id ? 'selected' : '' }}>
                                {{ $tramo->name }} ({{ \Carbon\Carbon::parse($tramo->start_time)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($tramo->end_time)->format('H:i') }})
                            </option>
                        @endforeach
                    </select>
                    @error('time_slot_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="group_id">Grupo</label>
                    <select name="group_id" id="group_id" class="form-control @error('group_id') is-invalid @enderror"
                        required>
                        <option value="">Selecciona un grupo</option>
                        @foreach($grupos as $grupo)
                            <option value="{{ $grupo->id }}" {{ old('group_id') == $grupo->id ? 'selected' : '' }}>
                                {{ $grupo->course }} - {{ $grupo->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('group_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label for="zona_id">Zona</label>
                    <select name="zona_id" id="zona_id" class="form-control @error('zona_id') is-invalid @enderror"
                        required>
                        <option value="">Selecciona una zona</option>
                        @foreach($zonas as $zona)
                            <option value="{{ $zona->id }}" {{ old('zona_id') == $zona->id ? 'selected' : '' }}>
                                {{ $zona->nombre }} ({{ $zona->planta }})
                            </option>
                        @endforeach
                    </select>
                    @error('zona_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="tarea">Tarea <span style="color: var(--danger);">*</span></label>
                <textarea name="tarea" id="tarea" rows="8" class="form-control @error('tarea') is-invalid @enderror"
                    placeholder="Describe la tarea que se debe realizar durante la ausencia..."
                    required>{{ old('tarea') }}</textarea>
                @error('tarea')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                <small style="color: var(--text-muted); display: block; margin-top: 0.5rem;">Este campo es
                    obligatorio.</small>
            </div>

            <div class="form-actions" style="margin-top: 2rem; text-align: right;">
                <button type="submit" class="btn btn-primary" style="padding: 0.8rem 2rem; font-size: 1rem;">Guardar
                    Ausencia</button>
            </div>
        </form>
    </div>
@endsection