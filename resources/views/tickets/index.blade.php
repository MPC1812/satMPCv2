<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Gestión - satMPC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- FontAwesome para los iconos de Editar/Imprimir/Ojo -->
    <link rel="stylesheet" href="https://cloudflare.com">
</head>
<body class="bg-slate-50 p-8">
    <div class="max-w-6xl mx-auto">
        


        <!-- ENCABEZADO: Título, Buscador, Nueva Entrada y Logout -->
        <div class="flex flex-col lg:flex-row justify-between items-center mb-8 gap-4">
            <h2 class="text-3xl font-black text-slate-800 italic uppercase leading-none tracking-tighter">
                Gestión de Equipos
            </h2>
            <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                <!-- BUSCADOR -->
                <form action="{{ route('tickets.index') }}" method="GET" class="relative flex-1 md:w-64 group">
                    <input type="text" name="buscar" value="{{ request('buscar') }}"
                        placeholder="Buscar cliente o parte..." 
                        class="w-full pl-10 pr-12 py-4 bg-white border border-slate-200 rounded-2xl text-[11px] font-black uppercase tracking-widest outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-300 transition-all italic shadow-sm"
                    >
                    <!-- Icono Lupa SVG -->
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg xmlns="http://w3.org" class="h-4 w-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <!-- Botón Limpiar -->
                    @if(request('buscar') || request('estado'))
                        <a href="{{ route('tickets.index') }}" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-red-500 transition-colors">
                            <svg xmlns="http://w3.org" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </a>
                    @endif
                    <button type="submit" class="hidden"></button>
                </form>

                <!-- BOTÓN NUEVA ENTRADA -->
                <a href="{{ route('tickets.create') }}" class="bg-blue-600 text-white px-8 py-4 rounded-2xl font-black shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all transform hover:-translate-y-1 active:scale-95 uppercase text-[11px] italic tracking-widest whitespace-nowrap">
                    + Nueva Entrada
                </a>

                <!-- BOTÓN LOGOUT (Cerrar Sesión) -->
                <form action="{{ route('logout') }}" method="POST" class="no-print">
                    @csrf
                    <button type="submit" class="group flex items-center justify-center w-[52px] h-[52px] md:w-auto md:px-5 bg-white border border-slate-200 rounded-2xl shadow-sm hover:bg-red-50 hover:border-red-100 transition-all cursor-pointer" title="Cerrar Sesión">
                        <span class="hidden md:block text-[10px] font-black uppercase tracking-widest text-slate-400 group-hover:text-red-600 transition-colors italic mr-3">
                            Cerrar Sesión
                        </span>
                        <svg xmlns="http://w3.org" class="w-4 h-4 text-slate-400 group-hover:text-red-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>


        <!-- FILTROS RÁPIDOS: Tus 5 estados reales -->
        <div class="flex gap-2 mb-8 overflow-x-auto pb-2 no-print">
            <a href="{{ route('tickets.index') }}" 
               class="px-4 py-2 rounded-xl text-[10px] font-black uppercase italic tracking-widest transition-all {{ !request('estado') ? 'bg-slate-800 text-white shadow-lg' : 'bg-white text-slate-400 border border-slate-200 hover:bg-slate-50' }}">
                Todos
            </a>
            <a href="{{ route('tickets.index', ['estado' => 'recibido']) }}" 
               class="px-4 py-2 rounded-xl text-[10px] font-black uppercase italic tracking-widest transition-all {{ request('estado') == 'recibido' ? 'bg-blue-600 text-white shadow-lg' : 'bg-white text-slate-400 border border-slate-200 hover:bg-blue-50' }}">
                Recibidos
            </a>
            <a href="{{ route('tickets.index', ['estado' => 'en proceso']) }}" 
               class="px-4 py-2 rounded-xl text-[10px] font-black uppercase italic tracking-widest transition-all {{ request('estado') == 'en proceso' ? 'bg-indigo-500 text-white shadow-lg' : 'bg-white text-slate-400 border border-slate-200 hover:bg-indigo-50' }}">
                En Proceso
            </a>
            <a href="{{ route('tickets.index', ['estado' => 'esperando repuesto']) }}" 
               class="px-4 py-2 rounded-xl text-[10px] font-black uppercase italic tracking-widest transition-all {{ request('estado') == 'esperando repuesto' ? 'bg-orange-500 text-white shadow-lg' : 'bg-white text-slate-400 border border-slate-200 hover:bg-orange-50' }}">
                Esperando Repuesto
            </a>
            <a href="{{ route('tickets.index', ['estado' => 'listo']) }}" 
               class="px-4 py-2 rounded-xl text-[10px] font-black uppercase italic tracking-widest transition-all {{ request('estado') == 'listo' ? 'bg-green-500 text-white shadow-lg' : 'bg-white text-slate-400 border border-slate-200 hover:bg-green-50' }}">
                Listos
            </a>
            <a href="{{ route('tickets.index', ['estado' => 'entregado']) }}" 
               class="px-4 py-2 rounded-xl text-[10px] font-black uppercase italic tracking-widest transition-all {{ request('estado') == 'entregado' ? 'bg-slate-400 text-white shadow-lg' : 'bg-white text-slate-400 border border-slate-200 hover:bg-slate-50' }}">
                Entregados
            </a>
        </div>

        <!-- TABLA DE DATOS -->
        <div class="bg-white rounded-[2rem] shadow-xl overflow-hidden border border-slate-200">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-5 text-[10px] font-black uppercase text-slate-400 italic tracking-widest">Parte</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase text-slate-400 italic tracking-widest">Cliente</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase text-slate-400 italic tracking-widest">Equipo</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase text-slate-400 italic tracking-widest">Estado</th>
                        <th class="px-6 py-5 text-[10px] font-black uppercase text-slate-400 italic text-center tracking-widest">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($tickets as $t)
                    <tr class="hover:bg-blue-50/30 transition-colors">
                        <td class="px-6 py-4 font-black text-blue-600 tracking-tighter">{{ $t->codigo }}</td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-700 leading-none mb-1">{{ $t->cliente->nombre }} {{ $t->cliente->apellidos }}</div>
                            <div class="text-[10px] text-slate-400 font-medium">{{ $t->cliente->telefono }}</div>
                        </td>
                        <td class="px-6 py-4 text-slate-500 font-medium">{{ $t->equipo }}</td>
                        <td class="px-6 py-4">
                            {{-- Convertimos a minúsculas para que la comparación siempre funcione --}}
                            @php $estadoSlug = Str::lower($t->estado); @endphp

                            <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase italic tracking-wider shadow-sm text-white
                                @if($estadoSlug == 'recibido') bg-blue-600 
                                @elseif($estadoSlug == 'en proceso') bg-indigo-500 
                                @elseif($estadoSlug == 'esperando repuesto') bg-orange-500 
                                @elseif($estadoSlug == 'listo') bg-green-500 
                                @elseif($estadoSlug == 'entregado') bg-slate-400 
                                @else bg-slate-200 text-slate-500 {{-- Color por defecto si no coincide ninguno --}}
                                @endif">
                                {{ $t->estado }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center items-center gap-6">
                                <a href="{{ route('tickets.show', $t->id) }}" class="text-slate-400 hover:text-green-600 font-bold text-[10px] uppercase italic transition-colors flex items-center gap-1.5 no-underline">
                                   <i class="fas fa-eye text-[11px]"></i> Ver
                                </a>
                                <a href="{{ route('tickets.edit', $t->id) }}" class="text-slate-400 hover:text-blue-600 font-bold text-[10px] uppercase italic transition-colors flex items-center gap-1.5 no-underline">
                                   <i class="fas fa-edit text-[11px]"></i> Editar
                                </a>
                                <a href="{{ route('tickets.imprimir', $t->id) }}" target="_blank" class="text-slate-400 hover:text-slate-800 font-bold text-[10px] uppercase italic transition-colors flex items-center gap-1.5 no-underline">
                                   <i class="fas fa-print text-[11px]"></i> Imprimir
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center">
                            <p class="text-slate-400 text-xs font-black uppercase italic tracking-widest">No se han encontrado registros.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-8 text-center no-print">
            <p class="text-[10px] font-bold text-slate-300 uppercase tracking-[0.3em]">satMPC Management System v2.0</p>
        </div>
    </div>
</body>
</html>





