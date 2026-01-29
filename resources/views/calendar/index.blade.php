@extends('layouts.app')

@section('title', 'Calendario Escolar')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Calendario Escolar</h1>
        @role('admin|directiva')
        <button class="btn btn-primary" onclick="openAddHolidayModal()">Marcar Festivo</button>
        @endrole
    </div>

    <!-- View Controls -->
    <div class="card calendar-controls">
        <div class="view-selector">
            <a href="{{ route('calendar.index', ['view' => 'academic', 'date' => $dateParam]) }}"
                class="btn btn-view {{ $view === 'academic' ? 'active' : '' }}">Año Académico</a>
            <a href="{{ route('calendar.index', ['view' => 'monthly', 'date' => $dateParam]) }}"
                class="btn btn-view {{ $view === 'monthly' ? 'active' : '' }}">Mes</a>
            <a href="{{ route('calendar.index', ['view' => 'weekly', 'date' => $dateParam]) }}"
                class="btn btn-view {{ $view === 'weekly' ? 'active' : '' }}">Semana</a>
        </div>

        <div class="date-navigation">
            @php
                $carbonDate = \Carbon\Carbon::parse($dateParam);
                $prevDate = match ($view) {
                    'academic' => $carbonDate->copy()->subYear()->format('Y-m-d'),
                    'monthly' => $carbonDate->copy()->subMonth()->format('Y-m-d'),
                    'weekly' => $carbonDate->copy()->subWeek()->format('Y-m-d'),
                };
                $nextDate = match ($view) {
                    'academic' => $carbonDate->copy()->addYear()->format('Y-m-d'),
                    'monthly' => $carbonDate->copy()->addMonth()->format('Y-m-d'),
                    'weekly' => $carbonDate->copy()->addWeek()->format('Y-m-d'),
                };
            @endphp
            <a href="{{ route('calendar.index', ['view' => $view, 'date' => $prevDate]) }}" class="btn btn-icon">&laquo;
                Anterior</a>
            <a href="{{ route('calendar.index', ['view' => $view, 'date' => date('Y-m-d')]) }}" class="btn btn-icon">Hoy</a>
            <a href="{{ route('calendar.index', ['view' => $view, 'date' => $nextDate]) }}" class="btn btn-icon">Siguiente
                &raquo;</a>
        </div>
    </div>

    <div
        class="calendar-grid {{ $view === 'academic' ? '' : 'single-view' }} {{ $view === 'weekly' ? 'weekly-grid' : '' }}">
        @foreach($months as $month)
            <div class="card month-card">
                <h3 class="month-title">{{ $month['name'] }}</h3>

                @if(isset($month['is_weekly']))
                    <div class="calendar-days weekly-mode">
                        @foreach($month['days'] as $day)
                            <div class="day-row {{ $day['is_holiday'] ? 'holiday-row' : '' }} {{ $day['is_weekend'] ? 'weekend-row' : '' }} {{ $day['is_today'] ? 'is-today' : '' }} @role('admin|directiva') clickable @endrole"
                                @role('admin|directiva')
                                onclick="openAddHolidayModal('{{ $day['date'] }}', '{{ $day['holiday_name'] ?? '' }}', '{{ $day['description'] ?? '' }}')"
                                @endrole>
                                <div class="day-label">{{ $day['full_name'] }}</div>
                                <div class="day-content">
                                    @if($day['is_holiday'])
                                        <span class="holiday-badge">{{ $day['holiday_name'] }}</span>
                                        @role('admin|directiva')
                                        <form action="{{ route('holidays.destroy', $day['id']) }}" method="POST" class="delete-inline"
                                            onclick="event.stopPropagation()">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="view" value="{{ $view }}">
                                            <input type="hidden" name="active_date" value="{{ $dateParam }}">
                                            <button type="submit" class="delete-link"
                                                onclick="return confirm('¿Eliminar festivo?')">Eliminar</button>
                                        </form>
                                        @endrole
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="calendar-header">
                        <span>Lu</span><span>Ma</span><span>Mi</span><span>Ju</span><span>Vi</span><span>Sa</span><span>Do</span>
                    </div>
                    <div class="calendar-days">
                        @foreach($month['days'] as $day)
                            @if($day === null)
                                <div class="day empty"></div>
                            @else
                                <div class="day {{ $day['is_holiday'] ? 'holiday' : '' }} {{ $day['is_weekend'] ? 'weekend' : '' }} {{ $day['is_today'] ? 'is-today' : '' }} @role('admin|directiva') clickable @endrole"
                                    title="{{ $day['holiday_name'] ?? '' }}" @role('admin|directiva')
                                    onclick="openAddHolidayModal('{{ $day['date'] }}', '{{ $day['holiday_name'] ?? '' }}', '{{ $day['description'] ?? '' }}')"
                                    @endrole>
                                    {{ $day['day'] }}
                                    @if($day['is_holiday'] && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('directiva')))
                                        <form action="{{ route('holidays.destroy', $day['id']) }}" method="POST" class="delete-holiday-form"
                                            onclick="event.stopPropagation()">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete-btn"
                                                onclick="return confirm('¿Eliminar festivo?')">&times;</button>
                                        </form>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    @role('admin|directiva')
    <!-- Modal for adding holiday -->
    <div id="addHolidayModal" class="modal">
        <div class="modal-content card">
            <h2 style="margin-bottom: 1.5rem">Añadir Día Festivo</h2>
            <form action="{{ route('holidays.store') }}" method="POST">
                @csrf
                <input type="hidden" name="view" value="{{ $view }}">
                <input type="hidden" name="active_date" value="{{ $dateParam }}">
                <div class="form-group">
                    <label for="name">Nombre del Festivo</label>
                    <input type="text" name="name" id="name" required placeholder="Ej: Navidad">
                </div>
                <div class="form-group">
                    <label for="date">Fecha</label>
                    <input type="date" name="date" id="date" required>
                </div>
                <div class="form-group">
                    <label for="description">Descripción (Opcional)</label>
                    <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                </div>
                <div style="display: flex; gap: 1rem; justify-content: flex-end">
                    <button type="button" class="btn btn-danger" onclick="toggleModal('addHolidayModal')">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
    @endrole

    <style>
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .month-card {
            padding: 1.5rem;
            margin-bottom: 0;
        }

        .month-title {
            text-align: center;
            margin-bottom: 1rem;
            color: var(--primary);
            text-transform: capitalize;
        }

        .calendar-header {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            text-align: center;
            font-weight: 600;
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
        }

        .calendar-days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
        }

        .day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            border-radius: 0.25rem;
            position: relative;
            background: rgba(255, 255, 255, 0.03);
        }

        .day.weekend {
            color: var(--text-muted);
            background: rgba(255, 255, 255, 0.01);
        }

        .day.holiday {
            background: var(--danger);
            color: white;
            font-weight: 700;
            box-shadow: 0 0 10px rgba(239, 68, 68, 0.4);
        }

        .day.empty {
            background: transparent;
        }

        .day.clickable {
            cursor: pointer;
        }

        .day.clickable:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .day.holiday.clickable:hover {
            background: rgba(239, 68, 68, 0.8);
        }

        .day.is-today,
        .day-row.is-today {
            border: 2px solid white !important;
        }

        .delete-holiday-form {
            position: absolute;
            top: -5px;
            right: -5px;
            display: none;
        }

        .day.holiday:hover .delete-holiday-form {
            display: block;
        }

        .delete-btn {
            background: #fff;
            color: var(--danger);
            border: 1px solid var(--danger);
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            cursor: pointer;
            padding: 0;
            line-height: 1;
        }

        /* Multi-view controls */
        .calendar-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .view-selector,
        .date-navigation {
            display: flex;
            gap: 0.5rem;
        }

        .btn-view {
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-muted);
            border: 1px solid var(--border);
        }

        .btn-view.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .btn-icon {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border);
            color: var(--text-color);
        }

        /* Layout modifications */
        .calendar-grid.single-view {
            grid-template-columns: 1fr;
            max-width: 800px;
            margin: 0 auto;
        }

        /* Weekly mode styling */
        .calendar-days.weekly-mode {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .day-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 0.5rem;
            transition: background 0.2s;
        }

        .day-row.clickable {
            cursor: pointer;
        }

        .day-row.clickable:hover {
            background: rgba(255, 255, 255, 0.08);
        }

        .day-row.weekend-row {
            background: rgba(255, 255, 255, 0.01);
            color: var(--text-muted);
        }

        .day-row.holiday-row {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .day-row.holiday-row.clickable:hover {
            background: rgba(239, 68, 68, 0.2);
        }

        .day-label {
            font-weight: 600;
            text-transform: capitalize;
        }

        .holiday-badge {
            background: var(--danger);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .delete-inline {
            margin-left: 1rem;
            display: inline;
        }

        .delete-link {
            background: none;
            border: none;
            color: var(--danger);
            font-size: 0.8rem;
            cursor: pointer;
            text-decoration: underline;
        }

        textarea {
            width: 100%;
            padding: 0.75rem;
            border-radius: 0.5rem;
            border: 1px solid var(--border);
            background: rgba(0, 0, 0, 0.2);
            color: var(--text-color);
            font-family: inherit;
        }

        /* Restored Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        .modal-content {
            margin: 10% auto;
            width: 100%;
            max-width: 500px;
        }
    </style>

    <script>
        function toggleModal(id) {
            const modal = document.getElementById(id);
            modal.style.display = modal.style.display === 'block' ? 'none' : 'block';
        }

        function openAddHolidayModal(date, name = '', description = '') {
            const modal = document.getElementById('addHolidayModal');
            const dateInput = document.getElementById('date');
            const nameInput = document.getElementById('name');
            const descInput = document.getElementById('description');
            const modalTitle = modal.querySelector('h2');
            const submitBtn = modal.querySelector('button[type="submit"]');

            if (date) {
                dateInput.value = date;
            }

            nameInput.value = name;
            descInput.value = description;

            modalTitle.textContent = name ? 'Modificar Festivo' : 'Añadir Día Festivo';
            submitBtn.textContent = name ? 'Guardar Cambios' : 'Guardar';

            modal.style.display = 'block';
        }

        window.onclick = function (event) {
            if (event.target.className === 'modal') {
                event.target.style.display = "none";
            }
        }
    </script>
@endsection