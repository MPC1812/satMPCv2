<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Parte - satMPC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cloudflare.com">
    <style>
        @media print {
            .no-print, form button, .bg-blue-50 { display: none !important; }
            body { background: white !important; p: 0 !important; }
            .bg-white { border: none !important; shadow: none !important; }
        }
    </style>
</head>
<body class="bg-slate-50 p-4 md:p-8">
    <div class="max-w-6xl mx-auto">

        <!-- BLOQUE DE BOTONES (ESTILO IMAGEN) -->
        <div class="no-print p-4 mb-6 flex justify-between items-center">
            <div class="flex items-center">
                <!-- Botón Imprimir (Negro, Rectangular, Texto Blanco) -->
                <button onclick="window.print()" class="bg-black text-white px-8 py-3 rounded font-bold text-xs uppercase hover:bg-gray-800 transition-all tracking-widest">
                    Imprimir Ahora
                </button>
                
                <!-- Botón Volver (Gris, Itálico, con Flecha) -->
                <a href="{{ route('tickets.index') }}" class="ml-6 text-xs font-bold text-gray-400 uppercase italic hover:text-black transition-colors tracking-widest">
                    ← Volver
                </a>
            </div>

            <!-- Mantenemos el Logout a la derecha pero discreto para no romper el estilo -->
            <form action="{{ route('logout') }}" method="POST" class="no-print">
                @csrf
                <button type="submit" class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-red-600 transition-colors italic">
                    Cerrar Sesión
                </button>
            </form>
        </div>

        <!-- TÍTULO DE LA PÁGINA (Justo debajo de los botones) -->
        <div class="mb-8">
            <h2 class="text-3xl font-black text-slate-800 italic uppercase leading-none tracking-tighter">
                Editar Parte: <span class="text-blue-600">{{ $ticket->codigo }}</span>
            </h2>
        </div>

        <!-- CUERPO PRINCIPAL -->
        <div class="bg-white rounded-[2rem] shadow-xl border border-slate-200 overflow-hidden">
            <div class="p-8">
                <form action="{{ route('tickets.update', $ticket->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Campo Equipo -->
                        <div>
                            <label class="block text-[10px] font-black uppercase text-slate-400 italic tracking-widest mb-2">Equipo</label>
                            <input type="text" name="equipo" value="{{ old('equipo', $ticket->equipo) }}" 
                                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-blue-100 focus:border-blue-300 transition-all outline-none">
                        </div>

                        <!-- Selector de Estado -->
                        <div class="no-print">
                            <label class="block text-[10px] font-black uppercase text-slate-400 italic tracking-widest mb-2">Estado del Parte</label>
                            <select name="estado" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-blue-100 focus:border-blue-300 transition-all outline-none">
                                <option value="Recibido" {{ $ticket->estado == 'Recibido' ? 'selected' : '' }}>Recibido</option>
                                <option value="En Proceso" {{ $ticket->estado == 'En Proceso' ? 'selected' : '' }}>En Proceso</option>
                                <option value="Esperando Repuesto" {{ $ticket->estado == 'Esperando Repuesto' ? 'selected' : '' }}>Esperando Repuesto</option>
                                <option value="Listo" {{ $ticket->estado == 'Listo' ? 'selected' : '' }}>Listo</option>
                                <option value="Entregado" {{ $ticket->estado == 'Entregado' ? 'selected' : '' }}>Entregado</option>
                            </select>
                        </div>
                    </div>

                    <!-- Campos de Texto -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black uppercase text-slate-400 italic tracking-widest mb-2">Descripción Avería</label>
                            <textarea name="averia" rows="4" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:ring-4 focus:ring-blue-100 outline-none">{{ old('averia', $ticket->averia) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase text-slate-400 italic tracking-widest mb-2">Observaciones Técnico</label>
                            <textarea name="notas_tecnicas" rows="4" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:ring-4 focus:ring-blue-100 outline-none">{{ old('notas_tecnicas', $ticket->notas_tecnicas) }}</textarea>
                        </div>
                    </div>

                    <!-- SECCIÓN REPUESTOS -->
                    <div class="bg-blue-50/50 p-6 rounded-[1.5rem] border border-blue-100 no-print">
                        <h3 class="text-[11px] font-black text-blue-600 uppercase italic tracking-widest mb-4">Añadir Material</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="md:col-span-2">
                                <select name="repuesto_id" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-700 outline-none">
                                    <option value="">-- Seleccionar pieza --</option>
                                    @foreach($repuestos as $repuesto)
                                        <option value="{{ $repuesto->id }}">
                                            {{ $repuesto->descripcion }} (Stock: {{ $repuesto->stock_actual }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="number" name="cantidad_repuesto" value="1" min="1" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-700 outline-none">
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="bg-blue-600 text-white px-10 py-4 rounded-2xl font-black shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all transform hover:-translate-y-1 uppercase text-[11px] italic tracking-widest">
                            Guardar Cambios
                        </button>
                    </div>
                </form>

                <!-- TABLA DE REPUESTOS YA USADOS -->
                <div class="mt-12">
                    <h3 class="text-[11px] font-black text-slate-400 uppercase italic tracking-widest mb-4">Repuestos utilizados</h3>
                    <div class="overflow-hidden border border-slate-100 rounded-2xl">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-4 text-[9px] font-black text-slate-400 uppercase italic">Pieza</th>
                                    <th class="px-6 py-4 text-[9px] font-black text-slate-400 uppercase italic text-center">Cant.</th>
                                    <th class="px-6 py-4 text-[9px] font-black text-slate-400 uppercase italic text-right">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($ticket->repuestos as $item)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4 text-sm font-bold text-slate-700">{{ $item->descripcion }}</td>
                                    <td class="px-6 py-4 text-sm font-black text-center text-blue-600">{{ $item->pivot->cantidad }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <form action="{{ route('tickets.repuesto.destroy', [$ticket->id, $item->id]) }}" method="POST" onsubmit="return confirm('¿Devolver al stock?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition-colors">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="px-6 py-8 text-center text-slate-400 italic text-sm">Sin repuestos asignados.</td></tr>
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
