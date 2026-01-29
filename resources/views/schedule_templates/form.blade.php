@extends('layouts.app')

@section('title', isset($template) ? 'Editar Plantilla' : 'Nueva Plantilla')

@section('content')
<div class="header-actions">
    <h1>{{ isset($template) ? 'Editar Plantilla' : 'Crear Nueva Plantilla' }}</h1>
    <a href="{{ route('schedule-templates.index') }}" class="btn-secondary">Volver</a>
</div>

<div class="card" style="padding: 20px;">
    <form id="templateForm" method="POST" action="{{ isset($template) ? route('schedule-templates.update', $template->id) : route('schedule-templates.store') }}">
        @csrf
        @if(isset($template))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="name">Nombre de la Plantilla</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $template->name ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="description">Descripción (Opcional)</label>
            <textarea name="description" id="description" class="form-control">{{ old('description', $template->description ?? '') }}</textarea>
        </div>

        <div class="form-group">
            <label>Días Activos</label>
            <div class="days-checkboxes">
                @php
                    $days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                    $activeDays = old('active_days', $template->active_days ?? []);
                @endphp
                @foreach($days as $index => $day)
                    <label class="checkbox-label">
                        <input type="checkbox" name="active_days[]" value="{{ $index + 1 }}" onchange="updateGrid()"
                            {{ in_array($index + 1, $activeDays) ? 'checked' : '' }}>
                        {{ $day }}
                    </label>
                @endforeach
            </div>
        </div>

        <div class="row">
            <!-- Slots Manager -->
            <div class="col-md-4" style="flex: 1; padding-right: 20px; border-right: 1px solid #eee;">
                <h3>Tramos Horarios</h3>
                <div id="slots-container">
                    <!-- Slots will be injected here via JS -->
                </div>
                <button type="button" class="btn-primary" onclick="addSlot()" style="margin-top: 10px; width: 100%;">+ Añadir Tramo</button>
            </div>

            <!-- Live Preview -->
            <div class="col-md-8" style="flex: 2; padding-left: 20px;">
                <h3>Vista Previa del Grid</h3>
                <div class="grid-preview-container">
                    <table class="grid-table" id="gridTable">
                        <thead>
                            <tr id="gridHeader">
                                <th>Horario</th>
                                <!-- Days headers injected via JS -->
                            </tr>
                        </thead>
                        <tbody id="gridBody">
                            <!-- Grid rows injected via JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="form-actions" style="margin-top: 30px; text-align: right;">
            <button type="submit" class="btn-primary">Guardar Plantilla</button>
        </div>
    </form>
</div>

<!-- Template for JS -->
<template id="slot-template">
    <div class="slot-item" data-index="{index}">
        <div class="slot-header">
            <span class="slot-title">Tramo {number}</span>
            <button type="button" class="btn-icon delete" onclick="removeSlot(this)">×</button>
        </div>
        <div class="slot-body">
            <input type="text" name="slots[{index}][name]" class="form-control mb-2 slot-name" placeholder="Nombre (ej. 1ª Hora)" oninput="updateGrid()" required>
            <div class="time-inputs">
                <input type="time" name="slots[{index}][start_time]" class="form-control slot-start" onchange="updateGrid()" required>
                <span>-</span>
                <input type="time" name="slots[{index}][end_time]" class="form-control slot-end" onchange="updateGrid()" required>
            </div>
        </div>
    </div>
</template>

