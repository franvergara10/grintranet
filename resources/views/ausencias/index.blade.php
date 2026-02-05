@extends('layouts.app')

@section('title', 'Ausencias - ' . \Carbon\Carbon::parse($date)->format('d/m/Y'))

@section('content')
    <div class="page-header">
        <h1 class="page-title">Ausencias - {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</h1>
        <div style="display: flex; gap: 1rem; align-items: center;">
            <form action="{{ route('ausencias.index') }}" method="GET" style="display: flex; gap: 0.5rem;">
                <input type="date" name="date" value="{{ $date }}" class="form-control" onchange="this.form.submit()">
            </form>
            <a href="{{ route('ausencias.create', ['date' => $date]) }}" class="btn btn-primary">
                + Nueva Ausencia
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert"
            style="background: rgba(34, 197, 94, 0.1); color: var(--success); border: 1px solid rgba(34, 197, 94, 0.2);">
            {{ session('success') }}
        </div>
    @endif

    <div class="card" style="padding: 0; overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: rgba(255,255,255,0.02);">
                    <th
                        style="padding: 1rem; border-bottom: 1px solid rgba(255,255,255,0.05); text-align: left; width: 150px;">
                        Horario
                    </th>
                    <th style="padding: 1rem; border-bottom: 1px solid rgba(255,255,255,0.05); text-align: left;">
                        Ausencias
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($timeSlots as $slot)
                    @php
                        $slotAusencias = $ausencias[$slot->id] ?? collect();
                    @endphp
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); height: 100px;">
                        <td style="padding: 1rem; vertical-align: top; border-right: 1px solid rgba(255,255,255,0.05);">
                            <div style="font-weight: 600;">{{ $slot->name }}</div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">
                                {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                            </div>
                        </td>
                        <td style="padding: 0.5rem; vertical-align: top; position: relative;">
                            @if($slotAusencias->isNotEmpty())
                                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                    @foreach($slotAusencias as $ausencia)
                                        <div class="card"
                                            style="margin: 0; padding: 1rem; background: rgba(56, 189, 248, 0.1); border: 1px solid rgba(56, 189, 248, 0.2);">
                                            <div
                                                style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem; gap: 1rem;">
                                                <div style="font-weight: 700; color: #fff; font-size: 1.1rem; line-height: 1.2;">
                                                    {{ $ausencia->group->course }} {{ $ausencia->group->name }}
                                                </div>
                                                <div
                                                    style="font-size: 1.1rem; font-weight: 700; color: var(--primary); text-align: right; background: rgba(56, 189, 248, 0.1); padding: 0.2rem 0.6rem; border-radius: 0.4rem; white-space: nowrap;">
                                                    📍 {{ $ausencia->zona->nombre }}
                                                </div>
                                            </div>

                                            <div
                                                style="font-size: 0.95rem; color: #fff; margin-bottom: 0.75rem; background: rgba(255,255,255,0.03); padding: 0.5rem; border-radius: 0.4rem;">
                                                {{ $ausencia->tarea }}
                                            </div>

                                            <div style="display: flex; align-items: center; justify-content: left; font-size: 0.95rem;">
                                                <div style="color: var(--text-muted);">Profesor:</div>
                                                <div style="font-weight: 600; color: var(--primary);">
                                                    👤 {{ $ausencia->user->name }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <!-- Clickable empty area to create absence -->
                                <a href="{{ route('ausencias.create', ['date' => $date, 'time_slot_id' => $slot->id]) }}"
                                    style="display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; min-height: 80px; border: 2px dashed rgba(255,255,255,0.1); border-radius: 0.5rem; color: rgba(255,255,255,0.3); text-decoration: none; transition: all 0.2s;">
                                    <span style="font-size: 1.5rem;">+</span>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <style>
        a[href*="create"]:hover {
            background: rgba(255, 255, 255, 0.05);
            color: var(--primary) !important;
            border-color: var(--primary) !important;
        }
    </style>
@endsection