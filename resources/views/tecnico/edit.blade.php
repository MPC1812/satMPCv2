<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Parte - {{ $ticket->codigo }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        @media print {
            /* Ocultamos todo lo innecesario para el cliente en el papel */
            .no-print, form button, .bg-blue-50\/50, .repuestos-container { 
                display: none !important; 
            }
            body { background: white !important; padding: 0 !important; margin: 0 !important; }
            .max-w-6xl { max-width: 100% !important; width: 100% !important; }
            .bg-white { box-shadow: none !important; border: 1px solid #f1f5f9 !important; border-radius: 1rem !important; }
            @page { margin: 1cm; }
        }
    </style>
</head>
<body class="bg-slate-50 p-4 md:p-8 font-sans antialiased">
    <div class="max-w-6xl mx-auto">

        <!-- CABECERA: BOTONES DE ACCIÓN (ESTILO SATMPC) -->
        <div class="no-print mb-8 flex justify-between items-center">
            <div class="flex items-center">
                <!-- Botón Imprimir (Negro Rectangular) -->
                <button onclick="window.print()" class="bg-black text-white px-8 py-3 rounded-lg font-black text-[11px] uppercase tracking-[0.15em] hover:bg-slate-800 transition-all shadow-sm">
                    IMPRIMIR AHORA
                </button>
                
                <!-- Botón Volver -->
                <a href="{{ route('tickets.index') }}" class="ml-10 text-[11px] font-black text-slate-400 uppercase italic hover:text-black transition-colors tracking-[0.15em] flex items-center">
                    <span class="mr-2">←</span> VOLVER
                </a>
            </div>

            <!-- BOTÓN LOGOUT (ESTILO VISTA PRINCIPAL) -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="group flex items-center justify-center w-[52px] h-[52px] md:w-auto md:px-5 bg-white border border-slate-200 rounded-2xl shadow-sm hover:bg-red-50 hover:border-red-100 transition-all cursor-pointer">
                    <span class="hidden md:block text-[10px] font-black uppercase tracking-widest text-slate-400 group-hover:text-red-600 transition-colors italic mr-3">
                        Cerrar Sesión
                    </span>
                    <svg xmlns="http://w3.org" class="w-4 h-4 text-slate-400 group-hover:text-red-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>

        <!-- TÍTULO DEL PARTE -->
        <div class="mb-8">
            <h2 class="text-3xl font-black text-slate-800 italic uppercase leading-none tracking-tighter">
                Editar Parte: <span class="text-blue-600">{{ $ticket->codigo }}</span>
            </h2>
        </div>

        <!-- BLOQUE PRINCIPAL BLANCO -->
        <div class="bg-white rounded-[2rem] shadow-xl border border-slate-200 overflow-hidden mb-12">
            <div class="p-8 md:p-10">
                
                <!-- 1. FORMULARIO DE EDICIÓN Y AÑADIR MATERIAL -->
                <form action="{{ route('tickets.update', $ticket->id) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Campo Equipo -->
                        <div>
                            <label class="block text-[10px] font-black uppercase text-slate-400 italic tracking-widest mb-2">Equipo / Dispositivo</label>
                            <input type="text" name="equipo" value="{{ old('equipo', $ticket->equipo) }}" 
                                   class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-blue-100 focus:border-blue-300 transition-all outline-none">
                        </div>

                        <!-- Selector de Estado -->
                        <div>
                            <label class="block text-[10px] font-black uppercase text-slate-400 italic tracking-widest mb-2">Estado del Parte</label>
                            <select name="estado" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-black uppercase italic tracking-widest text-slate-700 focus:ring-4 focus:ring-blue-100 outline-none">
                                <option value="Recibido" {{ $ticket->estado == 'Recibido' ? 'selected' : '' }}>Recibido</option>
                                <option value="En Proceso" {{ $ticket->estado == 'En Proceso' ? 'selected' : '' }}>En Proceso</option>
                                <option value="Esperando Repuesto" {{ $ticket->estado == 'Esperando Repuesto' ? 'selected' : '' }}>Esperando Repuesto</option>
                                <option value="Listo" {{ $ticket->estado == 'Listo' ? 'selected' : '' }}>Listo</option>
                                <option value="Entregado" {{ $ticket->estado == 'Entregado' ? 'selected' : '' }}>Entregado</option>
                            </select>
                        </div>
                    </div>

                    <!-- Descripciones -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[10px] font-black uppercase text-slate-400 italic tracking-widest mb-2">Descripción Avería</label>
                            <textarea name="averia" rows="5" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium text-slate-600 focus:ring-4 focus:ring-blue-100 outline-none">{{ old('averia', $ticket->averia) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase text-slate-400 italic tracking-widest mb-2">Notas Técnicas de Reparación</label>
                            <textarea name="notas_tecnicas" rows="5" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium text-slate-600 focus:ring-4 focus:ring-blue-100 outline-none" placeholder="Escribe aquí los detalles del trabajo realizado...">{{ old('notas_tecnicas', $ticket->notas_tecnicas) }}</textarea>
                        </div>
                    </div>

                    <!-- Bloque Añadir Material (Oculto en impresión) -->
                    <div class="bg-blue-50/50 p-6 rounded-[2rem] border border-blue-100 no-print">
                        <h3 class="text-[11px] font-black text-blue-600 uppercase italic tracking-[0.15em] mb-4">Añadir Material al Parte</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="md:col-span-2">
                                <select name="repuesto_id" class="w-full px-5 py-4 bg-white border border-slate-200 rounded-2xl text-sm font-bold text-slate-700 outline-none">
                                    <option value="">-- Seleccionar pieza del almacén --</option>
                                    @foreach($repuestos as $repuesto)
                                        <option value="{{ $repuesto->id }}">
                                            {{ $repuesto->descripcion }} (Stock: {{ $repuesto->stock_actual }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="number" name="cantidad_repuesto" value="1" min="1" class="w-full px-5 py-4 bg-white border border-slate-200 rounded-2xl text-sm font-bold text-slate-700 outline-none">
                        </div>
                    </div>

                    <!-- Botón Guardar -->
                    <div class="flex justify-end no-print pt-4">
                        <button type="submit" class="bg-blue-600 text-white px-12 py-4 rounded-2xl font-black shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all transform hover:-translate-y-1 uppercase text-[11px] italic tracking-widest">
                            Guardar Cambios
                        </button>
                    </div>
                </form>

                <!-- 2. TABLA DE REPUESTOS (FUERA DEL FORMULARIO PARA QUE FUNCIONE EL DELETE) -->
                <div class="mt-12 repuestos-container no-print">
                    <h3 class="text-[11px] font-black text-slate-400 uppercase italic tracking-widest mb-4">Repuestos utilizados actualmente</h3>
                    <div class="overflow-hidden border border-slate-100 rounded-2xl">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-slate-50 border-b border-slate-100">
                                <tr>
                                    <th class="px-6 py-4 text-[9px] font-black text-slate-400 uppercase italic tracking-widest">Pieza</th>
                                    <th class="px-6 py-4 text-[9px] font-black text-slate-400 uppercase italic text-center tracking-widest">Cant.</th>
                                    <th class="px-6 py-4 text-[9px] font-black text-slate-400 uppercase italic text-right tracking-widest">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($ticket->repuestos as $item)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 text-sm font-bold text-slate-700">{{ $item->descripcion }}</td>
                                    <td class="px-6 py-4 text-sm font-black text-center text-blue-600">{{ $item->pivot->cantidad }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <form action="{{ route('tickets.repuesto.destroy', [$ticket->id, $item->id, $item->pivot->cantidad]) }}" method="POST" onsubmit="return confirm('¿Devolver al stock?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center text-red-500 hover:text-red-700 font-black text-[10px] uppercase transition-colors px-3 py-1 bg-red-50 rounded-lg border border-red-100">
                                                <svg xmlns="http://w3.org" class="h-3 w-3 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Devolver
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center text-slate-400 italic text-sm">No hay piezas asignadas todavía.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