<style>
    /* Styles specifically for the editor */
    h1, h2, h3, h4, label { color: #ffffff !important; }
    .header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .slot-title { color: #000000 !important; }
    .row { display: flex; }
    .form-group { margin-bottom: 20px; }
    .form-control { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; color: #000000; }
    .mb-2 { margin-bottom: 8px; }
    .days-checkboxes { display: flex; gap: 15px; flex-wrap: wrap; }
    .checkbox-label { display: flex; align-items: center; gap: 5px; cursor: pointer; color: #000000; }
    
    .slot-item { background: #f9fafb; border: 1px solid #e5e7eb; padding: 10px; border-radius: 6px; margin-bottom: 10px; }
    .slot-header { display: flex; justify-content: space-between; margin-bottom: 5px; font-weight: 600; font-size: 0.9em; color: #000000; }
    .time-inputs { display: flex; gap: 5px; align-items: center; }
    
    .grid-table { width: 100%; border-collapse: collapse; font-size: 0.9em; }
    .grid-table th, .grid-table td { border: 1px solid #e5e7eb; padding: 8px; text-align: center; color: #000000; }
    .grid-table th { background: #f3f4f6; color: #000000; }
    .grid-table td:first-child { color: #ffffff; }
    
    .btn-secondary { background: #6b7280; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none; }
    .btn-primary { background: #4f46e5; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
    .btn-icon.delete { color: red; cursor: pointer; background: none; border: none; font-size: 1.2em; }
</style>

<script>
    let slotCount = 0;
    const existingSlots = @json($template->timeSlots ?? []);
    const days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

    document.addEventListener('DOMContentLoaded', () => {
        if (existingSlots.length > 0) {
            existingSlots.forEach(slot => {
                addSlot(slot);
            });
        } else {
            // Add one empty slot by default
            addSlot();
        }
        updateGrid();
    });

    function addSlot(data = null) {
        const template = document.getElementById('slot-template').innerHTML;
        const html = template
            .replace(/{index}/g, slotCount)
            .replace(/{number}/g, slotCount + 1);
        
        const container = document.getElementById('slots-container');
        const div = document.createElement('div');
        div.innerHTML = html;
        const slotEl = div.firstElementChild;
        
        container.appendChild(slotEl);

        if (data) {
            slotEl.querySelector('.slot-name').value = data.name;
            slotEl.querySelector('.slot-start').value = data.start_time; // Ensure format HH:MM via controller/model accessor if needed, or JS slice
            slotEl.querySelector('.slot-end').value = data.end_time;
        }

        slotCount++;
        reindexSlots();
        updateGrid();
    }

    function removeSlot(btn) {
        btn.closest('.slot-item').remove();
        reindexSlots();
        updateGrid();
    }

    function reindexSlots() {
        const slots = document.querySelectorAll('.slot-item');
        slots.forEach((slot, index) => {
            slot.querySelector('.slot-title').textContent = `Tramo ${index + 1}`;
            // NOTE: We don't necessarily need to re-index the name attributes 
            // if the backend handles array of objects, but Laravel usually likes unique indices.
            // For simplicity, we keep original indices or we naturally rely on the array submission.
            // However, to be cleaner, we could re-index name attributes. 
            // For now, let's leave attributes as they were generated, 
            // but we might have gaps in indices (slots[0], slots[2]). 
            // Laravel's $request->slots will verify array integrity or use array_values if we use specific keys.
            // BUT: HTML form submission with slots[0], slots[2] results in an array with indices 0 and 2.
            // $request->slots in Laravel will be an array.
            // Controller loop: foreach($request->slots as $index => $slotData) handle gaps fine.
        });
    }

    function updateGrid() {
        // 1. Get Active Days
        const activeDaysChecks = document.querySelectorAll('input[name="active_days[]"]:checked');
        const activeIndices = Array.from(activeDaysChecks).map(cb => parseInt(cb.value));
        activeIndices.sort();

        // 2. Update Header
        const headerRow = document.getElementById('gridHeader');
        // Clear existing headers except first
        while (headerRow.children.length > 1) {
            headerRow.removeChild(headerRow.lastChild);
        }
        
        activeIndices.forEach(idx => {
            const th = document.createElement('th');
            th.textContent = days[idx - 1];
            headerRow.appendChild(th);
        });

        // 3. Get Slots Data
        const slots = [];
        document.querySelectorAll('.slot-item').forEach(item => {
            slots.push({
                name: item.querySelector('.slot-name').value,
                start: item.querySelector('.slot-start').value,
                end: item.querySelector('.slot-end').value
            });
        });

        // 4. Update Body
        const body = document.getElementById('gridBody');
        body.innerHTML = '';

        slots.forEach(slot => {
            const tr = document.createElement('tr');
            
            // Time Column
            const tdTime = document.createElement('td');
            // Format time if present
            const start = slot.start ? slot.start.substring(0, 5) : '--:--';
            const end = slot.end ? slot.end.substring(0, 5) : '--:--';
            tdTime.innerHTML = `<strong>${start} - ${end}</strong><br><small>${slot.name || 'Sin nombre'}</small>`;
            tr.appendChild(tdTime);

            // Day Columns
            activeIndices.forEach(() => {
                const td = document.createElement('td');
                td.style.backgroundColor = '#fff'; // Placeholder for activity
                tr.appendChild(td);
            });

            body.appendChild(tr);
        });
    }

    // Handle AJAX form submission for smoother experience (optional, but requested: "eliminar tramos dinámicamente sin recargar")
    // The requirement says "gestor... donde se puedan añadir, editar... sin recargar". 
    // This is achieved by the JS editor. The final "Save" can be a standard POST or AJAX.
    // I implemented standard POST.
    
    // To handle "Preview" or "Delete" requests, I used the standard links in Index.
    // Here we use standard form submission.
    
    document.getElementById('templateForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                alert('Error: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred.');
        });
    });

</script>
@endsection
