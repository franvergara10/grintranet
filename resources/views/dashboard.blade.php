@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Dashboard</h1>
        <div style="color: var(--text-muted);">
            Bienvenido, {{ Auth::user()->name }}
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
        @role('admin')
        <div class="card">
            <h3
                style="color: var(--text-muted); margin-bottom: 0.5rem; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em;">
                Total Usuarios</h3>
            <div style="font-size: 3rem; font-weight: 700; color: var(--primary);">{{ $usersCount }}</div>
            <a href="{{ route('users.index') }}"
                style="display: inline-block; margin-top: 1rem; font-size: 0.9rem;">Gestionar Usuarios &rarr;</a>
        </div>

        <div class="card">
            <h3
                style="color: var(--text-muted); margin-bottom: 0.5rem; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em;">
                Total Roles</h3>
            <div style="font-size: 3rem; font-weight: 700; color: var(--success);">{{ $rolesCount }}</div>
            <a href="{{ route('roles.index') }}"
                style="display: inline-block; margin-top: 1rem; font-size: 0.9rem; color: var(--success);">Gestionar Roles
                &rarr;</a>
        </div>

        <div class="card">
            <h3
                style="color: var(--text-muted); margin-bottom: 0.5rem; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em;">
                Total Grupos</h3>
            <div style="font-size: 3rem; font-weight: 700; color: #f59e0b;">{{ $groupsCount }}</div>
            <a href="{{ route('groups.index') }}"
                style="display: inline-block; margin-top: 1rem; font-size: 0.9rem; color: #f59e0b;">Gestionar Grupos
                &rarr;</a>
        </div>
        @endrole

        @role('profesor')
        <div class="card">
            <h3
                style="color: var(--text-muted); margin-bottom: 0.5rem; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em;">
                Mis Alumnos Totales</h3>
            <div style="font-size: 3rem; font-weight: 700; color: var(--primary);">{{ $myStudentsCount }}</div>
            <p style="color: var(--text-muted); font-size: 0.85rem; margin-top: 0.5rem;">Suma de alumnos en todos tus grupos
                tutorizados.</p>
        </div>

        <div class="card">
            <h3
                style="color: var(--text-muted); margin-bottom: 0.5rem; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em;">
                Grupos Tutorizados</h3>
            <div style="font-size: 3rem; font-weight: 700; color: var(--success);">{{ $myGroups->count() }}</div>
            <a href="{{ route('groups.index') }}"
                style="display: inline-block; margin-top: 1rem; font-size: 0.9rem; color: var(--success);">Ver Mis Grupos
                &rarr;</a>
        </div>
        @endrole

        <div class="card">
            <h3
                style="color: var(--text-muted); margin-bottom: 0.5rem; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em;">
                Mi Perfil</h3>
            <div style="margin-top: 0.5rem; display: flex; flex-direction: column; gap: 1rem;">
                <div>
                    @foreach(Auth::user()->getRoleNames() as $role)
                        <span class="badge badge-role"
                            style="font-size: 0.85rem; padding: 0.4rem 0.8rem;">{{ ucfirst($role) }}</span>
                    @endforeach
                </div>
                <a href="{{ route('profile.edit') }}" style="font-size: 0.9rem;">Editar Perfil &rarr;</a>
            </div>
        </div>
    </div>

    @if(Auth::user()->hasRole('profesor') && $myGroups->isNotEmpty())
        <div class="card" style="margin-top: 2rem;">
            <h2 style="margin-bottom: 1.5rem; font-size: 1.25rem; color: #fff;">Resumen de Mis Grupos</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Curso</th>
                            <th>Grupo</th>
                            <th>Nº Alumnos</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($myGroups as $group)
                            <tr>
                                <td style="color: var(--primary); font-weight: 500;">{{ $group->course }}</td>
                                <td style="font-weight: 600;">{{ $group->name }}</td>
                                <td><span class="badge badge-role">{{ $group->students_count }}</span></td>
                                <td>
                                    <a href="{{ route('groups.show', $group) }}" class="btn"
                                        style="background: rgba(56, 189, 248, 0.1); color: var(--primary); padding: 0.3rem 0.6rem; font-size: 0.8rem;">Ver
                                        Alumnos</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

@endsection