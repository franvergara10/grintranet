@extends('layouts.app')

@section('title', 'Elegir Plantilla de Horario')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Elegir Plantilla</h1>
        <a href="{{ route('personal-schedules.index') }}" style="color: var(--text-muted);">&larr; Volver</a>
    </div>

    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <p style="margin-bottom: 2rem; color: var(--text-muted);">
            Selecciona una base horaria para crear tu instancia personal. Una vez creada, podrás asignar tus guardias o
            actividades a cada tramo.
        </p>

        <form action="{{ route('personal-schedules.store') }}" method="POST">
            @csrf
            <div class="form-group" style="margin-bottom: 2rem;">
                <label for="schedule_template_id" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Plantilla
                    disponible:</label>
                <select name="schedule_template_id" id="schedule_template_id" class="form-control"
                    style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; background: var(--bg-card); color: #fff; border: 1px solid rgba(255,255,255,0.1);">
                    @foreach($templates as $template)
                        <option value="{{ $template->id }}">
                            {{ $template->name }} ({{ count($template->active_days ?? []) }} días,
                            {{ $template->timeSlots->count() }} tramos)
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem;">
                Instanciar Horario
            </button>
        </form>
    </div>
@endsection