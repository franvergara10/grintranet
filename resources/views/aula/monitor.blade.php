@extends('layouts.app')

@section('title', 'AulaPass - Monitor Conserjería')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4 sm:gap-0">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-gray-200 text-center sm:text-left">Monitor
                    de Pasillo</h1>
                <span class="text-xs sm:text-sm text-gray-500 bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full">
                    Auto-update: 30s
                </span>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($activePasses->isEmpty())
                        <div class="text-center py-12 text-gray-500">
                            <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <p class="text-lg">No hay alumnos en el pasillo ahora mismo.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($activePasses as $pass)
                                <div
                                    class="p-6 border-b border-gray-100 dark:border-gray-700 last:border-0 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <span class="flex h-3 w-3 relative">
                                                <span
                                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                                <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                                            </span>
                                            <div>
                                                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                                    {{ $pass->student?->name }} {{ $pass->student?->last_name }}
                                                </h3>
                                                <p class="text-sm text-gray-500">
                                                    {{ $pass->student?->groupRel?->course ?? '' }}
                                                    {{ $pass->student?->groupRel?->name ?? '' }}
                                                    &bull; {{ $pass->reason }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-3xl font-mono font-bold text-blue-600 dark:text-blue-400 timer"
                                                data-start="{{ $pass->start_time->timestamp }}">
                                                00:00
                                            </div>
                                            <span class="text-xs text-gray-400">Salida:
                                                {{ $pass->start_time->format('H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto refresh
        setTimeout(() => {
            window.location.reload();
        }, 30000);

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
    </script>
@endsection