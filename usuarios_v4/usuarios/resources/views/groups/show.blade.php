@extends('layouts.app')

@section('title', 'Lista de Clase - ' . $group->course . ' ' . $group->name)

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">{{ $group->course }} - {{ $group->name }}</h1>
            <p style="color: var(--text-muted);">
                Tutor:
                @if($group->tutor)
                    <strong style="color: #fff;">{{ $group->tutor->name }} {{ $group->tutor->last_name }}</strong>
                @else
                    <span style="font-style: italic;">Sin asignar</span>
                @endif
            </p>
        </div>
        <a href="{{ route('groups.index') }}" class="btn" style="background: rgba(255, 255, 255, 0.1);">Volver al
            listado</a>
    </div>

    <div class="card table-container">
        <h2 style="margin-bottom: 1.5rem; font-size: 1.25rem;">Listado de Alumnos ({{ $group->students->count() }})</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Email</th>
                    <th>Fecha Alta</th>
                </tr>
            </thead>
            <tbody>
                @forelse($group->students as $student)
                    <tr>
                        <td style="font-weight: 500;">{{ $student->name }}</td>
                        <td>{{ $student->last_name }}</td>
                        <td style="color: var(--text-muted);">{{ $student->email }}</td>
                        <td style="color: var(--text-muted);">{{ $student->created_at->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 2rem;">No hay alumnos
                            asignados a este grupo.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection