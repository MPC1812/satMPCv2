<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Sistema - satMPC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cloudflare.com">
    <!--<script src="https://tailwindcss.com"></script> -->
</head>
<body class="bg-slate-100 font-sans min-h-screen flex items-center justify-center p-4">

    <!-- Contenedor Principal -->
    <div class="w-full max-w-5xl flex flex-col md:flex-row bg-white rounded-[2.5rem] overflow-hidden shadow-2xl min-h-[650px] border border-slate-200">
        
        <!-- PANEL IZQUIERDO: Informativo (Azul Oscuro) -->
        <div class="w-full md:w-1/2 bg-[#0a1629] p-12 lg:p-16 flex flex-col justify-between text-white">
            <div>
                <div class="mb-12">
                    <h1 class="text-3xl font-black italic tracking-tighter uppercase">
                        SAT <span class="text-blue-500">MPC</span>
                    </h1>
                    <p class="text-[10px] tracking-[0.2em] opacity-50 font-bold uppercase mt-1">
                        Gestión Integral de Informática
                    </p>
                </div>

                <h2 class="text-4xl font-bold mb-10 leading-tight">
                    Soluciones rápidas para tus dispositivos.
                </h2>

                <ul class="space-y-6">
                    <li class="flex items-center gap-4 text-sm font-medium opacity-80">
                        <span class="flex-shrink-0 w-6 h-6 bg-blue-500/20 rounded flex items-center justify-center text-blue-400 text-xs">
                            <i class="fas fa-check"></i>
                        </span>
                        Seguimiento de tickets en tiempo real (RF5)
                    </li>
                    <li class="flex items-center gap-4 text-sm font-medium opacity-80">
                        <span class="flex-shrink-0 w-6 h-6 bg-blue-500/20 rounded flex items-center justify-center text-blue-400 text-xs">
                            <i class="fas fa-check"></i>
                        </span>
                        Técnicos especializados por marca (RF3)
                    </li>
                </ul>
            </div>
            <p class="text-[10px] opacity-30 font-medium italic">© 2026 Mario Puerma Cortés - IES Aguadulce</p>
        </div>

        <!-- PANEL DERECHO: Login -->
        <div class="w-full md:w-1/2 bg-white p-12 lg:p-16 flex flex-col justify-center">
            
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-slate-800">Acceso al Sistema</h2>
                <p class="text-slate-400 text-sm mt-1 font-medium italic">Introduce tus credenciales autorizadas.</p>
            </div>

            <!-- BLOQUE DE ERRORES DE LOGIN -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl animate-in fade-in slide-in-from-top-2 duration-300">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="text-red-600 text-xs font-bold flex items-center">
                                <i class="fas fa-exclamation-circle mr-2 text-[10px]"></i> {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1 italic">Correo Electrónico</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-300">
                            <i class="far fa-envelope text-lg"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full pl-12 pr-4 py-4 bg-slate-50 border {{ $errors->has('email') ? 'border-red-300' : 'border-slate-100' }} rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-50 outline-none transition-all text-sm font-medium" 
                            placeholder="admin@satmpc.com" required autofocus>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1 italic">Contraseña</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-300">
                            <i class="fas fa-lock text-lg"></i>
                        </span>
                        <input type="password" name="password" 
                            class="w-full pl-12 pr-4 py-4 bg-slate-50 border {{ $errors->has('email') ? 'border-red-300' : 'border-slate-100' }} rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-50 outline-none transition-all text-sm" 
                            placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl shadow-xl shadow-blue-100 uppercase text-xs tracking-widest transition-all transform active:scale-95 italic">
                    Entrar al Sistema (RF12)
                </button>
            </form>

            <!-- SECCIÓN CONSULTA TICKET (Acceso Clientes) -->
            <div class="mt-10 pt-8 border-t border-slate-50 text-center">
                <p class="text-[10px] text-slate-300 font-bold uppercase tracking-widest mb-4">¿Solo quieres consultar un estado?</p>
                <form action="{{ route('tickets.consulta') }}" method="GET" class="relative max-w-xs mx-auto">
                    <input type="text" name="codigo" 
                        class="w-full pl-6 pr-12 py-3 border-2 border-blue-600 text-blue-600 rounded-full text-[10px] font-black uppercase tracking-widest outline-none hover:bg-blue-50 focus:bg-blue-50 transition-colors placeholder:text-blue-300" 
                        placeholder="Nº DE PARTE">
                    <button type="submit" class="absolute right-1 top-1/2 -translate-y-1/2 bg-blue-600 text-white w-8 h-8 rounded-full flex items-center justify-center">
                        <i class="fas fa-search text-[10px]"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
