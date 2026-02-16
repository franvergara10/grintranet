@extends('layouts.app')

@section('title', 'AulaPass - Dashboard')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-6 font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header, Statistics & Search -->
            <div
                class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 dark:border-gray-700/50 p-6 mb-8 transition-all duration-300">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8">
                    <div>
                        <h1
                            class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400 mb-1">
                            AulaPass
                        </h1>
                        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Gestión inteligente de salidas</p>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="grid grid-cols-2 gap-4 w-full lg:w-auto">
                        <div class="bg-blue-500/10 border border-blue-500/20 rounded-xl px-4 py-3 min-w-[140px]">
                            <p class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider mb-1">En
                                Pasillo</p>
                            <div class="flex items-baseline gap-1">
                                <span
                                    class="text-2xl font-black text-blue-700 dark:text-blue-200">{{ $stats['active_count'] }}</span>
                                <span class="text-blue-600/50 text-xs font-bold">Activos</span>
                            </div>
                        </div>
                        <div class="bg-indigo-500/10 border border-indigo-500/20 rounded-xl px-4 py-3 min-w-[140px]">
                            <p class="text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-1">
                                Total Hoy</p>
                            <div class="flex items-baseline gap-1">
                                <span
                                    class="text-2xl font-black text-indigo-700 dark:text-indigo-200">{{ $stats['today_count'] }}</span>
                                <span class="text-indigo-600/50 text-xs font-bold">Pases</span>
                            </div>
                        </div>
                    </div>

                    <!-- Search & Class Selector -->
                    <div class="flex flex-col sm:flex-row items-center gap-4 w-full lg:w-auto">
                        <div class="relative w-full sm:w-64">
                            <input type="text" id="student-search" placeholder="Buscar alumno..."
                                class="w-full bg-white dark:bg-gray-700 border-0 rounded-xl shadow-sm ring-1 ring-gray-200 dark:ring-gray-600 py-2.5 pl-10 pr-4 text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 transition-all">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>

                        <div class="flex gap-2 w-full sm:w-auto">
                            <div class="relative flex-1 sm:w-48">
                                <select id="class-selector"
                                    class="block w-full bg-white dark:bg-gray-700 border-0 rounded-xl shadow-sm ring-1 ring-gray-200 dark:ring-gray-600 py-2.5 pl-4 pr-10 text-sm text-gray-900 dark:text-gray-100 font-semibold focus:ring-2 focus:ring-blue-500 transition-all appearance-none cursor-pointer">
                                    <option value="" disabled selected>Seleccionar clase...</option>
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}">
                                            {{ $group->course }} {{ $group->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>

                            <a href="{{ route('aula.monitor') }}"
                                class="p-2.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"
                                title="Monitor">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <a href="{{ route('aula.history') }}"
                                class="p-2.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"
                                title="Historial">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <button id="return-all-btn" onclick="returnAll()"
                    class="hidden w-full mt-6 py-3 px-4 bg-gradient-to-r from-rose-500 to-red-600 hover:from-rose-600 hover:to-red-700 text-white rounded-xl font-bold shadow-lg shadow-red-500/30 transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Regresar a todos los alumnos del grupo
                </button>
            </div>

            <!-- Student Grid -->
            <div id="student-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($students as $student)
                    @php
                        $activePass = $activePasses->firstWhere('user_id', $student->id);
                    @endphp
                    <div class="student-card group relative bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700 flex flex-col justify-between"
                        data-group-id="{{ $student->group_id }}" data-id="{{ $student->id }}"
                        data-search="{{ strtolower($student->name . ' ' . $student->last_name) }}" style="display: none;">

                        <!-- Card Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div
                                    class="h-10 w-10 rounded-full bg-gradient-to-tr from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-sm shadow-md">
                                    {{ substr($student->name, 0, 1) }}{{ substr($student->last_name ?? '', 0, 1) }}
                                </div>
                                <div class="overflow-hidden">
                                    <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100 truncate"
                                        title="{{ $student->name }} {{ $student->last_name }}">
                                        {{ $student->name }} {{ $student->last_name }}
                                    </h3>
                                    <span class="text-xs text-gray-400 dark:text-gray-500 truncate block">
                                        {{ $student->groupRel?->course ?? '' }} {{ $student->groupRel?->name ?? '' }}
                                    </span>
                                </div>
                            </div>
                            @if($activePass)
                                <span class="flex h-3 w-3 relative">
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
                                </span>
                            @endif
                        </div>

                        <!-- Actions Area -->
                        <div class="mt-auto">
                            @if($activePass)
                                <!-- Active State -->
                                <div class="space-y-3">
                                    <div
                                        class="bg-amber-50 dark:bg-amber-900/20 rounded-xl p-3 border border-amber-100 dark:border-amber-800/50">
                                        <div class="flex justify-between items-center mb-1">
                                            <span
                                                class="text-xs font-bold text-amber-600 dark:text-amber-400 uppercase tracking-wide">
                                                {{ $activePass->reason }}
                                            </span>
                                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="text-2xl font-mono font-bold text-amber-600 dark:text-amber-400 timer"
                                            data-start="{{ $activePass->start_time->timestamp }}">
                                            00:00
                                        </div>
                                    </div>
                                    <button onclick="endPass({{ $activePass->id }})"
                                        class="w-full py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl font-bold shadow-lg shadow-emerald-500/30 transform active:scale-95 transition-all duration-200 flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Regresar
                                    </button>
                                </div>
                            @else
                                <!-- Idle State -->
                                <div class="grid grid-cols-2 gap-2">
                                    <button onclick="createPass({{ $student->id }}, 'Baño')"
                                        class="group/btn p-3 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/40 text-blue-600 dark:text-blue-400 rounded-xl border border-blue-200 dark:border-blue-800 transition-all duration-200 flex flex-col items-center gap-1">
                                        <svg class="w-6 h-6 opacity-80 group-hover/btn:scale-110 transition-transform" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m8-2a2 2 0 100-4 2 2 0 000 4zM7 8h10M7 12h10">
                                            </path>
                                        </svg>
                                        <span class="text-xs font-semibold">Baño</span>
                                    </button>
                                    <button onclick="createPass({{ $student->id }}, 'Agua')"
                                        class="group/btn p-3 bg-cyan-50 dark:bg-cyan-900/20 hover:bg-cyan-100 dark:hover:bg-cyan-900/40 text-cyan-600 dark:text-cyan-400 rounded-xl border border-cyan-200 dark:border-cyan-800 transition-all duration-200 flex flex-col items-center gap-1">
                                        <svg class="w-6 h-6 opacity-80 group-hover/btn:scale-110 transition-transform" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 14.66V20a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2h2.5"></path>
                                        </svg>
                                        <span class="text-xs font-semibold">Agua</span>
                                    </button>
                                    <button onclick="createPass({{ $student->id }}, 'Taquilla')"
                                        class="group/btn p-3 bg-orange-50 dark:bg-orange-900/20 hover:bg-orange-100 dark:hover:bg-orange-900/40 text-orange-600 dark:text-orange-400 rounded-xl border border-orange-200 dark:border-orange-800 transition-all duration-200 flex flex-col items-center gap-1">
                                        <svg class="w-6 h-6 opacity-80 group-hover/btn:scale-110 transition-transform" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 3h18v18H3zM12 8v8m-4-4h8"></path>
                                        </svg>
                                        <span class="text-xs font-semibold">Taquilla</span>
                                    </button>
                                    <button onclick="promptCustomReason({{ $student->id }})"
                                        class="group/btn p-3 bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400 rounded-xl border border-gray-200 dark:border-gray-600 transition-all duration-200 flex flex-col items-center gap-1">
                                        <svg class="w-6 h-6 opacity-80 group-hover/btn:scale-110 transition-transform" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z">
                                            </path>
                                        </svg>
                                        <span class="text-xs font-semibold">Otro</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div id="empty-state" class="hidden flex flex-col items-center justify-center py-20 text-center">
                <div class="bg-gray-100 dark:bg-gray-800 rounded-full p-6 mb-4 animate-pulse">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-700 dark:text-gray-300 mb-2">Selecciona una clase</h3>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div id="toast-container"></div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('student-search');
            const selector = document.getElementById('class-selector');
            const cards = document.querySelectorAll('.student-card');
            const emptyState = document.getElementById('empty-state');
            const returnAllBtn = document.getElementById('return-all-btn');

            function applyFilters() {
                const selectedGroup = selector.value;
                const searchTerm = searchInput.value?.toLowerCase().trim() || '';
                let counter = 0;

                cards.forEach(card => {
                    const matchesGroup = !selectedGroup || String(card.dataset.groupId) === String(selectedGroup);
                    const matchesSearch = !searchTerm || card.dataset.search.includes(searchTerm);

                    if (matchesGroup && matchesSearch) {
                        card.style.display = 'flex';
                        counter++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Empty state handling
                if (counter === 0 && (selectedGroup || searchTerm)) {
                    emptyState.innerHTML = `
                            <div class="bg-gray-100 dark:bg-gray-800 rounded-full p-6 mb-4 animate-pulse">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-700 dark:text-gray-300 mb-2">No se han encontrado alumnos</h3>
                            <p class="text-gray-500 max-w-sm">Prueba ajustando los filtros o el término de búsqueda.</p>
                        `;
                    emptyState.classList.remove('hidden');
                    returnAllBtn.classList.add('hidden');
                } else if (!selectedGroup && !searchTerm) {
                    emptyState.innerHTML = `
                            <div class="bg-gray-100 dark:bg-gray-800 rounded-full p-6 mb-4 animate-pulse">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-700 dark:text-gray-300 mb-2">Selecciona una clase</h3>
                            <p class="text-gray-500 max-w-sm">Elige un grupo o busca un alumno para comenzar.</p>
                        `;
                    emptyState.classList.remove('hidden');
                    returnAllBtn.classList.add('hidden');
                } else {
                    emptyState.classList.add('hidden');
                    const hasActiveInGroup = Array.from(cards).some(card =>
                        String(card.dataset.groupId) === String(selectedGroup) &&
                        card.querySelector('.timer')
                    );
                    if (selectedGroup && hasActiveInGroup) {
                        returnAllBtn.classList.remove('hidden');
                    } else {
                        returnAllBtn.classList.add('hidden');
                    }
                }
            }

            selector.addEventListener('change', applyFilters);
            searchInput.addEventListener('input', applyFilters);

            // Initial call
            applyFilters();

            // Toast System
            window.showToast = function (message, type = 'info') {
                const container = document.getElementById('toast-container');
                const toast = document.createElement('div');
                toast.className = `toast toast-${type}`;

                let icon = '';
                if (type === 'success') icon = '<svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
                if (type === 'error') icon = '<svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>';
                if (type === 'info') icon = '<svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';

                toast.innerHTML = `
                        ${icon}
                        <span>${message}</span>
                    `;

                container.appendChild(toast);

                setTimeout(() => {
                    toast.classList.add('hide');
                    setTimeout(() => toast.remove(), 300);
                }, 4000);
            };

            // Timer Logic
            setInterval(() => {
                document.querySelectorAll('.timer').forEach(el => {
                    const start = parseInt(el.dataset.start);
                    const now = Math.floor(Date.now() / 1000);
                    const diff = now - start;
                    const minutes = Math.floor(diff / 60).toString().padStart(2, '0');
                    const seconds = (diff % 60).toString().padStart(2, '0');
                    el.textContent = `${minutes}:${seconds}`;
                });
            }, 1000);
        });

        // API Calls
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

        async function createPass(studentId, reason) {
            try {
                const res = await fetch('{{ route("aula.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ student_id: studentId, reason: reason })
                });
                if (!res.ok) {
                    const data = await res.json();
                    throw new Error(data.error || 'Error creating pass');
                }
                showToast('Pase creado correctamente', 'success');
                setTimeout(() => window.location.reload(), 500);
            } catch (e) {
                console.error(e);
                showToast(e.message, 'error');
            }
        }

        function promptCustomReason(studentId) {
            const reason = prompt("Especifica el motivo de la salida:");
            if (reason && reason.trim()) {
                createPass(studentId, reason.trim());
            }
        }

        async function endPass(passId) {
            try {
                const res = await fetch(`/aula/pass/${passId}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ _method: 'PATCH' })
                });

                if (!res.ok) throw new Error('Error ending pass');
                showToast('Pase finalizado', 'success');
                setTimeout(() => window.location.reload(), 500);
            } catch (e) {
                showToast(e.message, 'error');
            }
        }

        async function returnAll() {
            const selector = document.getElementById('class-selector');
            const groupId = selector.value;
            const groupName = selector.options[selector.selectedIndex].text.trim();

            if (!groupId) return;
            if (!confirm(`¿Regresar a TODOS los alumnos de ${groupName}?`)) return;

            try {
                const res = await fetch('{{ route("aula.return-all") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ group_id: groupId })
                });

                if (!res.ok) throw new Error('Error returning all');
                showToast('Todos los alumnos han regresado', 'success');
                setTimeout(() => window.location.reload(), 500);
            } catch (e) {
                showToast(e.message, 'error');
            }
        }
    </script>
@endsection