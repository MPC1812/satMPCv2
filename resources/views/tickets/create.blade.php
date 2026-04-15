<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Entrada - satMPC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cloudflare.com">
</head>
<body class="bg-slate-100 font-sans min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-2xl bg-white rounded-[2.5rem] p-10 shadow-2xl border border-slate-100">
        
        <h3 class="text-xs font-black text-blue-600 uppercase tracking-widest mb-6 italic flex items-center">
            <span class="mr-2 text-lg">📥</span> Registro de Entrada (RF2)
        </h3>

        <!-- BLOQUE DE MENSAJES DE ERROR -->
        @if ($errors->any())
            <div class="mb-8 p-5 bg-red-50 border-l-4 border-red-500 rounded-r-2xl animate-in fade-in slide-in-from-top-4 duration-500">
                <div class="flex items-center mb-3">
                    <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                    <span class="text-red-800 font-black uppercase text-[10px] tracking-widest italic">Errores detectados:</span>
                </div>
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="text-red-600 text-xs font-bold flex items-center">
                            <span class="w-1.5 h-1.5 bg-red-400 rounded-full mr-2"></span> {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tickets.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- BUSCADOR DE CLIENTE -->
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase text-slate-400 italic ml-1 tracking-widest">Buscar Cliente (DNI o Nombre)</label>
                <div class="flex gap-3">
                    <input list="lista-clientes" id="cliente_input" placeholder="Empieza a escribir para buscar..." 
                        class="flex-1 px-6 py-4 bg-slate-50 border {{ $errors->has('cliente_id') ? 'border-red-300' : 'border-slate-200' }} rounded-2xl focus:ring-4 focus:ring-blue-100 outline-none font-bold text-sm transition-all">
                    
                    <button type="button" id="btn-nuevo-cliente" class="hidden px-5 bg-green-500 text-white rounded-2xl font-black text-[10px] uppercase italic tracking-tighter hover:bg-green-600 transition-colors">
                        + Nuevo
                    </button>
                </div>
                <datalist id="lista-clientes">
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->dni }} - {{ $cliente->nombre }} {{ $cliente->apellidos }}" data-id="{{ $cliente->id }}">
                    @endforeach
                </datalist>
                <input type="hidden" name="cliente_id" id="cliente_id" value="{{ old('cliente_id') }}">
            </div>

            <!-- REGISTRO RÁPIDO (Se mantiene visible si hubo errores en campos de 'nuevo_') -->
            <div id="form-rapido-cliente" class="{{ old('nuevo_dni') || $errors->has('nuevo_dni') ? '' : 'hidden' }} p-6 bg-blue-50/50 rounded-[2rem] border border-blue-100 grid grid-cols-2 gap-4 animate-in fade-in zoom-in duration-300">
                <div class="col-span-2 text-[10px] font-black text-blue-600 uppercase italic mb-1">Datos para alta rápida:</div>
    
                <input type="text" name="nuevo_dni" id="nuevo_dni" value="{{ old('nuevo_dni') }}" placeholder="DNI / NIE" 
                    class="px-5 py-3 rounded-xl border {{ $errors->has('nuevo_dni') ? 'border-red-300' : 'border-white' }} font-bold text-sm outline-none focus:bg-white transition-all shadow-sm">
                
                <input type="text" name="nuevo_tel" id="nuevo_tel" value="{{ old('nuevo_tel') }}" placeholder="Teléfono" 
                    class="px-5 py-3 rounded-xl border {{ $errors->has('nuevo_tel') ? 'border-red-300' : 'border-white' }} font-bold text-sm outline-none focus:bg-white transition-all shadow-sm">
    
                <input type="text" name="nuevo_nom" id="nuevo_nom" value="{{ old('nuevo_nom') }}" placeholder="Nombre" 
                    class="px-5 py-3 rounded-xl border {{ $errors->has('nuevo_nom') ? 'border-red-300' : 'border-white' }} font-bold text-sm outline-none focus:bg-white transition-all shadow-sm">
                
                <input type="text" name="nuevo_ape" id="nuevo_ape" value="{{ old('nuevo_ape') }}" placeholder="Apellidos" 
                    class="px-5 py-3 rounded-xl border {{ $errors->has('nuevo_ape') ? 'border-red-300' : 'border-white' }} font-bold text-sm outline-none focus:bg-white transition-all shadow-sm">
    
                <div class="col-span-2">
                    <input type="email" name="nuevo_email" id="nuevo_email" value="{{ old('nuevo_email') }}" placeholder="Correo electrónico (para notificaciones)" 
                        class="w-full px-5 py-3 rounded-xl border {{ $errors->has('nuevo_email') ? 'border-red-300' : 'border-white' }} font-bold text-sm outline-none focus:bg-white transition-all shadow-sm">
                </div>
            </div>

            <!-- DATOS DEL EQUIPO -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-slate-400 italic ml-1">Equipo / Modelo</label>
                    <input type="text" name="equipo" value="{{ old('equipo') }}" placeholder="Ej: MacBook Pro 2022" 
                        class="w-full px-6 py-4 bg-slate-50 border {{ $errors->has('equipo') ? 'border-red-300' : 'border-slate-200' }} rounded-2xl focus:ring-4 focus:ring-blue-100 outline-none font-bold text-sm" required>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-slate-400 italic ml-1">Estado Inicial</label>
                    <div class="w-full px-6 py-4 bg-slate-100 border border-slate-200 rounded-2xl font-bold text-sm text-slate-400 uppercase italic">Recibido</div>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase text-slate-400 italic ml-1">Descripción de la Avería</label>
                <textarea name="averia" rows="3" placeholder="Detalla el problema detectado..." 
                    class="w-full px-6 py-4 bg-slate-50 border {{ $errors->has('averia') ? 'border-red-300' : 'border-slate-200' }} rounded-2xl focus:ring-4 focus:ring-blue-100 outline-none font-bold text-sm resize-none" required>{{ old('averia') }}</textarea>
            </div>

            <!-- ACCIONES -->
            <div class="flex gap-4 pt-4">
                <a href="{{ route('tickets.index') }}" class="w-1/3 bg-slate-100 text-slate-400 font-black py-5 rounded-3xl text-center text-xs uppercase tracking-widest italic hover:bg-slate-200 transition">
                    Cancelar
                </a>
                <button type="submit" class="w-2/3 bg-blue-600 hover:bg-blue-700 text-white font-black py-5 rounded-3xl shadow-xl shadow-blue-200 uppercase text-sm tracking-widest transition-all transform active:scale-95 italic">
                    Generar Ticket y Código
                </button>
            </div>
        </form>
    </div>

    <script>
        const input = document.getElementById('cliente_input');
        const btnNuevo = document.getElementById('btn-nuevo-cliente');
        const formRapido = document.getElementById('form-rapido-cliente');
        const hiddenId = document.getElementById('cliente_id');

        input.addEventListener('input', function(e) {
            const list = document.getElementById('lista-clientes');
            const option = Array.from(list.options).find(opt => opt.value === input.value);
            
            if (option) {
                hiddenId.value = option.getAttribute('data-id');
                btnNuevo.classList.add('hidden');
                formRapido.classList.add('hidden');
            } else {
                hiddenId.value = "";
                if(input.value.length > 2) {
                    btnNuevo.classList.remove('hidden');
                } else {
                    btnNuevo.classList.add('hidden');
                }
            }
        });

        btnNuevo.addEventListener('click', () => {
            formRapido.classList.toggle('hidden');
            if (!formRapido.classList.contains('hidden')) {
                document.getElementById('nuevo_dni').value = input.value;
                document.getElementById('nuevo_dni').focus();
            }
        });
    </script>
</body>
</html>
