@extends('layouts.app')

@section('title', 'Mis Horarios Personales')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Mis Horarios Personales</h1>
        <div>
            <a href="{{ route('personal-schedules.create') }}" class="btn btn-primary">
                + Nuevo Horario
            </a>
        </div>
    </div>

    @if($schedules->isEmpty())
        <div class="card" style="text-align: center; padding: 4rem 2rem;">
            <div style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;">📅</div>
            <h2 style="color: var(--text-muted); margin-bottom: 1rem;">No tienes horarios personales aún</h2>
            <p style="margin-bottom: 2rem; color: var(--text-muted);">
                Para empezar, selecciona una plantilla de las configuradas por el administrador.
            </p>
            <a href="{{ route('personal-schedules.create') }}" class="btn btn-primary">
                Elegir Plantilla
            </a>
        </div>
    @else
        <div class="grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem;">
            @foreach($schedules as $schedule)
                <div class="card shadow-hover" style="display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                            <h3 style="font-weight: 600; font-size: 1.25rem;">{{ $schedule->scheduleTemplate->name }}</h3>
                            <span class="badge badge-success">Personalizado</span>
                        </div>
                        <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1rem;">
                            {{ $schedule->scheduleTemplate->description ?? 'Sin descripción' }}
                        </p>
                        <div style="font-size: 0.85rem; color: var(--text-muted);">
                            <strong>Días:</strong> {{ implode(', ', $schedule->scheduleTemplate->active_days ?? []) }}
                        </div>
                    </div>

                    <div style="margin-top: 1.5rem; display: flex; gap: 0.5rem;">
                        <a href="{{ route('personal-schedules.show', $schedule) }}" class="btn"
                            style="flex: 1; background: rgba(16, 185, 129, 0.1); color: #10b981; text-align: center; border: 1px solid #10b981;">
                            Ver Horario
                        </a>
                        <a href="{{ route('personal-schedules.edit', $schedule) }}" class="btn"
                            style="flex: 1; background: rgba(56, 189, 248, 0.1); color: var(--primary); text-align: center; border: 1px solid var(--primary);">
                            Editar
                        </a>
                        <form action="{{ route('personal-schedules.destroy', $schedule) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn"
                                style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid #ef4444;"
                                onclick="return confirm('¿Estás seguro de eliminar este horario personal?')">
                                🗑️
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection