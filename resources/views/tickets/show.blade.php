<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen Técnico - {{ $ticket->codigo }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cloudflare.com">
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; margin: 0 !important; }
            .main-container { max-width: 100% !important; width: 100% !important; padding: 0 !important; margin: 0 !important; }
            .content-card { 
                box-shadow: none !important; 
                border: 1px solid #eee !important; 
                border-radius: 0.5rem !important;
                padding: 1cm !important;
                margin: 0 !important;
            }
            /* Fuerza las 2 columnas en el papel */
            .print-grid { 
                display: grid !important; 
                grid-template-columns: 1fr 1fr !important; 
                gap: 2rem !important; 
            }
            .section-box { border-radius: 1rem !important; }
        }
    </style>
</head>
<body class="bg-slate-50 p-4 md:p-8">
    <div class="max-w-4xl mx-auto main-container">
        
        <!-- Barra de Acciones (Botones a la izquierda, Estado a la derecha) -->
        <div class="no-print p-4 mb-4 flex justify-between items-center">
            <div class="flex items-center">
                <button onclick="window.print()" class="bg-black text-white px-6 py-2 rounded font-bold text-xs uppercase hover:bg-gray-800 transition-colors">
                    Imprimir Ahora
                </button>
                <a href="{{ route('tickets.index') }}" class="ml-4 text-xs font-bold text-gray-500 uppercase italic hover:text-black transition-colors">
                    ← Volver
                </a>
            </div>

            <span class="px-4 py-2.5 rounded-xl text-[10px] font-black uppercase italic shadow-md {{ $ticket->estado == 'Listo' || $ticket->estado == 'Entregado' ? 'bg-green-600 text-white' : 'bg-blue-600 text-white' }}">
                {{ $ticket->estado }}
            </span>
        </div>

        <!-- CONTENIDO DEL INFORME -->
        <div class="bg-white rounded-[2.5rem] shadow-xl overflow-hidden border border-slate-200 p-8 md:p-12 content-card">
            
            <!-- Encabezado -->
            <div class="flex justify-between items-start mb-10 pb-8 border-b border-slate-100">
                <div>
                    <h1 class="text-3xl font-black text-slate-800 uppercase italic tracking-tighter leading-none mb-1">
                        SAT <span class="text-blue-600">MPC</span>
                    </h1>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.2em] italic">Resumen Técnico de Reparación</p>
                </div>
                <div class="text-right">
                    <p class="text-[9px] font-black text-slate-400 uppercase italic tracking-widest mb-1">Código de Parte</p>
                    <p class="text-2xl font-black text-slate-800 tracking-tighter">{{ $ticket->codigo }}</p>
                </div>
            </div>

            <!-- Información Básica (Forzado a 2 columnas con print-grid) -->
            <div class="print-grid grid grid-cols-1 md:grid-cols-2 gap-10 mb-12">
                <div>
                    <h3 class="text-[9px] font-black text-slate-400 uppercase mb-2 tracking-widest italic leading-none">Información del Equipo</h3>
                    <p class="text-xl font-black text-slate-800 uppercase italic leading-tight">{{ $ticket->equipo }}</p>
                    <p class="text-slate-400 text-[11px] font-medium mt-1 italic">Ingreso: {{ $ticket->created_at->format('d/m/Y') }}</p>
                </div>
                <div class="md:text-right">
                    <h3 class="text-[9px] font-black text-slate-400 uppercase mb-2 tracking-widest italic leading-none">Cliente</h3>
                    <p class="text-lg font-bold text-slate-700 leading-tight">{{ $ticket->cliente->nombre }} {{ $ticket->cliente->apellidos }}</p>
                    <p class="text-slate-400 text-[11px] font-medium mt-1">{{ $ticket->cliente->telefono }}</p>
                </div>
            </div>

            <!-- Secciones con Espaciado -->
            <div class="space-y-12">
                
                <!-- Avería Inicial -->
                <div>
                    <h4 class="text-[9px] font-black text-blue-600 uppercase mb-3 italic tracking-widest">Avería Reportada:</h4>
                    <div class="bg-slate-50 p-8 rounded-[2rem] border border-slate-100 italic text-slate-600 text-sm section-box">
                        "{{ $ticket->averia }}"
                    </div>
                </div>

                <!-- Informe Técnico -->
                <div class="mt-10">
                    <h4 class="text-[9px] font-black text-green-600 uppercase mb-3 italic tracking-widest">Informe Técnico / Notas:</h4>
                    <div class="bg-white p-8 rounded-[2rem] border-2 border-green-100 text-slate-700 text-sm font-medium min-h-[100px] section-box shadow-sm">
                        @if($ticket->notas_tecnicas)
                            {!! nl2br(e($ticket->notas_tecnicas)) !!}
                        @else
                            <span class="text-slate-300 italic">No se han registrado observaciones técnicas.</span>
                        @endif
                    </div>
                </div>

                <!-- Repuestos -->
                @if($ticket->repuestos->count() > 0)
                <div class="mt-10">
                    <h4 class="text-[9px] font-black text-slate-400 uppercase mb-3 italic tracking-widest">Repuestos Instalados:</h4>
                    <div class="overflow-hidden rounded-[2rem] border border-slate-100 section-box">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-8 py-4 font-black uppercase text-[10px] text-slate-400 italic">Repuesto</th>
                                    <th class="px-8 py-4 font-black uppercase text-[10px] text-slate-400 italic text-center">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($ticket->repuestos as $repuesto)
                                <tr>
                                    <td class="px-8 py-5 font-bold text-slate-700">{{ $repuesto->descripcion }}</td>
                                    <td class="px-8 py-5 text-center font-bold text-slate-600">{{ $repuesto->pivot->cantidad }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
            <!-- Pie del Informe (Tamaño micro para impresión profesional) -->
            <div class="hidden print:block mt-20 pt-4 border-t border-slate-50 text-center">
                <p style="font-size: 8px !important; letter-spacing: 0.5em !important;" class="font-normal text-slate-300 uppercase opacity-50">
                    Documento generado por satMPC Management System
                </p>
            </div>
        </div>
    </div>
</body>
</html>