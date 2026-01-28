@extends('layouts.app')

@section('title', 'Plantillas de Horario')

@section('content')
    <div class="header-actions">
        <h1>Plantillas de Horario</h1>
        <a href="{{ route('schedule-templates.create') }}" class="btn-primary">
            + Crear Nueva Plantilla
        </a>
    </div>

    <div class="card" style="margin-top: 20px;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Días Activos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($templates as $template)
                    <tr>
                        <td>
                            <strong>{{ $template->name }}</strong>
                            @if($template->description)
                                <div style="font-size: 0.85em; color: #666;">{{ $template->description }}</div>
                            @endif
                        </td>
                        <td>
                            @if($template->active_days)
                                {{ implode(', ', $template->active_days) }}
                            @else
                                <em>No definidos</em>
                            @endif
                        </td>
                        <td class="actions-cell">
                            <a href="{{ route('schedule-templates.preview', $template->id) }}" class="btn-icon"
                                title="Vista Previa" target="_blank">
                                👁️
                            </a>
                            <a href="{{ route('schedule-templates.edit', $template->id) }}" class="btn-icon" title="Editar">
                                ✏️
                            </a>
                            <form action="{{ route('schedule-templates.destroy', $template->id) }}" method="POST"
                                style="display:inline;" onsubmit="return confirm('¿Estás seguro?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon delete" title="Eliminar">🗑️</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 20px;">No hay plantillas creadas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <style>
        /* Inline styles for quick implementation matching likely existing styles */
        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header-actions h1 {
            color: #ffffff;
        }

        .btn-primary {
            background-color: #4f46e5;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: #4338ca;
        }

        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th,
        .data-table td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .data-table th {
            background-color: #f9fafb;
            font-weight: 600;
            color: #000000;
        }

        .data-table td {
            color: #000000;
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        .actions-cell {
            display: flex;
            gap: 10px;
        }

        .btn-icon {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.1em;
            text-decoration: none;
        }

        .btn-icon.delete {
            color: #ef4444;
        }
    </style>
@endsection