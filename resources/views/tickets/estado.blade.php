<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de Reparación - satMPC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 font-sans min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-2xl bg-white rounded-[3rem] p-10 shadow-2xl border border-slate-100">
        
        <!-- Cabecera -->
        <div class="flex justify-between items-start mb-10">
            <div>
                <h3 class="text-xs font-black text-blue-600 uppercase tracking-widest mb-1 italic">Consulta Finalizada</h3>
                <h2 class="text-3xl font-black text-slate-800 uppercase italic">Ticket #{{ $ticket->codigo }}</h2>
            </div>
            <div class="bg-blue-50 px-4 py-2 rounded-2xl">
                <span class="text-[10px] font-black text-blue-600 uppercase tracking-tighter">Estado Actual:</span>
                <p class="text-sm font-bold text-blue-800 uppercase italic">{{ $ticket->estado }}</p>
            </div>
        </div>

        <!-- Información del Equipo -->
        <div class="grid grid-cols-2 gap-8 mb-10">
            <div class="space-y-1">
                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest italic">Dispositivo</label>
                <p class="text-lg font-bold text-slate-700">{{ $ticket->equipo }}</p>
            </div>
            <div class="space-y-1">
                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest italic">Fecha de Entrada</label>
                <p class="text-lg font-bold text-slate-700">{{ $ticket->created_at->format('d/m/Y') }}</p>
            </div>
        </div>

        <!-- Barra de Progreso Visual -->
        <div class="mb-10">
            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-4 block italic">Progreso de la Reparación</label>
            <div class="relative w-full h-4 bg-slate-100 rounded-full overflow-hidden border border-slate-200">
                @php
                    $progreso = [
                        'Recibido' => '20%',
                        'En Proceso' => '50%',
                        'Esperando Repuesto' => '70%',
                        'Listo' => '90%',
                        'Entregado' => '100%'
                    ][$ticket->estado] ?? '0%';
                @endphp
                <div class="absolute top-0 left-0 h-full bg-blue-600 transition-all duration-1000" style="width: {{ $progreso }}"></div>
            </div>
            <div class="flex justify-between mt-2 text-[9px] font-black text-slate-400 uppercase tracking-tighter italic">
                <span>Recibido</span>
                <span>Reparando</span>
                <span>Listo para Recogida</span>
            </div>
        </div>

        <!-- Botón Volver -->
        <div class="pt-6 border-t border-slate-100">
            <a href="/" class="inline-flex items-center text-sm font-black text-slate-400 hover:text-blue-600 transition-colors uppercase tracking-widest italic">
                <span class="mr-2">←</span> Volver al inicio
            </a>
        </div>
    </div>

</body>
</html>
