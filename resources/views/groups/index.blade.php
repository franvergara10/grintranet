@extends('layouts.app')

@section('title', 'Gestión de Grupos - Gestor de Usuarios')

@section('content')
    <div class="page-header">
        <h1 class="page-title">{{ auth()->user()->hasRole('admin') ? 'Cursos y Grupos' : 'Mis Grupos' }}</h1>
        @role('admin')
        <a href="{{ route('groups.create') }}" class="btn btn-primary">Nuevo Grupo</a>
        @endrole
    </div>

    @if(session('success'))
        <div class="alert"
            style="background: rgba(34, 197, 94, 0.1); color: var(--success); border: 1px solid rgba(34, 197, 94, 0.2);">
            {{ session('success') }}
        </div>
    @endif

    <div class="card table-container">
        <table>
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Grupo</th>
                    <th>Tutor</th>
                    <th>Alumnos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($groups as $group)
                    <tr>
                        <td style="font-weight: 500; color: var(--primary);">{{ $group->course }}</td>
                        <td style="font-weight: 600;">{{ $group->name }}</td>
                        <td>
                            @if($group->tutor)
                                <span style="color: #fff;">{{ $group->tutor->name }} {{ $group->tutor->last_name }}</span>
                            @else
                                <span style="color: var(--text-muted); font-style: italic;">Sin tutor</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-role">{{ $group->students_count }}</span>
                        </td>
                        <td style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('groups.show', $group) }}" class="btn"
                                style="background: rgba(56, 189, 248, 0.1); color: var(--primary); padding: 0.4rem 0.8rem; font-size: 0.8rem;">Ver
                                Alumnos</a>
                            @role('admin')
                            <a href="{{ route('groups.edit', $group) }}" class="btn"
                                style="background: rgba(255, 255, 255, 0.1); padding: 0.4rem 0.8rem; font-size: 0.8rem;">Editar</a>
                            <form action="{{ route('groups.destroy', $group) }}" method="POST"
                                onsubmit="return confirm('¿Estás seguro?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    style="padding: 0.4rem 0.8rem; font-size: 0.8rem;">Eliminar</button>
                            </form>
                            @endrole
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 2rem;">No hay grupos
                            creados aún.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection