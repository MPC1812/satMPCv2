<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial Cliente - {{ $cliente->nombre }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cloudflare.com">
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; p: 0 !important; }
            .content-card { box-shadow: none !important; border: 1px solid #eee !important; }
        }
    </style>
</head>
<body class="bg-slate-50 p-8">
    <div class="max-w-5xl mx-auto">
        
        <!-- CABECERA DE ACCIONES -->
        <div class="flex justify-between items-center mb-8 no-print">
            <div class="flex items-center">
                <button onclick="window.print()" class="bg-black text-white px-6 py-2 rounded font-bold text-xs uppercase hover:bg-gray-800 transition-colors">
                    Imprimir Historial
                </button>
                <a href="{{ route('admin.clientes') }}" class="ml-4 text-xs font-bold text-gray-500 uppercase italic hover:text-black">
                    ← Volver
                </a>
            </div>
            <div class="text-right">
                <p class="text-[10px] font-black text-slate-400 uppercase italic tracking-widest">Total Reparaciones</p>
                <p class="text-2xl font-black text-blue-600 leading-none">{{ $tickets->count() }}</p>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-xl overflow-hidden border border-slate-200 content-card">
            <!-- INFO DEL CLIENTE -->
            <div class="p-10 border-b border-slate-100 bg-slate-50/30">
                <h2 class="text-[10px] font-black text-blue-600 uppercase tracking-[0.2em] mb-2 italic">Historial de Servicio Técnico</h2>
                <h1 class="text-3xl font-black text-slate-800 uppercase italic tracking-tighter">{{ $cliente->nombre }} {{ $cliente->apellidos }}</h1>
                <div class="flex gap-6 mt-4 text-xs font-bold text-slate-500 uppercase italic">
                    <span><i class="fas fa-id-card mr-2 text-blue-500"></i>{{ $cliente->dni }}</span>
                    <span><i class="fas fa-phone mr-2 text-blue-500"></i>{{ $cliente->telefono }}</span>
                    <span><i class="fas fa-envelope mr-2 text-blue-500"></i>{{ $cliente->email }}</span>
                </div>
            </div>

            <!-- TABLA DE PARTES -->
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-400 italic">Fecha</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-400 italic">Parte / Equipo</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-400 italic text-center">Coste Repuestos</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-400 italic text-center">Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($tickets as $t)
                    <tr>
                        <td class="px-8 py-5 text-xs font-bold text-slate-500">{{ $t->created_at->format('d/m/Y') }}</td>
                        <td class="px-8 py-5">
                            <span class="font-black text-blue-600 block">{{ $t->codigo }}</span>
                            <span class="font-bold text-slate-700 uppercase text-xs">{{ $t->equipo }}</span>
                        </td>
                        <td class="px-8 py-5 text-center font-bold text-slate-700">
                            {{-- Calculamos el total sumando (precio * cantidad) de la tabla pivote --}}
                            @php 
                                $totalRepuestos = $t->repuestos->sum(function($r) {
                                    return $r->pivot->cantidad * $r->precio; // Ajusta 'precio' al nombre de tu campo
                                });
                            @endphp
                            {{ number_format($totalRepuestos, 2, ',', '.') }} €
                        </td>
                        <td class="px-8 py-5 text-center">
                            <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase italic text-white
                                @if(Str::lower($t->estado) == 'listo' || Str::lower($t->estado) == 'entregado') bg-green-500 @else bg-blue-600 @endif">
                                {{ $t->estado }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                {{-- Fila de Total Acumulado (Informe de Administración) --}}
                <tfoot class="bg-slate-50 font-black">
                    <tr>
                        <td colspan="2" class="px-8 py-5 text-[10px] uppercase text-right italic">Inversión Total del Cliente:</td>
                        <td class="px-8 py-5 text-center text-blue-600 text-lg">
                            {{ number_format($tickets->sum(function($t){
                                return $t->repuestos->sum(fn($r) => $r->pivot->cantidad * $r->precio);
                            }), 2, ',', '.') }} €
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <!-- Pie de Informe para el Administrador -->
    <div class="hidden print:block mt-12 pt-6 border-t border-slate-200">
        <div class="flex justify-between text-[9px] font-bold text-slate-400 uppercase tracking-widest italic">
            <span>satMPC - Departamento de Administración</span>
            <span>Fecha del informe: {{ now()->format('d/m/Y') }}</span>
        </div>
    </div>
</body>
</html>
