<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista Previa - {{ $template->name }}</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .schedule-table th,
        .schedule-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        .schedule-table th {
            background-color: #f0f0f0;
        }

        .time-col {
            width: 150px;
            font-weight: bold;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()">Imprimir</button>
        <button onclick="window.close()">Cerrar</button>
    </div>

    <h1>{{ $template->name }}</h1>
    @if($template->description)
        <p style="text-align: center;">{{ $template->description }}</p>
    @endif

    <table class="schedule-table">
        <thead>
            <tr>
                <th class="time-col">Horario</th>
                @foreach (['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'] as $index => $day)
                    @if(in_array($index + 1, $template->active_days ?? []))
                        <th>{{ $day }}</th>
                    @endif
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($template->timeSlots as $slot)
                <tr>
                    <td class="time-col">
                        {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} -
                        {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                        <br>
                        <small>{{ $slot->name }}</small>
                    </td>
                    @foreach (['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'] as $index => $day)
                        @if(in_array($index + 1, $template->active_days ?? []))
                            <td></td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>