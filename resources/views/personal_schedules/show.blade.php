@extends('layouts.app')

@section('title', 'Mi Horario - Vista')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Mi Horario Personal</h1>
            <p style="color: var(--text-muted);">Vista de hoy: <strong>{{ now()->translatedFormat('l, d \d\e F') }}</strong>
            </p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('personal-schedules.index') }}" class="btn"
                style="background: rgba(255,255,255,0.05);">Volver</a>
            <a href="{{ route('personal-schedules.edit', $personal_schedule) }}" class="btn btn-primary">Editar Horario</a>
        </div>
    </div>

    <div class="card" style="max-width: 900px; margin: 0 auto; padding: 0; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: rgba(56, 189, 248, 0.05);">
                    <th style="padding: 1.5rem; border-bottom: 2px solid rgba(255,255,255,0.1); text-align: left; width: 250px;">
                        <div style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--primary);">Horario</div>
                        <div style="font-size: 1.2rem; margin-top: 0.25rem;">Tramo</div>
                    </th>
                    <th style="padding: 1.5rem; border-bottom: 2px solid rgba(255,255,255,0.1); text-align: left;">
                        <div style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--primary);">Planificación</div>
                        <div style="font-size: 1.2rem; margin-top: 0.25rem;">Actividad y Ausencias ({{ ucfirst($todaySpanish) }})</div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($slots as $slot)
                    @php
                        $selection = $todaySelections->get($slot->id);
                    @endphp
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 1.5rem; vertical-align: top;">
                            <div style="font-weight: 800; font-size: 1.25rem; color: #fff; margin-bottom: 0.5rem;">{{ $slot->name }}</div>
                            <div style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.4rem 0.8rem; background: rgba(255,255,255,0.07); border-radius: 0.5rem; font-size: 0.9rem; color: var(--primary); font-weight: 700; border: 1px solid rgba(56, 189, 248, 0.2);">
                                🕒 {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                            </div>
                        </td>
                        <td style="padding: 1.5rem;">
                            @if($selection)
                                <div style="background: {{ $selection->guardia_id ? 'rgba(56, 189, 248, 0.1)' : 'rgba(255, 255, 255, 0.03)' }}; padding: 1.5rem; border-radius: 1rem; border: 1px solid {{ $selection->guardia_id ? 'var(--primary)' : 'rgba(255,255,255,0.1)' }};">
                                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: {{ $selection->guardia_id ? '1.25rem' : '0' }};">
                                        <span style="font-size: 1.5rem;">{{ $selection->guardia_id ? '🛡️' : '📝' }}</span>
                                        <div style="font-weight: 800; font-size: 1.3rem; color: {{ $selection->guardia_id ? 'var(--primary)' : '#fff' }};">
                                            {{ $selection->guardia_id ? 'Guardia: ' . $selection->guardia->name : $selection->value }}
                                        </div>
                                    </div>
                                    
                                    @if($selection->guardia_id)
                                        <div style="padding-top: 1.25rem; border-top: 2px dashed rgba(255,255,255,0.07);">
                                            <div style="display: flex; align-items: center; gap: 0.6rem; margin-bottom: 1.25rem;">
                                                <div style="width: 10px; height: 10px; border-radius: 50%; background: #ef4444; box-shadow: 0 0 10px rgba(239, 68, 68, 0.5); animation: pulse 2s infinite;"></div>
                                                <div style="font-size: 0.85rem; color: #fca5a5; font-weight: 900; text-transform: uppercase; letter-spacing: 0.08em;">
                                                    Docentes Ausentes:
                                                </div>
                                            </div>
                                            
                                            @php
                                                $slotAbsences = $absences[$slot->id] ?? collect();
                                            @endphp
                                            
                                            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem;">
                                                @forelse($slotAbsences as $abs)
                                                    <div style="background: rgba(0,0,0,0.25); padding: 1.25rem; border-radius: 0.85rem; border: 1px solid rgba(239, 68, 68, 0.2); display: flex; flex-direction: column; gap: 0.6rem; position: relative;">
                                                        <div style="position: absolute; left: 0; top: 1rem; bottom: 1rem; width: 4px; background: #ef4444; border-radius: 0 4px 4px 0;"></div>
                                                        <div style="font-weight: 700; font-size: 1.1rem; color: #fff; padding-left: 0.5rem;">
                                                            {{ $abs->user->name }} {{ $abs->user->last_name }}
                                                        </div>
                                                        @if($abs->tarea)
                                                            <div style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.5; background: rgba(255,255,255,0.03); padding: 0.75rem; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.05);">
                                                                <span style="color: var(--primary); font-weight: 800; margin-right: 0.3rem;">TAREA:</span> "{{ $abs->tarea }}"
                                                            </div>
                                                        @endif
                                                    </div>
                                                @empty
                                                    <div style="grid-column: 1 / -1; padding: 2rem; background: rgba(16, 185, 129, 0.06); border-radius: 1rem; border: 1px dashed rgba(16, 185, 129, 0.3); text-align: center; color: #34d399; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 0.75rem;">
                                                        <span style="font-size: 1.2rem;">✅</span> No hay ausencias registradas para este tramo
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div style="padding: 2.5rem; text-align: center; background: rgba(255,255,255,0.015); border-radius: 1rem; color: var(--text-muted); border: 2px dashed rgba(255,255,255,0.04); font-style: italic; font-size: 1rem;">
                                    Ninguna actividad asignada en este tramo
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <style>
        @keyframes pulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }
    </style>

    <div
        style="margin-top: 2rem; color: var(--text-muted); font-size: 0.9rem; display: flex; align-items: center; gap: 0.5rem;">
        <span style="color: var(--primary);">ℹ</span> Las ausencias se muestran solo para los tramos marcados como "Guardia"
        y para el día actual.
    </div>
@endsection