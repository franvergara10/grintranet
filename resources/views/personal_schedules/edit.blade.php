@extends('layouts.app')

@section('title', 'Editar Mi Horario')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Mi Horario Personal</h1>
            <p style="color: var(--text-muted);">Basado en: <strong>{{ $template->name }}</strong></p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('personal-schedules.index') }}" class="btn"
                style="background: rgba(255,255,255,0.05);">Cancelar</a>
            <button type="button" onclick="saveSchedule()" class="btn btn-primary">Guardar Cambios</button>
        </div>
    </div>

    <div class="card" style="padding: 0; overflow-x: auto;">
        <form id="scheduleForm" action="{{ route('personal-schedules.update', $personal_schedule) }}" method="POST">
            @csrf
            @method('PUT')

            <table style="width: 100%; border-collapse: collapse; min-width: 800px;">
                <thead>
                    <tr style="background: rgba(255,255,255,0.02);">
                        <th
                            style="padding: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.05); text-align: left; width: 200px;">
                            Tramo Horario</th>
                        @foreach($days as $day)
                            <th style="padding: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.05); text-align: center;">
                                {{ $day }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($slots as $slot)
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                            <td style="padding: 1rem 1.5rem;">
                                <div style="font-weight: 600;">{{ $slot->name }}</div>
                                <div style="font-size: 0.8rem; color: var(--text-muted);">
                                    {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                                </div>
                            </td>
                            @foreach($days as $day)
                                @php
                                    $key = $slot->id . '-' . $day;
                                    $currentSelection = $selections[$key] ?? null;
                                @endphp
                                <td style="padding: 0.5rem; text-align: center;">
                                    <div class="schedule-cell" style="position: relative;">
                                        <select name="selections[{{ $slot->id }}][{{ $day }}]" class="form-control select-activity"
                                            style="width: 100%; padding: 0.5rem; border-radius: 0.4rem; background: {{ $currentSelection ? 'rgba(56, 189, 248, 0.1)' : 'var(--bg-card)' }}; color: #fff; border: 1px solid {{ $currentSelection ? 'var(--primary)' : 'rgba(255,255,255,0.05)' }};"
                                            onchange="this.style.background = this.value ? 'rgba(56, 189, 248, 0.1)' : 'var(--bg-card)'; this.style.borderColor = this.value ? 'var(--primary)' : 'rgba(255,255,255,0.05)';">
                                            <option value="" style="color: #000; background: #fff;">Vacío</option>
                                            @foreach($guardias as $guardia)
                                                <option value="guardia_{{ $guardia->id }}" style="color: #000; background: #fff;" 
                                                    {{ ($currentSelection && $currentSelection->guardia_id == $guardia->id) ? 'selected' : '' }}>
                                                    Guardia ({{ $guardia->name }})
                                                </option>
                                            @endforeach
                                            <option value="Otras" style="color: #000; background: #fff;" {{ ($currentSelection && $currentSelection->value == 'Otras') ? 'selected' : '' }}>Otras</option>
                                        </select>
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    </div>

    <div style="margin-top: 2rem; display: flex; justify-content: flex-end;">
        <button type="button" onclick="saveSchedule()" class="btn btn-primary" style="padding: 1rem 2rem;">Guardar Mi
            Horarios</button>
    </div>

    <script shadow>
        function saveSchedule() {
            const form = document.getElementById('scheduleForm');
            const formData = new FormData(form);

            // Show loading state
            const btn = event.target;
            const originalText = btn.innerText;
            btn.innerText = 'Guardando...';
            btn.disabled = true;

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = "{{ route('personal-schedules.index') }}";
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ocurrió un error al guardar.');
                })
                .finally(() => {
                    btn.innerText = originalText;
                    btn.disabled = false;
                });
        }

        function showToast(message) {
            // Check if toast element exists
            let toast = document.getElementById('toast-notification');
            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'toast-notification';
                toast.style.cssText = 'position: fixed; bottom: 2rem; right: 2rem; background: var(--success); color: #fff; padding: 1rem 2rem; border-radius: 0.5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.1); z-index: 9999; transform: translateY(100px); transition: transform 0.3s ease;';
                document.body.appendChild(toast);
            }

            toast.innerText = message;
            toast.style.transform = 'translateY(0)';

            setTimeout(() => {
                toast.style.transform = 'translateY(100px)';
            }, 3000);
        }
    </script>
@endsection